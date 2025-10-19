<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    protected array $statusKeyMap = [
        'baru' => 'new',
        'diproses' => 'processed',
        'dikirim' => 'sent',
        'selesai' => 'finished',
        'batal' => 'cancelled',
    ];
    public function __construct()
    {
        $this->middleware(['auth', 'can:admin']);
    }

    public function index()
    {
        // Overall metrics
        $stats = [
            'users'    => User::count(),
            'products' => Product::count(),
            'orders'   => Order::count(),
            'revenue'  => (int) Order::whereIn('status', ['diproses', 'dikirim', 'selesai'])->sum('total'),
        ];

        // Order breakdown (all dates)
        $orderStatusStats = $this->statusCounts();

        // Merge so the view can access both overall metrics and order breakdown
        $stats = array_merge($stats, $orderStatusStats);

        $latestOrders = Order::with('user')->latest()->take(5)->get();

        $newOrders = Order::with('user')
            ->whereNotIn('status', ['selesai', 'batal'])
            ->orderByDesc('created_at')
            ->get();

        $today = Carbon::today();

        return view('admin.dashboard', [
            'stats' => $stats,
            'orderStatusStats' => $orderStatusStats,
            'latestOrders' => $latestOrders,
            'newOrders' => $newOrders,
            'defaultRangeLabel' => __('Semua tanggal'),
            'todayDate' => $today->toDateString(),
        ]);
    }

    public function statsByDate(string $date): JsonResponse
    {
        try {
            $parsed = Carbon::createFromFormat('Y-m-d', $date)->startOfDay();
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Tanggal tidak valid.',
            ], 422);
        }

        $stats = $this->statusCounts($parsed);
        $label = $parsed->locale(app()->getLocale())->translatedFormat('d F Y');

        return response()->json([
            'date' => $parsed->toDateString(),
            'label' => $label,
            'stats' => $stats,
        ]);
    }

    protected function statusCounts(?Carbon $date = null): array
    {
        $statuses = array_keys($this->statusKeyMap);

        $query = Order::query()->whereIn('status', $statuses);

        if ($date) {
            $query->whereDate('created_at', $date->toDateString());
        }

        $counts = $query
            ->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $results = [];
        foreach ($this->statusKeyMap as $status => $key) {
            $results[$key] = (int) ($counts[$status] ?? 0);
        }

        return $results;
    }
}

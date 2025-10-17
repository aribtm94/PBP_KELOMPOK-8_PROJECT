<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'order_number')) {
                $table->string('order_number', 50)->unique()->after('id');
            }
            if (!Schema::hasColumn('orders', 'receiver_name')) {
                $table->string('receiver_name')->after('user_id');
            }
            if (!Schema::hasColumn('orders', 'receiver_address')) {
                $table->text('receiver_address')->after('receiver_name');
            }
            if (!Schema::hasColumn('orders', 'receiver_phone')) {
                $table->string('receiver_phone', 20)->nullable()->after('receiver_address');
            }
            if (!Schema::hasColumn('orders', 'payment_method')) {
                $table->string('payment_method', 50)->default('transfer')->after('receiver_phone');
            }
            if (!Schema::hasColumn('orders', 'status')) {
                $table->string('status', 50)->default('baru')->after('payment_method');
            }
            if (!Schema::hasColumn('orders', 'total')) {
                $table->bigInteger('total')->default(0)->after('status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'order_number',
                'receiver_name',
                'receiver_address',
                'receiver_phone',
                'payment_method',
                'status',
                'total',
            ]);
        });
    }
};

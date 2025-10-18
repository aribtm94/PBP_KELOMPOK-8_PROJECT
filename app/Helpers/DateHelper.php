<?php

namespace App\Helpers;

use Carbon\Carbon;

class DateHelper
{
    /**
     * Format tanggal untuk tampilan Indonesia
     */
    public static function formatIndonesia($date)
    {
        return Carbon::parse($date)->timezone('Asia/Jakarta')->format('d M Y, H:i') . ' WIB';
    }

    /**
     * Format tanggal lengkap Indonesia
     */
    public static function formatLengkap($date)
    {
        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        
        $carbon = Carbon::parse($date)->timezone('Asia/Jakarta');
        return $carbon->format('d') . ' ' . $months[$carbon->month] . ' ' . $carbon->format('Y, H:i') . ' WIB';
    }

    /**
     * Mendapatkan waktu Jakarta sekarang
     */
    public static function now()
    {
        return Carbon::now('Asia/Jakarta');
    }

    /**
     * Format untuk database (UTC)
     */
    public static function forDatabase($date = null)
    {
        $jakartaTime = $date ? Carbon::parse($date)->timezone('Asia/Jakarta') : self::now();
        return $jakartaTime->utc()->format('Y-m-d H:i:s');
    }
}
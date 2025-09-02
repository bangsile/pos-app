<?php

use Carbon\Carbon;

if (!function_exists('remainingDays')) {
    function remainingDays($date): ?int
    {
        if (!$date) {
            return null;
        }

        $date = Carbon::parse($date);
        return now()->diffInDays($date, false);
    }
}

if (!function_exists('formatTimezone')) {
    /**
     * Format tanggal/waktu sesuai timezone yang diberikan
     *
     * @param \DateTimeInterface|string|null $date
     * @param string $timezone IANA timezone, contoh 'Asia/Jakarta'
     * @param string $format format output, default 'Y-m-d H:i:s'
     * @return string|null
     */
    function formatTimezone($date, string $timezone = null, string $format = 'Y-m-d H:i:s'): ?string
    {
        if (!$date) return null;

        // fallback ke timezone default app jika tidak di-set
        $tz = $timezone ?: config('app.timezone');

        return Carbon::parse($date)
            ->setTimezone($tz)
            ->format($format);
    }
}

if (!function_exists('zonaWIT')) {
    /**
     * Format tanggal/waktu sesuai timezone yang diberikan
     *
     * @param \DateTimeInterface|string|null $date
     * @param string $timezone IANA timezone, contoh 'Asia/Jakarta'
     * @param string $format format output, default 'Y-m-d H:i:s'
     * @return string|null
     */
    function zonaWIT($date): ?string
    {
        if (!$date) return null;

        return formatTimezone($date, 'Asia/Jayapura');
    }
}
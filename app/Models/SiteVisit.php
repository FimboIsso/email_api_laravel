<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class SiteVisit extends Model
{
    use HasFactory;

    protected $fillable = [
        'ip_address',
        'user_agent',
        'page_url',
        'referer',
        'visited_at'
    ];

    protected $casts = [
        'visited_at' => 'datetime',
    ];

    /**
     * Get total visits count
     */
    public static function getTotalVisits()
    {
        return self::count();
    }

    /**
     * Get unique visitors count
     */
    public static function getUniqueVisitors()
    {
        return self::distinct('ip_address')->count();
    }

    /**
     * Get today's visits
     */
    public static function getTodayVisits()
    {
        return self::whereDate('visited_at', Carbon::today())->count();
    }

    /**
     * Get this week's visits
     */
    public static function getWeekVisits()
    {
        return self::whereBetween('visited_at', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ])->count();
    }

    /**
     * Get this month's visits
     */
    public static function getMonthVisits()
    {
        return self::whereMonth('visited_at', Carbon::now()->month)
            ->whereYear('visited_at', Carbon::now()->year)
            ->count();
    }

    /**
     * Record a visit
     */
    public static function recordVisit($request)
    {
        // Éviter de compter plusieurs fois la même IP dans les 30 dernières minutes
        $recentVisit = self::where('ip_address', $request->ip())
            ->where('page_url', $request->path())
            ->where('visited_at', '>', Carbon::now()->subMinutes(30))
            ->exists();

        if (!$recentVisit) {
            self::create([
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'page_url' => $request->path(),
                'referer' => $request->headers->get('referer'),
                'visited_at' => Carbon::now()
            ]);
        }
    }

    /**
     * Get visits statistics for chart
     */
    public static function getVisitsChart($days = 7)
    {
        $visits = self::selectRaw('DATE(visited_at) as date, COUNT(*) as count')
            ->where('visited_at', '>=', Carbon::now()->subDays($days))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $data = [];
        for ($i = $days - 1; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $data[$date] = 0;
        }

        foreach ($visits as $visit) {
            $data[$visit->date] = $visit->count;
        }

        return $data;
    }

    /**
     * Get popular pages
     */
    public static function getPopularPages($limit = 5)
    {
        return self::select('page_url')
            ->selectRaw('COUNT(*) as visits')
            ->groupBy('page_url')
            ->orderBy('visits', 'desc')
            ->limit($limit)
            ->get();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SiteVisit extends Model
{
    use HasFactory;

    protected $fillable = [
        'visitor_id',
        'ip_address',
        'user_agent',
        'page_url',
        'referer',
        'country',
        'city',
        'device_type',
        'browser',
        'platform',
        'is_bot',
        'session_id',
        'visited_at'
    ];

    protected $casts = [
        'visited_at' => 'datetime',
        'is_bot' => 'boolean',
    ];

    /**
     * Get total visits count (cached)
     */
    public static function getTotalVisits()
    {
        return Cache::remember('site_visits_total', 300, function () {
            return self::count();
        });
    }

    /**
     * Get unique visitors count (cached)
     */
    public static function getUniqueVisitors()
    {
        return Cache::remember('site_visits_unique', 300, function () {
            return self::distinct('visitor_id')->count();
        });
    }

    /**
     * Get real visitors (excluding bots)
     */
    public static function getRealVisitors()
    {
        return Cache::remember('site_visits_real', 300, function () {
            return self::where('is_bot', false)->distinct('visitor_id')->count();
        });
    }

    /**
     * Get today's visits
     */
    public static function getTodayVisits()
    {
        return Cache::remember('site_visits_today', 60, function () {
            return self::whereDate('visited_at', Carbon::today())
                ->where('is_bot', false)
                ->count();
        });
    }

    /**
     * Get this week's visits
     */
    public static function getWeekVisits()
    {
        return Cache::remember('site_visits_week', 300, function () {
            return self::whereBetween('visited_at', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ])->where('is_bot', false)->count();
        });
    }

    /**
     * Get this month's visits
     */
    public static function getMonthVisits()
    {
        return Cache::remember('site_visits_month', 300, function () {
            return self::whereMonth('visited_at', Carbon::now()->month)
                ->whereYear('visited_at', Carbon::now()->year)
                ->where('is_bot', false)
                ->count();
        });
    }

    /**
     * Detect if user agent is a bot
     */
    private static function isBot($userAgent)
    {
        if (!$userAgent) return true;

        $botPatterns = [
            'bot', 'crawl', 'spider', 'scraper', 'parser', 'checker',
            'google', 'bing', 'yahoo', 'facebook', 'twitter', 'linkedin',
            'whatsapp', 'telegram', 'slack', 'discord', 'curl', 'wget',
            'python', 'php', 'java', 'ruby', 'perl', 'postman'
        ];

        $userAgentLower = strtolower($userAgent);
        
        foreach ($botPatterns as $pattern) {
            if (str_contains($userAgentLower, $pattern)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Parse user agent to extract browser and platform
     */
    private static function parseUserAgent($userAgent)
    {
        if (!$userAgent) {
            return ['browser' => 'Unknown', 'platform' => 'Unknown', 'device_type' => 'Unknown'];
        }

        $browser = 'Unknown';
        $platform = 'Unknown';
        $deviceType = 'Desktop';

        // Detect browser
        if (preg_match('/Chrome\/[\d.]+/', $userAgent)) {
            $browser = 'Chrome';
        } elseif (preg_match('/Firefox\/[\d.]+/', $userAgent)) {
            $browser = 'Firefox';
        } elseif (preg_match('/Safari\/[\d.]+/', $userAgent) && !preg_match('/Chrome/', $userAgent)) {
            $browser = 'Safari';
        } elseif (preg_match('/Edge\/[\d.]+/', $userAgent)) {
            $browser = 'Edge';
        }

        // Detect platform
        if (preg_match('/Windows/', $userAgent)) {
            $platform = 'Windows';
        } elseif (preg_match('/Mac OS X/', $userAgent)) {
            $platform = 'macOS';
        } elseif (preg_match('/Linux/', $userAgent)) {
            $platform = 'Linux';
        } elseif (preg_match('/Android/', $userAgent)) {
            $platform = 'Android';
            $deviceType = 'Mobile';
        } elseif (preg_match('/iOS|iPhone|iPad/', $userAgent)) {
            $platform = 'iOS';
            $deviceType = preg_match('/iPad/', $userAgent) ? 'Tablet' : 'Mobile';
        }

        // Detect device type
        if (preg_match('/Mobile|Android|iPhone/', $userAgent)) {
            $deviceType = 'Mobile';
        } elseif (preg_match('/Tablet|iPad/', $userAgent)) {
            $deviceType = 'Tablet';
        }

        return [
            'browser' => $browser,
            'platform' => $platform,
            'device_type' => $deviceType
        ];
    }

    /**
     * Generate visitor ID from IP and User Agent
     */
    private static function generateVisitorId($ipAddress, $userAgent)
    {
        return hash('sha256', $ipAddress . '|' . $userAgent);
    }

    /**
     * Record a visit with enhanced tracking
     */
    public static function recordVisit($request)
    {
        $ipAddress = $request->ip();
        $userAgent = $request->userAgent();
        $pageUrl = $request->path();
        $sessionId = $request->session()->getId();
        
        // Generate unique visitor ID
        $visitorId = self::generateVisitorId($ipAddress, $userAgent);
        
        // Check if this is a bot
        $isBot = self::isBot($userAgent);
        
        // Parse user agent
        $agentInfo = self::parseUserAgent($userAgent);
        
        // Éviter de compter plusieurs fois la même visite dans les 10 dernières minutes
        $cacheKey = "visit_recorded_{$visitorId}_{$pageUrl}";
        
        if (!Cache::has($cacheKey)) {
            try {
                self::create([
                    'visitor_id' => $visitorId,
                    'ip_address' => $ipAddress,
                    'user_agent' => $userAgent,
                    'page_url' => $pageUrl,
                    'referer' => $request->headers->get('referer'),
                    'country' => null, // TODO: Add GeoIP lookup
                    'city' => null, // TODO: Add GeoIP lookup
                    'device_type' => $agentInfo['device_type'],
                    'browser' => $agentInfo['browser'],
                    'platform' => $agentInfo['platform'],
                    'is_bot' => $isBot,
                    'session_id' => $sessionId,
                    'visited_at' => Carbon::now()
                ]);

                // Cache for 10 minutes to avoid duplicates
                Cache::put($cacheKey, true, 600);

                // Clear relevant caches
                Cache::forget('site_visits_total');
                Cache::forget('site_visits_unique');
                Cache::forget('site_visits_real');
                Cache::forget('site_visits_today');

            } catch (\Exception $e) {
                Log::error('Error recording visit: ' . $e->getMessage());
            }
        }
    }

    /**
     * Get visits statistics for chart
     */
    public static function getVisitsChart($days = 7)
    {
        $cacheKey = "visits_chart_{$days}";
        
        return Cache::remember($cacheKey, 300, function () use ($days) {
            $visits = self::selectRaw('DATE(visited_at) as date, COUNT(*) as total, COUNT(DISTINCT visitor_id) as unique_visitors')
                ->where('visited_at', '>=', Carbon::now()->subDays($days))
                ->where('is_bot', false)
                ->groupBy('date')
                ->orderBy('date')
                ->get();

            $data = [];
            for ($i = $days - 1; $i >= 0; $i--) {
                $date = Carbon::now()->subDays($i)->format('Y-m-d');
                $data[$date] = [
                    'total' => 0,
                    'unique' => 0,
                    'date_formatted' => Carbon::now()->subDays($i)->format('d/m')
                ];
            }

            foreach ($visits as $visit) {
                $data[$visit->date] = [
                    'total' => $visit->total,
                    'unique' => $visit->unique_visitors,
                    'date_formatted' => Carbon::parse($visit->date)->format('d/m')
                ];
            }

            return $data;
        });
    }

    /**
     * Get popular pages
     */
    public static function getPopularPages($limit = 5)
    {
        $cacheKey = "popular_pages_{$limit}";
        
        return Cache::remember($cacheKey, 600, function () use ($limit) {
            return self::select('page_url')
                ->selectRaw('COUNT(*) as visits, COUNT(DISTINCT visitor_id) as unique_visitors')
                ->where('is_bot', false)
                ->where('visited_at', '>=', Carbon::now()->subDays(30))
                ->groupBy('page_url')
                ->orderBy('visits', 'desc')
                ->limit($limit)
                ->get();
        });
    }

    /**
     * Get device statistics
     */
    public static function getDeviceStats()
    {
        return Cache::remember('device_stats', 600, function () {
            return self::select('device_type')
                ->selectRaw('COUNT(*) as count')
                ->where('is_bot', false)
                ->where('visited_at', '>=', Carbon::now()->subDays(30))
                ->groupBy('device_type')
                ->get();
        });
    }

    /**
     * Get browser statistics
     */
    public static function getBrowserStats()
    {
        return Cache::remember('browser_stats', 600, function () {
            return self::select('browser')
                ->selectRaw('COUNT(*) as count')
                ->where('is_bot', false)
                ->where('visited_at', '>=', Carbon::now()->subDays(30))
                ->groupBy('browser')
                ->orderBy('count', 'desc')
                ->get();
        });
    }

    /**
     * Clean old visits (older than 1 year)
     */
    public static function cleanupOldVisits()
    {
        $deleted = self::where('visited_at', '<', Carbon::now()->subYear())->delete();
        
        // Clear all caches
        Cache::forget('site_visits_total');
        Cache::forget('site_visits_unique');
        Cache::forget('site_visits_real');
        
        return $deleted;
    }
}

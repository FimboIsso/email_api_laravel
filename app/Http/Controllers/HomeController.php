<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmailLog;
use App\Models\SiteVisit;
use App\Models\User;
use App\Models\MailConfiguration;
use App\Models\Otp;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        // Récupérer les statistiques globales
        $stats = $this->getGlobalStats();

        return view('welcome', compact('stats'));
    }

    private function getGlobalStats()
    {
        // Statistiques de visites
        $totalVisits = SiteVisit::count();
        $uniqueVisitors = SiteVisit::distinct('ip_address')->count();

        // Statistiques des utilisateurs
        $totalUsers = User::count();
        $newUsersThisMonth = User::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        // Statistiques des emails
        $totalEmails = EmailLog::count();
        $sentEmails = EmailLog::where('status', 'sent')->count();
        $failedEmails = EmailLog::where('status', 'failed')->count();
        $emailsThisMonth = EmailLog::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        // Statistiques des OTP
        $totalOtps = Otp::count();
        $usedOtps = Otp::where('is_used', true)->count();
        $expiredOtps = Otp::where('expires_at', '<', now())->where('is_used', false)->count();
        $otpsThisMonth = Otp::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        // Statistiques par type d'OTP
        $otpsByType = Otp::selectRaw('type, count(*) as count')
            ->groupBy('type')
            ->pluck('count', 'type')
            ->toArray();

        // Taux de succès
        $emailSuccessRate = $totalEmails > 0 ? round(($sentEmails / $totalEmails) * 100, 1) : 0;
        $otpUsageRate = $totalOtps > 0 ? round(($usedOtps / $totalOtps) * 100, 1) : 0;

        // Statistiques des configurations
        $totalConfigurations = MailConfiguration::count();

        return [
            'visits' => [
                'total' => $totalVisits,
                'unique_visitors' => $uniqueVisitors,
            ],
            'users' => [
                'total' => $totalUsers,
                'this_month' => $newUsersThisMonth,
            ],
            'emails' => [
                'total' => $totalEmails,
                'sent' => $sentEmails,
                'failed' => $failedEmails,
                'this_month' => $emailsThisMonth,
                'success_rate' => $emailSuccessRate,
            ],
            'otps' => [
                'total' => $totalOtps,
                'used' => $usedOtps,
                'expired' => $expiredOtps,
                'this_month' => $otpsThisMonth,
                'usage_rate' => $otpUsageRate,
                'by_type' => $otpsByType,
            ],
            'configurations' => [
                'total' => $totalConfigurations,
            ],
        ];
    }
}

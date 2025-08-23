<?php

namespace App\Services;

use App\Models\EmailLog;
use App\Models\User;
use App\Models\ApiToken;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class EmailStatisticsService
{
    /**
     * Get email statistics for a user
     */
    public function getUserStatistics(int $userId, ?string $period = 'month'): array
    {
        $dateRange = $this->getDateRange($period);

        $query = EmailLog::byUser($userId)
            ->inDateRange($dateRange['start'], $dateRange['end']);

        return [
            'period' => $period,
            'date_range' => $dateRange,
            'total_emails' => $query->count(),
            'sent_emails' => $query->clone()->byStatus('sent')->count(),
            'failed_emails' => $query->clone()->byStatus('failed')->count(),
            'pending_emails' => $query->clone()->byStatus('pending')->count(),
            'delivered_emails' => $query->clone()->byStatus('delivered')->count(),
            'bounced_emails' => $query->clone()->byStatus('bounced')->count(),
            'success_rate' => $this->calculateSuccessRate($query),
            'daily_breakdown' => $this->getDailyBreakdown($userId, $dateRange),
            'top_applications' => $this->getTopApplications($userId, $dateRange),
            'top_recipients' => $this->getTopRecipients($userId, $dateRange),
        ];
    }

    /**
     * Get email statistics for a specific API token
     */
    public function getTokenStatistics(int $tokenId, ?string $period = 'month'): array
    {
        $dateRange = $this->getDateRange($period);

        $query = EmailLog::byToken($tokenId)
            ->inDateRange($dateRange['start'], $dateRange['end']);

        $token = ApiToken::with('user')->findOrFail($tokenId);

        return [
            'token_info' => [
                'id' => $token->id,
                'name' => $token->name,
                'user' => $token->user->name,
                'created_at' => $token->created_at,
            ],
            'period' => $period,
            'date_range' => $dateRange,
            'total_emails' => $query->count(),
            'sent_emails' => $query->clone()->byStatus('sent')->count(),
            'failed_emails' => $query->clone()->byStatus('failed')->count(),
            'pending_emails' => $query->clone()->byStatus('pending')->count(),
            'delivered_emails' => $query->clone()->byStatus('delivered')->count(),
            'bounced_emails' => $query->clone()->byStatus('bounced')->count(),
            'success_rate' => $this->calculateSuccessRate($query),
            'daily_breakdown' => $this->getDailyBreakdownByToken($tokenId, $dateRange),
            'top_applications' => $this->getTopApplicationsByToken($tokenId, $dateRange),
            'error_analysis' => $this->getErrorAnalysisByToken($tokenId, $dateRange),
        ];
    }

    /**
     * Get email statistics for a specific application
     */
    public function getApplicationStatistics(string $applicationName, ?string $period = 'month'): array
    {
        $dateRange = $this->getDateRange($period);

        $query = EmailLog::byApplication($applicationName)
            ->inDateRange($dateRange['start'], $dateRange['end']);

        return [
            'application_name' => $applicationName,
            'period' => $period,
            'date_range' => $dateRange,
            'total_emails' => $query->count(),
            'sent_emails' => $query->clone()->byStatus('sent')->count(),
            'failed_emails' => $query->clone()->byStatus('failed')->count(),
            'pending_emails' => $query->clone()->byStatus('pending')->count(),
            'delivered_emails' => $query->clone()->byStatus('delivered')->count(),
            'bounced_emails' => $query->clone()->byStatus('bounced')->count(),
            'success_rate' => $this->calculateSuccessRate($query),
            'daily_breakdown' => $this->getDailyBreakdownByApplication($applicationName, $dateRange),
            'top_users' => $this->getTopUsersByApplication($applicationName, $dateRange),
            'top_tokens' => $this->getTopTokensByApplication($applicationName, $dateRange),
        ];
    }

    /**
     * Get global email statistics
     */
    public function getGlobalStatistics(?string $period = 'month'): array
    {
        $dateRange = $this->getDateRange($period);

        $query = EmailLog::inDateRange($dateRange['start'], $dateRange['end']);

        return [
            'period' => $period,
            'date_range' => $dateRange,
            'total_emails' => $query->count(),
            'sent_emails' => $query->clone()->byStatus('sent')->count(),
            'failed_emails' => $query->clone()->byStatus('failed')->count(),
            'pending_emails' => $query->clone()->byStatus('pending')->count(),
            'delivered_emails' => $query->clone()->byStatus('delivered')->count(),
            'bounced_emails' => $query->clone()->byStatus('bounced')->count(),
            'success_rate' => $this->calculateSuccessRate($query),
            'daily_breakdown' => $this->getGlobalDailyBreakdown($dateRange),
            'top_applications' => $this->getGlobalTopApplications($dateRange),
            'top_users' => $this->getGlobalTopUsers($dateRange),
            'mailer_breakdown' => $this->getMailerBreakdown($dateRange),
        ];
    }

    /**
     * Calculate success rate
     */
    private function calculateSuccessRate($query): float
    {
        $total = $query->count();
        if ($total === 0) return 0;

        $successful = $query->clone()->whereIn('status', ['sent', 'delivered'])->count();
        return round(($successful / $total) * 100, 2);
    }

    /**
     * Get date range based on period
     */
    private function getDateRange(string $period): array
    {
        switch ($period) {
            case 'today':
                return [
                    'start' => Carbon::today(),
                    'end' => Carbon::now()
                ];
            case 'week':
                return [
                    'start' => Carbon::now()->startOfWeek(),
                    'end' => Carbon::now()
                ];
            case 'month':
                return [
                    'start' => Carbon::now()->startOfMonth(),
                    'end' => Carbon::now()
                ];
            case 'quarter':
                return [
                    'start' => Carbon::now()->startOfQuarter(),
                    'end' => Carbon::now()
                ];
            case 'year':
                return [
                    'start' => Carbon::now()->startOfYear(),
                    'end' => Carbon::now()
                ];
            default:
                return [
                    'start' => Carbon::now()->startOfMonth(),
                    'end' => Carbon::now()
                ];
        }
    }

    /**
     * Get daily breakdown for user
     */
    private function getDailyBreakdown(int $userId, array $dateRange): array
    {
        return EmailLog::byUser($userId)
            ->inDateRange($dateRange['start'], $dateRange['end'])
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(CASE WHEN status = "sent" THEN 1 ELSE 0 END) as sent'),
                DB::raw('SUM(CASE WHEN status = "failed" THEN 1 ELSE 0 END) as failed')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->toArray();
    }

    /**
     * Get daily breakdown by token
     */
    private function getDailyBreakdownByToken(int $tokenId, array $dateRange): array
    {
        return EmailLog::byToken($tokenId)
            ->inDateRange($dateRange['start'], $dateRange['end'])
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(CASE WHEN status = "sent" THEN 1 ELSE 0 END) as sent'),
                DB::raw('SUM(CASE WHEN status = "failed" THEN 1 ELSE 0 END) as failed')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->toArray();
    }

    /**
     * Get daily breakdown by application
     */
    private function getDailyBreakdownByApplication(string $applicationName, array $dateRange): array
    {
        return EmailLog::byApplication($applicationName)
            ->inDateRange($dateRange['start'], $dateRange['end'])
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(CASE WHEN status = "sent" THEN 1 ELSE 0 END) as sent'),
                DB::raw('SUM(CASE WHEN status = "failed" THEN 1 ELSE 0 END) as failed')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->toArray();
    }

    /**
     * Get global daily breakdown
     */
    private function getGlobalDailyBreakdown(array $dateRange): array
    {
        return EmailLog::inDateRange($dateRange['start'], $dateRange['end'])
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(CASE WHEN status = "sent" THEN 1 ELSE 0 END) as sent'),
                DB::raw('SUM(CASE WHEN status = "failed" THEN 1 ELSE 0 END) as failed')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->toArray();
    }

    /**
     * Get top applications for user
     */
    private function getTopApplications(int $userId, array $dateRange): array
    {
        return EmailLog::byUser($userId)
            ->inDateRange($dateRange['start'], $dateRange['end'])
            ->select('application_name', DB::raw('COUNT(*) as count'))
            ->whereNotNull('application_name')
            ->groupBy('application_name')
            ->orderBy('count', 'desc')
            ->limit(10)
            ->get()
            ->toArray();
    }

    /**
     * Get top applications by token
     */
    private function getTopApplicationsByToken(int $tokenId, array $dateRange): array
    {
        return EmailLog::byToken($tokenId)
            ->inDateRange($dateRange['start'], $dateRange['end'])
            ->select('application_name', DB::raw('COUNT(*) as count'))
            ->whereNotNull('application_name')
            ->groupBy('application_name')
            ->orderBy('count', 'desc')
            ->limit(10)
            ->get()
            ->toArray();
    }

    /**
     * Get top recipients for user
     */
    private function getTopRecipients(int $userId, array $dateRange): array
    {
        return EmailLog::byUser($userId)
            ->inDateRange($dateRange['start'], $dateRange['end'])
            ->select('to', DB::raw('COUNT(*) as count'))
            ->groupBy('to')
            ->orderBy('count', 'desc')
            ->limit(10)
            ->get()
            ->toArray();
    }

    /**
     * Get global top applications
     */
    private function getGlobalTopApplications(array $dateRange): array
    {
        return EmailLog::inDateRange($dateRange['start'], $dateRange['end'])
            ->select('application_name', DB::raw('COUNT(*) as count'))
            ->whereNotNull('application_name')
            ->groupBy('application_name')
            ->orderBy('count', 'desc')
            ->limit(10)
            ->get()
            ->toArray();
    }

    /**
     * Get global top users
     */
    private function getGlobalTopUsers(array $dateRange): array
    {
        return EmailLog::inDateRange($dateRange['start'], $dateRange['end'])
            ->join('users', 'email_logs.user_id', '=', 'users.id')
            ->select('users.name', 'users.email', DB::raw('COUNT(*) as count'))
            ->groupBy('users.id', 'users.name', 'users.email')
            ->orderBy('count', 'desc')
            ->limit(10)
            ->get()
            ->toArray();
    }

    /**
     * Get top users by application
     */
    private function getTopUsersByApplication(string $applicationName, array $dateRange): array
    {
        return EmailLog::byApplication($applicationName)
            ->inDateRange($dateRange['start'], $dateRange['end'])
            ->join('users', 'email_logs.user_id', '=', 'users.id')
            ->select('users.name', 'users.email', DB::raw('COUNT(*) as count'))
            ->groupBy('users.id', 'users.name', 'users.email')
            ->orderBy('count', 'desc')
            ->limit(10)
            ->get()
            ->toArray();
    }

    /**
     * Get top tokens by application
     */
    private function getTopTokensByApplication(string $applicationName, array $dateRange): array
    {
        return EmailLog::byApplication($applicationName)
            ->inDateRange($dateRange['start'], $dateRange['end'])
            ->join('api_tokens', 'email_logs.api_token_id', '=', 'api_tokens.id')
            ->select('api_tokens.name', DB::raw('COUNT(*) as count'))
            ->groupBy('api_tokens.id', 'api_tokens.name')
            ->orderBy('count', 'desc')
            ->limit(10)
            ->get()
            ->toArray();
    }

    /**
     * Get mailer breakdown
     */
    private function getMailerBreakdown(array $dateRange): array
    {
        return EmailLog::inDateRange($dateRange['start'], $dateRange['end'])
            ->select('mailer_used', DB::raw('COUNT(*) as count'))
            ->groupBy('mailer_used')
            ->orderBy('count', 'desc')
            ->get()
            ->toArray();
    }

    /**
     * Get error analysis by token
     */
    private function getErrorAnalysisByToken(int $tokenId, array $dateRange): array
    {
        return EmailLog::byToken($tokenId)
            ->inDateRange($dateRange['start'], $dateRange['end'])
            ->byStatus('failed')
            ->select('error_message', DB::raw('COUNT(*) as count'))
            ->whereNotNull('error_message')
            ->groupBy('error_message')
            ->orderBy('count', 'desc')
            ->limit(10)
            ->get()
            ->toArray();
    }
}

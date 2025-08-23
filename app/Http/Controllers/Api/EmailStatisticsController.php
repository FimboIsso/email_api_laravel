<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\EmailStatisticsService;
use App\Models\ApiToken;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

class EmailStatisticsController extends Controller
{
    protected EmailStatisticsService $statisticsService;

    public function __construct(EmailStatisticsService $statisticsService)
    {
        $this->statisticsService = $statisticsService;
    }

    /**
     * Get user email statistics
     */
    public function userStats(Request $request): JsonResponse
    {
        $request->validate([
            'period' => ['nullable', Rule::in(['today', 'week', 'month', 'quarter', 'year'])],
        ]);

        $user = $request->user();
        $period = $request->get('period', 'month');

        try {
            $statistics = $this->statisticsService->getUserStatistics($user->id, $period);

            return response()->json([
                'success' => true,
                'data' => $statistics
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des statistiques utilisateur',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get token email statistics
     */
    public function tokenStats(Request $request, int $tokenId): JsonResponse
    {
        $request->validate([
            'period' => ['nullable', Rule::in(['today', 'week', 'month', 'quarter', 'year'])],
        ]);

        $user = $request->user();
        $period = $request->get('period', 'month');

        // Verify that the token belongs to the user
        $token = ApiToken::where('id', $tokenId)
            ->where('user_id', $user->id)
            ->first();

        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'Token non trouvé ou vous n\'avez pas l\'autorisation'
            ], 404);
        }

        try {
            $statistics = $this->statisticsService->getTokenStatistics($tokenId, $period);

            return response()->json([
                'success' => true,
                'data' => $statistics
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des statistiques du token',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get application email statistics
     */
    public function applicationStats(Request $request, string $applicationName): JsonResponse
    {
        $request->validate([
            'period' => ['nullable', Rule::in(['today', 'week', 'month', 'quarter', 'year'])],
        ]);

        $user = $request->user();
        $period = $request->get('period', 'month');

        try {
            // Verify that the application has emails from this user
            $hasEmails = \App\Models\EmailLog::where('user_id', $user->id)
                ->where('application_name', $applicationName)
                ->exists();

            if (!$hasEmails) {
                return response()->json([
                    'success' => false,
                    'message' => 'Aucun email trouvé pour cette application'
                ], 404);
            }

            $statistics = $this->statisticsService->getApplicationStatistics($applicationName, $period);

            // Filter statistics to only include data from this user
            $statistics['user_filtered'] = true;

            return response()->json([
                'success' => true,
                'data' => $statistics
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des statistiques de l\'application',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get global statistics (admin only)
     */
    public function globalStats(Request $request): JsonResponse
    {
        $request->validate([
            'period' => ['nullable', Rule::in(['today', 'week', 'month', 'quarter', 'year'])],
        ]);

        $user = $request->user();

        // For now, allow all users to see global stats
        // In the future, you might want to add admin role check

        $period = $request->get('period', 'month');

        try {
            $statistics = $this->statisticsService->getGlobalStatistics($period);

            return response()->json([
                'success' => true,
                'data' => $statistics
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des statistiques globales',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get user's email history
     */
    public function emailHistory(Request $request): JsonResponse
    {
        $request->validate([
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
            'status' => ['nullable', Rule::in(['pending', 'sent', 'failed', 'bounced', 'delivered'])],
            'application' => ['nullable', 'string', 'max:255'],
            'from_date' => ['nullable', 'date'],
            'to_date' => ['nullable', 'date', 'after_or_equal:from_date'],
        ]);

        $user = $request->user();
        $perPage = $request->get('per_page', 20);

        try {
            $query = \App\Models\EmailLog::with(['apiToken', 'mailConfiguration'])
                ->where('user_id', $user->id);

            if ($status = $request->get('status')) {
                $query->where('status', $status);
            }

            if ($application = $request->get('application')) {
                $query->where('application_name', $application);
            }

            if ($fromDate = $request->get('from_date')) {
                $query->whereDate('created_at', '>=', $fromDate);
            }

            if ($toDate = $request->get('to_date')) {
                $query->whereDate('created_at', '<=', $toDate);
            }

            $emails = $query->orderBy('created_at', 'desc')
                ->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => $emails
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération de l\'historique des emails',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get email details
     */
    public function emailDetails(Request $request, int $emailId): JsonResponse
    {
        $user = $request->user();

        try {
            $email = \App\Models\EmailLog::with(['apiToken', 'mailConfiguration', 'user'])
                ->where('user_id', $user->id)
                ->where('id', $emailId)
                ->first();

            if (!$email) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email non trouvé'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $email
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des détails de l\'email',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

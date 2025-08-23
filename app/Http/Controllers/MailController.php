<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Mail\CustomMail;
use App\Services\MailService;
use App\Models\ApiToken;
use Exception;

class MailController extends Controller
{
    /**
     * Send email via API
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendEmail(Request $request)
    {
        try {
            // Validation des données
            $validator = Validator::make($request->all(), [
                'to' => 'required|email',
                'subject' => 'required|string|max:255',
                'message' => 'required|string',
                'cc' => 'sometimes|array',
                'cc.*' => 'email',
                'bcc' => 'sometimes|array',
                'bcc.*' => 'email',
                'attachments' => 'sometimes|array',
                'attachments.*' => 'file|max:10240', // Max 10MB par fichier
                'application_name' => 'sometimes|string|max:255', // Nom de l'application
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $data = $validator->validated();

            // Get the authenticated user and token from the request
            $user = $request->user();
            $token = $request->attributes->get('api_token'); // Added by middleware

            // Apply user mail configuration
            MailService::applyUserMailConfig($user);

            // Get mail configuration for logging
            $mailConfig = MailService::getMailConfigurationForUser($user, $token);

            // Prepare email data for logging
            $emailData = [
                'to' => $data['to'],
                'subject' => $data['subject'],
                'message' => $data['message'],
                'cc' => $data['cc'] ?? null,
                'bcc' => $data['bcc'] ?? null,
                'application_name' => $data['application_name'] ?? ($token ? $token->name : 'API'),
                'metadata' => [
                    'has_attachments' => !empty($data['attachments']),
                    'attachment_count' => count($data['attachments'] ?? []),
                    'request_ip' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                ]
            ];

            // Use the new MailService method that logs emails
            $success = MailService::sendAndLogEmail($emailData, $user, $token, $mailConfig, $request);

            if ($success) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Email sent successfully',
                    'data' => [
                        'to' => $data['to'],
                        'subject' => $data['subject'],
                        'sent_at' => now()->toDateTimeString(),
                        'sent_by' => $user->name,
                        'application' => $emailData['application_name'],
                        'token_used' => $token ? $token->name : null
                    ]
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to send email. Check logs for details.'
                ], 500);
            }

        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to send email: ' . $e->getMessage()
            ], 500);
        }
    }
}

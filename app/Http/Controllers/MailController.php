<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Mail\CustomMail;
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
                'attachments.*' => 'file|max:10240' // Max 10MB par fichier
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $data = $validator->validated();

            // Get the authenticated user from the request
            $user = $request->user();

            // Créer et envoyer l'email
            $mail = new CustomMail(
                $data['to'],
                $data['subject'],
                $data['message'],
                $user->name ?? 'UZASHOP Client'
            );

            // Ajouter CC si présent
            if (!empty($data['cc'])) {
                $mail->cc($data['cc']);
            }

            // Ajouter BCC si présent
            if (!empty($data['bcc'])) {
                $mail->bcc($data['bcc']);
            }

            // Ajouter les pièces jointes si présentes
            if (!empty($data['attachments'])) {
                foreach ($data['attachments'] as $attachment) {
                    $mail->attach($attachment->getRealPath(), [
                        'as' => $attachment->getClientOriginalName(),
                        'mime' => $attachment->getMimeType(),
                    ]);
                }
            }

            // Envoyer l'email
            Mail::to($data['to'])->send($mail);

            return response()->json([
                'status' => 'success',
                'message' => 'Email sent successfully',
                'data' => [
                    'to' => $data['to'],
                    'subject' => $data['subject'],
                    'sent_at' => now()->toDateTimeString(),
                    'sent_by' => $user->name
                ]
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to send email: ' . $e->getMessage()
            ], 500);
        }
    }
}

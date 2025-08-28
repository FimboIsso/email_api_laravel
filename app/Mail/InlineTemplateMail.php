<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Blade;

class InlineTemplateMail extends Mailable
{
    use Queueable, SerializesModels;

    public $emailData;
    public $templateData;

    public function __construct(array $emailData, array $templateData = [])
    {
        $this->emailData = $emailData;
        $this->templateData = $templateData;
    }

    public function build()
    {
        $mail = $this->subject($this->emailData['subject']);

        // Si un contenu de template est fourni
        if (!empty($this->emailData['template_content'])) {
            try {
                // Créer un fichier temporaire pour le template
                $tempViewName = 'temp_email_' . uniqid();
                $tempViewPath = resource_path('views/emails/' . $tempViewName . '.blade.php');

                // Créer le répertoire s'il n'existe pas
                $emailViewsDir = resource_path('views/emails');
                if (!is_dir($emailViewsDir)) {
                    mkdir($emailViewsDir, 0755, true);
                }

                // Écrire le contenu du template dans le fichier temporaire
                file_put_contents($tempViewPath, $this->emailData['template_content']);

                // Utiliser le template temporaire avec les données
                $mail->view('emails.' . $tempViewName)
                    ->with($this->templateData);

                // Programmer la suppression du fichier après l'envoi
                register_shutdown_function(function () use ($tempViewPath) {
                    if (file_exists($tempViewPath)) {
                        unlink($tempViewPath);
                    }
                });
            } catch (\Exception $e) {
                // En cas d'erreur, utiliser le template par défaut
                $mail->view('emails.default')
                    ->with([
                        'content' => $this->emailData['message'],
                        'data' => $this->templateData,
                        'error' => 'Template processing failed: ' . $e->getMessage()
                    ]);
            }
        } else {
            // Utiliser le template par défaut
            $mail->view('emails.default')
                ->with([
                    'content' => $this->emailData['message'],
                    'data' => $this->templateData
                ]);
        }

        // Ajouter CC et BCC si présents
        if (!empty($this->emailData['cc'])) {
            $mail->cc($this->emailData['cc']);
        }

        if (!empty($this->emailData['bcc'])) {
            $mail->bcc($this->emailData['bcc']);
        }

        return $mail;
    }
}

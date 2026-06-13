<?php

declare(strict_types=1);

namespace Src\Service\Notification;

use Src\Entity\Inscription\Inscription;
use Src\Entity\Event\Event;

final class InscriptionMailService
{
    private MailerService $mailer;

    public function __construct()
    {
        $this->mailer = new MailerService();
    }

    public function sendConfirmation(Inscription $inscription, Event $event): void
    {
        $toEmail = $inscription->email();
        $toName  = $inscription->name() . ' ' . $inscription->surname();
        $subject = '✓ Inscripción confirmada - ' . $event->title();

        $htmlBody = $this->buildHtml($inscription, $event);

        $this->mailer->send($toEmail, $toName, $subject, $htmlBody);
    }

    private function buildHtml(Inscription $inscription, Event $event): string
    {
        $nombre      = htmlspecialchars($inscription->name(), ENT_QUOTES, 'UTF-8');
        $titulo      = htmlspecialchars($event->title(), ENT_QUOTES, 'UTF-8');
        $descripcion = nl2br(htmlspecialchars($event->description(), ENT_QUOTES, 'UTF-8'));
        $fechaFin    = $event->endDate() ? $event->endDate()->format('d/m/Y') : 'A confirmar';

        return <<<HTML
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inscripción confirmada</title>
</head>
<body style="margin:0; padding:0; font-family: Arial, Helvetica, sans-serif; background-color:#f4f4f4;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f4f4; padding:30px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color:#ffffff; border-radius:8px; overflow:hidden; box-shadow:0 2px 8px rgba(0,0,0,0.1);">
                    <tr>
                        <td style="background-color:#2c3e50; padding:30px; text-align:center;">
                            <h1 style="color:#ffffff; margin:0; font-size:24px;">📚 Biblioteca TUP</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:40px 30px;">
                            <h2 style="color:#2c3e50; margin-top:0;">¡Hola {$nombre}!</h2>
                            <p style="color:#555; font-size:16px; line-height:1.5;">
                                Tu inscripción fue registrada con éxito. Te esperamos en el evento.
                            </p>

                            <div style="background-color:#f9f9f9; border-left:4px solid #3498db; padding:20px; margin:25px 0; border-radius:4px;">
                                <h3 style="color:#2c3e50; margin-top:0; margin-bottom:15px;">Detalles del evento</h3>
                                <p style="margin:8px 0; color:#333;"><strong>📌 Curso/Evento:</strong> {$titulo}</p>
                                <p style="margin:8px 0; color:#333;"><strong>📝 Descripción:</strong><br>{$descripcion}</p>
                                <p style="margin:8px 0; color:#333;"><strong>📅 Fecha:</strong> {$fechaFin}</p>
                            </div>

                            <p style="color:#555; font-size:14px; line-height:1.5;">
                                Si tenés alguna duda, podés acercarte personalmente a la biblioteca.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="background-color:#ecf0f1; padding:20px 30px; text-align:center; color:#7f8c8d; font-size:12px;">
                            <p style="margin:0;">Este es un mail automático, por favor no respondas.</p>
                            <p style="margin:5px 0 0 0;">© Biblioteca TUP</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
HTML;
    }
}

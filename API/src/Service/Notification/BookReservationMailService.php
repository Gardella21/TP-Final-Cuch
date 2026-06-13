<?php

declare(strict_types=1);

namespace Src\Service\Notification;

use Src\Entity\BookReservation\BookReservation;
use Src\Entity\Book\Book;

final class BookReservationMailService
{
    private MailerService $mailer;

    public function __construct()
    {
        $this->mailer = new MailerService();
    }

    public function sendConfirmation(BookReservation $reservation, Book $book): void
    {
        $toEmail = $reservation->email();
        $toName  = $reservation->name() . ' ' . $reservation->surname();
        $subject = '✓ Reserva confirmada - ' . $book->titulo();

        $htmlBody = $this->buildHtml($reservation, $book);

        $this->mailer->send($toEmail, $toName, $subject, $htmlBody);
    }

    private function buildHtml(BookReservation $reservation, Book $book): string
    {
        $nombre    = htmlspecialchars($reservation->name(), ENT_QUOTES, 'UTF-8');
        $titulo    = htmlspecialchars($book->titulo(), ENT_QUOTES, 'UTF-8');
        $autor     = htmlspecialchars($book->autor(), ENT_QUOTES, 'UTF-8');
        $codigo    = htmlspecialchars($book->codigo(), ENT_QUOTES, 'UTF-8');
        $editorial = htmlspecialchars($book->editorial(), ENT_QUOTES, 'UTF-8');
        $anio      = $book->anio();

        return <<<HTML
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reserva confirmada</title>
</head>
<body style="margin:0; padding:0; font-family: Arial, Helvetica, sans-serif; background-color:#f4f4f4;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f4f4; padding:30px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color:#ffffff; border-radius:8px; overflow:hidden; box-shadow:0 2px 8px rgba(0,0,0,0.1);">
                    <tr>
                        <td style="background-color:#27ae60; padding:30px; text-align:center;">
                            <h1 style="color:#ffffff; margin:0; font-size:24px;">📚 Biblioteca TUP</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:40px 30px;">
                            <h2 style="color:#2c3e50; margin-top:0;">¡Hola {$nombre}!</h2>
                            <p style="color:#555; font-size:16px; line-height:1.5;">
                                Tu reserva fue registrada correctamente. Te avisaremos cuando esté lista para retirar.
                            </p>

                            <div style="background-color:#f9f9f9; border-left:4px solid #27ae60; padding:20px; margin:25px 0; border-radius:4px;">
                                <h3 style="color:#2c3e50; margin-top:0; margin-bottom:15px;">Detalles del libro</h3>
                                <p style="margin:8px 0; color:#333;"><strong>📖 Título:</strong> {$titulo}</p>
                                <p style="margin:8px 0; color:#333;"><strong>✍️ Autor:</strong> {$autor}</p>
                                <p style="margin:8px 0; color:#333;"><strong>🏷️ Código:</strong> {$codigo}</p>
                                <p style="margin:8px 0; color:#333;"><strong>🏢 Editorial:</strong> {$editorial}</p>
                                <p style="margin:8px 0; color:#333;"><strong>📅 Año:</strong> {$anio}</p>
                            </div>

                            <div style="background-color:#fff3cd; border:1px solid #ffeaa7; padding:15px; border-radius:4px; margin:20px 0;">
                                <p style="margin:0; color:#856404; font-size:14px;">
                                    <strong>⚠️ Importante:</strong> Tu reserva está en estado <strong>pendiente</strong>.
                                    Recibirás otro mail cuando la biblioteca la apruebe.
                                </p>
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
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

    /**
     * Mail cuando el admin ACEPTA la reserva (estado = confirmada).
     */
    public function sendAccepted(BookReservation $reservation, Book $book): void
    {
        $toEmail = $reservation->email();
        $toName  = $reservation->name() . ' ' . $reservation->surname();
        $subject = '✅ Reserva aprobada - ' . $book->titulo();

        $htmlBody = $this->buildHtml(
            reservation: $reservation,
            book: $book,
            headerColor: '#27ae60',
            titulo: '¡Tu reserva fue aprobada!',
            mensaje: 'Buenas noticias: la biblioteca aprobó tu reserva. Ya podés pasar a retirar el libro por nuestra sede en el horario de atención.',
            aviso: null,
            avisoColor: null
        );

        $this->mailer->send($toEmail, $toName, $subject, $htmlBody);
    }

    /**
     * Mail cuando el admin RECHAZA la reserva (estado = cancelada).
     */
    public function sendRejected(BookReservation $reservation, Book $book): void
    {
        $toEmail = $reservation->email();
        $toName  = $reservation->name() . ' ' . $reservation->surname();
        $subject = 'Reserva no aprobada - ' . $book->titulo();

        $htmlBody = $this->buildHtml(
            reservation: $reservation,
            book: $book,
            headerColor: '#c0392b',
            titulo: 'Tu reserva no pudo aprobarse',
            mensaje: 'Lamentamos informarte que, por el momento, tu reserva no pudo ser aprobada. Esto puede deberse a que el libro no está disponible. Si tenés dudas, podés acercarte personalmente a la biblioteca.',
            aviso: null,
            avisoColor: null
        );

        $this->mailer->send($toEmail, $toName, $subject, $htmlBody);
    }

    /**
     * Mail de confirmación al momento de reservar (estado = pendiente).
     * Se mantiene por si más adelante querés avisar que la reserva se registró.
     */
    public function sendConfirmation(BookReservation $reservation, Book $book): void
    {
        $toEmail = $reservation->email();
        $toName  = $reservation->name() . ' ' . $reservation->surname();
        $subject = '📚 Reserva registrada - ' . $book->titulo();

        $htmlBody = $this->buildHtml(
            reservation: $reservation,
            book: $book,
            headerColor: '#2c3e50',
            titulo: '¡Recibimos tu reserva!',
            mensaje: 'Tu reserva quedó registrada y está pendiente de aprobación. Te vamos a avisar por este medio cuando la biblioteca la revise.',
            aviso: 'Tu reserva está en estado pendiente. Recibirás otro mail cuando sea aprobada o rechazada.',
            avisoColor: '#856404'
        );

        $this->mailer->send($toEmail, $toName, $subject, $htmlBody);
    }

    /**
     * Arma el HTML del mail. Centraliza el diseño para no repetirlo en cada método.
     */
    private function buildHtml(
        BookReservation $reservation,
        Book $book,
        string $headerColor,
        string $titulo,
        string $mensaje,
        ?string $aviso,
        ?string $avisoColor
    ): string {
        $nombre    = htmlspecialchars($reservation->name(), ENT_QUOTES, 'UTF-8');
        $tituloLib = htmlspecialchars($book->titulo(), ENT_QUOTES, 'UTF-8');
        $autor     = htmlspecialchars($book->autor(), ENT_QUOTES, 'UTF-8');
        $codigo    = htmlspecialchars($book->codigo(), ENT_QUOTES, 'UTF-8');
        $editorial = htmlspecialchars($book->editorial(), ENT_QUOTES, 'UTF-8');
        $anio      = $book->anio();

        $tituloSafe  = htmlspecialchars($titulo, ENT_QUOTES, 'UTF-8');
        $mensajeSafe = htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8');

        // Bloque de aviso opcional (recuadro amarillo tipo "importante")
        $avisoHtml = '';
        if ($aviso !== null) {
            $avisoSafe  = htmlspecialchars($aviso, ENT_QUOTES, 'UTF-8');
            $avisoColor = $avisoColor ?? '#856404';
            $avisoHtml = <<<HTML
                            <div style="background-color:#fff3cd; border:1px solid #ffeaa7; padding:15px; border-radius:4px; margin:20px 0;">
                                <p style="margin:0; color:{$avisoColor}; font-size:14px;">
                                    <strong>⚠️ Importante:</strong> {$avisoSafe}
                                </p>
                            </div>
            HTML;
        }

        return <<<HTML
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>{$tituloSafe}</title>
</head>
<body style="margin:0; padding:0; font-family: Arial, Helvetica, sans-serif; background-color:#f4f4f4;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f4f4; padding:30px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color:#ffffff; border-radius:8px; overflow:hidden; box-shadow:0 2px 8px rgba(0,0,0,0.1);">
                    <tr>
                        <td style="background-color:{$headerColor}; padding:30px; text-align:center;">
                            <h1 style="color:#ffffff; margin:0; font-size:24px;">📚 Biblioteca TUP</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:40px 30px;">
                            <h2 style="color:#2c3e50; margin-top:0;">¡Hola {$nombre}!</h2>
                            <p style="color:#555; font-size:16px; line-height:1.5;">
                                {$mensajeSafe}
                            </p>

                            <div style="background-color:#f9f9f9; border-left:4px solid {$headerColor}; padding:20px; margin:25px 0; border-radius:4px;">
                                <h3 style="color:#2c3e50; margin-top:0; margin-bottom:15px;">Detalles del libro</h3>
                                <p style="margin:8px 0; color:#333;"><strong>📖 Título:</strong> {$tituloLib}</p>
                                <p style="margin:8px 0; color:#333;"><strong>✍️ Autor:</strong> {$autor}</p>
                                <p style="margin:8px 0; color:#333;"><strong>🏷️ Código:</strong> {$codigo}</p>
                                <p style="margin:8px 0; color:#333;"><strong>🏢 Editorial:</strong> {$editorial}</p>
                                <p style="margin:8px 0; color:#333;"><strong>📅 Año:</strong> {$anio}</p>
                            </div>
{$avisoHtml}
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
<?php

declare(strict_types=1);

namespace Src\Service\Notification;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as PHPMailerException;

final class MailerService
{
    private string $host;
    private int $port;
    private string $username;
    private string $password;
    private string $fromAddress;
    private string $fromName;
    private ?string $bccAddress;

    public function __construct()
    {
        $this->host        = $_ENV['MAIL_HOST']         ?? 'smtp.gmail.com';
        $this->port        = (int)($_ENV['MAIL_PORT']   ?? 587);
        $this->username    = $_ENV['MAIL_USERNAME']     ?? '';
        $this->password    = $_ENV['MAIL_PASSWORD']     ?? '';
        $this->fromAddress = $_ENV['MAIL_FROM_ADDRESS'] ?? $this->username;
        $this->fromName    = $_ENV['MAIL_FROM_NAME']    ?? 'Biblioteca TUP';
        $this->bccAddress  = $_ENV['MAIL_BCC_ADDRESS']  ?? null;
    }

    public function send(string $toEmail, string $toName, string $subject, string $htmlBody): void
    {
        $mail = new PHPMailer(true);

        // Configuración SMTP
        $mail->isSMTP();
        $mail->Host       = $this->host;
        $mail->SMTPAuth   = true;
        $mail->Username   = $this->username;
        $mail->Password   = $this->password;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = $this->port;
        $mail->CharSet    = 'UTF-8';

        // Remitente
        $mail->setFrom($this->fromAddress, $this->fromName);

        // Destinatario
        $mail->addAddress($toEmail, $toName);

        // Copia oculta al admin (si está configurada)
        if (!empty($this->bccAddress)) {
            $mail->addBCC($this->bccAddress);
        }

        // Contenido
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $htmlBody;
        $mail->AltBody = strip_tags($htmlBody);

        $mail->send();
    }
}
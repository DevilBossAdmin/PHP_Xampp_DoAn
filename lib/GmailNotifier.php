<?php
require_once __DIR__ . '/../config/mail_env.php';
require_once __DIR__ . '/SMTPMailer.php';

class GmailNotifier {
    public static function sendOrderUpdate($to, $customerName, $subject, $htmlBody) {
        $fromEmail = mail_env('MAIL_FROM_ADDRESS', mail_env('EMAIL_USERNAME', ''));
        if (empty($fromEmail) || empty($to)) {
            self::logNotification($to, $subject, 'skipped', 'Thiếu cấu hình EMAIL_USERNAME / MAIL_FROM_ADDRESS trong file .env');
            return array('ok' => false, 'message' => 'Chưa cấu hình SMTP Gmail trong file .env');
        }

        $result = SMTPMailer::send((string)$to, (string)$customerName, (string)$subject, (string)$htmlBody);
        self::logNotification($to, $subject, $result['ok'] ? 'sent' : 'failed', $result['message']);
        return $result;
    }

    private static function logNotification($email, $subject, $status, $message) {
        $line = sprintf("[%s] %s | %s | %s | %s
", date('Y-m-d H:i:s'), $status, $email, $subject, preg_replace('/\s+/', ' ', strip_tags((string)$message)));
        @file_put_contents(__DIR__ . '/../logs/order_notifications.log', $line, FILE_APPEND);
    }
}
?>
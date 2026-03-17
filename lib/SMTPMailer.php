<?php
require_once __DIR__ . '/../config/mail_env.php';

class SMTPMailer {
    private static function expect($socket, array $codes): array {
        $data = '';
        while (($line = fgets($socket, 515)) !== false) {
            $data .= $line;
            if (preg_match('/^([0-9]{3})([\s-])/', $line, $m)) {
                if ($m[2] === ' ') {
                    $code = (int)$m[1];
                    if (!in_array($code, $codes, true)) {
                        throw new Exception('SMTP unexpected response: ' . trim($data));
                    }
                    return [$code, $data];
                }
            }
        }
        throw new Exception('SMTP no response from server');
    }

    private static function sendCmd($socket, string $cmd, array $okCodes): array {
        fwrite($socket, $cmd . "\r\n");
        return self::expect($socket, $okCodes);
    }

    public static function send(string $toEmail, string $toName, string $subject, string $htmlBody): array {
        $host = mail_env('MAIL_HOST', 'smtp.gmail.com');
        $port = (int)mail_env('MAIL_PORT', '587');
        $username = mail_env('EMAIL_USERNAME');
        $password = mail_env('EMAIL_PASSWORD');
        $fromEmail = mail_env('MAIL_FROM_ADDRESS', $username ?: '');
        $fromName = mail_env('MAIL_FROM_NAME', 'Website Linh Kiện Điện Tử');
        $secure = strtolower((string)mail_env('MAIL_ENCRYPTION', 'tls'));
        $timeout = 20;

        if (empty($username) || empty($password) || empty($toEmail)) {
            return ['ok' => false, 'message' => 'Thiếu EMAIL_USERNAME hoặc EMAIL_PASSWORD trong file .env'];
        }

        $socket = @stream_socket_client("tcp://{$host}:{$port}", $errno, $errstr, $timeout, STREAM_CLIENT_CONNECT);
        if (!$socket) {
            return ['ok' => false, 'message' => 'Không kết nối được SMTP: ' . $errstr];
        }

        try {
            stream_set_timeout($socket, $timeout);
            self::expect($socket, [220]);
            $domain = mail_env('MAIL_EHLO_DOMAIN', 'localhost');
            self::sendCmd($socket, 'EHLO ' . $domain, [250]);

            if ($secure === 'tls') {
                self::sendCmd($socket, 'STARTTLS', [220]);
                if (!stream_socket_enable_crypto($socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)) {
                    throw new Exception('Không bật được TLS cho kết nối SMTP');
                }
                self::sendCmd($socket, 'EHLO ' . $domain, [250]);
            }

            self::sendCmd($socket, 'AUTH LOGIN', [334]);
            self::sendCmd($socket, base64_encode($username), [334]);
            self::sendCmd($socket, base64_encode($password), [235]);
            self::sendCmd($socket, 'MAIL FROM:<' . $fromEmail . '>', [250]);
            self::sendCmd($socket, 'RCPT TO:<' . $toEmail . '>', [250, 251]);
            self::sendCmd($socket, 'DATA', [354]);

            $headers = [
                'MIME-Version: 1.0',
                'Content-Type: text/html; charset=UTF-8',
                'From: ' . sprintf('%s <%s>', self::mimeHeader($fromName), $fromEmail),
                'To: ' . sprintf('%s <%s>', self::mimeHeader($toName ?: $toEmail), $toEmail),
                'Subject: ' . self::mimeHeader($subject),
                'Date: ' . date('r'),
            ];
            $body = implode("\r\n", $headers) . "\r\n\r\n" . str_replace("\n.", "\n..", $htmlBody) . "\r\n.";
            fwrite($socket, $body . "\r\n");
            self::expect($socket, [250]);
            self::sendCmd($socket, 'QUIT', [221]);
            fclose($socket);
            return ['ok' => true, 'message' => 'Đã gửi email SMTP thành công'];
        } catch (Exception $e) {
            if (is_resource($socket)) {
                fclose($socket);
            }
            return ['ok' => false, 'message' => $e->getMessage()];
        }
    }

    private static function mimeHeader(string $text): string {
        return '=?UTF-8?B?' . base64_encode($text) . '?=';
    }
}

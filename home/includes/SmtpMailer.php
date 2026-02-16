<?php
// includes/SmtpMailer.php

class SmtpMailer {
    private $host;
    private $port;
    private $user;
    private $pass;
    private $debug = false;

    public function __construct($host, $port, $user, $pass) {
        $this->host = $host;
        $this->port = $port;
        $this->user = $user;
        $this->pass = $pass;
    }

    public function send($to, $subject, $message, $fromName, $fromEmail) {
        $header = "MIME-Version: 1.0\r\n";
        $header .= "Content-type: text/html; charset=UTF-8\r\n";
        $header .= "From: $fromName <$fromEmail>\r\n";
        $header .= "To: $to\r\n";
        $header .= "Subject: $subject\r\n";
        $header .= "Date: " . date("r") . "\r\n";
        $header .= "\r\n";

        $full_message = $header . $message;

        try {
            // Connect to server
            $socket = fsockopen(($this->port == 465 ? "ssl://" : "") . $this->host, $this->port, $errno, $errstr, 30);
            if (!$socket) throw new Exception("Could not connect: $errstr ($errno)");
            $this->getResponse($socket, "220");

            // EHLO
            fwrite($socket, "EHLO " . $_SERVER['SERVER_NAME'] . "\r\n");
            $this->getResponse($socket, "250");

            // STARTTLS if port 587
            if ($this->port == 587) {
                fwrite($socket, "STARTTLS\r\n");
                $this->getResponse($socket, "220");
                if (!stream_socket_enable_crypto($socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)) {
                    throw new Exception("Cannot enable TLS");
                }
                // EHLO again after TLS
                fwrite($socket, "EHLO " . $_SERVER['SERVER_NAME'] . "\r\n");
                $this->getResponse($socket, "250");
            }

            // Auth
            fwrite($socket, "AUTH LOGIN\r\n");
            $this->getResponse($socket, "334");
            fwrite($socket, base64_encode($this->user) . "\r\n");
            $this->getResponse($socket, "334");
            fwrite($socket, base64_encode($this->pass) . "\r\n");
            $this->getResponse($socket, "235");

            // From
            fwrite($socket, "MAIL FROM: <$this->user>\r\n");
            $this->getResponse($socket, "250");

            // To
            fwrite($socket, "RCPT TO: <$to>\r\n");
            $this->getResponse($socket, "250");

            // Data
            fwrite($socket, "DATA\r\n");
            $this->getResponse($socket, "354");
            fwrite($socket, $full_message . "\r\n.\r\n");
            $this->getResponse($socket, "250");

            // Quit
            fwrite($socket, "QUIT\r\n");
            fclose($socket);

            return true;
        } catch (Exception $e) {
            if ($this->debug) echo "Error: " . $e->getMessage();
            return false;
        }
    }

    private function getResponse($socket, $expected) {
        $response = "";
        while ($line = fgets($socket, 512)) {
            $response .= $line;
            if (substr($line, 3, 1) == " ") break;
        }
        if (substr($response, 0, 3) !== $expected) {
            throw new Exception("Unexpected response: $response (Expected: $expected)");
        }
        return $response;
    }
}
?>

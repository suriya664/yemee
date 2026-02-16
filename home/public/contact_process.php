<?php
// public/contact_process.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'] ?? 'Not provided';
    $mobile  = $_POST['mobile'] ?? 'Not provided';
    $email = $_POST['email'] ?? 'Not provided';
    $message = $_POST['message'] ?? 'Not provided';
    $subject_form = $_POST['subject'] ?? 'Enquiry from Contact Form';

    $msg = "<html><body>";
    $msg .= "<h2>Hi Mesmaa Team,</h2>";
    $msg .= "<p>You have received a new enquiry from the contact form.</p>";
    $msg .= "<table border='1' cellpadding='5' cellspacing='0' style='border-collapse: collapse; min-width: 300px;'>";
    $msg .= "<tr><th align='left' bgcolor='#f2f2f2'>Name</th><td>{$name}</td></tr>";
    $msg .= "<tr><th align='left' bgcolor='#f2f2f2'>Mobile</th><td>{$mobile}</td></tr>";
    $msg .= "<tr><th align='left' bgcolor='#f2f2f2'>Email</th><td>{$email}</td></tr>";
    $msg .= "<tr><th align='left' bgcolor='#f2f2f2'>Subject</th><td>{$subject_form}</td></tr>";
    $msg .= "<tr><th align='left' bgcolor='#f2f2f2'>Message</th><td>" . nl2br(htmlspecialchars($message)) . "</td></tr>";
    $msg .= "</table>";
    $msg .= "<br><br>";
    $msg .= "<p>Regards,<br>{$name}</p>";
    $msg .= "</body></html>";

    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From: Mesmaa Website <noreply@yamee.co.in>' . "\r\n"; // Recommended to use a valid from domain
    $headers .= 'Reply-To: ' . $email . "\r\n";
    $headers .= 'Cc:yameecluster@gmail.com' . "\r\n";

    // Recipient email from user request
    $to = "ajithveera0504@gmail.com";
    $subject_email = "Enquiry: " . $subject_form . " from " . $name;

    // --- EASY SMTP CONFIGURATION ---
    // Update THESE details to start sending real emails
    $smtpHost = 'smtp.gmail.com';
    $smtpPort = 587; // 587 for TLS, 465 for SSL
    $smtpUser = 'your-email@gmail.com'; // Enter your email here
    $smtpPass = 'your-app-password';   // Enter your 16-character App Password here
    // -------------------------------

    require_once __DIR__ . '/../includes/SmtpMailer.php';
    $mailer = new SmtpMailer($smtpHost, $smtpPort, $smtpUser, $smtpPass);

    if ($mailer->send($to, $subject_email, $msg, "Mesmaa Website", $smtpUser)) {
        // Success redirect
        header("Location: contact.php?status=success");
    } else {
        // Check if we are on localhost to give a better hint
        $isLocal = in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1']);
        if ($isLocal) {
            header("Location: contact.php?status=smtp_error");
        } else {
            header("Location: contact.php?status=error");
        }
    }
    exit();
} else {
    // If not POST, redirect to contact page
    header("Location: contact.php");
    exit();
}
?>

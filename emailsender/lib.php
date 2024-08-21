<?php
defined('MOODLE_INTERNAL') || die;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;



/**
 * Custom function to send an email using SMTP.
 *
 * @param string $to Recipient's email address.
 * @param string $from Sender's email address.
 * @param string $subject Subject of the email.
 * @param string $message Body of the email.
 * @return bool True if the email was sent successfully, false otherwise.
 */
function my_custom_smtp_email_sender($to, $from, $subject, $message) {
 
 
 
    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; // Set the SMTP server to send through
        $mail->SMTPAuth   = true;
        $mail->Username   = 'abdullahamin919021@gmail.com'; // SMTP username
        $mail->Password   = 'lbtmzncktphsmpuj'; // SMTP password
        $mail->SMTPSecure = 'ssl'; // Enable TLS encryption, `ssl` also accepted
        $mail->Port       = 465; // TCP port to connect to

        // Recipients
        $mail->setFrom($from);
        $mail->addAddress($to);

        // Content
        $mail->isHTML(false); // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $message;

        // Send the email
        $mail->send();
        return true;
    } catch (Exception $e) {
        debugging('Message could not be sent. Mailer Error: ' . $mail->ErrorInfo, DEBUG_DEVELOPER);
        return false;
    }
}

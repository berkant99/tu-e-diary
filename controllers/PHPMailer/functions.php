<?php
require_once 'PHPMailerAutoload.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/controllers/constants.php';

function sendCodeToMail($recipient, $subject, $title, $code)
{
    $mail = new PHPMailer;
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.abv.bg';                           // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = EMAIL;                                // SMTP username
    $mail->Password = PASS;                                // SMTP password
    $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 465;                                       // TCP port to connect to
    $mail->setFrom(EMAIL, 'Technical University of Varna');
    $mail->addAddress($recipient);                      // Add a recipient
    $mail->addReplyTo(EMAIL);
    $mail->isHTML(true);                                    // Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body    = 
    '<p style="text-align: center; font-size: 20px;">' . $title . '</p><br>
    <div style=
    "border: 2px solid #175c93;
    border-radius: 25px;
    color: #175c93;
    text-align: center;
    font-size: 35px;
    width: 100%;
    font-weight: bold;
    letter-spacing: 2px;
    padding: 5px;">' . $code . '</div>';
    if (!$mail->send()) {
        return false;
    } else {
        return true;
    }
}

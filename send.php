<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPmailer\Exception;

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if (isset($_POST["send"])) {
    $mail = new PHPMailer(true);
    $mail->CharSet = "UTF-8";

    $mail->isSMTP();
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPAuth = true;
    $mail->Username = $_ENV['MAIL'];
    $mail->Password = $_ENV['PASSWORD'];
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;

    $mail->setFrom($_ENV['MAIL']);
    $mail->addAddress($_POST["email"]);

    $mail->isHTML(true);

    $mail->Subject = $_POST["subject"];
    $ek = "** Bana gönderdiğiniz mesajın bir kopyasıdır **";
    $mail->Body = $ek . $_POST["message"];

    $mail->Send();

    echo "
    <script>
        alert('Sent Successfully');
        document.location.href = 'index.php'
    </script>
    ";
}
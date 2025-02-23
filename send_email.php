<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'path/to/PHPMailer/src/Exception.php';
require 'path/to/PHPMailer/src/PHPMailer.php';
require 'path/to/PHPMailer/src/SMTP.php';

#require 'vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';  // Change for Outlook/Yahoo
    $mail->SMTPAuth   = true;
    $mail->Username   = '';  // Your email
    $mail->Password   = '';  // Use an App Password, not your real password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 465;

    // Read JSON input
    $data = json_decode(file_get_contents("php://input"), true);

    // Validate inputs
    if (empty($data["firstName"]) || empty($data["lastName"]) || empty($data["email"]) || empty($data["subject"]) || empty($data["message"])) {
        echo json_encode(["status" => "error", "message" => "All fields are required."]);
        exit;
    }

    // Prepare email
    $mail->setFrom($data["email"], $data["firstName"] . " " . $data["lastName"]);
    $mail->addAddress('samikshakolhe10@gmail.com');  // Your email
    $mail->Subject = $data["subject"];
    $mail->Body = "Name: " . $data["firstName"] . " " . $data["lastName"] . "\nEmail: " . $data["email"] . "\nMessage:\n" . $data["message"];

    // Send email
    $mail->send();
    echo json_encode(["status" => "success", "message" => "Email sent successfully!"]);
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => "Mailer Error: {$mail->ErrorInfo}"]);
}
?>
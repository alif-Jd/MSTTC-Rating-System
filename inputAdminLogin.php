<?php
session_start(); // Start the session at the beginning

// Include the configuration file
include 'config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

$mail = new PHPMailer(true);

// Get form data
$user = $_POST['Username'];
$pass = $_POST['Password'];

// Prepare and bind
$stmt = $connect->prepare("SELECT * FROM admins WHERE BINARY username = ? AND BINARY password = ?");
$stmt->bind_param("ss", $user, $pass);

// Execute the statement
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();

if ($result->num_rows > 0) {
    // Set session flag to indicate username and password are verified
    $_SESSION['username_verified'] = true;
    $_SESSION['username'] = $user; // Store the username in session (optional)

    // Generate OTP and set expiry time
    $otp_code = generateSecureNumericOTP(6);
    $otp_expiry = date("Y-m-d H:i:s", strtotime("+1 minutes"));
    $admin_email = $admin['email'];

    // Store OTP and expiry in the database
    $stmt = $connect->prepare("UPDATE admins SET otp_code = ?, otp_expiry = ? WHERE username = ?");
    $stmt->bind_param("sss", $otp_code, $otp_expiry, $user);
    $stmt->execute();

    // After verifying login credentials
    $_SESSION['username'] = $user; // Store the username in the session

    // Generate OTP and send it
    if (sendOTPEmail($admin_email, $otp_code)) {
        // Redirect to OTP verification page without passing the username in the URL
        header("Location: verify_otp.php");
        exit();
    } else {
            // failed to send Otp when lost connection
        header("Location: AdminLogin.php?error=Login 2FA Failed.For support, contact admin.");
        exit();
    }
} else {
    // Login failed
    header("Location: AdminLogin.php?error=Incorrect Username or Password.Try again!");
    exit();
}

// Close the connection
$stmt->close();
$connect->close();

// Function to generate a secure numeric OTP
function generateSecureNumericOTP($length = 6)
{
    $otp = '';
    for ($i = 0; $i < $length; $i++) {
        $otp .= random_int(0, 9);
    }
    return $otp;
}

// Function to send OTP email using PHPMailer
function sendOTPEmail($email, $otp_code)
{
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = '';//email here ''
        $mail->Password = '';//pass ''
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('', ''); //first '' put email , then second '' put name for who send it
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'OTP Code Admin MSTTC';
        $mail->Body = '
        <!DOCTYPE html>
<html>
<head>
    <style>
        @media only screen and (max-width: 600px) {
            .email-container {
                padding: 20px !important;
            }
            .email-content {
                padding: 30px !important;
            }
            .otp-code {
                font-size: 25px !important;
                letter-spacing: 5px !important;
            }
        }
    </style>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4;">
    <div style="background: linear-gradient(to right, black, #D6B400); padding: 20px; text-align: center;">
        <div class="email-container" style="background-color: #1a1b34; padding: 50px; border-radius: 10px; max-width: 600px; margin: 0 auto; color: #f2f2f2;">
            <h1 style="font-weight: bold; color: #ffffff;">MSTTC Rating System</h1>
            <h2 style="color: #f2f2f2;">Login <span style="background-color: #fdd835; padding: 2px 8px; color: #000000;">Code</span></h2>
            
            <div class="email-content" style="background-color: #f2f2f2; padding: 10px; border-radius: 8px; margin: 20px auto; max-width: 550px; text-align: center;">
                <p style="font-size: 16px; color: #000000;">Here is your login <span style="background-color: #fdd835; padding: 2px 4px; color: #000000;">code:</span></p>
                <h1 class="otp-code" style="font-size: 35px; letter-spacing: 10px; color: #000000;">' . $otp_code . '</h1>
            </div>

            <p style="color: #f2f2f2;">If you didn\'t request this, <span style="background-color: darkred; padding: 2px 4px; color: #ffffff;">please ignore this email.</span></p>
            <br>
            <p style="color: #f2f2f2;">&copy; 2024 MSTTC. All rights reserved.</p>
        </div>
    </div>
</body>
</html>';

        $mail->send();
        return true;
    } catch (Exception $e) {
        echo "Mailer Error: " . $mail->ErrorInfo;
        return false;
    }
}


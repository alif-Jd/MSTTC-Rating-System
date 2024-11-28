<?php
// Start session and enable error reporting for debugging
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include the configuration file for database connection
include 'config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

// Check if the form was submitted
$message = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the admin email from the form
    $email = $_POST['email'];

    // Prepare and execute the query to find the email in the database
    $stmt = $connect->prepare("SELECT * FROM admins WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Admin exists, retrieve the username and password
        $admin = $result->fetch_assoc();
        $username = $admin['username'];
        $password = $admin['password']; // Assuming password is stored as plain text (consider hashing it for security)

        // Send email with username and password
        if (sendCredentialsEmail($email, $username, $password)) {
            header("Location: ForgotPassword.php?success=Your credential has been sent to your email.");
            exit();
        } else {
            //$message = "Failed to send credentials. Please try again.";
            header("Location: ForgotPassword.php?error=Failed to send credentials.For support, contact admin.");
            exit();
        }
    } else {
        // Email not found in the database
        //$message = "Email not found.";
        // Email not found in the database
        header("Location: ForgotPassword.php?error=Email not register.Please enter a valid email.");
        exit();
    }

    // Close the statement and connection
    $stmt->close();
    $connect->close();
}

// Function to send credentials email using PHPMailer
function sendCredentialsEmail($email, $username, $password)
{
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'msttc24@gmail.com';
        $mail->Password = 'uasf xnba hcea bcft'; // Replace with your Gmail app-specific password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('msttc24@gmail.com', 'MSTTC Rating System');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Your Admin Credentials for MSTTC';
        $mail->Body = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        /* Responsive adjustments */
        @media only screen and (max-width: 600px) {
                
            .credentials-box {
                padding: 10px !important;
                height: auto !important;
                margin: 10px 0 !important;
            }
            .credentials-text {
                font-size: 15px !important;
            }
        }
    </style>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4;">

    <div style="background: linear-gradient(to right, black, #D6B400); padding: 20px; text-align: center;">
        <div class="email-container" style="background-color: #1a1b34; padding: 50px; border-radius: 10px; max-width: 600px; margin: 0 auto; color: #f2f2f2;">
            <h1 style="font-weight: bold; color: #ffffff;">MSTTC Rating System</h1>
            <h2 style="color: #f2f2f2;">Admin Credentials</h2>
            <p style="color: #f2f2f2;">Here are your <span style="background-color: #fdd835; padding: 2px 8px; color: #000000;">login credentials:</span></p>
            
            <div class="credentials-box" style="background-color: #f2f2f2; padding: 10px; border-radius: 8px; margin: 20px auto; max-width: 550px; height: 100px; justify-content: center; align-items: center; text-align: center;">
                <p class="credentials-text" style="font-size: 18px; color: black;"><strong>Username:</strong> ' . htmlspecialchars($username) . '</p>
                <p class="credentials-text" style="font-size: 18px; color: black;"><strong>Password:</strong> ' . htmlspecialchars($password) . '</p>
            </div>

            <p style="color: #f2f2f2;">If you didn\'t request this, <span style="background-color: darkred; padding: 2px 4px; color: #ffffff;">please ignore this email.</span></p>
            <p style="color: #f2f2f2;">&copy; 2024 MSTTC. All rights reserved.</p>
        </div>
    </div>

</body>
</html> ';

        $mail->send();
        return true;
    } catch (Exception $e) {
        echo "Mailer Error: " . $mail->ErrorInfo;
        return false;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MSTTC - Forgot Password</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(to right, black, gold);
        }

        .card {
            border-radius: 10px;
            background-color: #1a1b34;
            width: 100%;
            max-width: 650px;
            margin: 0 auto;
            padding: 20px;
            color: white;
        }

        /* Logo and label section */
        .login-img {
            text-align: center;
            margin-bottom: 50px;
            margin-right: auto;
        }

        .login-img img {
            height: 50px;
            max-width: 100%;
        }

        .btn {
            background-color: #00bf63;
            font-size: 16px;
            font-weight: bold;
            width: 100%;
            max-width: 150px;
            margin-top: 10px;
            margin-bottom: 20px;
        }

        .btn:hover {
            background-color: #008f4c;
        }

        .forgot-password-label {
            text-align: center;
            color: whitesmoke;
            font-size: 23px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        label {
            margin-bottom: 20px;
        }

        /* Social icons section */
        .social-links a {
            text-decoration: none;
            /* Remove underline */
        }

        .social-links a:hover i {
            transform: scale(1.1);
        }

        .social-links i {
            font-size: 1.5rem;
            margin: 0 10px;
            transition: transform 0.3s ease, color 0.3s ease;
        }

        /* Facebook icon color */
        .social-links .bi-facebook {
            color: #1877F2;
            /* Facebook blue */
        }

        .social-links .bi-facebook:hover {
            color: #0d47a1;
            /* Darker blue on hover */
        }

        /* WhatsApp icon color */
        .social-links .bi-whatsapp {
            color: #25D366;
            /* WhatsApp green */
        }

        .social-links .bi-whatsapp:hover {
            color: #128C7E;
            /* Darker green on hover */
        }


        .footer-custom p {
            color: white;
            margin-bottom: 0px;
        }

        /* Additional styles for the Forgot Password link */
    .forgot-password-link {
        text-align: left;
        color: gold;
        text-decoration: none;
        font-size: 1rem;
        margin-left: 15%;
        display: block;
        margin-top: -10px;
    }

    .forgot-password-link:hover {
        color: #d4af37; /* Darker gold color */
        text-decoration: none;
    }

        @keyframes popout {
            0% {
                transform: scale(0);
                opacity: 0;
            }

            50% {
                transform: scale(1.05);
                opacity: 1;
            }

            100% {
                transform: scale(1);
            }
        }

        .popout-animation {
            animation: popout 0.5s ease-in-out;
        }

        /* Responsive adjustments for mobile devices */
        @media (max-width: 576px) {
            .card {
                padding: 10px;
            }
            
            .forgot-password-label{
                font-size: 20px;
            }

            .login-img img {
                height: 40px;
                max-width: 100%;
            }

            .login-label {
                font-size: 22px;
            }

            input.form-control {
                font-size: 14px;
                max-width: 100%;
            }

            .btn {
                max-width: 50%;
                font-size: 14px;
            }
        }
        
         @media (max-width: 576px) {
             
              .forgot-password-label{
                font-size: 18px;
            }
         }
    </style>
</head>

<body>
    <section class="vh-100">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-xl-10">
                    <div class="card">
                         <!-- Logo Section -->
                         <div class="login-img">
                            <img src="MsttcLogo-1.png" class="img-fluid" alt="MSTTC Logo">
                        </div>
                        <div class="text-center">
                            <h5 class="forgot-password-label">FORGOT USERNAME OR PASSWORD?</h5>
                            <label for="">Enter Your Registered Email below</label>
                        </div>

                        <form action="" method="post">
                            <div class="mb-3 text-center">
                                <input type="email" class="form-control mb-3" placeholder="Enter Admin Email" name="email" required style="max-width: 70%; margin: 0 auto;">
                            </div>
                            <p><a href="AdminLogin.php" class="forgot-password-link">Back to Login</a></p>

                            <div class="text-center">
                                <button class="btn btn-lg" type="submit">
                                    Submit
                                </button>
                            </div>

                            <?php if (!empty($message)) : ?>
                                <div class="alert alert-success mt-3 text-center popout-animation" style="max-width: 50%; margin: 0 auto; font-size: 0.9rem; padding: 10px;">
                                    <?php echo $message; ?>
                                </div>
                            <?php endif; ?>

                            <!-- Display the Bootstrap alert if there is an error -->
                            <?php if (isset($_GET['error'])) : ?>
                                        <div class="alert alert-danger d-flex align-items-center justify-content-center popout-animation" role="alert" style="width: 64%; padding: 8px; margin: 10px auto; font-size: 1.1em; border-radius: 5px; text-align: center;">
                                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                            <div>
                                                <?php echo $_GET['error']; ?>
                                            </div>
                                        </div>
                            <?php endif; ?>
                            
                            <!-- Display success message if there is any -->
                             <?php if (isset($_GET['success'])) : ?>
                                 <div class="alert alert-success d-flex align-items-center justify-content-center popout-animation" role="alert" style="width: 64%; padding: 8px; margin: 10px auto; font-size: 1.1em; border-radius: 5px; text-align: center;">
                                    <i class="bi bi-check-circle-fill me-2"></i>
                                    <div><?php echo $_GET['success']; ?></div>
                                </div>
                            <?php endif; ?>
                        </form>

                        <!-- Social links and footer -->
                        <div class="container text-center">
                            <p class="social-links">
                                <a href="https://www.facebook.com/msttc.madzam.shah.table.tannis.club" target="_blank" class="social-icon">
                                    <i class="bi bi-facebook"></i>
                                </a>
                                <a href="https://wa.me/60129612701?" target="_blank" class="social-icon">
                                    <i style="color: #008f4c;" class="bi bi-whatsapp"></i>
                                </a>
                            </p>
                            <p class="footer-custom" style="color: white;margin-bottom: 30px;">&copy; 2024 MSTTC. All rights reserved.</p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>
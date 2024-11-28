<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MSTTC - Admin Login</title>

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
        }

        .btn:hover {
            background-color: #008f4c;
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

        .login-label {
            text-align: center;
            color: whitesmoke;
            font-size: 27px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        input.form-control {
            margin-bottom: 1rem;
            max-width: 70%;
            margin: 0px auto;
        }

        .btn {
            background-color: #00bf63;
            font-size: 16px;
            font-weight: bold;
            width: 100%;
            max-width: 150px;
            margin-top: 10px;
        }

        .text-end {
            display: flex;
            justify-content: center;
        }
        
        .text-end1 {
            display: flex;
            justify-content:right;
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

        .forgot-password-link {
            color: gold;
            text-decoration: none;
            font-size: 1rem;
            text-align: left;
            display: block;
            margin-top: -10px;
            margin-left: 90px;
        }

        .forgot-password-link:hover {
            color: #d4af37;
            /* Darker gold color */
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
            .forgot-password-link {
            margin-left: 10px;
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

                        <!-- Centered Label for Admin Login Page -->
                        <h5 class="login-label">ADMIN LOGIN PAGE</h5>

                        <!-- Form column -->
                        <div class="col d-flex align-items-center justify-content-center">
                            <div class="card-body text-white">
                                <form action="inputAdminLogin.php" method="post">
                                    <!-- Input fields -->
                                    <div class="text-center">
                                        <input type="text" class="form-control mb-3" placeholder="Enter Admin Username" name="Username" required>
                                        <div class="input-group mb-3">
                                            <input type="password" id="password" class="form-control" placeholder="Enter Password" name="Password" required>
                                        </div>
                                        <p class="">
                                            <a href="ForgotPassword.php" class="forgot-password-link">Forgot Username or Password?</a>
                                        </p>
                                    </div>


                                    <!-- Login button -->
                                    <div class="text-end">
                                        <button class="btn btn-lg" type="submit">
                                            Login
                                        </button>
                                    </div>

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
                            </div>
                        </div>

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
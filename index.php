<?php
session_start();
session_destroy();
//print_r($_SESSION);
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- My Custom Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Special+Elite&display=swap" rel="stylesheet">

    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"
        integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">

    <link rel="icon" type="image/png" href="images/favicon.png" />
    <title>Welcome to NRR Bank Services !!</title>
    <style>
        body {
            font-family: 'Special Elite', cursive;
        }

        .themecol {
            color: mediumseagreen;
        }

        .navbar {
            font-weight: bold;
            letter-spacing: 2px;
        }

        .custom-nav {
            background-color: rgb(62, 170, 111);
        }

        .logreg {
            margin-right: 1em;
            margin-top: 0.5em;
            background-color: mediumseagreen;
            color: white;
            border-radius: 5px;
            padding: 0.3em 0.5em;
        }

        .logreg:hover {
            font-weight: 600;
            color: rgb(73, 156, 73);
            background-color: rgba(255, 255, 255, 0.876);
            border: 3px solid rgb(73, 156, 73);
        }

        .banner {
            margin-bottom: 4em;
        }

        hr.divider {
            border-top: 4px solid mediumseagreen;
            width: 30%;
        }

        .card {
            border: none;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark custom-nav">
        <a class="navbar-brand" href="#">NRR Bank - Let's Grow with Trust</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-chart-bar"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="register.php">Register</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="signin.php">Login<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contactus.php">Contact Us</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container mb-5">
        <section class="banner row justify-content-center mt-3">
            <div class="col-md-12 col-lg-5 order-2 order-lg-1 mx-2 my-auto px-5 py-3">
                <h1 class="row">Welcome to NRR Bank Services!</h1>
                <div class="row d-flex ">
                    <a role="button" href="signin.php" class="btn logreg">User Login</a>
                    <a role="button" href="manager/managerlogin.php" class="btn logreg">Manager Login</a>
                </div>
            </div>
            <div class="col-md-12 col-lg-6 order-1 order-lg-2 mx-auto">
                <img class="img-fluid" src="images/img-banner.jpg" alt="">
            </div>
        </section>

        <div class="services">
            <h1 class="text-center">OUR SERVICES</h1>
            <hr class="divider">

            <div class="row">
                <div class="card col-12 col-md-4">
                    <img class="card-img-top" src="images/services1.png" alt="Card image cap">
                    <div class="card-body">
                        <h3 class="card-title text-center">Private Keys on Accounts </h3>
                        <hr class="divider">
                        <p class="card-text">We respect our client's expectations of an equally safe way to perform
                            transactions as it is to create accounts. In the same way, those in charge of operating the
                            banking system make it their first and most important priority to serve our clients to their
                            satisfaction.
                        </p>
                    </div>
                </div>
                <div class="card col-12 col-md-4">
                    <img class="card-img-top" src="images/services2.jpg" alt="Card image cap">
                    <div class="card-body">
                        <h3 class="card-title text-center">Secure Transactions</h3>
                        <hr class="divider">
                        <p class="card-text">The systems and procedures in banks must be designed to make customers feel
                            safe about carrying out electronic banking transactions.We have build a system of
                            continually and repeatedly advising customers on how to protect themselves from electronic
                            banking and payments related frauds.</p>
                    </div>
                </div>
                <div class="card col-12 col-md-4">
                    <img class="card-img-top" src="images/services3.jpg" alt="Card image cap">
                    <div class="card-body">
                        <h3 class="card-title text-center">Trustworthy Management</h3>
                        <hr class="divider">
                        <p class="card-text">Lack of Security and Truth is what we aim to resolve, thus calling for
                            needs of a bank management, which ensures quality services to our customers. Our concerns
                            broadly include liquidity management, asset management, liability management and capital
                            management.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="text-center text-lg-start bg-light text-muted">
        <!-- Section: Social media -->
        <section class="d-flex justify-content-center justify-content-lg-between p-4 border-bottom">
            <!-- Left -->
            <div class="mx-2 d-none d-lg-block">
                <span>Get connected with us on social networks:</span>
            </div>
            <!-- Left -->

            <!-- Right -->
            <div>
                <a href="" class="mx-2 text-reset themecol">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="" class="mx-2 text-reset themecol">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="" class="mx-2 text-reset themecol">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="" class="mx-2 text-reset themecol">
                    <i class="fab fa-linkedin"></i>
                </a>
                <a href="" class="mx-2 text-reset themecol">
                    <i class="fab fa-github"></i>
                </a>
            </div>
            <!-- Right -->
        </section>

        <!-- Section: Links  -->
        <section class="">
            <div class="container text-center text-md-center mt-5">
                <!-- Grid row -->
                <div class="row mt-3">
                    <!-- Grid column -->
                    <div class="col-md-3 mx-auto mb-4">
                        <!-- Content -->
                        <h6 class="text-uppercase fw-bold mb-4">
                            <i class="fas fa-university"></i> NRR Bank Services
                        </h6>
                        <p>
                            A Software Engineering Project built on the Topic:<br><b>Bank Management</b>
                        </p>
                    </div>
                    <!-- Grid column -->

                    <!-- Grid column -->
                    <div class="col-md-5 mx-auto mb-4 d-none d-lg-block">
                        <!-- Links -->
                        <h6 class="text-uppercase fw-bold mb-4">
                            Address
                        </h6>
                        <p class="mx-auto"><iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3684.1252655909!2d88.43158931391169!3d22.574417785181872!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3a0275bb4df8a60d%3A0x905231d91b918a3!2sInstitute%20of%20Engineering%20%26%20Management!5e0!3m2!1sen!2sin!4v1628497416009!5m2!1sen!2sin"
                                width="450" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                        </p>
                    </div>


                    <!-- Grid column -->
                    <div class="col-md-4 mx-auto mb-md-0 mb-4">
                        <!-- Links -->
                        <h6 class="text-uppercase fw-bold mb-4">
                            Contact
                        </h6>
                        <p><i class="fas fa-home me-3"></i> Institute of Engineering and Management</p>
                        <p>
                            <p><i class="fas fa-map-marked-alt"></i> College More, Kolkata-700040</p>
                            <i class="fas fa-envelope me-3"></i>
                            nrr.officials@gmail.com
                        </p>
                        <p><i class="fas fa-phone me-3"></i> +917294179372</p>
                    </div>
                    <!-- Grid column -->
                </div>
                <!-- Grid row -->
            </div>
        </section>
        <!-- Section: Links  -->

        <!-- Copyright -->
        <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.05);">
            © 2021
            <span class="themecol">NRR Bank: Let's Grow with Trust</span>
        </div>

    </footer>




    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
</body>

</html>
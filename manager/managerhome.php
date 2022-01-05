<?php

include '../connect.php';
session_start();

if(array_key_exists('sn',$_SESSION)){
    unset($_SESSION['sn']);
}
if(array_key_exists('approvals',$_SESSION)){
    unset($_SESSION['approvals']);
}
// if(array_key_exists('qt',$_SESSION)){
//     unset($_SESSION['qt']);
// }
// if(array_key_exists('ft',$_SESSION)){
//     unset($_SESSION['ft']);
// }
// if(array_key_exists('changepwd',$_SESSION)){
//     unset($_SESSION['changepwd']);
// }
// if(array_key_exists('npwd',$_SESSION)){
//     unset($_SESSION['npwd']);
// }
// if(array_key_exists('amt',$_SESSION)){
//     unset($_SESSION['amt']);
// }
// if(array_key_exists('recipient',$_SESSION)){
//     unset($_SESSION['recipient']);
// }
// if(array_key_exists('recipient_name',$_SESSION)){
//     unset($_SESSION['recipient_name']);
// }
// if(array_key_exists('otp',$_SESSION)){
//     unset($_SESSION['otp']);
// }
// if(array_key_exists('verified',$_SESSION)){
//     unset($_SESSION['verified']);
// }

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
    
    <link rel="icon" type="image/png" href="../images/favicon.png" />
    <title>User's HomePage: NRR Bank</title>
    <style>
        body {
            font-family: 'Special Elite', cursive;
        }
        @media (max-width: 576px) {
            .nodisplaysmall{
                display:none;
            }
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

        .actBtn {
            margin-right: 1em;
            background-color: mediumseagreen;
            color: white;
            border-radius: 5px;
            transition: 0.6s;
        }

        .actBtn:hover {
            font-weight: 600;
            color: rgb(73, 156, 73);
            background-color: rgba(255, 255, 255, 0.876);
            border: 1px solid rgb(73, 156, 73);
        }

        .register {
            padding: 1em 0;
            position: relative;
        }

        .btn-send {
            background: mediumseagreen;
            padding: 15px 20px;
            color: #FFFFFF;
            font-weight: 700;
            border: none;
            margin: 2% auto;
            letter-spacing: 1px;
        }

        .fa-user-circle {
            position: relative;
            top: 3px;
            font-size: 1.5em;
        }

        .marquee {
            color: mediumseagreen;
            height: 100%;
            font-size: larger;
        }

        .card {
            border: none;
            margin: 8px 0;
        }

        .card-title {
            text-align: center;
        }
        li a{
            color: dodgerblue;
            font-size: 1.1em;
        }
        li a:hover {
            text-decoration: none;
            font-weight: bolder;
            color: darkblue;
        }
        .fa-sign-out-alt{
            color: red;
            font-size: 1.1em;
        }
        .navbar-brand img{
            height: 7vh;
        }

    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark custom-nav">
    <a class="navbar-brand" href="#">NRR Bank <span class="nodisplaysmall">- Let's Grow with Trust</span></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-chart-bar"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown active">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-user-circle"></i> Welcome 
                        <?php echo $_SESSION['mName']; ?>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <!-- <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <div class="dropdown-divider"></div> -->
                        <a class="dropdown-item" href="../logout.php">Signout <i class="fas fa-sign-out-alt"></i></a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container register mt-2">
        <!-- <h1 class="title text-center d-lg-none">Welcome <?php //echo $_SESSION['name']; ?> !</h1> -->

        <div class="title text-center d-lg-none mb-4">
            <div class="text-primary"><b>Welcome Manager <?php echo $_SESSION['mName']; ?> !!<b></div>
            <h6 class="text-muted">Operate as a NRR Bank Official Here !!</h6>
        </div>

        <div class="row d-flex font-weight-bold justify-content-around">
            <div class="col-6 col-md-3 flex-3 text-center">
                <div class="text-danger">Last Login Date & Time</div>
                <?php
                    if($_SESSION){
                        echo $_SESSION['lastlogin'];
                    }
                    else{
                        echo "UNKNOWN";
                    }
                    
                ?>
            </div>

            <div class="d-none d-lg-block col-12 col-md-6 flex-6 text-center title">
                <div class="text-primary">Welcome Manager <?php echo $_SESSION['mName']; ?> !!</div>
                <h6 class="text-muted">Operate as a NRR Bank Official Here !!</h6>
            </div>

            <div class="col-6 col-md-3 flex-3 text-center">
                <div class="text-success">Welcome Back</div>
                <?php
                    if($_SESSION){
                        echo get_Date();
                    }
                    else{
                        echo "UNKNOWN";
                    }
                    
                ?>
            </div>
        </div>
        <?php
            if(array_key_exists('forgotuid', $_SESSION)){
                echo '<div class="alert alert-info text-center">You can Reset Your User ID and Password, please do check Out those Facilities given below </div>';
                unset($_SESSION['forgotuid']);
            }
        ?>

    </div>

    <div class="container main my-2 text-center">
        <ul class="list-group list-group-flush">
            <li class="list-group-item"><a href="allaccounts.php">
                See All NRR Bank Accounts    
            </a></li>
            <li class="list-group-item"><a href="addmanager.php">
                Add a Manager
            </a></li>
            <li class="list-group-item"><a href="alltransacts.php">
                See All Transactions
            </a></li>
            <li class="list-group-item"><a href="approvals.php">
                View and Approve Requests
                <?php
                    $sql = "SELECT id FROM accstatements WHERE (type = 'D') AND (isapproved = 0)";
                    $res1 = mysqli_query($conn, $sql); //Pending Money Deposits

                    $sql = "SELECT id FROM nrracc_primary WHERE isapproved = 0";
                    $res2 = mysqli_query($conn, $sql);
                    
                    $sql = "SELECT id FROM loans WHERE stage = 0";
                    $res3 = mysqli_query($conn, $sql);

                    $n = mysqli_num_rows($res1) + mysqli_num_rows($res2) + mysqli_num_rows($res3);
                    if($n > 0){
                        echo '<span class="badge badge-danger">'.$n.' new</span>';
                    }
                ?>
            </a></li>
            <li class="list-group-item"><a href="notifications.php">
                Notifications at Manager's Desk
            </a></li>
        </ul>
    </div>

    <footer class="text-center text-lg-start bg-light pt-2 text-muted">

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
                        <hr>
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
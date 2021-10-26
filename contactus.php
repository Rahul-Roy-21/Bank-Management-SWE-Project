<?php
    session_start();
    //print_r($_SESSION);
    include 'mailer.php';
    include 'connectonly.php';

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $message = $_POST['text'];

        // Email to NRR Official(User/Anyone)
        //$res = sendMail($name, $email,"",'CONTACTUS',$phone, $message);

        //Save the Message in NRR contacts Database
        $sql = "";

        if($_SESSION){
            $accnum = $_SESSION['accnum'];
            $sql = "INSERT INTO contacts (accnum,name,email,msg) VALUES ('$accnum','$name','$email','$message')";
        }
        else{
            $sql = "INSERT INTO contacts (name,email,msg) VALUES ('$name','$email','$message')";
        }
        mysqli_query($conn, $sql);
        $res = empty(mysqli_error($conn));

    }

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
    <title>Contact the Officials: NRR Bank</title>
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
            background-color: mediumseagreen;
            color: white;
            border-radius: 5px;
            transition: 0.6s;
        }

        .logreg:hover {
            font-weight: 600;
            color: rgb(73, 156, 73);
            background-color: rgba(255, 255, 255, 0.876);
            border: 1px solid rgb(73, 156, 73);
        }

        .contact-section {
            width: 900px;
            height: 600px;
            padding: 1em 0;
            position: relative;
        }

        .container .map {
            width: 45%;
            float: left;
            margin: auto 0;
        }

        .container .map img {
            width: 380px;
        }

        .container .contact-form {
            width: 100%;
            margin-left: 2%;
            float: left;
        }

        @media only screen and (max-width: 600px) {
            .container .contact-form {
                width: 53%;
                margin-left: 2%;
                float: left;
            }
        }

        .container .contact-form .title {
            font-weight: 700;
            color: #242424;
            margin-left: 10px;
            letter-spacing: 2px;
        }

        .container .contact-form input,
        .container .contact-form textarea {
            width: 100%;
            padding: 3%;
            margin: 2% 0;
            color: #242424;
        }

        .container .contact-form input::placeholder,
        .container .contact-form textarea::placeholder {
            color: #242424;
        }

        .container .contact-form .btn-send {
            background: mediumseagreen;
            padding: 15px 20px;
            color: #FFFFFF;
            font-weight: 700;
            margin: 2% 8%;
            border: none;
            letter-spacing: 3px;
        }
        .fa-sign-out-alt{
            color: red;
            font-size: 1.1em;
        }
    </style>
</head>

<body>
    <?php
    if($_SESSION){
        echo '<nav class="navbar navbar-expand-lg navbar-dark custom-nav">
        <a class="navbar-brand" href="#">NRR Bank - Let\'s Grow with Trust</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-chart-bar"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="userhome.php"><i class="fas fa-home"></i> Back to Home</a>
                </li>
                <li class="nav-item dropdown active">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-user-circle"></i> Welcome 
                        '.$_SESSION["name"].'
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="logout.php">Signout <i class="fas fa-sign-out-alt"></i></a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>';
    }
    else{
        $nav = '<nav class="navbar navbar-expand-lg navbar-dark custom-nav">';
        $nav .= '<a class="navbar-brand" href="#">NRR Bank - Let\'s Grow with Trust</a>';
        $nav .= '<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"';
            $nav .= 'aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">';
            $nav .= '<i class="fas fa-chart-bar"></i>';
        $nav .= '</button>';

        $nav .= '<div class="collapse navbar-collapse" id="navbarSupportedContent">';
            $nav .= '<ul class="navbar-nav ml-auto">';
                $nav .= '<li class="nav-item">';
                    $nav .= '<a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>';
                $nav .= '</li>';
                $nav .= '<li class="nav-item">';
                    $nav .= '<a class="nav-link" href="register.php">Register</a>';
                $nav .= '</li>';
                $nav .= '<li class="nav-item">';
                    $nav .= '<a class="nav-link" href="signin.php">Login<span class="sr-only">(current)</span></a>';
                $nav .= '</li>';
                $nav .= '<li class="nav-item active">';
                    $nav .= '<a class="nav-link" href="#">Contact Us</a>';
                $nav .= '</li>';
            $nav .= '</ul>';
        $nav .= '</div>';
        $nav .= '</nav>';
        echo $nav;
    }
    ?>
    

    <div class="container contact-section mb-5">
        <div class="map col-6 d-none 
        <?php
                if(!$res){
                    echo 'd-md-block';
                }
        ?>
        
        ">
            <img src="images/contactus.jpg" alt="" class="img-fluid">
        </div>
        <div class="contact-form mx-auto col-12  
        <?php
                if(!$res){
                    echo 'col-md-6';
                }
        ?>
        
        ">
            <h1 class="title text-center">Contact Us <i class="far fa-edit"></i></h1>
            <h5 class="title text-center">Let's Us Know What's in Your Mind</h5>

            <div class="alert alert-success my-3 text-center font-weight-bold 
            <?php
                if($res){
                    echo 'd-block';
                }
                else{
                    echo 'd-none';
                }
            ?>
            ">
                Your Message is Successfully Sent !!<br>We will try to contact you back soon <i class="fas fa-thumbs-up"></i>
            </div>

            <form method="POST" class="
            <?php
                if(!$res){
                    echo 'd-block';
                }
                else{
                    echo 'd-none';
                }
            ?>
            ">
            <?php
                echo '<input type="text" name="name" placeholder="Your Name" '; 
                if($_SESSION){
                    echo 'value="'.$_SESSION['name'].'"';
                }
                echo 'required/>';

                echo '<input type="email" name="email" placeholder="Your E-mail Adress" '; 
                if($_SESSION){
                    echo 'value="'.$_SESSION['email'].'"';
                }
                echo 'required/>';
            ?>
                <textarea name="text" rows="4" placeholder="Your Message" required></textarea>
                <button class="btn-send">Send Message</button>
            </form>
        </div>
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
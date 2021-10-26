<?php
    session_start();
    include 'connect.php';
    include 'mailer.php';
    //print_r($_SESSION);
    $err = "";

    if(!array_key_exists('verified', $_SESSION)){
        $_SESSION['verified'] = False;
    }
    
    if(!$_SESSION['verified']){
        $name = $_SESSION['name'];
        $email = $_SESSION['email'];
        $token = $_SESSION['token'];
        
        $res = sendMail($name, $email, $token);
    }
    if($_SERVER["REQUEST_METHOD"] == "POST" && !$_SESSION['verified']){

        $codeEntered = trim($_POST['code']);
        
        if(empty($codeEntered)){
            $err = "Please Enter the OTP !!"; 
        }
        if($codeEntered != $token){
            $err = "Invalid OTP !!";
        }
        if(empty($err) && !$_SESSION['verified']){
            $accNum = $_SESSION['accnum'];
            $contact = $_SESSION['reg']['mobile'];
            $user_id = $_SESSION['reg']['userid'];
            $inibal = $_SESSION['reg']['bal'];
            $pwd = $_SESSION['reg']['pwd'];
            $tpwd = $_SESSION['reg']['tpwd'];

            $guardian = $_SESSION['reg']['guardian'];
            $aadhar = $_SESSION['reg']['aadhar'];
            $dob = $_SESSION['reg']['dob'];
            $address = $_SESSION['reg']['addr'];
            $gender = $_SESSION['reg']['gender'];
            $city = $_SESSION['reg']['city'];
            $state = $_SESSION['reg']['state'];
            $pin = $_SESSION['reg']['pin'];
            $date = $_SESSION['reg']['accopen'];

            $sql = "INSERT INTO nrracc_primary (name, accnum, email, mobile, userid, balance, pwd, tpwd, token) VALUES('$name','$accNum','$email','$contact','$user_id','$inibal','$pwd','$tpwd','$token')";
            mysqli_query($conn, $sql);

            $sql = "INSERT INTO nrracc_sec (accnum, guardian, aadhar, dob, address, gender, city, stateinput, pin, accopendate) VALUES('$accNum','$guardian','$aadhar','$dob','$address','$gender','$city','$state', '$pin', '$date')";
            mysqli_query($conn, $sql);

            $_SESSION['verified'] = True;
        }
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
    <title>OTP Verification for Register: NRR Bank</title>
    <style>
        body {
            font-family: 'Special Elite', cursive;
        }

        .themecol {
            color: mediumseagreen;
        }

        a.themecol {
            text-decoration-color: green;
            text-decoration: none;
        }

        .navbar {
            font-weight: bold;
            letter-spacing: 2px;
        }

        .custom-nav {
            background-color: rgb(62, 170, 111);
        }

        .signin .card {
            padding-top: 2%;
            max-width: 600px;
            margin: 0 auto;
            box-shadow: 5px 10px 8px #bbb;
        }

        .btn-send {
            background: mediumseagreen;
            color: #FFFFFF;
            font-weight: 700;
            border: none;
            margin: 2% auto;
            letter-spacing: 1px;
        }
        .fa-sign-out-alt{
            color: red;
            font-size: 1.1em;
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
                <li class="nav-item">
                    <a class="nav-link active" href="logout.php">Back To Home <span class="sr-only">(current)</span></a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container signin my-5">
        <div class="card">
            <div class="card-body">

                <h1 class="card-title title text-center">Activate Your Account<i class="fas fa-id-card"></i></h1>
                <?php

                    if($_SESSION && !$_SESSION['verified']){
                        echo "<h6 class='alert alert-info mb-2 text-center'>We have sent u a Verification code on <b>".$email."</b> to activate your account, come back here to get your relevant Login Details</h6>";
                    }
                    if($_SESSION && $err){
                        echo "<h6 class='alert alert-danger mb-2 text-center'>".$err."</h6>";
                    }
                    // if($_SESSION && $_SESSION['verified']){
                    //     echo "<h6 class='alert alert-success mb-2 text-center'><b>Congratulations!! </b>You are Now a Verified Customer of Our Bank. You can Now <a href='signin.php'>Login</a> with The Credentials Given Below from your Created Account</h6>";
                    // }
                ?>
                
                <?php

                if($_SESSION && $_SESSION['verified']){
                    echo "<h6 class='alert alert-warning mb-2 text-center'>Your Details are Successfully Sent to the Bank Officials. Once, your Account gets Verified, you can then <a href='signin.php'>Sign In</a> with The Login Credentials Sent to you at <b>".$_SESSION['email']."</b><hr>You Can Also Contact the Officials at <u>Contact Us</u></h6>";
                    

                    // $accNum = $_SESSION['accnum'];
                    // $sql = "SELECT id,name,accnum,userid,email,mobile FROM nrracc_primary WHERE accnum = '$accNum'";
                    // $result = mysqli_query($conn, $sql);
                    // // echo var_dump($result);

                    // $res = mysqli_fetch_array($result);
                    // // print_r($res);
                    // echo '<div class="bankid border border-primary p-3 my-2">
                    //     <div class="row d-flex justify-content-center">
                    //         <label class="col-5">Account No.</label>
                    //         <label class="col-7">'.$res[2].'</label>
                    //     </div>
                    //     <div class="row d-flex justify-content-center">
                    //         <label class="col-5">Account Holder</label>
                    //         <label class="col-7">'.$res[1].'</label>
                    //     </div>
                    //     <div class="row d-flex justify-content-center">
                    //         <label class="col-5">User Id.</label>
                    //         <label class="col-7">'.$res[3].'</label>
                    //     </div>
                    //     <div class="row d-flex justify-content-center">
                    //         <label class="col-5">Email Id.</label>
                    //         <label class="col-7">'.$res[4].'</label>
                    //     </div>
                    //     <div class="row d-flex justify-content-center">
                    //         <label class="col-5">Phone No.</label>
                    //         <label class="col-7">'.$res[5].'</label>
                    //     </div>
                    // </div>';

                }
                else{
                    echo '<form class="verifyForm my-5 pr-2" method="post">
                    <div class="form-group text-center">
                        <label>Enter Your Verification Code</label>

                        <input type="text" class="form-control border border-success w-75 mx-auto" name="code">
                    </div>

                    <div class="text-center">
                        <button type="submit" name="submit" class="btn btn-send btn-block mb-3 py-2 w-50">Verify Now</button>
                    </div>
                </form>';
                }
                ?>

                <div class="text-center">
                    <small>By creating this account, you agree to our <span class="themecol">Terms &
                            Conditions.</span></small>
                </div>
            </div>
        </div>
    </div>
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
<?php
    include 'connectonly.php';
    include 'mailer.php';
    session_start();
    $err = "";

    if(!array_key_exists('forgotuid', $_SESSION)){
        $_SESSION['forgotuid'] = 1;
        //Step 1 of Forgot User ID
    }

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $aadhar = trim($_POST['aadhar']);

        if(empty($aadhar)){
            $err = "Aadhar Number is Not Entered !!";
        }
        if(empty($err)){
            $sql = "SELECT accnum FROM nrracc_sec WHERE aadhar = '$aadhar'";
            $res = mysqli_query($conn, $sql);

            if(mysqli_num_rows($res) == 0){
                $err = "This Aadhar Number is Not Registered !!";
            }
            else{
                $row = mysqli_fetch_assoc($res);
                $accnum = $row['accnum'];

                $sql = "SELECT name, email FROM nrracc_primary WHERE accnum = '$accnum'";
                $rowfetched = mysqli_fetch_assoc(mysqli_query($conn, $sql));

                $_SESSION['name'] = $rowfetched['name'];
                $_SESSION['email'] = $rowfetched['email'];
                $_SESSION['accnum'] = $accnum;
                $_SESSION['otp'] = bin2hex(random_bytes(4));
                
                $mail = sendMail($_SESSION['name'], $_SESSION['email'], $_SESSION['otp'],'FORGETUSERID','','');

                if($mail){
                    $_SESSION['forgotuid'] = 2;
                    header('location: forgotuserid2.php');
                }
                else{
                    $err = "Cannot Verify and Proceed !!";
                }
            }
        }

    }
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
    <title>Login without User ID: NRR Bank</title>
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

        .sel{
            border-width: 1px 0 0 1px;
            border-style: solid;
            border-color: green;
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
                    <a class="nav-link active" href="index.php">Back to Home<span class="sr-only">(current)</span></a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container signin my-5">
        <div class="card w-100">

            <div class="card-body">

                <h2 class="card-title title text-center">
                    Forgot User ID <i class="fas fa-user-lock"></i>
                </h2>
                <h6 class="card-subtitle mb-2 text-muted text-center">Missing out some of  your Login Details?<br>Get yourself Authenticated so that you can login again..</h6>

                <?php
                    if(!empty($err)){
                        echo '<div class="alert alert-danger text-center">'.$err.'</div>';
                    }
                ?>
                
                <form method="post" class="verifyForm my-3 pr-2 ">
                    <div class="row my-4">
                        <b class="col-3">Step 1 :- </b>
                        <div class="col-9 sel">Enter Your Aadhar Number for User Identification.</div>
                        <b class="col-3">Step 2 :- </b>
                        <div class="col-9">Enter One time password (OTP) received on your registered Email Address for authentication.</div>          
                    </div>

                    <div class="form-group text-center">
                        <label>Enter Your 12 Digit Aadhar Number</label>
                        <input type="text" class="form-control border border-success w-75 mx-auto" name="aadhar">
                    </div>

                    <div class="text-center">
                        <button type="submit" name="submit" class="btn btn-send btn-block mb-3 py-2 w-50">Verify Now</button>
                    </div>
                </form>

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
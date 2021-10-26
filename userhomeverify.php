<?php
    session_start();
    include 'connect.php';
    include 'mailer.php';
    //echo $_SESSION['accNum'];
    $accnum = $_SESSION['accnum'];
    $err = '';

    if(array_key_exists('ft', $_SESSION) && $_SESSION['verified'] && !$_SESSION['ft']){   
        $amount = $_SESSION['amt'];
        $reciever_acc = $_SESSION['recipient'];
        $reciever = $_SESSION['recipient_name'];
        $otp = $_SESSION['otp'];

        if($_SERVER["REQUEST_METHOD"] == "POST" && $_SESSION['verified']){

            $codeEntered = trim($_POST['code']);
            
            if($codeEntered != $otp){
                $err = "Invalid OTP !!";
            }
            if(empty($codeEntered)){
                $err = "Please Enter the OTP !!"; 
            }
            if(empty($err)){

                // Update User Balance
                $curbal = floatval($_SESSION["bal"]) - floatval($amount);
                $_SESSION['bal'] = $curbal;

                $sql = "UPDATE nrracc_primary SET balance = '$curbal' WHERE accnum = '$accnum'";
                mysqli_query($conn, $sql);

                // Update Reciever's Balance
                $sql = "UPDATE nrracc_primary SET balance = balance + '$amount' WHERE accnum = '$reciever_acc'";
                mysqli_query($conn, $sql);

                // Store this Acc. Statement
                $today = date("Y-m-d", strtotime(substr(get_Date("L"),0,11)));
                $nowtime = date("d/m/Y h:i:s A", time());

                // User's ACC. Statement of Debit
                $description = "TO TRANSFER-NRR ".$reciever." via. FUND TRANSFER";
                $refc = "TRANSFER TO ".$reciever_acc;

                $sql = "INSERT INTO accstatements (accnum, amount, type, des, ref, date,datetime, isapproved) VALUES('$accnum','$amount','WT','$description','$refc','$today','$nowtime',1)";
                mysqli_query($conn, $sql);
                $res = mysqli_error($conn);

                // Reciever's ACC. Statement of Credit
                $description = "BY TRANSFER-CREDIT from ".$_SESSION['name']." via.FUND TRANSFER";
                $refc = "TRANSFER FROM ".$accnum;

                $sql = "INSERT INTO accstatements (accnum, amount, type, des, ref, date,datetime, isapproved) VALUES('$reciever_acc','$amount','DT','$description','$refc','$today','$nowtime',1)";
                mysqli_query($conn, $sql);
                $res .= mysqli_error($conn);

                if(empty($res)){
                    $_SESSION['ft'] = True; 
                    header('location: fundtransfer.php');   
                }
                else{
                    $err = "ERROR IN UPDATION<br>".$res;
                }
            }
        }
    }
    if(array_key_exists('changetpwd', $_SESSION) && $_SESSION['verified'] && !$_SESSION['changetpwd']){   
        $npwd = $_SESSION['npwd'];
        $otp = $_SESSION['otp'];

        if($_SERVER["REQUEST_METHOD"] == "POST" && $_SESSION['verified']){

            $codeEntered = trim($_POST['code']);
            
            if($codeEntered != $otp){
                $err = "Invalid OTP !!";
            }
            if(empty($codeEntered)){
                $err = "Please Enter the OTP !!"; 
            }
            if(empty($err)){

                // Update Password
                $sql = "UPDATE nrracc_primary SET tpwd = '$npwd' WHERE accnum = '$accnum'";
                mysqli_query($conn, $sql);

                if($e = mysqli_error($conn)){
                    $err = "An ERROR Has Occured !!<br>".$e;
                }
                else{
                    $_SESSION['changetpwd'] = True; 
                    header('location: changetpwd.php');
                }
            }
        }
    }
    if(array_key_exists('changepwd', $_SESSION) && $_SESSION['verified'] && !$_SESSION['changepwd']){   
        $npwd = $_SESSION['npwd'];
        $otp = $_SESSION['otp'];

        if($_SERVER["REQUEST_METHOD"] == "POST" && $_SESSION['verified']){

            $codeEntered = trim($_POST['code']);
            
            if($codeEntered != $otp){
                $err = "Invalid OTP !!";
            }
            if(empty($codeEntered)){
                $err = "Please Enter the OTP !!"; 
            }
            if(empty($err)){

                // Update Password
                $sql = "UPDATE nrracc_primary SET pwd = '$npwd' WHERE accnum = '$accnum'";
                mysqli_query($conn, $sql);

                if($e = mysqli_error($conn)){
                    $err = "An ERROR Has Occured !!<br>".$e;
                }
                else{
                    $_SESSION['changepwd'] = True; 
                    header('location: changepwd.php');
                }
            }
        }
    }
    if(!array_key_exists('verified', $_SESSION)){
        $err = "This Window Has No Actions to Perform !!";
    }

// print_r($_SESSION);
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
    <title>OTP Authentications : NRR Bank</title>
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
                <li class="nav-item active">
                    <a class="nav-link" href="userhome.php"><i class="fas fa-home"></i> Back to Home</a>
                </li>
                <li class="nav-item dropdown active">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-user-circle"></i> Welcome 
                        <?php echo $_SESSION['name']; ?>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="logout.php">Signout <i class="fas fa-sign-out-alt"></i></a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container signin my-5">
        <div class="card">
            <div class="card-body">

                <h2 class="card-title title text-center">
                    <?php
                        if(array_key_exists('ft', $_SESSION) && $_SESSION['verified']){
                            echo 'Fund Transfer : Verification';
                        }
                        if(array_key_exists('changepwd', $_SESSION) && $_SESSION['verified']){
                            echo 'Change Password : Verification';
                        }
                        if(array_key_exists('changetpwd', $_SESSION) && $_SESSION['verified']){
                            echo 'Change Transaction Password : Verification';
                        }
                    ?>
                    <i class="fas fa-user-shield"></i>
                </h2>
                <?php
                    if(array_key_exists('changepwd', $_SESSION) && $_SESSION['verified'] && !$_SESSION['changepwd']){
                        echo "<h6 class='alert alert-info mb-2 text-center'>We have sent u a Verification code on <b>".$_SESSION['email']."</b> to validate this Password Updation.</h6>";
                    }
                    if(array_key_exists('changetpwd', $_SESSION) && $_SESSION['verified'] && !$_SESSION['changetpwd']){
                        echo "<h6 class='alert alert-info mb-2 text-center'>We have sent u a Verification code on <b>".$_SESSION['email']."</b> to validate this Transaction Password Updation.</h6>";
                    }
                    if(array_key_exists('ft', $_SESSION) && $_SESSION['verified'] && !$_SESSION['ft']){
                        echo "<h6 class='alert alert-info mb-2 text-center'>We have sent u a Verification code on <b>".$_SESSION['email']."</b> to validate this transfer, come back here to complete this transaction</h6>";
                    }
                    if($err){
                        echo "<h6 class='alert alert-danger mb-2 text-center'>".$err."</h6>";
                    }
                ?>

                <form method="post" class="verifyForm my-5 pr-2
                <?php
                    if(!array_key_exists('verified', $_SESSION) || !$_SESSION['verified']){
                        echo 'd-none';
                    }
                ?>
                ">
                    <div class="form-group text-center">
                        <label>Enter Your Verification Code</label>

                        <input type="text" class="form-control border border-success w-75 mx-auto" name="code">
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
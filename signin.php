<?php

include 'connect.php';
$err="";
session_start();
if($_SESSION && !array_key_exists('verified', $_SESSION)){
    header('location: userhome.php');
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $userId = trim($_POST['userId']);
    $pwd = trim($_POST['password']);

    if(empty($userId) || empty($pwd)){
        $err = "Fill All Details to Login..";
    }
    else{
        $sql = "SELECT * FROM nrracc_primary WHERE userid = '$userId'";
        $res = mysqli_query($conn, $sql);

        if(mysqli_num_rows($res) == 1){
            $row = mysqli_fetch_array($res);

            if(password_verify($pwd, $row['pwd'])){
                
                $_SESSION['name'] = $row['name'];
                $_SESSION['accnum'] = $row['accnum'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['bal'] = $row['balance'];

                // Set Login Time
                $accno = $row['accnum'];
                $sql = "SELECT * FROM logintimes WHERE accnum = '$accno'";
                $res = mysqli_query($conn, $sql);

                $curtime = get_Date();
                $lastlogin = "First Time";
                $tl = "";

                if(mysqli_num_rows($res) == 1){
                    $row = mysqli_fetch_array($res);
                    $tl = $row['timeslogin'];

                    if($tl%2){
                        $sql = "UPDATE logintimes SET time1 = '$curtime'WHERE accnum = '$accno'";
                        $lastlogin = $row['time0'];
                    }
                    else{
                        $sql = "UPDATE logintimes SET time0 = '$curtime'WHERE accnum = '$accno'";
                        $lastlogin = $row['time1'];
                    }
                    mysqli_query($conn, $sql);
                    $tl = $tl+1;
                    $sql = "UPDATE logintimes SET timeslogin = '$tl'WHERE accnum = '$accno'";
                    mysqli_query($conn, $sql);
                }
                else{
                    //$curtime = date_format($curtime, "Y-m-d h:i:u");
                    $sql = "INSERT INTO logintimes (accnum, timeslogin, time0) VALUES('$accno',1,'$curtime')";
                    mysqli_query($conn, $sql);
                }
                
                

                $_SESSION['err'] = mysqli_error($conn);
                $_SESSION['curtime'] = $curtime;
                if($lastlogin == "First Time"){
                    $_SESSION['lastlogin'] = $lastlogin;
                }
                else{
                    $_SESSION['lastlogin'] = $lastlogin;
                }

                header('location: userhome.php');
            }
            else{
                $err = "Invalid Password !!";
            }
        }
        if(mysqli_num_rows($res) == 0){
           $err = "This User Doesn't Exists! Please Register before Login";
        }
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
    <title>Sign In as User: NRR Bank</title>
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
                    <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="register.php">Register</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="#">Login<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contactus.php">Contact Us</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container signin my-5">
        <div class="card">
            <div class="card-body">

                <h1 class="card-title title text-center">Login <i class="fas fa-id-card"></i></h1>
                <h6 class="card-subtitle mb-2 text-muted text-center">Sign In with your Credentials</h6>

                <?php

                    if(!empty($err)){
                        echo '<div class="alert alert-danger text-center">'.$err.'</div>';
                    }
                ?>

                <form action="" class="my-5 pr-2" method="POST">
                    <div class="form-group row">
                        <label for="exampleInputPassword1" class="col-4">User Id.</label>

                        <input type="text" class="form-control col-8" name="userId" placeholder="Enter User Id.">
                    </div>

                    <div class="form-group row my-3">
                        <label for="exampleInputEmail1" class="col-4">Password</label>
                        <input type="password" class="form-control col-8" name="password"
                            placeholder="Your Unique Password">
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-send btn-block mb-3 py-2 w-75">Login Now!</button>
                        <h6>Don't Have an Account? <a class="themecol" href="register.php">Register Here</a></h6>
                        <h6>Forgot UserID./Password?<a class="themecol" href="forgotuserid.php">Click Here</a></h6>
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
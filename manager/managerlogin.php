<?php

include '../connect.php';
$err = "";

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $manager_Id = trim($_POST['managerId']);
    $pwd = trim($_POST['password']);

    if(empty($manager_Id) || empty($pwd)){
        $err = "Please Fill All Details !!";
    }
    if(empty($err)){
        $sql = "SELECT * FROM manager WHERE userid = '$manager_Id'";
        $res = mysqli_query($conn, $sql);

        if(mysqli_num_rows($res) > 0){
            $row = mysqli_fetch_assoc($res);
            $hashed_pwd = $row['pwd'];

            if(password_verify($pwd, $hashed_pwd)){
                session_start();
                $_SESSION['mName'] = $row['name'];
                $_SESSION['mEmail'] = $row['email'];
                $_SESSION['mId'] = $manager_Id;
                $_SESSION['managerNum'] = $row['managerid'];

                $sql = "SELECT * FROM logintimes WHERE accnum = '$manager_Id'";
                $res = mysqli_query($conn, $sql);

                $curtime = get_Date();
                $lastlogin = "First Time";
                $tl = "";

                if(mysqli_num_rows($res) == 1){
                    $row = mysqli_fetch_array($res);
                    $tl = $row['timeslogin'];

                    if($tl%2){
                        $sql = "UPDATE logintimes SET time1 = '$curtime'WHERE accnum = '$manager_Id'";
                        $lastlogin = $row['time0'];
                    }
                    else{
                        $sql = "UPDATE logintimes SET time0 = '$curtime'WHERE accnum = '$manager_Id'";
                        $lastlogin = $row['time1'];
                    }
                    mysqli_query($conn, $sql);
                    $tl = $tl+1;
                    $sql = "UPDATE logintimes SET timeslogin = '$tl'WHERE accnum = '$manager_Id'";
                    mysqli_query($conn, $sql);
                }
                else{
                    //$curtime = date_format($curtime, "Y-m-d h:i:u");
                    $sql = "INSERT INTO logintimes (accnum, timeslogin, time0) VALUES('$manager_Id',1,'$curtime')";
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

                header('location: managerhome.php');
            }
            else{
                $err = "Invalid Password !!";
            }
        }
        else{
            $err = "This Manager Id Doesn't Exist !!";
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
    <title>Manager's Login: NRR Bank</title>
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
                <li class="nav-item">
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

    <div class="container signin my-5">
        <div class="card">
            <div class="card-body">

                <h1 class="card-title title text-center">Manager's Login <i class="fas fa-user-tie"></i></h1>
                <h6 class="card-subtitle mb-2 text-muted text-center">Sign In as a NRR Manager</h6>

                <?php
                    if(!empty($err)){
                        echo '<div class="alert alert-danger text-center">'.$err.'</div>';
                    }
                ?>

                <form class="my-5 pr-2" method="POST">
                    <div class="form-group row">
                        <label for="exampleInputPassword1" class="col-4">Manager Id.</label>

                        <input type="text" class="form-control col-8" name="managerId" placeholder="Enter Unique Manager Id.">
                    </div>

                    <div class="form-group row my-3">
                        <label for="exampleInputEmail1" class="col-4">Password</label>
                        <input type="password" class="form-control col-8" name="password"
                            placeholder="Your Unique Password">
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-send btn-block mb-3 py-2 w-75">Verify & Login !</button>
                    </div>
                </form>
                <div class="text-center">
                    <h6>By creating this account,<br>you agree to our <span class="themecol">Terms &
                            Conditions.</span></h6>
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
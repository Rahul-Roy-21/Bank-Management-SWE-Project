<?php
session_start();
// print_r($_SESSION);

include 'connect.php';
$accnum = $_SESSION['accnum'];

$sql = "SELECT * FROM nrracc_primary WHERE accnum = '$accnum'";
$res_p = mysqli_fetch_array(mysqli_query($conn, $sql));

$sql = "SELECT * FROM nrracc_sec WHERE accnum = '$accnum'";
$res_s = mysqli_fetch_array(mysqli_query($conn, $sql));


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
    <title>e-Statements : NRR Bank</title>
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

        label{
            font-weight:bold;
            letter-spacing: 1px;
            border-bottom: 1px solid lightseagreen;
            border-left: 1px solid lightseagreen;
        }
        .summary .row{
            margin-bottom: 18px;
        }
        .fas{
            font-size: 1.2em;
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
                        <!-- <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <div class="dropdown-divider"></div> -->
                        <a class="dropdown-item" href="logout.php">Signout <i class="fas fa-sign-out-alt"></i></a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container my-4">
        <h1 class="title text-center">Account Summary <i class="fas fa-id-card-alt"></i></h1>
        <h6 class="text-center text-muted">See your Registered Profile Details Below</h6>

        <div class="summary text-center my-4 border border-success p-3">
            <div class="row">
                <div class="col-md-3 col-6 d-flex flex-column">
                    <label class="text-muted">Username</label>
                    <h5><?php echo $res_p['name'];?></h5>
                </div>
                <div class="col-md-3 col-6 d-flex flex-column">
                    <label class="text-muted">Account No.</label>
                    <h5><?php echo $accnum;?></h5>
                </div>
                <div class="col-md-3 col-6 d-flex flex-column">
                    <label class="text-muted">NRR User_Id</label>
                    <h5><?php echo $res_p['userid'];?></h5>
                </div>
                <div class="col-md-3 col-6 d-flex flex-column">
                    <label class="text-muted">Guardian Name</label>
                    <h5><?php echo $res_s['guardian'];?></h5>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 col-6 d-flex flex-column">
                    <label class="text-muted">Date Of Birth</label>
                    <h5><?php echo $res_s['dob'];?></h5>
                </div>
                <div class="col-md-3 col-6 d-flex flex-column">
                    <label class="text-muted">Aadhar Number</label>
                    <h5>
                        <?php 
                        $aadhar = trim($res_s['aadhar']);
                        echo chunk_split($aadhar,4," ");
                        ?>
                    </h5>
                </div>
                <div class="col-md-3 col-6 d-flex flex-column">
                    <label class="text-muted">Email Address</label>
                    <h6><?php echo $res_p['email'];?></h6>
                </div>
                <div class="col-md-3 col-6 d-flex flex-column">
                    <label class="text-muted">Mobile Number</label>
                    <h5><?php echo $res_p['mobile'];?></h5>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3 col-6  d-flex flex-column">
                    <label class="text-muted">Address</label>
                    <h5><?php echo $res_s['address'];?></h5>
                </div>
                <div class="col-md-3 col-6  d-flex flex-column">
                    <label class="text-muted">City</label>
                    <h5><?php echo $res_s['city'];?></h5>
                </div>
                <div class="col-md-3 col-6  d-flex flex-column">
                    <label class="text-muted">State</label>
                    <h5><?php echo $res_s['stateinput'];?></h5>
                </div>
                <div class="col-md-3 col-6  d-flex flex-column">
                    <label class="text-muted">PINCode</label>
                    <h5><?php echo $res_s['pin'];?></h5>
                </div>
            </div>

            <div class="row justify-content-md-center">
                <div class="col-md-4 col-6  d-flex flex-column">
                    <label class="text-muted">Customer Since</label>
                    <h5><?php echo date("d/m/Y",strtotime($res_s['accopendate']));?></h5>
                </div>
                <div class="col-md-4 col-6  d-flex flex-column">
                    <label class="text-muted">Current Balance</label>
                    <h5 style="color: red; font-size: 1.3em; font-weight: bolder;"><i class="fas fa-rupee-sign"></i><?php echo ". ".number_format($res_p['balance'], 2);?>/-</h5>
                </div>
            </div>
            
            <small>All Rights Reserved @ NRR Bank</small>

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
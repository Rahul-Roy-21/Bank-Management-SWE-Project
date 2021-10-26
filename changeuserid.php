<?php
    include "connectonly.php";
    session_start();
    //print_r($_SESSION);
    $err = "";
    $accnum = $_SESSION["accnum"];

    if(!array_key_exists("verified",$_SESSION)){
        $_SESSION['verified'] = False;
    }

    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $pwd = trim($_POST['password']);
        $userId = trim($_POST['new_userid']);

        if(strlen($userId) < 5){
            $err = "User Id Should Have Atleast 5 characters.";
        }
        if(empty($pwd) || empty($userId)){
            $err = "Fill All Details !!";
        }

        $sql = "SELECT id FROM nrracc_primary WHERE userid = '$userId' AND NOT accnum = '$accnum'";
        $res = mysqli_query($conn, $sql);

        if(empty($err) && mysqli_num_rows($res) > 0){
            $err = "This User Id is Already Taken !!";
        }

        if(empty($err)){
            $sql = "SELECT id, pwd FROM nrracc_primary WHERE accnum = '$accnum'";
            $row = mysqli_fetch_assoc(mysqli_query($conn, $sql));

            if(password_verify($pwd, $row['pwd'])){
                $sql = "UPDATE nrracc_primary SET userid = '$userId' WHERE accnum = '$accnum'";
                mysqli_query($conn, $sql);

                $_SESSION['verified'] = True;
            }
            else{
                $err = "Invalid Password !!";
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
    <title>User ID Updation: NRR Bank</title>
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

        th {
            background-color: mediumseagreen;
            color: #FFFFFF;
            font-weight: 600;
            letter-spacing: 2px;
        }

        tr:nth-child(odd) {
            background-color: rgba(238, 238, 238, 0.63);
        }

        th,td {
            border: 2px solid white;
        }
        a{
            text-decoration: none;
            color: dodgerblue;
        }
        a:hover{
            color: darkblue;
            font-weight: 800;
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

    <div class="container signin my-5">
        <div class="card">
            <div class="card-body">

                <h1 class="card-title title text-center">User Id Customize <i class="fas fa-credit-card"></i></h1>
                <h6 class="card-subtitle mb-2 text-muted text-center">Change the pre-set User ID. to an unique and relevant User ID. here</h6>

                <?php 
                    if($err){
                        echo '<div class="alert alert-danger text-center my-3">'.$err.'</div>';
                    } 
                    if($_SESSION['verified']){
                        echo '<div class="alert alert-success text-center my-3" role="alert">Your User Id. is Successfully Updated !!<br>Check <a href="accSummary.php" class="alert-link">Account Summary</a> to see your Updated Details</div>';
                    }
                ?>

                <form class="my-5 
                <?php
                    if($_SESSION['verified']){
                        echo 'd-none';
                    } 
                ?>
                " method="POST">
                    <div class="form-group row my-3">
                        <label for="exampleInputEmail1" class="col-5">Current User Id.</label>
                        <label for="exampleInputEmail1" class="col-7">
                            <?php echo $_SESSION['accnum']; ?>
                        </label>
                    </div>

                    <div class="form-group row my-3">
                        <label for="exampleInputEmail1" class="col-4">Password</label>
                        <input type="password" class="form-control col-8" name="password" aria-describedby="emailHelp"
                            placeholder="Your Unique Password">
                    </div>

                    <div class="form-group row my-3">
                        <label for="exampleInputEmail1" class="col-4">New User ID.</label>
                        <input type="text" class="form-control col-8" aria-describedby="emailHelp" name="new_userid"
                        placeholder="Set Your Desired User Id">
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-send btn-block mb-3 py-2 w-75">Proceed</button>
                        
                    </div>
                </form>

                <div class="text-center">
                    <small>While creating this account, you agree to our <span class="themecol">Terms &
                            Conditions.</span></small>
                </div>
            </div>
        </div>
    </div> -->
   

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
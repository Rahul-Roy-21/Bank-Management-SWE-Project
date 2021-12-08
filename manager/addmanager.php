<?php

include '../connectonly.php';
session_start();
//print_r($_SESSION);

$accnum = $_SESSION['managerNum'];
$err = "";
$gotresults = False;

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $name = trim($_POST['mname']);
    $email = trim($_POST['memail']);
    $pwd = trim($_POST['mpwd']);

    $sql = "SELECT id FROM manager WHERE email = '$email'";
    $res = mysqli_query($conn, $sql);

    if(mysqli_num_rows($res)){
        $err = "This Email '".$email."' Already Exists!!";
    }

    if(empty($err)){

        $res = mysqli_query($conn, "SELECT id FROM manager ORDER BY id DESC LIMIT 1");
        $last_id = mysqli_fetch_assoc($res)['id'];

        $manager_Id = "MNRR".rand(100,999).str_pad(strval(intval($last_id)+1),3,"0",STR_PAD_LEFT);

        $nmarr = explode(" ",$name);
        $userid = ucfirst(end($nmarr)).strtolower($nmarr[0])."@NRROfficial";

        $pwd = password_hash($pwd, PASSWORD_DEFAULT);

        $sql = "INSERT INTO manager (managerid,name,email,userid,pwd) VALUES ('$manager_Id','$name','$email','$userid','$pwd')";

        mysqli_query($conn, $sql);
        if(!mysqli_error($conn)){
            $gotresults = True;
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
    <title>Transaction History: NRR Bank</title>
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

        table{
            font-size: 84%;
            letter-spacing: 1px;
            overflow-x: auto;
        }

        th {
            background-color: mediumseagreen;
            color: #FFFFFF;
            font-weight: 600;
            text-align: center;
        }

        tr:nth-child(odd) {
            background-color: rgba(238, 238, 238, 0.63);
        }

        th,td {
            border: 2px solid white;
            text-align: center;
        }
        .fa-sign-out-alt{
            color: red;
            font-size: 1.1em;
        }
        .card {
            box-shadow: 5px 10px 8px #bbb;
        }
        hr{
            border-bottom: 2px solid gray;
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
                <li class="nav-item active">
                    <a class="nav-link" href="managerhome.php" role="button">
                    <i class="fas fa-home"></i> Back Home
                    </a>
                </li>
                <li class="nav-item dropdown active">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-user-tie"></i> Welcome 
                        <?php echo $_SESSION['mName']; ?>
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
        <h1 class="title text-center">Manager Profiles <i class="fas fa-user-tie"></i></h1>
        <h6 class="text-center text-muted">Add and View Managers'directory here</h6>
        <!-- Form Registration -->

        <div class="card my-4 p-4 text-center alert alert-secondary">
            <h3>Add a New Manager Here</h3><hr>
            <?php
                if(!empty($err)){
                    echo '<div class="alert alert-danger text-center"> <b>'.$err.'</b> <i class="fas fa-exclamation-triangle"></i></div>';
                }
                if($gotresults){
                    echo '<div class="alert alert-success text-center"> <b>New Manager Added !!</b> <i class="fas fa-exclamation-triangle"></i></div>';
                }
            ?>
            <form method="post" class="text-center px-3">
                <div class="form-group row">
                    <label class="col-4">Manager Name</label>
                    <input type="text" class="form-control col-8" aria-describedby="emailHelp" placeholder="Enter Manager Name" name="mname" required>
                </div>
                <div class="form-group row">
                    <label class="col-4" for="exampleInputEmail1">Email address</label>
                    <input type="email" class="form-control col-8" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Email address" name="memail" required>
                </div>
                <div class="form-group row">
                    <label class="col-4" for="exampleInputPassword1">Set a Unique Password</label>
                    <input type="password" class="form-control col-8" id="exampleInputPassword1" placeholder="Password" name="mpwd" required>
                    <small id="emailHelp" class="form-text text-muted mx-auto col-10">We'll never share this password with anyone else.</small>
                </div>
                <button type="submit" class="btn btn-send btn-block w-75">Add this Manager <i class="fas fa-check-circle"></i></button>
            </form>
        </div>


        <div class="card my-4 p-4 text-center">
            <h3>Our Manager's Directory</h3><hr>
            <div class="statement" style="overflow-x:auto;">
                <!-- Real Table Starts Here -->
                <?php
                    echo '<table class="table col-5">
                    <tr>
                        <th>Manager\'s Bank ID.</th>
                        <th>Manager Name</th>
                        <th>Email Address</th>
                        <th>Manager\'s User ID.</th>
                    </tr>';

                    $sql = "SELECT * FROM manager";
                    $res = mysqli_query($conn, $sql);

                    //Get the Rows of Table - The Transactions Details
                    while($row = mysqli_fetch_assoc($res))
                    {
                        echo '<tr><td>'.$row['managerid'].'</td>';
                        echo '<td>'.$row['name'].'</td>';
                        echo '<td>'.$row['email'].'</td>';
                        echo '<td>'.$row['userid'].'</td></tr>';
                    }
                ?>
                </table>
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
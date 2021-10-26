<?php

include 'connectonly.php';
session_start();
print_r($_SESSION);
$accnum = $_SESSION['accnum'];


if(array_key_exists('applied',$_SESSION)){
    unset($_SESSION['applied']);
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
    
    <link rel="icon" type="image/png" href="/images/favicon.png" />
    <title>Profile Updates: NRR Bank</title>
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

        .card {
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

        th,
        td {
            border: 2px solid white;
        }
        table{
            font-family:'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
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
        <h1 class="title text-center">Latest News & Updates <i class="fas fa-newspaper"></i></h1>
        <h6 class="text-center text-muted">Here, you can see all the Latest Updates regarding your Account and all Recent Activities.</h6>
        
        <div class="card my-4 p-4">
            <h3  class="text-center">Your Account History</h3><hr>
            <div class="text-center mb-3">
                <div class="justify-content-between">
                <span class="badge badge-pill badge-secondary">Bank Generated Statement</span>
                <span class="badge badge-pill badge-warning">Waiting for Manager's Approval</span>
                <span class="badge badge-pill badge-success">Deposits</span>
                <span class="badge badge-pill badge-danger">Withdrawals</span>
                
                <span class="badge badge-pill badge-primary">Transaction Debits</span>
                <span class="badge badge-pill badge-success">Transaction Crebits</span>
                </div>
            </div>

            <div style="height: 300px; overflow-y:auto;">
            <?php
                $sql = "SELECT * FROM accstatements WHERE accnum = '$accnum' ORDER BY id DESC";
                $res = mysqli_query($conn, $sql);

                $alerttype = array('WT'=>'danger','DT'=>'success','W'=>'danger','D'=>'success');

                while($row = mysqli_fetch_assoc($res)){
                    $des_arr = explode(' ',$row['des']);

                    $lastlogin = date("Y-m-d", strtotime($_SESSION['lastlogin']));

                    if($row['type'] == 'WT'){
                        echo '<div class="alert alert-primary" role="alert">You transferred Rs.<b>'.$row["amount"].'</b> to '.substr($row["ref"],-10).'('.$des_arr[2].' '.$des_arr[3].') via. 
                        <strong>'.$des_arr[count($des_arr)-2].' '.$des_arr[count($des_arr)-1].'</strong> ('.$row["datetime"].' )';

                        
                    }
                    if($row['type'] == 'DT'){
                        echo '<div class="alert alert-success" role="alert">Your Account was Credited Rs.<b>'.$row["amount"].'</b> by '.substr($row["ref"],-10).'('.$des_arr[3].' '.$des_arr[4].') via. 
                        <strong>'.$des_arr[count($des_arr)-2].' '.$des_arr[count($des_arr)-1].'</strong> ('.$row["datetime"].' )';

                    }
                    if($row['type'] == 'W'){
                        echo '<div class="alert alert-danger" role="alert">You withdrew Rs.<b>'.$row["amount"].'</b> for <strong>'.$row["des"].'</strong> ('.date("d/m/Y", strtotime($row["date"])).')';

                    }
                    if($row['type'] == 'D'){
                        if($row['isapproved'] == 0){
                            echo '<div class="alert alert-warning" role="alert">Deposit of Rs.<b>'.$row["amount"].'</b> for <strong>'.$row["des"].'</strong> is yet to be Approved by the Manager ('.date("d/m/Y", strtotime($row["date"])).')';
                        }
                        else{  
                            echo '<div class="alert alert-success" role="alert">You deposited Rs.<b>'.$row["amount"].'</b> for <strong>'.$row["des"].'</strong> via. <b>Manager\'s Approval</b> ('.date("d/m/Y", strtotime($row["date"])).')';
                        }
                    }
                    if($row['isseen'] == 0){
                        echo ' <span class="badge badge-danger">New</span></div>';
                    }
                    else{
                        echo "</div>";
                    }
                }

                $sql = "UPDATE accstatements SET isseen = '1' WHERE accnum = '$accnum'";
                mysqli_query($conn, $sql);


                $sql = "SELECT accopendate FROM nrracc_sec WHERE accnum = '$accnum'";
                $res = mysqli_query($conn, $sql);
                $mydetails = mysqli_fetch_assoc($res);

                echo '<div class="alert alert-secondary" role="alert">
                This Account was Registered on '.date("d/m/Y", strtotime($mydetails["accopendate"])).'. You can check your <a href="accSummary.php" class="alert-link">Profile Details</a> anytime</div>';
            ?>
            </div>
        </div>
        <div class="card my-4 p-4 text-center">
            <h3>Updates from Manager's Desk <i class="fas fa-mail-bulk"></i></h3><hr>
            
            <?php
                $sql = "SELECT msg,replyto,isseen,is_resolved FROM contacts WHERE accnum = '$accnum' AND from_manager = 1 ORDER BY id DESC";
                $res = mysqli_query($conn, $sql);

                if(mysqli_num_rows($res) > 0){
                    while($r = mysqli_fetch_assoc($res)){
                        
                        if($r['is_resolved'] == 2){
                            echo '<div class="alert alert-info border border-dark" role="alert"><u>Bank Notice</u><b><i>: '.$r['msg'].'</i></b>';
                        }
                        else{
                            $replyto = $r['replyto'];

                            $sql = "SELECT msg FROM contacts WHERE id = '$replyto'";

                            $msg = mysqli_fetch_assoc(mysqli_query($conn, $sql))['msg'];

                            echo '<div class="alert alert-info border border-dark" role="alert"><u>Your Query</u><b><i>: '.$msg.'</i></b><br><u>NRROfficials Replied</u>: <b><i>'.$r['msg'].'</i></b>';
                        }

                        if($r['isseen'] == 0){
                            echo ' <span class="badge badge-danger">New</span>';
                        }
                        echo '</div>';
                    }
                    $sql = "UPDATE contacts SET isseen = 1 WHERE accnum = '$accnum' AND from_manager = 1";
                    mysqli_query($conn, $sql);
                }
                else{
                    echo '<div class="alert alert-warning" role="alert"><b>No Unseen Notices from the Manager\'s Desk !</b></div>';
                }
            ?>

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
<?php

include 'connectonly.php';
session_start();
//print_r($_SESSION);

$accnum = $_SESSION['accnum'];
$err = "";
$gotresults = False;
$res = "";

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $searchby = $_POST['searchby'];
    $searchval = trim($_POST['searchval']);
    $sortby = $_POST['sortby'];

    if(empty($searchval) && $searchby == "accnum"){
        $err = "Account Number Field is Empty";
    }

    if($searchby == "accnum" && $searchval == $accnum){
        $err = "You Cannot Enter Your Own Account Number !!";
    }

    if(empty($err)){

        $sql = "SELECT * FROM accstatements WHERE type LIKE '%T' AND (accnum = '$accnum' OR ref LIKE '%$accnum')";
        
        if($searchby == "accnum" && !empty($searchval)){
            $sql .= " AND (accnum = '$searchval' OR ref LIKE '%$searchval')";
        }

        if($searchby[0] == 'l'){
            $today = date("Y-m-d", strtotime('now'));

            if($searchby[2] == 'm'){
                $prevdate = date("Y-m-d", strtotime('-'.$searchby[1].' months'));
            }
            if($searchby[2] == 'y'){
                $prevdate = date("Y-m-d", strtotime('-'.$searchby[1].' years'));
            }

            $sql .= " AND (date BETWEEN '$prevdate' AND '$today')";
        }

        // Sort By
        if($sortby == "dtd"){
            $sql .= " ORDER BY datetime DESC";
        }
        if($sortby == "dta"){
            $sql .= " ORDER BY datetime";
        }
        if($sortby == "amtd"){
            $sql .= " ORDER BY cast(amount as unsigned) DESC";
        }
        if($sortby == "amta"){
            $sql .= " ORDER BY cast(amount as unsigned)";
        }

        $res = mysqli_query($conn, $sql);
        
        if(mysqli_error($conn)){
            $err = "ERROR";
            
        }

        if(mysqli_num_rows($res) > 0){
            $gotresults = True;
        }
        else{
            $err = "NO RESULTS";
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
            font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
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
        <h1 class="title text-center">Transaction History <i class="fas fa-money-check"></i></h1>
        <h6 class="text-center text-muted">Know all your Money Transfer Details Here</h6>

        <!-- Form Registration -->
        <form method="post" class="my-5 text-center">
            <div class="row justify-content-around my-2">
                <label class="col-3">Search by</label>
                <select class="col-8" name="searchby">
                    <option value="all" selected>All Transactions</option>
                    <option value="l1m">Last Month</option>
                    <option value="l2m">Last 2 Months</option>
                    <option value="l3m">Last 3 Months</option>
                    <option value="l6m">Last 6 Months</option>
                    <option value="l1y">Last Year</option>
                    <option value="accnum">Account Number</option>
                </select>
            </div>
            <div class="row justify-content-around my-2">
                <label class="col-3">Account No.</label>
                <input type="text" class="col-8" placeholder="Account No. (if searched above)" name="searchval">
            </div>
            <div class="row justify-content-around my-2">
                <label class="col-3">Sort by</label>
                <select class="col-8" name="sortby">
                    <option value="dtd">Date & Time - Most Recent First</option>
                    <option value="dta">Date & Time - Most Recent Last</option>
                    <option value="amta">Transfer Amount - Lowest First</option>
                    <option value="amtd">Transfer Amount - Highest First</option>
                </select>
            </div>
            <button type="submit" class="btn btn-send btn-block w-50">Search Results</button>
        </form>

        <?php
            if(!empty($err)){
                echo '<div class="alert alert-danger text-center w-75 mx-auto"><b>'.$err.'</b></div>';
            }

        ?>

        <div class="statement my-5
        <?php 
            if(!$gotresults){
                echo 'd-none';
            }
        ?>
        ">
            <!-- Real Table Starts Here -->
            <?php
                if($gotresults){
                    echo '<table class="table col-5 text-center">
                    <tr>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Ref.</th>
                        <th>Other Account</th>
                        <th>Debit/Credit</th>
                    </tr>';
                    //Get the Rows of Table - The Transactions Details
                    for($i=0; $i<mysqli_num_rows($res); $i=$i+2){
                        mysqli_data_seek($res, $i);
                        $row = mysqli_fetch_assoc($res);

                        echo '<tr><td>'.$row['datetime'].'</td>';

                        //If the User Debited(Lost) Money
                        if($row['accnum'] == $accnum){
                            $ref = $row["ref"];
                            $des = $row["des"];
                            $nm = substr($ref,-10);
                            $sql = "SELECT name FROM nrracc_primary WHERE accnum = '$nm'";
                            
                            $nm = mysqli_fetch_assoc(mysqli_query($conn, $sql))['name'];

                            echo '<td>'.$des.'</td>';
                            echo '<td>'.$ref.'</td>';

                            $otheracc = substr($ref,-10).'<br>('.$nm.')';
                            echo '<td>'.$otheracc.'</td>';
                            echo '<td style="color: red;">'.number_format($row['amount'], 2).'</td></tr>';
                        }
                        else{
                            mysqli_data_seek($res, $i+1);
                            $row = mysqli_fetch_assoc($res);

                            $ref = $row["ref"];
                            $des = $row["des"];
                            $nm = explode(" ",$des);
                            $nm = $nm[3]." ".$nm[4];

                            echo '<td>'.$des.'</td>';
                            echo '<td>'.$ref.'</td>';

                            $otheracc = substr($ref,-10).'<br>('.$nm.')';
                            echo '<td>'.$otheracc.'</td>';
                            echo '<td style="color: green;">'.number_format($row['amount'], 2).'</td></tr>';
                        }
                    }
                }
                
            ?>
            </table>
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
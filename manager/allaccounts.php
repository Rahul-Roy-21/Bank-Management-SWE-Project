<?php

include '../connectonly.php';
session_start();
//print_r($_SESSION);

$accnum = $_SESSION['managerNum'];
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

        $sql = "SELECT nrracc_primary.accnum as accnum,
        nrracc_primary.name as name,
        nrracc_primary.email as email,
        nrracc_sec.dob as dob,
        nrracc_primary.mobile as mobile,
        nrracc_sec.aadhar as aadhar,
        nrracc_sec.gender as sex,
        nrracc_primary.balance as bal,
        nrracc_sec.accopendate as accod
        FROM nrracc_primary
        JOIN nrracc_sec
        WHERE nrracc_primary.accnum = nrracc_sec.accnum 
        AND isapproved = 1";
        
        if($searchby == "accnum" && !empty($searchval)){
            $sql .= " AND nrracc_primary.accnum = '$searchval'";
        }

        if($searchby[0] == 'l'){
            $today = date("Y-m-d", strtotime('now'));

            if($searchby[2] == 'm'){
                $prevdate = date("Y-m-d", strtotime('-'.$searchby[1].' months'));
            }
            if($searchby[2] == 'y'){
                $prevdate = date("Y-m-d", strtotime('-'.$searchby[1].' years'));
            }

            $sql .= " AND (nrracc_sec.accopendate BETWEEN '$prevdate' AND '$today')";
        }

        // Sort By
        if($sortby == "dtd"){
            $sql .= " ORDER BY nrracc_sec.accopendate DESC";
        }
        if($sortby == "dta"){
            $sql .= " ORDER BY nrracc_sec.accopendate";
        }
        if($sortby == "amtd"){
            $sql .= " ORDER BY cast(nrracc_primary.balance as unsigned) DESC";
        }
        if($sortby == "amta"){
            $sql .= " ORDER BY cast(nrracc_primary.balance as unsigned)";
        }

        $res = mysqli_query($conn, $sql);
        
        if(mysqli_error($conn)){
            $err = "ERROR";
            
        }

        if(mysqli_num_rows($res) > 0){
            $gotresults = True;
        }
        else{
            $err = "Accounts Not Found !!";
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
        }
        .fa-sign-out-alt{
            color: red;
            font-size: 1.1em;
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
                        <a class="dropdown-item" href="../logout.php">Signout <i class="fas fa-sign-out-alt"></i></a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    
    <div class="container my-4">
        <h1 class="title text-center">Our Accounts <i class="fas fa-book"></i></h1>
        <h6 class="text-center text-muted">Get All Registered Bank Accounts Details</h6>

        <!-- Form Registration -->
        <form method="post" class="my-5 text-center">
            <div class="row justify-content-around my-2">
                <label class="col-3">Search by</label>
                <select class="col-8" name="searchby">
                    <option value="all" selected>All Accounts</option>
                    <option value="l1m">Created Last Month</option>
                    <option value="l2m">Created in last 2 Months</option>
                    <option value="l3m">Created in last 3 Months</option>
                    <option value="l6m">Created in last 6 Months</option>
                    <option value="l1y">Created in last Year</option>
                    <option value="accnum">Account Number (Entered below)</option>
                </select>
            </div>
            <div class="row justify-content-around my-2">
                <label class="col-3">Account No.</label>
                <input type="text" class="col-8" placeholder="Account No. (if searched above)" name="searchval">
            </div>
            <div class="row justify-content-around my-2">
                <label class="col-3">Sort by</label>
                <select class="col-8" name="sortby">
                    <option value="dtd">Most Recent Created First</option>
                    <option value="dta">Most Recent Created Last</option>
                    <option value="amta">Cur.Balance - Lowest First</option>
                    <option value="amtd">Cur.Balance - Highest First</option>
                </select>
            </div>
            <button type="submit" class="btn btn-send btn-block w-50">Search Accounts</button>
        </form>

        <?php
            if(!empty($err)){
                echo '<div class="alert alert-danger text-center mx-auto"> <b>'.$err.'</b> <i class="fas fa-exclamation-triangle"></i></div>';
            }
            if($_SERVER['REQUEST_METHOD'] == 'POST' && empty($err)){
                echo '<div class="alert alert-primary text-center mx-auto"><b>'.mysqli_num_rows($res).' Matching Accounts Found !!</b> <i class="fas fa-check-circle"></i></div>';
            }

        ?>

        <div class="statement my-5
        <?php 
            if(!$gotresults){
                echo 'd-none';
            }
        ?>
        " style="overflow-x:auto;">
            <!-- Real Table Starts Here -->
            <?php
                if($gotresults){
                    echo '<table class="table col-5">
                    <tr>
                        <th>Account No.</th>
                        <th>Account Holder</th>
                        <th>Email Address</th>
                        <th>Mobile Number</th>
                        <th>Aadhar No.</th>
                        <th>Date Of Birth</th>
                        <th>Sex</th>
                        <th>Balance<br>(in Rs.)</th>
                        <th>Customer Since</th>
                    </tr>';
                    //Get the Rows of Table - The Transactions Details
                    while($row = mysqli_fetch_assoc($res))
                    {
                        echo '<tr><td>'.$row['accnum'].'</td>';
                        echo '<td>'.$row['name'].'</td>';
                        echo '<td>'.$row['email'].'</td>';
                        echo '<td>'.$row['mobile'].'</td>';
                        echo '<td>'.$row['aadhar'].'</td>';
                        echo '<td>'.date("d/m/Y",strtotime($row['dob'])).'</td>';
                        echo '<td class="text-center">'.substr($row['sex'],0,1).'</td>';
                        echo '<td class="text-right">'.number_format($row['bal'], 2).'</td>';
                        
                        echo '<td>'.date("d/m/Y",strtotime($row['accod'])).'</td></tr>';

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
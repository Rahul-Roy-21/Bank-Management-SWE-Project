<?php

include 'connect.php';
session_start();
//print_r($_SESSION);
$accnum = $_SESSION['accnum'];

$sql = "SELECT id, accopendate FROM nrracc_sec WHERE accnum = '$accnum'";
$acc_open = mysqli_fetch_array(mysqli_query($conn, $sql))['accopendate'];
$datetimelocal = strtotime(substr(get_Date("L"),0,11));

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
    <title>Account Summary: NRR Bank</title>
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
        .alert{
            font-weight: bold;
            text-align: center;
            width: 70%;
            margin: 0 auto;
        }
        .salutation th{
            padding: 2px 15px;
        }
        .fas{
            font-size: 1.2em;
        }
        .statement{
            font-family: 'Lucida Console', serif;
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
        <h1 class="title text-center">Account Statement <i class="fas fa-money-check"></i></h1>
        <h6 class="text-center text-muted">An official summary of all financial transactions occurring within a given
            period for your NRR Bank account</h6>

        <!-- Form Registration -->
        <form method="POST" class="my-5 text-center">
            <h4>Enter Statement Period</h4>
            <div class="form-row">
                <div class="col-1">From</div>
                <div class="form-group col-5">

                    <input name="from" type="date" class="form-control" value="<?php echo $acc_open;?>">
                </div>
                <div class="col-1">to</div>
                <div class="form-group col-5">
                    <input name="to" type="date" class="form-control" value="<?php echo date('Y-m-d',$datetimelocal);?>">
                </div>
            </div>

            <button type="submit" class="btn btn-send btn-block w-75">Get Bank Statement Now!</button>
        </form>

        <?php
        $res = "";

        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $from = $_POST['from'];
            $to = $_POST['to'];
        
            $sql = "SELECT * FROM accstatements WHERE accnum = '$accnum' AND isapproved = 1 AND date BETWEEN '$from' AND '$to' ORDER BY id DESC";
            $res = mysqli_query($conn, $sql);
            echo mysqli_error($conn);
        
            if(empty($res)){
                echo '<div class="alert alert-info" role="alert">Enter a Timespan to search Statements</div>';
            }
            else if(mysqli_num_rows($res) == 0){
                echo '<div class="alert alert-danger" role="alert">No Results Found !! </div>';
            }
            else{
                $sql = "SELECT address, city, pin FROM nrracc_sec WHERE accnum = '$accnum'";
                $addr = mysqli_fetch_assoc(mysqli_query($conn, $sql));
                
                $stm = '<div class="statement my-5"><div class="top row justify-content-between m-4"><p class="userdetail_st col-5 p-4">';
                $stm.= strtoupper($_SESSION['name']).'<br>';
                $stm.= strtoupper($addr['address']).'<br>';
                $stm.= strtoupper($addr['city']).', PIN: '.$addr['pin'].'</p>';
                echo $stm;

                $stm = '<table class="col-5 text-center salutation"><tr><th>Statement Period</th><th>Account No.</th><th>Date of Issue</th></tr>';
                $stm.= '<tr><td>'.$from.' to '.$to.'</td><td>'.$accnum.'</td><td>'.date("d M Y").'</td></tr></table></div>';
                echo $stm;

                $stm = '<table class="table col-5 text-center">';
                $stm .=  '<tr><th>Date</th><th>Date Value</th><th>Description</th><th>Ref.</th><th>Debits</th><th>Credits</th><th>Balance</th></tr>';

                $sql = "SELECT balance FROM nrracc_primary WHERE accnum = '$accnum'";
                $curbal = mysqli_fetch_assoc(mysqli_query($conn, $sql))['balance'];

                $tab = '</table></div>';

                while($row = mysqli_fetch_assoc($res)){
                    $date = date("d/m/Y", strtotime($row['date']));
                    $dateval = date("d M Y", strtotime($row['date']));
                    $descr = $row['des'];
                    $refno = $row['ref'];
                    $amt = $row['amount'];

                    $r = "<tr><td>".$date."</td><td>".$dateval."</td><td>".$descr."</td><td>".$refno."</td>";

                    if($row['type'][0] == 'D'){
                        $r .= '<td></td><td>'.number_format($row['amount'], 2).'</td><td>'.number_format($curbal,2).'</td></tr>';
                        $curbal = $curbal - floatval($row['amount']);
                    }
                    else{
                        $r .= '<td>'.number_format($row['amount'], 2).'</td></td><td><td>'.number_format($curbal,2).'</td></tr>';
                        $curbal = $curbal + floatval($row['amount']);
                    }
                    $tab = $r.$tab;
                }
                if($from < $acc_open){
                    $from = $acc_open;
                }
                else{
                    $fr = date("d/m/Y", strtotime($from)).'</td><td>'.date("d M Y", strtotime($from));
                    $r = "<tr><td>".$fr."</td><td>Previous Balance</td><td></td><td></td><td></td><td>".number_format($curbal,2)."</td>";
                }
                $tab = $r.$tab;

                $stm .= $tab;
                
                $stm .= '<a class="btn btn-send btn-block w-75" target="_blank" href="issuestatement.php?accno='.$accnum.'&from='.$from.'&to='.$to.'&curbal='.$curbal.'" role="button">Print Bank Statement Now!</a>';
                echo $stm;
            }
        }
        ?>
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
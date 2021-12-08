<?php
include '../connectonly.php';

session_start();
//print_r($_SESSION);
//print_r($_POST);

if(!array_key_exists('approvals', $_SESSION)){
    $_SESSION['approvals'] = array('a'=>False,'ca'=>False,'la'=>False);
}
$type = array('EL'=>'Education Loan <i class="fas fa-graduation-cap"></i>',
            'HL'=>'Home Loan <i class="fas fa-home"></i>',
            'GL'=>'Gold Loan <i class="fas fa-coins"></i>',
            'CL'=>'Car Loan <i class="fas fa-car"></i>',
            'PL'=>'Personal Loan <i class="fas fa-universal-access"></i>'
        );

$sn_err = "";

if($_SERVER['REQUEST_METHOD'] == 'POST')
{   
    $b = array_keys($_POST)[0];

    //If post-call is for Approve Money Deposit
    if($b[0] == 'a' && !$_SESSION['approvals']['a']){
        
        $akey = explode('a',$b);
        $id = intval($akey[1]);
        $amt = floatval($akey[2]);
        $accnum = trim($akey[3]);

        $sql = "UPDATE nrracc_primary SET balance = balance + '$amt' WHERE accnum = '$accnum'";
        mysqli_query($conn, $sql);

        if($e = mysqli_error($conn)){
            $sn_err .= $e;
        }

        $sql = "UPDATE accstatements SET isseen = 0,isapproved = 1 WHERE id = '$id'";
        mysqli_query($conn, $sql);

        if($e = mysqli_error($conn)){
            if($sn_err){
                $sn_err .= '<br>'.$e;
            }
            else{
                $sn_err .= $e;
            }  
        }
        if(empty($sn_err)){
            $_SESSION['approvals'] = array('a'=>True,'ca'=>False,'la'=>False,'accnum'=>$accnum, 'amt'=>$amt);
        }
        
    }

    //If POST-request is for Dismiss Deposit Request
    if($b[0] == 'd'){
        $id = intval(substr($b,1));

        // DELETE this accStatement Now
        $sql = "DELETE FROM accstatements WHERE id = '$id'";
        mysqli_query($conn, $sql);
    }

    if($b[0] == 'c' && !$_SESSION['approvals']['ca']){
        $accnum = substr($b,1);
        
        $sql = "UPDATE nrracc_primary SET isapproved = 1 WHERE accnum = '$accnum'";
        mysqli_query($conn, $sql);

        include '../mailer.php';

        $sql = "SELECT name,email,userid FROM nrracc_primary WHERE accnum = '$accnum'";
        $row = mysqli_fetch_assoc(mysqli_query($conn, $sql));

        $sent = sendMail($row['name'], $row['email'], array('accnum'=>$accnum, 'userid'=>$row['userid']),'CREATEDACC');

        if(!$sent){
            $sn_err = "EMAIL can't be Sent !!!";
        }

        $sql = "SELECT name,accnum,email,userid FROM nrracc_primary WHERE accnum = '$accnum'";
        $row = mysqli_fetch_assoc(mysqli_query($conn, $sql));

        if($e = mysqli_error($conn)){
            if($sn_err){
                $sn_err .= '<br>'.$e;
            }
            else{
                $sn_err .= $e;
            }  
        }

        if(empty($sn_err)){
            $_SESSION['approvals'] = array('a'=>False,'ca'=>True,'la'=>False,'accnum'=>$accnum);
        }

    }

    //If POST-request is for Dismiss Deposit Request
    if($b[0] == 'z'){
        $accnum = substr($b,1);

        // DELETE this accStatement Now
        $sql = "DELETE FROM nrracc_primary WHERE accnum = '$accnum'";
        mysqli_query($conn, $sql);
        $sql = "DELETE FROM nrracc_sec WHERE accnum = '$accnum'";
        mysqli_query($conn, $sql);
    }

    if($b[0] == 'l' && !$_SESSION['approvals']['la']){
        $info = explode('l',$b);
        $id = $info[1];
        $accnum = $info[2];
        $amount = $info[3];
        $loan_type = $info[4];

        //Set stage = 1,issuedate = now() for loan
        //Send Notice
        $now = date('Y-m-d H:i:s');

        $sql = "UPDATE loans SET stage = 1, issuedate = '$now' WHERE id = '$id'";
        mysqli_query($conn, $sql);

        $notice = $type[$loan_type].' of Rs.'.number_format($amount,2).'/- is Approved and Sanctioned by NRR Bank !!';

        $sql = "INSERT INTO contacts (from_manager,accnum,msg,is_resolved) VALUES (1,'$accnum','$notice',2)";
        mysqli_query($conn, $sql);

        if($e = mysqli_error($conn)){
            if($sn_err){
                $sn_err .= '<br>'.$e;
            }
            else{
                $sn_err .= $e;
            }  
        }

        if(empty($sn_err)){
            $_SESSION['approvals'] = array('a'=>False,'ca'=>False,'la'=>True,'accnum'=>$accnum, 'amt'=>$amount);
        }

    }

    //If POST-request is for Dismiss Deposit Request
    if($b[0] == 'x'){
        $id = substr($b,1);

        // DELETE this accStatement Now
        $sql = "DELETE FROM loans WHERE id = '$id'";
        mysqli_query($conn, $sql);
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
    <title>Hello, world!</title>
    <style>
        body {
            font-family: 'Special Elite', cursive;
        }

        .themecol {
            color: mediumseagreen;
        }

        .navbar {
            font-weight: bold;
            letter-spacing: 2px;
        }

        .custom-nav {
            background-color: rgb(62, 170, 111);
        }

        .actBtn {
            margin-right: 1em;
            background-color: mediumseagreen;
            color: white;
            border-radius: 5px;
            transition: 0.6s;
        }

        .actBtn:hover {
            font-weight: 600;
            color: rgb(73, 156, 73);
            background-color: rgba(255, 255, 255, 0.876);
            border: 1px solid rgb(73, 156, 73);
        }

        .register {
            padding: 1em 0;
            position: relative;
        }

        .btn-send {
            background: mediumseagreen;
            padding: 5px 0;
            color: #FFFFFF;
            font-weight: 700;
            border: none;
            margin: 2% auto;
            letter-spacing: 1px;
        }

        .fa-user-circle {
            position: relative;
            top: 3px;
            font-size: 1.5em;
        }

        .marquee {
            color: mediumseagreen;
            height: 100%;
            font-size: larger;
        }

        .card {
            border: none;
            margin: 8px 0;
            box-shadow: 5px 10px 8px #bbb;
        }

        li a {
            color: dodgerblue;
            font-size: 1.1em;
        }

        li a:hover {
            text-decoration: none;
            font-weight: bolder;
        }
        label{
            font-weight: 700;
        }
        
        table{
            font-size: 84%;
            letter-spacing: 1px;
        }

        th {
            background-color: mediumseagreen;
            color: #FFFFFF;
            font-weight: 600;
            text-align: center;
        }

        th,td {
            border: 2px solid white;
            text-align: center;
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

    <div class="container my-3">

        <?php
            if($_SESSION['approvals']['a']){
                echo '<div class="alert alert-success alert-dismissible fade show text-center" role="alert"><b>Deposit of Rs. '.number_format($_SESSION['approvals']['amt'],2).'/- to Acc. '.$_SESSION['approvals']['accnum'].' Approved Successfully <i class="fas fa-thumbs-up"></i> !!</b></div>';
                //$_SESSION['approvals'] = array('a'=>False);
            }
            if($_SESSION['approvals']['ca']){
                echo '<div class="alert alert-success alert-dismissible fade show text-center" role="alert"><b>New Account '.$_SESSION['approvals']['accnum'].' Created Successfully !!<i class="fas fa-thumbs-up"></i> !!</b></div>';
                //$_SESSION['approvals'] = array('a'=>False);
            }
            if($_SESSION['approvals']['la']){
                echo '<div class="alert alert-success alert-dismissible fade show text-center" role="alert"><b>Loan of Rs. '.number_format($amount,2).'/-  is Sanctioned successfully for Account No. '.$accnum.' <i class="fas fa-thumbs-up"></i> !!</b></div>';
                //$_SESSION['approvals'] = array('a'=>False);
            }
            if($sn_err){
                echo '<div class="alert alert-danger text-center"><b>'.$sn_err.' <i class="fas fa-exclamation-circle"></i></b></div>';
            }
        ?>

        <div class="statement card alert alert-warning p-3 my-4">
            <h3 class="text-center pt-3"></i> Money Deposit Requests <i class="fas fa-bell"></i></h3>
            <hr class="border border-dark">

            <form method="post" style="overflow:auto;">
                <!-- Real Table Starts Here -->
                <?php

                    $sql = "SELECT * FROM accstatements WHERE type = 'D' AND isapproved = 0";
                    $res = mysqli_query($conn, $sql);

                    if(mysqli_num_rows($res) > 0){
                        echo '<table class="table col-5">
                        <tr>
                            <th>Name</th>
                            <th>Deposit Amount</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>';
                    }
                    else{
                        echo '<div class="alert alert-info text-center"><b>No Pending Money Request Found !!</b></div>';
                    }

                    //Get the Rows of Table - The Transactions Details
                    while($row = mysqli_fetch_assoc($res))
                    {   
                        $acn = $row['accnum'];

                        $sql="SELECT name FROM nrracc_primary WHERE accnum = '$acn'";
                        $name = mysqli_fetch_assoc(mysqli_query($conn, $sql))['name'];
                        $name .= " (".$acn.") ";

                        $name .= "<span class='badge badge-danger'>New</span>";

                        echo '<tr><td>'.$name.'</td>';
                        echo '<td>'.number_format($row['amount'],2) .'</td>';

                        echo '<td>'.$row['des'].'</td>';
                        
                        $buttons = '<div class="btn-group" role="group">';
                        $buttons .= '<button class="btn btn-success btn-sm mx-1" type="submit" name="a'.$row['id'].'a'.$row['amount'].'a'.$acn.'">Approve</button>';
                        $buttons .= '<button class="btn btn-danger btn-sm mx-1" type="submit" name="d'.$row['id'].'">Dismiss</button></div>';
                        echo '<td>'.$buttons.'</td></tr>';
                    }
                ?>
                </table>
            </form>
        </div>

        <div class="statement card alert alert-info p-3 my-4">
            <h3 class="text-center pt-3"></i> Account Creation Requests <i class="fas fa-book"></i></h3>
            <hr class="border border-dark">

            <form method="post" style="overflow:auto;">
                <!-- Real Table Starts Here -->
                <?php
                    
                    $sql = "SELECT * FROM nrracc_primary JOIN nrracc_sec WHERE nrracc_primary.accnum = nrracc_sec.accnum AND nrracc_primary.isapproved = 0";
                    $res = mysqli_query($conn, $sql);

                    if(mysqli_num_rows($res) > 0){
                        echo '<table class="table col-5">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Initial Balance</th>
                            <th>Aadhar No.</th>
                            <th>Address</th>
                            <th>Actions</th>
                        </tr>';
                    }
                    else{
                        echo '<div class="alert alert-warning text-center"><b>No Pending Registration Found !!</b></div>';
                    }

                    //Get the Rows of Table - The Transactions Details
                    while($row = mysqli_fetch_assoc($res))
                    {   
                        $name = $row['name']." (S/W of ".$row['guardian'].")";

                        $name .= "<span class='badge badge-danger'>New</span>";

                        echo '<tr><td  width="100px">'.$name.'</td>';
                        echo '<td>'.$row['email'].'</td>';
                        echo '<td>'.$row['mobile'].'</td>';
                        
                        echo '<td>'.number_format($row['balance'],2) .'</td>';
                        echo '<td>'.$row['aadhar'].'</td>';
                        
                        echo '<td>'.$row['address'].','.$row['city'].','.$row['stateinput'].',PIN: '.$row['pin'].'</td>';
                        
                        $buttons = '<div class="btn-group" role="group">';
                        $buttons .= '<button class="btn btn-success btn-sm mx-1" type="submit" name="c'.$row['accnum'].'">Approve</button>';
                        $buttons .= '<button class="btn btn-danger btn-sm mx-1" type="submit" name="z'.$row['id'].'">Dismiss</button></div>';
                        echo '<td>'.$buttons.'</td></tr>';
                    }
                ?>
                </table>
            </form>
        </div>

        <div class="statement card alert alert-success p-3 my-4">
            <h3 class="text-center pt-3"></i> Loan Approval Requests <i class="fas fa-file-invoice-dollar"></i></h3>
            <hr class="border border-dark">

            <form method="post" style="overflow:auto;">
                <!-- Real Table Starts Here -->
                <?php
                    
                    $sql = "SELECT loans.*,nrracc_primary.name FROM loans JOIN nrracc_primary WHERE loans.accnum = nrracc_primary.accnum AND loans.stage = 0";
                    $res = mysqli_query($conn, $sql);

                    if(mysqli_num_rows($res) > 0){
                        echo '<table class="table col-5">
                        <tr>
                            <th>Name</th>
                            <th>Type of Loan</th>
                            <th>Loan Amount</th>
                            <th>Loan Tenure</th>
                            <th>Apply Date</th>
                            <th>Actions</th>
                        </tr>';
                    }
                    else{
                        echo '<div class="alert alert-warning text-center"><b>No Pending Loan Requests Found !!</b></div>';
                    }

                    
                    //Get the Rows of Table - The Transactions Details
                    while($row = mysqli_fetch_assoc($res))
                    {   
                        $name = $row['name']." (".$row['accnum'].")";

                        $name .= "<span class='badge badge-danger'>New</span>";

                        echo '<tr><td>'.$name.'</td>';
                        echo '<td>'.$type[$row['type']].'</td>';
                        echo '<td>'.number_format($row['amount'],2).'</td>';
                        
                        if($row['tenure'] < 12){
                            echo '<td>'.$row['tenure'].' Months</td>';
                        }
                        else{
                            echo '<td>1 Year</td>';
                        }
                        echo '<td>'.date('d/m/Y h:i:s A', strtotime($row['issuedate'])).'</td>';
                        
                        $buttons = '<div class="btn-group" role="group">';
                        $buttons .= '<button class="btn btn-success btn-sm mx-1" type="submit" name="l'.$row['id'].'l'.$row['accnum'].'l'.$row['amount'].'l'.$row['type'].'">Approve</button>';
                        $buttons .= '<button class="btn btn-danger btn-sm mx-1" type="submit" name="x'.$row['id'].'">Dismiss</button></div>';
                        echo '<td>'.$buttons.'</td></tr>';
                    }
                ?>
                </table>
            </form>
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
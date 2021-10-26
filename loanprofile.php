<?php

include 'connectonly.php';
session_start();
//print_r($_SESSION);
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
    <link href="https://fonts.googleapis.com/css2?family=Rubik&family=Special+Elite&display=swap" rel="stylesheet">

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

        th,td {
            border: 2px solid white;
        }

        table{
            font-family:'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
        }

        .fa-sign-out-alt{
            color: red;
            font-size: 1.1em;
        }

        .Rubik{
            font-family: 'Rubik', serif;
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
        <h1 class="title text-center">Loan Criterias & Applications <i class="fas fa-hand-holding-usd"></i></h1>
        <h6 class="text-center text-muted">Here, you get to know all the Eligibility criterias as well as check all your Loans, including all the Active Santioned Loans and those Waiting for Manager's Approval</h6>
        
        <div class="card my-4 p-4">
            <h3 class="text-center">Applied and Approved Loans <i class="fas fa-file-invoice-dollar"></i></h3>
            <hr class="border border-success">
            <div class="text-center mb-3">
                <div class="justify-content-between">
                <span class="badge badge-pill badge-warning">Waiting for Manager's Approval</span>
                <span class="badge badge-pill badge-info">Active Loans</span>
                <span class="badge badge-pill badge-success">Successful Loans</span>
                </div>
            </div>

            <div style="height:auto; max-height:500px overflow-y:auto;">
            <?php
                $sql = "SELECT * FROM loans WHERE accnum = '$accnum' ORDER BY id DESC";
                $res = mysqli_query($conn, $sql);

                if(mysqli_num_rows($res) == 0){
                    echo '<div class="alert alert-warning text-center border border-warning" role="alert">No Loan Applications Found !!</div>';
                }

                while($row = mysqli_fetch_assoc($res)){
                    // $des_arr = explode(' ',$row['des']);

                    // $lastlogin = date("Y-m-d", strtotime($_SESSION['lastlogin']));

                    $date = date('d/m/Y', strtotime($row['issuedate']));
                    $type = array('EL'=>'Education Loan <i class="fas fa-graduation-cap"></i>',
                    'HL'=>'Home Loan <i class="fas fa-home"></i>',
                    'GL'=>'Gold Loan <i class="fas fa-coins"></i>',
                    'CL'=>'Car Loan <i class="fas fa-car"></i>',
                    'PL'=>'Personal Loan <i class="fas fa-universal-access"></i>');

                    if($row['stage'] == 0){
                        echo '<div class="alert alert-warning" role="alert">[Applied on '.$date.'] <b>'.$type[$row['type']].'</b> of <b>Rs.'.number_format($row['amount'], 2).'/-</b> is Waiting for <b>Manager\'s Approval</b></div>';
                        
                    }
                    if($row['stage'] == 1){
                        echo '<div class="alert alert-info" role="alert">[Sanctioned on '.$date.'] <b>'.$type[$row['type']].'</b> of <b>Rs.'.number_format($row['amount'], 2).'/-</b> is <b>Active </b>Now</div>';
                        
                    }
                    if($row['stage'] == 2){
                        echo '<div class="alert alert-info" role="alert"> [Sanctioned on '.$date.'] <b>'.$type[$row['type']].'</b> of <b>Rs.'.number_format($row['amount'], 2).'/-</b> is <b>Successfully Repaid and Cleared</b></div>';
                    }
                }
            ?>
            </div>
        </div>
        <hr>
        <div class="container my-3 p-4">
            <h3 class="text-center">
                Understanding Loan Utilities in NRR Bank <i class="fas fa-hand-holding-usd"></i>
            </h3>
            <hr class="border border-success">

            <div class="container">
            <img src="images/aboutloans.jpg" class="img-fluid" alt="Understanding Loans image">
            </div>

            <br>
            <h4 class="text-center"><b>Qualifying for a Loan</b></h4>
            <p class="Rubik">To get a loan you’ll have to qualify. Lenders only make loans when they believe they’ll be repaid. There are a few factors that lenders use to determine whether you are eligible for a loan or not.
            <ol class="Rubik" type="I">
                <li>Your <b>Credit score</b> is a key factor in helping you qualify since it shows how you’ve used loans in the past. If you have a higher credit score, you’re more likely to get your loans approved at a reasonable interest rate.</li>

                <li>You'll likely also need to show that you have enough income to repay the loan. Lenders will often look at your <b>debt-to-income ratio</b> —the amount of money you have borrowed compared to the amount you earn.</li>

                <li>If you don’t have strong credit, or if you’re borrowing a lot of money, you may also have to <b>secure the loan with collateral</b>—otherwise known as a <b>secured loan</b>. This allows the lender to take something and sell it if you’re unable to repay the loan. You might even need to have <b>someone with good credit co-sign on the loan</b>, which means they take responsibility to pay it if you can’t.</li>
            </ol>
            </p>

            <h4 class="text-center"><b>Applying for a Loan</b></h4>
            <ol type="I" class="Rubik">
                <li>When you want to borrow money, you will have to <a href="loanapply.php">Apply for the Loan<a>, and then contact the NRR officials—either online or in-person and request for the approval of your loan.</li>

                <li>The manager will evaluate your application based on your Account Summary and past details and decide whether you qualify for the loan.</li> 
                
                <li>If you’re approved, the lender will send funds to you or the entity you're paying—if you're buying a house or a car, for example, the money might be sent to you.</li>

                <li>Shortly after receiving the funding, you’ll start to repay the loan on an agreed-upon recurring date (once a month), with a pre-determined rate of interest.</li>


            </p>
            

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
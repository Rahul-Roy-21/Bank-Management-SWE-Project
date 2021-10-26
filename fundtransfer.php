<?php
include 'connect.php';
include 'mailer.php';
session_start();

if(!array_key_exists('ft', $_SESSION)){
    $_SESSION['ft'] = False;
}
if(!array_key_exists('verified', $_SESSION)){
    $_SESSION['verified'] = False;
}
// 'verified' will be used to otp verify users in fund transfer, update useriD and Passwords. 'verified' turns True when we have succesfully sent the mail and go to userhomeverify window to verify the transaction/updation

//print_r($_SESSION);

$accnum = $_SESSION['accnum'];
$err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $tpwd = trim($_POST['tpwd']);
    $rec = explode("(", $_POST['reciever']);
    $amount = trim($_POST['amount']);

    if(count($rec) > 0 && $rec[0] == "C"){
        $err = "Choose a Recipient from the List";
    }
    if(!is_numeric($amount)){
        $err = "Enter a Valid Transfer Amount";
    }
    if(empty($tpwd) || empty($amount) || !count($rec)){
        $err = "Fill ALL Details to Proceed";
    }

    if(empty($err) && !$_SESSION['ft']){
        $sql = "SELECT id,balance,tpwd FROM nrracc_primary WHERE accnum = '$accnum'";
        $row = mysqli_fetch_assoc(mysqli_query($conn, $sql));

        $reciever = $rec[0];
        $reciever_acc = substr($rec[1], 0, 10) ;
        $db_tpwd = $row['tpwd'];
        if(password_verify($tpwd, $db_tpwd) && !$_SESSION['ft'])
        {
            $_SESSION['amt'] = $amount;
            $_SESSION['recipient'] = $reciever_acc;
            $_SESSION['recipient_name'] = $reciever;
            $_SESSION['otp'] = bin2hex(random_bytes(5));

            $res = sendMail($_SESSION['name'], $_SESSION['email'], $_SESSION['otp'], 'FTVERIFY');
            $_SESSION['verified'] = True;
            // 'verified' turns True when we have succesfully sent the mail
            // and go to userhomeverify window to verify the transaction/updation

            header('location: userhomeverify.php');

            
        }
        else{
            $err = "Invalid Password !";
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
    <title>Fund Transfer: NRR Bank</title>
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
        select option{
            font-family: 'Lucida Console', serif;
        }
        .fas{
            font-size: 0.7em;
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

                <h1 class="card-title title text-center">
                    Funds Transfer 
                    <i class="fas fa-credit-card"></i>
                    <i class="fas fa-exchange-alt"></i>
                    <i class="fas fa-credit-card"></i>
                </h1>
                <h6 class="card-subtitle mb-2 text-muted text-center">The Real Money Transaction Portal is here</h6>

                <?php
                    if(!empty($err)){
                        echo '<div class="alert alert-danger text-center mt-3">'.$err.'</div>';
                    }
                    if($_SESSION['ft'] && $_SESSION['verified']){
                        echo '<div class="alert alert-success text-center mt-3"><b>Transaction Successful !!</b><br><i class="fas fa-rupee-sign"></i> '.number_format($_SESSION['amt'],2).'/- DEBITED from your Account</div>';
                    }
                ?>

                <form method="POST" class="my-4 pr-2
                <?php
                    if($_SESSION['ft'] && $_SESSION['verified']){
                        echo "d-none";
                    }
                ?>
                ">

                    <div class="form-group row my-3">
                        <label class="col-4" for="inputState">Choose Recipient</label>
                        <select class="form-control col-8" class="form-control" name="reciever">
                        
                        <?php
                            
                            $sql= "SELECT name, accnum FROM nrracc_primary WHERE NOT accnum = '$accnum' ORDER BY name";
                            $res = mysqli_query($conn, $sql);

                            echo '<option value="C" selected>Choose a Recipient...</option>';

                            while($row = mysqli_fetch_assoc($res)){
                                echo '<option value="'.$row["name"].'('.$row["accnum"].')">'.$row["name"].'('.$row["accnum"].')</option>';
                            }

                        ?>
                        </select>
                    </div>

                    <div class="form-group row my-3">
                        <label for="exampleInputEmail1" class="col-4">Transfer Amount</label>
                        <input type="text" class="form-control col-8" name="amount" aria-describedby="emailHelp">
                    </div>

                    <div class="form-group row my-3">
                        <label class="col-4">Transaction Password</label>
                        <input type="password" class="form-control col-8" name="tpwd" aria-describedby="emailHelp"
                            placeholder="Enter Transaction Password">
                    </div>

                    <!-- Get the Transaction ID. , Wait for Approval of Manager-->

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


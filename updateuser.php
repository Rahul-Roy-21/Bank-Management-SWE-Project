<?php

include 'connectonly.php';
session_start();
// print_r($_SESSION);
$err="";

if(!array_key_exists('verified', $_SESSION)){
    $_SESSION['verified'] = False;
}

$states = array("Andhra Pradesh",
        "Arunachal Pradesh",
        "Assam",
        "Bihar",
        "Chhattisgarh",
        "Goa",
        "Gujarat",
        "Haryana",
        "Himachal Pradesh",
        "Jammu and Kashmir",
        "Jharkhand",
        "Karnataka",
        "Kerala",
        "Madhya Pradesh",
        "Maharashtra",
        "Manipur",
        "Meghalaya",
        "Mizoram",
        "Nagaland",
        "Odisha",
        "Punjab",
        "Rajasthan",
        "Sikkim",
        "Tamil Nadu",
        "Telangana",
        "Tripura",
        "Uttarakhand",
        "Uttar Pradesh",
        "West Bengal",
        "Andaman and Nicobar Islands",
        "Chandigarh",
        "Dadra and Nagar Haveli",
        "Daman and Diu",
        "Delhi",
        "Lakshadweep",
        "Puducherry"
    );

function getStates($st="Andhra Pradesh"){
    $sel = '<select name="state" id="state" class="form-control">';
    $states = $GLOBALS['states'];

    for($i=0; $i<count($states); $i++){
        if($states[$i] == $st){
            $sel .= "<option value='".$states[$i]."' selected>".$states[$i]."</option>";
        }
        else{
            $sel .= "<option value='".$states[$i]."'>".$states[$i]."</option>";
        }
    }

    $sel .='</select>';
    return $sel;
}

$accnum = $_SESSION['accnum'];
$sql = "SELECT * FROM nrracc_primary WHERE accnum = '$accnum'";
$resp = mysqli_fetch_assoc(mysqli_query($conn, $sql));

$sql = "SELECT * FROM nrracc_sec WHERE accnum = '$accnum'";
$ress = mysqli_fetch_assoc(mysqli_query($conn, $sql));


// When the { Register Now !!} is Clicked.
if($_SERVER['REQUEST_METHOD'] == "POST" && !$_SESSION['verified']){
    
    $name = trim($_POST['name']);
    $guardian = trim($_POST['guardian']);
    $fieldsEmpty = empty($name) || empty($guardian);

    $email = trim($_POST['email']);
    $contact = trim($_POST['contact']);
    $aadhar = trim($_POST['aadhar']);
    $fieldsEmpty = $fieldsEmpty || empty($email) || empty($contact) || empty($aadhar);


    $dob = $_POST['dob'];
    $address = trim($_POST['address']);
    $fieldsEmpty = $fieldsEmpty || empty($dob) || empty($address);


    $city = trim($_POST['city']);
    $state = $_POST['state'];
    $pin = trim($_POST['pin']);
    $fieldsEmpty = $fieldsEmpty || empty($city) || empty($pin);

    if($fieldsEmpty){
        $err = "Please Fill ALL Details.";
    }
    
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $err .= "Invalid Email Address<br>"; 
    }
    if(strlen($aadhar)!=12){
        $err .= "Invalid Aadhar Number<br>";
    }
    if(empty($dob)){
        $err .= "Select Your Date of Birth<br>";
    }



    if(empty($err)){
        $accnum = $_SESSION['accnum'];

        $sql = "SELECT * FROM nrracc_primary WHERE email = '$email' AND NOT accnum = '$accnum'";
        $emailMatchs = mysqli_num_rows(mysqli_query($conn, $sql));
        
        $sql = "SELECT * FROM nrracc_sec WHERE aadhar = '$aadhar' AND NOT accnum = '$accnum'";
        $aadharMatchs = mysqli_num_rows(mysqli_query($conn, $sql));

        $sql = "SELECT * FROM nrracc_primary WHERE mobile = '$contact' AND NOT accnum = '$accnum'";
        $contactMatchs = mysqli_num_rows(mysqli_query($conn, $sql));
        

        if($emailMatchs > 0){
            $err = "This Email Address is Already Taken !"; 
        }
        else if($aadharMatchs > 0){
            $err = "This Aadhar Number is Already Registered !";
        }
        else if($contactMatchs > 0){
            $err = "This Mobile Number is Already Registered !";
        }
        else{
            $sql = "UPDATE nrracc_primary SET name = '$name', email = '$email', mobile = '$contact' WHERE accnum = '$accnum'";
            mysqli_query($conn,$sql);

            $sql = "UPDATE nrracc_sec SET guardian = '$guardian', aadhar = '$aadhar', dob = '$dob', address = '$address', city = '$city', stateinput = '$state', pin = '$pin'  WHERE accnum = '$accnum'";
            mysqli_query($conn,$sql);

            $_SESSION['name'] = $name;
            $_SESSION['accnum'] = $accnum;
            $_SESSION['email'] = $email;

            $_SESSION['verified'] = True;

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
    <title>Profile Updation: NRR Bank</title>
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

        .logreg {
            margin-right: 1em;
            background-color: mediumseagreen;
            color: white;
            border-radius: 5px;
            transition: 0.6s;
        }

        .logreg:hover {
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
            padding: 15px 20px;
            color: #FFFFFF;
            font-weight: 700;
            border: none;
            margin: 2% auto;
            letter-spacing: 1px;
        }
        label.form-control{
            border: none;
        }
        input.form-control{
            border-width: 1px 0 0 1px;
            border-style: solid;
            border-color: green;
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
    
    <div class="container register mt-2">
        <h1 class="title text-center">Update Account Details <i class="fas fa-user-edit"></i></h1>
        <h5 class="text-center text-muted">Get to Update all the irrelevant, unimportant or insecure Account Details here..</h5>
        
        <?php 
            if($err){
                echo '<div class="alert alert-danger text-center my-3">'.$err.'</div>';
            } 
            if($_SESSION['verified']){
                echo '<div class="alert alert-success text-center my-3" role="alert">Your Account '.$accnum.' is Successfully Updated !!<br>Check <a href="accSummary.php" class="alert-link">Account Summary</a> to see your Updated Details</div>';
            }
        ?>
        <!-- Form Registration -->
        <form class="my-5 
        <?php
            if($_SESSION['verified']){
                echo 'd-none';
            } 
        ?>
        " method="POST">

            <div class="form-row mb-2">
                <div class="form-group col-md-4">
                    <label for="inputPassword4">Account Number</label>
                    <label class="form-control" for="inputPassword4">
                        <?php echo $accnum; ?>
                    </label>
                </div>
                <div class="form-group col-md-4">
                    <label for="inputEmail4">Name</label>
                    <input type="text" class="form-control" name="name" value="<?php echo $resp['name']; ?>">
                </div>
                <div class="form-group col-md-4">
                    <label for="inputEmail4">Guardian Name</label>
                    <input type="text" class="form-control" name="guardian" value="<?php echo $ress['guardian']; ?>">
                </div>

            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="inputPassword4">Email Address</label>
                    <input type="email" class="form-control" name="email" value="<?php echo $_SESSION['email']; ?>">
                </div>
                <div class="form-group col-md-4">
                    <label for="inputPassword4">Mobile Number</label>
                    <input type="text" class="form-control" name="contact" value="<?php echo $resp['mobile']; ?>">
                </div>
                <div class="form-group col-md-4">
                    <label for="inputPassword4">Aadhar Number</label>
                    <input type="text" class="form-control" name="aadhar" value="<?php echo $ress['aadhar']; ?>">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="inputPassword4">Date Of Birth</label>
                    <input type="date" class="form-control" name="dob" value="<?php echo $ress['dob']; ?>">
                </div>
                <div class="form-group col-md-5">
                    <label for="inputPassword4">Address</label>
                    <input type="text" class="form-control" name="address" value="<?php echo $ress['address']; ?>">
                </div>
                <div class="form-group col-md-3 mx-auto">
                    <label for="inputPassword4">Gender</label>
                    <label for="inputPassword4" class="form-control">
                        <?php 
                            echo $ress['gender'];
                        ?>
                    </label>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="inputCity">City</label>
                    <input type="text" class="form-control" name="city"
                    value="<?php echo $ress['city']; ?>">
                </div>
                <div class="form-group col-md-4">
                    <label for="inputState">State</label>
                    <?php
                        echo getStates($ress['stateinput']);
                    ?>
                </div>
                <div class="form-group col-md-4">
                    <label for="inputZip">PinCode</label>
                    <input type="text" class="form-control" name="pin"
                    value="<?php echo $ress['pin']; ?>">
                </div>
            </div>

            <button type="submit" class="btn btn-send btn-block w-50">Update Now!</button>
        </form>

    </div>

    </div>

    <footer class="text-center text-lg-start bg-light pt-2 text-muted">

        <!-- Section: Links  -->
        <section class="">
            <div class="container text-center text-md-center mt-5">
                <!-- Grid row -->
                <div class="row mt-3">
                    <!-- Grid column -->
                    <div class="col-md-3 mx-auto mb-4">
                        <!-- Content -->
                        <h6 class="text-uppercase fw-bold mb-4">
                            <i class="fas fa-university"></i> NRR Bank Services
                        </h6>
                        <hr>
                        <p>
                            A Software Engineering Project built on the Topic:<br><b>Bank Management</b>
                        </p>
                    </div>
                    <!-- Grid column -->

                    <!-- Grid column -->
                    <div class="col-md-5 mx-auto mb-4 d-none d-lg-block">
                        <!-- Links -->
                        <h6 class="text-uppercase fw-bold mb-4">
                            Address
                        </h6>
                        <p class="mx-auto"><iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3684.1252655909!2d88.43158931391169!3d22.574417785181872!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3a0275bb4df8a60d%3A0x905231d91b918a3!2sInstitute%20of%20Engineering%20%26%20Management!5e0!3m2!1sen!2sin!4v1628497416009!5m2!1sen!2sin"
                                width="450" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                        </p>
                    </div>


                    <!-- Grid column -->
                    <div class="col-md-4 mx-auto mb-md-0 mb-4">
                        <!-- Links -->
                        <h6 class="text-uppercase fw-bold mb-4">
                            Contact
                        </h6>
                        <p><i class="fas fa-home me-3"></i> Institute of Engineering and Management</p>
                        <p>
                        <p><i class="fas fa-map-marked-alt"></i> College More, Kolkata-700040</p>
                        <i class="fas fa-envelope me-3"></i>
                        nrr.officials@gmail.com
                        </p>
                        <p><i class="fas fa-phone me-3"></i> +917294179372</p>
                    </div>
                    <!-- Grid column -->
                </div>
                <!-- Grid row -->
            </div>
        </section>
        <!-- Section: Links  -->

        <!-- Copyright -->
        <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.05);">
            © 2021
            <span class="themecol">NRR Bank: Let's Grow with Trust</span>
        </div>

    </footer>




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
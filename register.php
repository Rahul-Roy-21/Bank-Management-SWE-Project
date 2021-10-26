<?php

include 'connect.php';
$err = "";

function getStates(){
    $sel = '<select name="state" id="state" class="form-control">';
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
    $sel .= "<option value='".$states[0]."' selected>".$states[0]."</option>";
    for($i=1; $i<count($states); $i++){
        $sel .= "<option value='".$states[$i]."'>".$states[$i]."</option>";
    }
    $sel .='</select>';
    return $sel;
}

// When the { Register Now !!} is Clicked.
if($_SERVER['REQUEST_METHOD'] == "POST"){
    
    $fname = trim($_POST['firstname']);
    $lname = trim($_POST['lastname']);
    $guardian = trim($_POST['guardian']);
    $fieldsEmpty = empty($fname) || empty($lname) || empty($guardian);

    $email = trim($_POST['email']);
    $contact = trim($_POST['contact']);
    $aadhar = trim($_POST['aadhar']);
    $fieldsEmpty = $fieldsEmpty || empty($email) || empty($contact) || empty($aadhar);


    $dob = trim($_POST['dob']);
    $address = trim($_POST['address']);
    if(array_key_exists('gender', $_POST)){
        $gender = trim($_POST['gender']);
    }
    $fieldsEmpty = $fieldsEmpty || empty($dob) || empty($address);

    //echo "CC".$fieldsEmpty;

    $city = trim($_POST['city']);
    if(array_key_exists('state', $_POST)){
        $state = $_POST['state'];
    }
    $pin = trim($_POST['pin']);
    $fieldsEmpty = $fieldsEmpty || empty($city) || empty($pin);

    //echo "BB".$fieldsEmpty;

    $inibal = trim($_POST['inibal']);
    $pwd = trim($_POST['pwd']);
    $tpwd = trim($_POST['transpwd']);
    $fieldsEmpty = $fieldsEmpty || empty($inibal) || empty($pwd) || empty($tpwd);

    //echo "AA".$fieldsEmpty;

    //print_r($_POST);

    if($fieldsEmpty){
        $err = "Please Fill ALL Details.";
    }
    else{
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $err .= "Invalid Email Address<br>"; 
        }
        if(strlen($aadhar)!=12){
            $err .= "Invalid Aadhar Number<br>";
        }
        if(empty($dob)){
            $err .= "Select Your Date of Birth<br>";
        }
        if(!array_key_exists('gender', $_POST)){
            $err .= "Choose Your Gender<br>";
        }
        if(!array_key_exists('state', $_POST)){
            $err .= "Choose Your State<br>";
        }
        if(!is_numeric($inibal) || floatval($inibal) < 5000){
            $err .= "Minimum Rs. 5,000/- Required to Create Account<br>";
        }
        if(strlen($pwd)<5 || strlen($tpwd)<5){
            $err .= "Password Can't Be less than 5 characters.<br>";
        }
    
    }


    if(empty($err)){
        $sql = "SELECT * FROM nrracc_primary WHERE email = '$email'";
        $emailMatchs = mysqli_num_rows(mysqli_query($conn, $sql));
        
        $sql = "SELECT * FROM nrracc_sec WHERE aadhar = '$aadhar'";
        $aadharMatchs = mysqli_num_rows(mysqli_query($conn, $sql));

        if($emailMatchs > 0){
            $err = "This Email Address is Already Taken !"; 
        }
        else if($aadharMatchs > 0){
            $err = "This Aadhar Number is ALready Registered !";
        }
        else{
            $lastrowres = mysqli_query($conn, 'SELECT * from nrracc_primary ORDER BY id DESC LIMIT 1');
            if(mysqli_num_rows($lastrowres) == 0){
                $last_id = 0;
            }
            else{
                $last_id = mysqli_fetch_row($lastrowres)[0];
            }
            
            $accNum = "NRR".rand(100,999).str_pad(strval(intval($last_id)+1),4,"0",STR_PAD_LEFT);

            $token = bin2hex(random_bytes('4'));

            $user_id = $fname.str_pad(strval(intval($last_id)+1),4,"0",STR_PAD_LEFT)."@NRR";
            $date = date('Y-m-d');
            $name = $fname." ".$lname;

            //Password Encrypt
            $pwd = password_hash($pwd, PASSWORD_DEFAULT);
            $tpwd = password_hash($tpwd, PASSWORD_DEFAULT);

            // echo "Name: ".$name;
            // echo "<br>Accnum: ".$accNum;
            // echo "<br>UserId: ".$user_id;
            // echo "<br>Token: ".$token;
            // echo "<br>DOB:". $dob;
            // echo "<br>Gender: ".$gender;
            //echo "<br>uState: ".$state;
            // echo "<br>Today: ".$date;
            //echo $name.'<br>'.$accNum.'<br>'.$email.'<br>'.$contact.'<br>'.$user_id.'<br>'.$inibal.'<br>'.$pwd.'<br>'.$tpwd.'<br>'.$token;

            session_start();
            $_SESSION['accnum'] = $accNum;
            $_SESSION['name'] = $name;
            $_SESSION['email'] = $email;
            $_SESSION['token'] = $token;

            $_SESSION['reg'] = array('mobile'=>$contact, 'userid'=>$user_id, 'bal'=>$inibal, 'pwd'=>$pwd, 'tpwd'=>$tpwd, 'guardian'=>$guardian, 'aadhar'=>$aadhar, 'dob'=>$dob, 'addr'=>$address, 'gender'=>$gender, 'city'=>$city, 'state'=>$state, 'pin'=>$pin, 'accopen'=>$date);

            header("location: activateacc.php");

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
    <title>Register At NRR Bank</title>
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
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="#">Register</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="signin.php">Login<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contactus.php">Contact Us</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container register mt-2">
        <h1 class="title text-center">Create New Account <i class="fas fa-user-edit"></i></h1>
        <h5 class="text-center text-muted">Register Here to Get your Bank Account ID Card and Avail Our Services</h5>
        <?php
            if(!empty($err)){
                echo '<div class="alert alert-danger" role="alert">'.$err.'</div>';
            }
        ?>
        <!-- Form Registration -->
        <form class="my-5" method="POST">

            <div class="form-row mb-2">
                <div class="form-group col-md-4">
                    <label for="inputEmail4">FirstName</label>
                    <input type="text" class="form-control" name="firstname" id="firstname" placeholder="FirstName" onkeyup='saveValue(this);'>
                </div>
                <div class="form-group col-md-4">
                    <label for="inputPassword4">LastName</label>
                    <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Surname" onkeyup='saveValue(this);'>
                </div>
                <div class="form-group col-md-4">
                    <label for="inputEmail4">Guardian Name</label>
                    <input type="text" class="form-control" name="guardian" id="guardian" placeholder="Son/Daughter/Wife of .." onkeyup='saveValue(this);'>
                </div>

            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="inputPassword4">Email Address</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="Email eg. xyz@gmail.com" onkeyup='saveValue(this);'>
                </div>
                <div class="form-group col-md-4">
                    <label for="inputPassword4">Mobile Number</label>
                    <input type="text" id="contact" class="form-control" name="contact" onkeyup='saveValue(this);'>
                </div>
                <div class="form-group col-md-4">
                    <label for="inputPassword4">Aadhar Number</label>
                    <input type="text" id="aadhar" class="form-control" name="aadhar" onkeyup='saveValue(this);'>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="inputPassword4">Date Of Birth</label>
                    <input type="date" class="form-control" name="dob" id="dob" placeholder="Email eg. xyz@gmail.com" onkeyup='saveValue(this);'>
                </div>
                <div class="form-group col-md-5">
                    <label for="inputPassword4">Address</label>
                    <input type="text" class="form-control" name="address" id="address" placeholder="Street Name/Locality" onkeyup='saveValue(this);'>
                </div>
                <div class="form-group col-md-3 mx-auto">
                    <label>Gender</label>
                    <div class="row pl-3">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" value="Male">
                            <label class="form-check-label" for="inlineCheckbox1">Male</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" value="Female">
                            <label class="form-check-label" for="inlineCheckbox2">Female</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" value="Others">
                            <label class="form-check-label" for="inlineCheckbox3">Others</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="inputCity">City</label>
                    <input type="text" id="city" class="form-control" name="city" onkeyup='saveValue(this);'>
                </div>
                <div class="form-group col-md-4">
                    <label for="state">State</label>
                    <?php echo getStates(); ?>
                </div>
                <div class="form-group col-md-4">
                    <label for="inputZip">PinCode</label>
                    <input type="text" id="pin" class="form-control" name="pin" onkeyup='saveValue(this);'>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="inputPassword4">Initial Balance</label>
                    <input type="text" id="inibal" class="form-control" name="inibal" placeholder="Rs.." onkeyup='saveValue(this);'>
                </div>
                <div class="form-group col-md-4">
                    <label for="inputPassword4">Unique Password</label>
                    <input type="password" id="pwd" class="form-control" name="pwd" placeholder="min. 5 characters" onkeyup='saveValue(this);'>
                    <small id="passwordHelpBlock" class="form-text text-muted text-start ml-1">
                        Required for User Authentications
                      </small>
                </div>
                <div class="form-group col-md-4">
                    <label for="inputPassword4">Transaction Password</label>
                    <input type="password" id="tpwd" class="form-control" name="transpwd" placeholder="min. 5 characters" onkeyup='saveValue(this);'>
                    <small id="passwordHelpBlock" class="form-text text-muted text-start ml-1">
                        Required for Cross Account Transactions
                      </small>
                </div>
            </div>

            <button type="submit" name="submit" class="btn btn-send btn-block w-50">Register Now!</button>
        </form>

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
        crossorigin="anonymous">
    </script>
    <script type="text/javascript">
        
        const inputs = ["firstname", "lastname", "guardian", "email", "contact", "aadhar", "dob", "address", "city", "state", "pin", "inibal", "pwd", "tpwd"];

        for (let i = 0; i < inputs.length; i++) {
            document.getElementById(inputs[i]).value = getSavedValue(inputs[i]); 
        }

        function saveValue(e){
            var id = e.id; 
            var val = e.value;
            localStorage.setItem(id, val);
        } 
        function getSavedValue  (v){
            if (!localStorage.getItem(v)) {
                return "";
            }
            return localStorage.getItem(v);
        }
    </script>
</body>

</html>
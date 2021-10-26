<?php
session_start();

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

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    
    <link rel="icon" type="image/png" href="images/favicon.png" />
    <title>FAQs and Other Policies: NRR Bank</title>
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
        .fa-sign-out-alt{
            color: red;
            font-size: 1.1em;
        }
        ul {
            list-style: none;
            padding: 0;
        }
        li {
            padding-left: 1.3em;
        }
        .fq li:before {
            content: "\f0a9"; /* FontAwesome Unicode */
            font-family: FontAwesome;
            display: inline-block;
            margin-left: -1.3em;
            width: 1.3em;
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

    <div class="container signin my-4">
        <h1 class="title text-center">Bank Policies and FAQs <i class="fas fa-question-circle"></i></h1>
        <h6 class="text-center text-muted">Here are the most Frequently asked Questions from our clients..</h6>

        <hr>

        <ol type="1">
            <li class="fq my-3 ">
                <h5 class="font-weight-bold">What are the 5 best features we get from this online portal of NRR Bank?</h5>
                <p>This Online portal is a Bank Management Project that has tried to emulate the Basics behind a real-life Banking system. Amongst all the exclusive features/utilities we provide, the best ones are -
                <ul>
                    <li><b>Account Statements</b> can be generated/printed out in <b>.pdf</b> format.</li>
                    <li><b>Online Fund Transactions</b> secured by OTP verificaion and user authorization.</li>
                    <li><b>Loans</b> can be Issued Online by Manager's Approval.</li>
                    <li><b>User-Friendly UI</b> for Net-Banking</li>
                    <li>A <b>Direct Contact Setup</b> to connect the Manager to his Clients through Online Chats/Messaging.</li>
                </ul>
                </p>
            </li>
        </ol>
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
<?php
include '../connectonly.php';

session_start();
print_r($_SESSION);
print_r($_POST);

$sn_err = "";

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if(array_key_exists('sn',$_SESSION) && array_key_exists('sendMessageBtn',$_POST) && isset($_POST['sendMessageBtn'])){

        if(!array_key_exists('sendEmail',$_POST) && !array_key_exists('sendCNotice',$_POST)){
            $sn_err = "Method of Send Notice is Compulsory !!";
        }
        else {
            if(isset($_POST['sendEmail'])){
                include '../mailer.php';
                $res = sendMail($_SESSION['sn']['name'], $_POST['email'],'', $act = 'SENDNOTICE',"", $_POST['message']);

                if(!$res){
                    $sn_err = "Email Can't Be Sent !!!";
                }
            }
            
            if(isset($_POST['sendCNotice'])){
                $name = $_SESSION['sn']['name'];
                $email = $_POST['email'];
                $msg = $_POST['message'];
                $accnum = $_SESSION['sn']['accnum'];
                $repliedto = $_SESSION['sn']['replyto'];

                $sql = "INSERT INTO contacts (from_manager,accnum,name,email,msg,replyto) VALUES (1,'$accnum','$name','$email','$msg', '$repliedto')";
                mysqli_query($conn, $sql);

            }
        }
        if(empty($sn_err)){
            $_SESSION['sn']['issent'] = 1;
        }
    }
    else
    {
        $b = array_keys($_POST)[0];
    
        //If post-call is for Dismiss
        if($b[0] == 'd'){
            $id = intval(substr($b,1));
            $sql = "UPDATE contacts SET is_resolved = 1 WHERE id = '$id'";
            mysqli_query($conn, $sql);
        }
        //If post-call is for Send_Notice
        if($b[0] == 's'){
            $id = intval(substr($b,1));

            $sql = "SELECT accnum,name,email FROM contacts WHERE id = '$id'";
            $row = mysqli_fetch_assoc(mysqli_query($conn, $sql));

            $_SESSION['sn'] = array('accnum'=>$row['accnum'], 'name'=>$row['name'], 'email'=>$row['email'], 'replyto'=>$id, 'issent'=>0);
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
            if(array_key_exists('sn',$_SESSION) && $_SESSION['sn']['issent'] == 1){
                echo '<div class="alert alert-success text-center"><b>Message Sent Successfully to '.$_SESSION['sn']['name'].' <i class="fas fa-thumbs-up"></i></b></div>';
                unset($_SESSION['sn']);
            }
            if($sn_err){
                echo '<div class="alert alert-danger text-center"><b>'.$sn_err.' <i class="fas fa-exclamation-circle"></i></b></div>';
            }
        ?>

        <div class="card alert alert-info
        <?php
            if(!array_key_exists('sn', $_SESSION)){
                echo 'd-none'; 
            }
        ?>        
        ">
            <div class="card-body pb-0">
                <h2 class="card-title text-center">Send Notice</h2>
                <h6 class="card-subtitle text-center font-weight-bold">Reply Messages via. Email/Notices</h6>
                <hr class="border border-dark">

                <form method="POST">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Recipient Name</label>
                            <input type="text" class="form-control" placeholder="Recipient Info" name="name" value="<?php
                                echo $_SESSION['sn']['name'];
                                if($acn = $_SESSION['sn']['accnum']){
                                    echo " (".$acn.")";
                                }
                            ?>
                            ">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputPassword4">Recipient Email Address</label>
                            <input type="email" class="form-control" placeholder="Email Address" name="email" value="
                            <?php
                                echo $_SESSION['sn']['email'];
                            ?>
                            ">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Write your Message Here</label>
                        <textarea class="form-control" name="message" id="exampleFormControlTextarea1" rows="3" required></textarea>
                    </div>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" name="sendEmail" type="checkbox" id="inlineCheckbox2" 
                        <?php 
                            if(empty($_SESSION['sn']['accnum'])){
                                echo 'checked';
                            }
                        ?>
                        >
                        <label class="form-check-label" for="inlineCheckbox2">Send Email</label>
                    </div>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" name="sendCNotice" type="checkbox" id="inlineCheckbox3"
                        <?php 
                            if(empty($_SESSION['sn']['accnum'])){
                                echo 'disabled';
                            }
                            else{
                                echo 'checked';
                            }
                        ?>
                        >
                        <label class="form-check-label" for="inlineCheckbox3">Send Customer Notice</label>
                    </div>

                    <button type="submit" name="sendMessageBtn" class="btn btn-send btn-sm px-3">Send Message</button>
                </form>

            </div>
        </div>  

        <div class="statement card alert alert-warning p-3 my-4">
            <h3 class="text-center pt-3"></i> Notifications at Manager's Desk <i class="fas fa-bell"></i></h3>
            <hr class="border border-dark">

            <form method="post" style="overflow:auto;">
                <!-- Real Table Starts Here -->
                <?php
                    echo '<table class="table col-5">
                    <tr>
                        <th>Name</th>
                        <th>Email Address</th>
                        <th>Message for Manager</th>
                        <th>Actions</th>
                    </tr>';

                    $sql = "SELECT * FROM contacts WHERE from_manager = 0 AND is_resolved = 0";
                    $res = mysqli_query($conn, $sql);

                    //Get the Rows of Table - The Transactions Details
                    while($row = mysqli_fetch_assoc($res))
                    {
                        $name = $row['name'];

                        if($acn = $row['accnum']){
                            $name .= " (".$acn.") ";    
                        }
                        if($row['isseen'] == 0){
                            $name .= "<span class='badge badge-danger'>New</span>";
                        }
                        echo '<tr><td>'.$name.'</td>';
                        echo '<td>'.$row['email'].'</td>';
                        echo '<td>'.$row['msg'].'</td>';
                        
                        $buttons = '<div class="btn-group" role="group">';
                        $buttons .= '<button class="btn btn-success btn-sm mx-1" type="submit" name="s'.$row['id'].'">Send Notice</button>';
                        $buttons .= '<button class="btn btn-danger btn-sm mx-1" type="submit" name="d'.$row['id'].'">Dismiss</button></div>';
                        echo '<td>'.$buttons.'</td></tr>';
                    }

                    $sql = "UPDATE contacts SET isseen = 1 WHERE from_manager = 0 AND is_resolved = 0";
                    mysqli_query($conn, $sql);

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
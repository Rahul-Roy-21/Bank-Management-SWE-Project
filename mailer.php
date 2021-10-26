<?php

function sendMail($toName, $toemail, $otp, $act = 'ACTIVATEACC',$phone="", $msg="", $attach = array()){
    require 'PHPMailer_stable/PHPMailerAutoload.php';

    $mail = new PHPMailer;

    //$mail->SMTPDebug = 3;                               
    // Enable verbose debug output
    $mail->isSMTP();                                      
    // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';  
    // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               
    // Enable SMTP authentication
    $mail->Username = 'nrr.officials@gmail.com';                 
    // SMTP username
    $mail->Password = 'iemiansnrr@141818';                           
    // SMTP password
    $mail->SMTPSecure = 'tls';                            
    // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    
    // TCP port to connect to

    if($act == "CONTACTUS"){
        $mail->setFrom($toemail, $toName);

        $mail->addAddress('nrr.officials@gmail.com', 'NRR_Manager');     
        // Add a recipient
        //$mail->addAddress('c.18.rahulroy@gmail.com');

        $mail->addReplyTo($toemail, $toName);
    }
    else{
        $mail->setFrom('nrr.officials@gmail.com', 'NRR Bank');

        $mail->addAddress($toemail, $toName);     
        // Add a recipient
        //$mail->addAddress('c.18.rahulroy@gmail.com');

        $mail->addReplyTo('nrr.officials@gmail.com', 'NRR Bank');
    }
    

    for($i=0; $i< count($attach); $i++){
        $mail->addAttachment($attach[$i]);
    }
    
    // Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    
    // Optional name
    $mail->isHTML(true);                                  
    // Set email format to HTML

    if($act == 'ACTIVATEACC'){
        $mail->Subject = 'Activate Your NRR Bank Account';
        $mail->Body    = '
            <div><h3>Hi '.$toName.', welcome to NRR Banks, here is your Verification Code to get Your Registered Bank Account Details.</h3>
            <br>
            <h1 style="color:mediumseagreen; text-align: center font-weight:800; letter-spacing:2px;">'.$otp.'</h1><br>
            Let\'s Grow with Trust !!
        </div>';
    }
    if($act == 'FTVERIFY'){
        $mail->Subject = 'Fund Transfer Validation : NRR Bank Account';
        $mail->Body    = '
            <div><h3>Hi '.$toName.', here is the Code to Verify Yourself and Complete the Requested Fund Transaction</h3>
            <br>
            <h1 style="color:mediumseagreen; text-align: center; font-weight:800; letter-spacing:2px;">'.$otp.'</h1><br>
            Let\'s Grow with Trust !!
        </div>';
    }
    if($act == 'CPWDVERIFY'){
        $mail->Subject = 'Password Change Requested : NRR Bank Account';
        $mail->Body    = '
            <div><h3>Hi '.$toName.', here is the Code to Verify Yourself before we complete the Password Change Request.</h3>
            <br>
            <h1 style="color:mediumseagreen; text-align: center; font-weight:800; letter-spacing:2px;">'.$otp.'</h1><br>
            Let\'s Grow with Trust !!
        </div>';
    }
    if($act == 'CTPWDVERIFY'){
        $mail->Subject = 'Transaction Password Change Requested : NRR Bank Account';
        $mail->Body    = '
            <div><h3>Hi '.$toName.', here is the Code to Verify Yourself before we complete the Transaction Password Updation.</h3>
            <br>
            <h1 style="color:mediumseagreen; text-align: center; font-weight:800; letter-spacing:2px;">'.$otp.'</h1><br>
            Let\'s Grow with Trust !!
        </div>';
    }
    if($act == 'FORGETUSERID'){
        $mail->Subject = 'Login Request via. Forgot User ID : NRR Bank Account';
        $mail->Body    = '
            <div><h3>Hi '.$toName.', here is the Code to Verify Yourself before you can Login Again to your NRR Bank Account.</h3>
            <br>
            <h1 style="color:mediumseagreen; text-align: center; font-weight:800; letter-spacing:2px;">'.$otp.'</h1><br>
            Let\'s Grow with Trust !!
        </div>';
    }

    if($act == 'CONTACTUS'){
        $mail->Subject = 'Someone\'s Contacted NRR Bank Officials';
        $mail->Body    = '<div>
            <h1>Name :'.$toName.'</h1>
            <h3>Email Address:'.$toemail.'</h3><br>
            <h3>Phone Number:'.$phone.'</h3><br>
            <h3>Meesage: '.$msg.'</h3><br>
        </div>';
    }

    if($act == 'SENDNOTICE'){
        $mail->Subject = 'Reply to Your Query: NRR Bank';
        $mail->Body    = '<div>
            <h3>Hello, '.$toName.'</h3>
            <h3>'.$msg.'</h3>
        </div>';
    }

    if($act == 'CREATEDACC'){
        $mail->Subject = 'Account Verified and Registered Successfully !!: NRR Bank';
        $mail->Body    = '<div>
            <h3>Congratutions!! You are Now a Verified User of our Bank, here are your Login Details</h3>
            <h3>Account Number: '.$otp['accnum'].'</h3>
            <h3>Account Holder: '.$toName.'</h3>
            <h3>User ID.: '.$otp['userid'].'</h3>
            <h3>Login Password: Same as the Unique Password Entered during Registration</h3>
            <h4 style="color:mediumseagreen; text-align: center; letter-spacing:2px;">Let\'s Grow With Trust!!</h4>
        </div>';
    }
 
    $mail->AltBody = 'AltBody';

    $res = $mail->send();
    return $res;
}



?>
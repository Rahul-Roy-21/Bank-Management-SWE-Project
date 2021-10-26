<?php

include '../connectonly.php';

// $name = "Rahul Roy";
// $email = "royrahul0921@gmail.com";
// $pwd = password_hash('Rahul@2021', PASSWORD_DEFAULT);
// $userid = "Royrahul@NRROfficial";

// $sql = "INSERT INTO manager (managerid,name,email,pwd,userid) VALUES ('MNRR043001','$name','$email','$pwd','$userid')";

// mysqli_query($conn, $sql);
// if($e = mysqli_error($conn)){
//     echo $e;
// }
// else{
//     echo "SUCCESSful !!";
// }
include '../mailer.php';
$sent = sendMail('Rahul Dravid', 'royrahul0921@gmail.com', array('accnum'=>'1234567', 'userid'=>'userID'),'CREATEDACC');

// $sql = "SELECT * FROM nrracc_primary JOIN nrracc_sec WHERE nrracc_primary.accnum = nrracc_sec.accnum AND nrracc_primary.isapproved = 0";
// $res = mysqli_query($conn, $sql);

// while($row = mysqli_fetch_assoc($res)){
//     print_r($row);
//     echo '<hr>👍&#x1f44d';
// }
// $sql = "SELECT nrracc_primary.accnum,
//             nrracc_primary.name,
//             nrracc_primary.email,
//             nrracc_primary.userid,
//             nrracc_primary.mobile,
//             nrracc_sec.aadhar,
//             nrracc_sec.gender,
//             nrracc_primary.balance,
//             nrracc_sec.accopendate
//             FROM nrracc_primary
//             JOIN nrracc_sec
//             WHERE nrracc_primary.accnum = nrracc_sec.accnum AND nrracc_primary.accnum = 'NRR8250005' 
//             ORDER BY nrracc_sec.accopendate DESC";
// $res = mysqli_query($conn, $sql);

// if($e = mysqli_error($conn)){
//     echo $e;
// }

// while($row = mysqli_fetch_assoc($res)){
//     print_r($row);
//     echo '<hr><hr><br>';
// }

?>
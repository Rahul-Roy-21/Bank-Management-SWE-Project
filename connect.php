<?php

function get_Date($d = "L"){
    if ($d == "L"){
        return date("d-M-Y [h:i A ")."IST]";
    }
    return date_format(date_create($d),"d-M-Y [h:i A ")."IST]";
}

date_default_timezone_set('Asia/Kolkata');
$server = 'b3gvbkopy8lcujyg35aw-mysql.services.clever-cloud.com';
$user = 'uhlv5dnwu2kuptal';
$password = '1Fsg2hqs9QQ3AxEMGoPr';
$dbname = 'b3gvbkopy8lcujyg35aw';


$conn = mysqli_connect($server, $user, $password, $dbname);

if(!$conn){
    die("CONNECTION FAILURE !!<br>");
}


?>
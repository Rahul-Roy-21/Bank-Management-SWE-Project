<?php
include 'connectonly.php';
// $accnum = 'NRR2880003';
// $sql = "SELECT id,date,datetime,des FROM accstatements WHERE accnum = '$accnum' ORDER BY date DESC,datetime DESC";
// $res = mysqli_query($conn, $sql);

// while($row = mysqli_fetch_assoc($res)){
//     print_r($row);
//     echo '<hr><br>';
// }
// $data = "a96a1343.43";
// $a = explode("a",$data);
// print_r($a);





// include 'connectonly.php';

// $pwd = "Derek@2020";
// $hash = password_hash($pwd, PASSWORD_DEFAULT);
// $acc = "NRR2880003";

// $sql = "SELECT * FROM nrracc_primary WHERE accnum = '$acc'";
// $res = mysqli_query($conn, $sql);

// while($row = mysqli_fetch_assoc($res)){
//     print_r($row);
//     echo '<hr>'.$row['pwd'];
//     echo '<br>'.password_verify($pwd, $row['pwd']);
// }
// echo '<br>'.$hash;



// function ln(){
//     echo '<br>';
// }
// $i = '5a00.010';
// echo '<hr>'.(is_numeric($i)).'<hr>';
// $name = 'Virat Kolhi';
// $d = date('Y-m-d');
// //$sql = "INSERT INTO test (name, date) VALUES ('$name', '$d')";
// //mysqli_query($conn, $sql);
// ln();
 
// $e = 'Rahul';
// echo '<br>'.password_hash($e, PASSWORD_DEFAULT);
// echo '<br>'.password_hash($e, PASSWORD_DEFAULT);
// echo '<br>'.password_hash($e, PASSWORD_BCRYPT);
// echo '<br>'.password_hash($e, PASSWORD_BCRYPT);

// $a = password_hash($e, PASSWORD_DEFAULT);

// $b = password_verify($e, $a);

// echo '<br>'.$b."AA";

// $sql = "SELECT * FROM nrracc_sec";
// $res = mysqli_query($conn, $sql);
// print_r($res);
// print(mysqli_num_rows($res));

// while($row = mysqli_fetch_array($res)){
//     print_r($row);
//     echo '<hr>';
// }
// echo "<hr>";

// $token = bin2hex(random_bytes('3'));
// echo "NRR".$token;

// $accNum = "NRR".rand(100,999).str_pad(strval(1),4,"0",STR_PAD_LEFT);
// echo '<br>'.$accNum;
// echo "<hr>";


// if(isset($_POST['submit'])){
// echo "<hr><hr>ENTERED ".$_POST['gender'];
// }

// echo '<hr>';
// $name = "rahul";
// $accNum = "NRR123";
// $email ="er@gmail";
// $contact ="2353535" ;
// $user_id = "1224343";
// $inibal = "12000";
// $pwd ="rahu";
// $tpwd = "rahuk";
// $token = "3453465gt53";

// $sql = "INSERT INTO nrracc_primary (name, accnum, email, mobile, userid, balance, pwd, tpwd, token) VALUES('$name','$accNum','$email','$contact','$user_id','$inibal','$pwd','$tpwd','$token')";
// $res = mysqli_query($conn, $sql);

// echo $res.mysqli_error($conn);

// $date = date('Y-m-d');
// echo $date;

// $d = date_create("2021-11-23");
// echo date_format($d, "d-m-Y");
// // echo '<hr>';



// $d=strtotime("15-03-2021 00:08:13.0000");
// echo "Created date is " . date("d-m-Y h:i:sa", $d);


// $dt = 'DT';

// $d=strtotime($dt)+86400;
// echo "Created date is " . var_dump(date("d-m-Y",$d));


// $d=strtotime('01/01/2021 21:01:45');
// echo '<br>'.var_dump(date("d/m/Y h:i:s A", time()));
// $today = date("Y/m/d h:i A",time());
// echo $today;
// $s = "20/08/2021 09:19 PM";

// echo '<br>'.($today == $s);
// echo '<br>TODAY '.date("d/m/Y h:i:s A",strtotime($today)).'<hr><hr>';

// $s = "TO TRANSFER-NRR Pritha Kansari via. FUND TRANSFER";
// $arr = explode(" ",$s);
// echo $arr[2]." ".$arr[3];

// $searchval = "NRR8660001";
// $sql = "SELECT * FROM accstatements WHERE accnum = '$searchval' ";
// $sql .= "OR ref LIKE '%$searchval' ORDER BY amount DESC";
// $res = mysqli_query($conn, $sql);
// print_r($res);
// echo '<hr>';
// for($i=0; $i<mysqli_num_rows($res); $i=$i+1){
//     mysqli_data_seek($res, $i);
//     $row = mysqli_fetch_assoc($res);
//     print_r($row);
//     echo "<br><br>";
// }

// if($_SERVER['REQUEST_METHOD']=='POST'){
//     $d1 = $_POST['date1'];//'2019-07-14';
//     $d2 = $_POST['date2'];//'2019-07-16';
//     echo var_dump($d1).'<br>';
//     echo var_dump($d2).'<br>';

//     $sql = "UPDATE test SET a = a + 2 WHERE name = 'Virat'";
//     mysqli_query($conn, $sql);

//     echo mysqli_error($conn);

//     $sql = "SELECT * FROM test WHERE date BETWEEN '$d1' AND '$d2'";
//     $res = mysqli_query($conn, $sql);
//     print_r($res);
//     echo '<hr>';
//     while($row = mysqli_fetch_assoc($res)){
//         print_r($row);
//         echo '<br>';
//     }
//     if(mysqli_num_rows($res) == 0){
//         echo "NO RESULT !!";
//     }
//     echo '<hr>';
//     echo $dt[0];
//     echo '<hr>';

// }
?>
<?php
//   $msg = "";
  
//   // If upload button is clicked ...
//   if (isset($_POST['upload'])) {
  
//     $filename = $_FILES["uploadfile"]["name"];
//     $tempname = $_FILES["uploadfile"]["tmp_name"];    
//         $folder = "image/".$filename;
          
//     $db = mysqli_connect("localhost", "root", "", "photos");
  
//         // Get all the submitted data from the form
//         $sql = "INSERT INTO image (filename) VALUES ('$filename')";
  
//         // Execute query
//         mysqli_query($db, $sql);
          
//         // Now let's move the uploaded image into the folder: image
//         if (move_uploaded_file($tempname, $folder))  {
//             $msg = "Image uploaded successfully";
//         }else{
//             $msg = "Failed to upload image";
//       }
//   }
//   $result = mysqli_query($db, "SELECT * FROM image");
?>

<!-- <!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="crossorigin="anonymous">
    </script>
	<title>Image Upload</title>
	<link rel="stylesheet"
		type="text/css"
		href="style.css" />
</head>

<body>
    <button onclick="scrollParagraph1()">
        paragraph 1
    </button>
  
    <button onclick="scrollParagraph2()">
        paragraph 2
    </button>
	<div id="content">

		<!-- <form method="POST"
			enctype="multipart/form-data">
			<input type="file"
				name="uploadfile"
				value="" />

			<div>
				<button type="submit"
						name="upload">
				UPLOAD
				</button>
			</div>
		</form> -->
        <!-- <div id="p1">
        <h1>Fees</h1>
<p>You sometimes also have to pay fees on loans. The types of fees you might have to pay can vary depending on the lender. These are some common types of fees:
</p><p>
<p>Application fee: Pays for the process of approving a loan
Processing fee: Similar to an application fee, this covers costs associated with administering a loan.
Origination fee: The cost of securing a loan (most common for mortgages)</p>
<p>Annual fee: A yearly flat fee you must pay to the lender (most common for credit cards).</p>
<p>Late fee: What the lender charges you for late payments
Prepayment fee: The cost of paying a loan off early (most common for home and car loans).14﻿</p>
<p>Lenders rely on loans for interest income. When you pay your loan off early, they lose the amount of income for the number of years you will not be paying—the prepayment fee is designed to compensate them for not receiving all the interest income they would have if you hadn't paid it off.15﻿16﻿</p>

Not all loans c
        </div>
        
        <div id="p2">
        <h1>Fees 21</h1>
<p>You sometimes also have to pay fees on loans. The types of fees you might have to pay can vary depending on the lender. These are some common types of fees:
</p><p>
<p>Application fee: Pays for the process of approving a loan
Processing fee: Similar to an application fee, this covers costs associated with administering a loan.
Origination fee: The cost of securing a loan (most common for mortgages)</p>
<p>Annual fee: A yearly flat fee you must pay to the lender (most common for credit cards).</p>
<p>Late fee: What the lender charges you for late payments
Prepayment fee: The cost of paying a loan off early (most common for home and car loans).14﻿</p>
<p>Lenders rely on loans for interest income. When you pay your loan off early, they lose the amount of income for the number of years you will not be paying—the prepayment fee is designed to compensate them for not receiving all the interest income they would have if you hadn't paid it off.15﻿16﻿</p>
        </div>

	</div> -->
    <script>
        // var container = $('div');
  
        // // Scrolls to paragraph 1
        // function scrollParagraph1() {
        //     var scrollTo = $("#p1");
  
        //     // Calculating new position
        //     // of scrollbar
        //     var position = scrollTo.offset().top 
        //         - container.offset().top 
        //         + container.scrollTop();
  
        //     // Animating scrolling effect
        //     container.animate({
        //         scrollTop: position
        //     });
        // }
  
        // // Scrolls to paragraph 2
        // function scrollParagraph2() {
        //     var scrollTo = $("#p2");
  
        //     // Calculating new position 
        //     // of scrollbar
        //     var position = scrollTo.offset().top 
        //         - container.offset().top 
        //         + container.scrollTop();
  
        //     // Animating scrolling effect
        //     container.animate({
        //         scrollTop: position
        //     });
        // }
    </script>
    <!-- <?php //echo mysqli_num_rows($result);?> -->
<!--</body>

</html> -->




<!--
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="post">
        <input name="date1" type="date" value="2019-01-01"/>
        <input name="date2" type="date" value="2021-09-21"/>
        <select class="form-control col-8" class="form-control" name="sel">
            <option selected value="C">Choose...</option>
            <option>Rahul Roy(NRR09125623)</option>
            <option>Shehasish Monal(NRR04565623)</option>
            <option>Somnath Mondal(NRR09111156)</option>
            <option value="Cdfd">Rupesh Roy(NRR09125623)</option>
            <option>Ayan Sahi(NRR04545624)</option>
            <option>Rahul Roy(NRR09125623)</option>
            <option>Rahul Roy(NRR09125623)</option>
            <option>Rahul Roy(NRR09125623)</option>
        </select>
        <button type="submit" name="submit" class="btn btn-send btn-block w-50">Register Now!</button>
    </form>
    <a href=issuestatement.php?accno=NRR3380002&name=Rahul" role="button" target="_blank">Pdf</a>

    <select class="form-control col-8" class="form-control" name="selt">
            <option selected value="C">Choose...</option>
            <option value="C1">Rahul Roy(NRR09125623)</option>
            <option value="C2">Shehasish Monal(NRR04565623)</option>
            <option value="C3">Somnath Mondal(NRR09111156)</option>
            <option value="C4">Rupesh Roy(NRR09125623)</option>
        </select>
    
</script>
</body>
</html> --> -->

<!DOCTYPE html>
<html lang="en">
  
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content=
        "width=device-width, initial-scale=1.0">
  
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
      
    <title>
        How to scroll to specific 
        item using jQuery?
    </title>
  
    <style>
  
        button {
            margin: 10px;
        }
    </style>
</head>
  
<body>
    <div class="demo">
        <h1>Heading</h1>
        <p id="p1">
        <h1>Fees 1</h1>
<p>You sometimes also have to pay fees on loans. The types of fees you might have to pay can vary depending on the lender. These are some common types of fees:
</p><p>
<p>Application fee: Pays for the process of approving a loan
Processing fee: Similar to an application fee, this covers costs associated with administering a loan.
Origination fee: The cost of securing a loan (most common for mortgages)</p>
<p>Annual fee: A yearly flat fee you must pay to the lender (most common for credit cards).</p>
<p>Late fee: What the lender charges you for late payments
Prepayment fee: The cost of paying a loan off early (most common for home and car loans).14﻿</p>
<p>Lenders rely on loans for interest income. When you pay your loan off early, they lose the amount of income for the number of years you will not be paying—the prepayment fee is designed to compensate them for not receiving all the interest income they would have if you hadn't paid it off.15﻿16﻿</p>
        </p>
        <p id="p2">
        <h1>Fees 2</h1>
<p>You sometimes also have to pay fees on loans. The types of fees you might have to pay can vary depending on the lender. These are some common types of fees:
</p><p>
<p>Application fee: Pays for the process of approving a loan
Processing fee: Similar to an application fee, this covers costs associated with administering a loan.
Origination fee: The cost of securing a loan (most common for mortgages)</p>
<p>Annual fee: A yearly flat fee you must pay to the lender (most common for credit cards).</p>
<p>Late fee: What the lender charges you for late payments
Prepayment fee: The cost of paying a loan off early (most common for home and car loans).14﻿</p>
<p>Lenders rely on loans for interest income. When you pay your loan off early, they lose the amount of income for the number of years you will not be paying—the prepayment fee is designed to compensate them for not receiving all the interest income they would have if you hadn't paid it off.15﻿16﻿</p>
        </p>
    </div>
  
    <button onclick="scrollParagraph1()">
        paragraph 1
    </button>
  
    <button onclick="scrollParagraph2()">
        paragraph 2
    </button>
  
    <script>
        var container = $('div');
  
        // Scrolls to paragraph 1
        function scrollParagraph1() {
            var scrollTo = $("#p1");
  
            // Calculating new position
            // of scrollbar
            var position = scrollTo.offset().top 
                - container.offset().top 
                + container.scrollTop();
  
            // Animating scrolling effect
            container.animate({
                scrollTop: position
            });
        }
  
        // Scrolls to paragraph 2
        function scrollParagraph2() {
            var scrollTo = $("#p2");
  
            // Calculating new position 
            // of scrollbar
            var position = scrollTo.offset().top 
                - container.offset().top 
                + container.scrollTop();
  
            // Animating scrolling effect
            container.animate({
                scrollTop: position
            });
        }
    </script>
</body>
  
</html>
<?php

include 'fpdf/fpdf.php';
// We need accnum,from,to,curbal 

class myPDF extends FPDF {
    
    
    function header(){
        $this->Image('images/logo.png', 10,6,90,30);
        $this->SetFont('Courier','B',20);
        $this->Cell(276,25,'ACCOUNT STATEMENT',0,1,'C');
        $this->Ln(15);
    }
    function footer(){
        $this->SetY(-15);
        $this->SetFont('Courier','B',14);
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }
    function userDetails(){
        $this->SetFont('Courier','B',15);

        include 'connectonly.php';
        $accnum = $_GET['accno'];
        $from = $_GET['from'];
        $to = $_GET['to'];
        $startbal = $_GET['curbal'];
        $sql = "SELECT * FROM nrracc_primary WHERE accnum = '$accnum'";
        $res_p = mysqli_fetch_assoc(mysqli_query($conn, $sql));

        $sql = "SELECT * FROM nrracc_sec WHERE accnum = '$accnum'";
        $res_s = mysqli_fetch_assoc(mysqli_query($conn, $sql));

        $this->Cell(70,10,'Account Holder',0,0,'L');
        $this->Cell(120,10,': Mr. '.strtoupper($res_p['name']),0,1,'L');

        $this->Cell(70,10,'Address',0,0,'L');
        $this->Cell(120,10,': '.strtoupper($res_s['address']),0,1,'L');
        $this->Cell(70,10,'',0,0,'L');
        $this->Cell(120,10,'  '.strtoupper($res_s['city']).', '.strtoupper($res_s['stateinput']),0,1,'L');
        $this->Cell(70,10,'',0,0,'L');
        $this->Cell(120,10,'  PIN: '.strtoupper($res_s['pin']),0,1,'L');

        $this->Cell(70,10,'Date Of Issue',0,0,'L');
        $this->Cell(120,10,': '.date("d M Y"),0,1,'L');

        $this->Cell(70,10,'Account Number',0,0,'L');
        $this->Cell(120,10,': '.$accnum,0,1,'L');

        $this->Cell(70,10,'Account Description',0,0,'L');
        $this->Cell(120,10,': NRRCHQ-CSA-PUB-IND-CSDMD-INR',0,1,'L');

        $this->Cell(70,10,'Email Address',0,0,'L');
        $this->Cell(120,10,': '.$res_p['email'],0,1,'L');

        $this->Cell(70,10,'Mobile Number',0,0,'L');
        $this->Cell(120,10,': +91'.$res_p['mobile'],0,1,'L');

        $this->Cell(70,10,'Balance on '.date("d M Y", strtotime($from)),0,0,'L');
        $this->Cell(120,10,': '.number_format($startbal, 2), 0, 1, 'L');

        $this->Ln(10);
    }
    function headerTable(){
        $from = $_GET['from'];
        $to = $_GET['to'];
        $startbal = $_GET['curbal'];

        $this->SetFont('Courier','B',16);
        $this->Cell(180,15,'ACCOUNT STATEMENT from '.date("d M Y", strtotime($from)).' to '.date("d M Y", strtotime($to)),0,1,'L');

        $this->Cell(30,12,'DATE',1,0,'C');
        $this->Cell(56,12,'DESCRIPTION',1,0,'C');
        $this->Cell(35,12,'REF NO.',1,0,'C');
        $this->Cell(22,12,'DEBIT',1,0,'C');
        $this->Cell(22,12,'CREDIT',1,0,'C');
        $this->Cell(28,12,'BALANCE',1,1,'C');
    }

    function showstmts(){
        $this->SetFont('Courier','B',11);

        include 'connectonly.php';
        $accnum = $_GET['accno'];
        $from = $_GET['from'];
        $to = $_GET['to'];
        $startbal = $_GET['curbal'];
        $sql = "SELECT * FROM accstatements WHERE accnum = '$accnum' AND date BETWEEN '$from' AND '$to'";
        $res = mysqli_query($conn, $sql);

        while($row = mysqli_fetch_assoc($res)){
        
            $d = str_split($row['des'], 22);
            $r = str_split($row['ref'], 13);

            $mx = (count($d) > count($r)) ? count($d):count($r);

            for($i=0; $i<$mx; $i++){

                if($mx == 1){
                    $toprowborders = 1;
                }
                else{
                    $toprowborders = 'T,L,R';
                }

                if($i == 0){
                    $rowh = 12;
                }
                else{
                    $rowh = 8;
                }

                if($i == 0){
                    $this->Cell(30,$rowh,date("d/m/Y",strtotime($row['date'])),$toprowborders,0,'C');

                    if(count($d) > 0){
                        $this->Cell(56,$rowh,$d[$i],$toprowborders,0,'L');
                    }
                    else{
                        $this->Cell(56,$rowh,'',$toprowborders,0,'L');
                    }

                    if(count($r) > 0){
                        $this->Cell(35,$rowh,$r[$i],$toprowborders,0,'L');
                    }
                    else{
                        $this->Cell(35,$rowh,'',$toprowborders,0,'L');
                    }
                    
                    if($row['type'][0] == 'D'){
                        $this->Cell(22,$rowh,'',$toprowborders ,0,'C');
                        $this->Cell(22,$rowh,number_format($row['amount'],2),$toprowborders,0,'C');
                        $startbal = $startbal + floatval($row['amount']);
                    }
                    else{
                        $this->Cell(22,$rowh,number_format($row['amount'],2),$toprowborders,0,'C');
                        $this->Cell(22,$rowh,'',$toprowborders,0,'C');
                        $startbal = $startbal - floatval($row['amount']);
                    }
                    
                    $this->Cell(28,$rowh,number_format($startbal,2),$toprowborders,1,'C');

                }
                else if($i == count($d)-1){
                    $dval = '';
                    if($i == 1){
                        $dval = date("(d M Y)",strtotime($row['date']));
                    }
                    $this->Cell(30,$rowh,$dval,'B,L,R',0,'C');

                    if(count($d) == $mx){
                        $this->Cell(56,$rowh,$d[$i],'B,L,R',0,'L');
                    }
                    else{
                        $this->Cell(56,$rowh,'','B,L,R',0,'L');
                    }

                    if(count($r) == $mx){
                        $this->Cell(35,$rowh,$r[$i],'B,L,R',0,'L');
                    }
                    else{
                        $this->Cell(35,$rowh,'','B,L,R',0,'L');
                    }
                    
                    
                    $this->Cell(22,$rowh,'','B,L,R',0,'C');
                    $this->Cell(22,$rowh,'','B,L,R',0,'C');
                    
                    $this->Cell(28,$rowh,'','B,L,R',1,'C');

                }
                else{
                    $dval = '';
                    if($i==1){
                        $dval = date("(d M Y)",strtotime($row['date']));
                    }
                    $this->Cell(30,$rowh,$dval,'L,R',0,'C');

                    if(count($d) > $i){
                        $this->Cell(56,$rowh,$d[$i],'L,R',0,'L');
                    }
                    else{
                        $this->Cell(56,$rowh,'','L,R',0,'L');
                    }

                    if(count($r) > $i){
                        $this->Cell(35,$rowh,$r[$i],'L,R',0,'L');
                    }
                    else{
                        $this->Cell(35,$rowh,'','L,R',0,'L');
                    }
                    
                    $this->Cell(22,$rowh,'','L,R',0,'C');
                    $this->Cell(22,$rowh,'','L,R',0,'C');

                    $this->Cell(28,$rowh,'','L,R',1,'C');
    
                }
            }
        }
    }
}

$pdf = new myPDF();
$pdf->AliasNbPages();
$pdf->AddPage('P','A4',0);
$pdf->userDetails();
$pdf->headerTable();
$pdf->showstmts();
$pdf->Output();

?>
<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';
?>
<style>
#myImg {
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s;
}

#myImg:hover {opacity: 0.7;}

/* The Modal (background) */
.modal {
    display: none; /* Hidden by default */
     position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 30px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
}

/* Modal Content (image) */
.modal-content {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 700px;
}

/* Caption of Modal Image */
#caption {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 700px;
    text-align: center;
    color: #ccc;
    padding: 10px 0;
    height: 150px;
}

/* Add Animation */
.modal-content, #caption {    
    -webkit-animation-name: zoom;
    -webkit-animation-duration: 0.6s;
    animation-name: zoom;
    animation-duration: 0.6s;
}

@-webkit-keyframes zoom {
    from {-webkit-transform:scale(0)} 
    to {-webkit-transform:scale(1)}
}

@keyframes zoom {
    from {transform:scale(0)} 
    to {transform:scale(1)}
}

/* The Close Button */
.closemain {
    position: absolute;
    top: 15px;
    right: 35px;
    color: #f1f1f1;
    font-size: 40px;
    font-weight: bold;
    transition: 0.3s;
}

.closemain:hover,
.closemain:focus {
    color: #bbb;
    text-decoration: none;
    cursor: pointer;
}

/* 100% Image Width on Smaller Screens */
@media only screen and (max-width: 700px){
    .modal-content {
        width: 100%;
    }
}
</style>
<?php
session_start();
if(!$_SESSION['userid']){
header('LOCATION:http://223.130.4.100/jobcardapp/login.php');	
exit();
}
 include('header.php');

 ?>
 
     <script type="text/javascript" src="js/bootstrap.min.js"></script>	
 <? if($_REQUEST['sendmail']=='yes'){
	$currentDate = date('Y-m-d:h:i:s');
	$jobcard = $_REQUEST['jobcard'];
    $redirect = $_SERVER['HTTP_REFERER'];
    $emailmessage = $_REQUEST['message'];
    $shopemail = $_SESSION['settings']['email'];
    $shopname = $_SESSION['settings']['shop'];

	$stmt = $dbh->query("SELECT * FROM jobcard where id=$jobcard ");
	$jobcardrecords = $stmt->fetch(); 
	
	$custID=$jobcardrecords['customer'];
	$ID=$jobcardrecords['id'];
	$stmtcustomer = $dbh->query("SELECT * FROM customer where id=$custID");
	$customerrecords = $stmtcustomer->fetch(); 
    
	$stmtjobrec = $dbh->query("SELECT * FROM jobrecord where jobcardId=$jobcard");
    $jobcardrecordsemail = $stmtjobrec->fetch(); 
	$actual_link = "http://$_SERVER[HTTP_HOST]";
	
	// Set parameters
$apikey = 'ee36621e-8036-49e8-b456-0f5bb98d14f0';
$value = '<center></br><h3> Byx  Job card '.$jobcard.'</h3><table width="640" cellpadding="0" cellspacing="0" border="1" class="wrapper" bgcolor="#FFFFFF">
  

     
        <tr>
          <td width="300" class="mobile" align="left" valign="top">
           <b>BiCycle</b>
          </td>
        
          <td width="300" style="text-align: left;" class="mobile" align="center" valign="top">
           '.$jobcardrecords['bicycle'].'
          </td>
        </tr>
		
         <tr>
          <td width="300" class="mobile" align="left" valign="top">
           <b>Date Opened</b>
          </td>
        
          <td width="300" style="text-align: left;" class="mobile" align="center" valign="top">
            '.$jobcardrecords['dateOpened'].'
          </td>
        </tr>
		<tr>
          <td width="300" class="mobile" align="left" valign="top">
           <b>Date Received</b>
          </td>
        
          <td width="300" style="text-align: left;" class="mobile" align="center" valign="top">
             '.$jobcardrecords['dateReceived'].'
          </td>
        </tr>
		<tr>
          <td width="300" class="mobile" align="left" valign="top">
           <b>Date Expected</b>
          </td>
        
          <td width="300" style="text-align: left;" class="mobile" align="center" valign="top">
          '.$jobcardrecords['dateExpected'].'
          </td>
        </tr>
		<tr>
          <td width="300" class="mobile" align="left" valign="top">
           <b> Date Of Collection</b>
          </td>
        
          <td width="300" style="text-align: left;" class="mobile" align="center" valign="top">
            '.$jobcardrecords['dateCollection'].'
          </td>
        </tr><tr>
          <td width="300" class="mobile" align="left" valign="top">
           <b>Date Of Warranty End</b>
          </td>
        
          <td width="300" style="text-align: left;" class="mobile" align="center" valign="top">
          '.$jobcardrecords['dateOfWarrantyEnd'].'
          </td>
        </tr><tr>
          <td width="300" class="mobile" align="left" valign="top">
           <b>Received By</b>
          </td>
        
          <td width="300" style="text-align: left;" class="mobile" align="center" valign="top">
           '.$jobcardrecords['receivedBy'].'
          </td>
        </tr><tr>
          <td width="300" class="mobile" align="left" valign="top">
           <b>Service Performed By</b>
          </td>
        
          <td width="300" style="text-align: left;" class="mobile" align="center" valign="top">
              '.$jobcardrecords['servicePerformedBy'].'
          </td>
        </tr>
		<tr>
          <td width="300" class="mobile" align="left" valign="top">
           <b>Handover By</b>
          </td>
        
          <td width="300" style="text-align: left;" class="mobile" align="center" valign="top">
           '.$jobcardrecords['handoverBy'].'
          </td>
        </tr>
		<tr>
          <td width="300" class="mobile" align="left" valign="top">
           <b> Current Status</b>
          </td>
        
          <td width="300" style="text-align: left;" class="mobile" align="center" valign="top">
           '.$jobcardrecords['status'].'
          </td>
          </tr>';
		  $value.='<tr><td style="font-size: 23px;text-align: center;" colspan="2"><b>Customer Details</b></td></tr>';
		   $stmtjobrecs = $dbh->query("SELECT * FROM customer where id=$custID");
           $jobcardrecordsemails = $stmtjobrecs->fetchAll(); 
	
	       foreach($jobcardrecordsemails as $recordems){
		  $value.='<tr>
          <td width="300" class="mobile" align="left" valign="top">
           <b>Name</b>
          </td>
         <td width="300" style="text-align: left;" class="mobile" align="center" valign="top">
          '.$recordems['name'].'
          </td>
        </tr>
		
            <tr>
          <td width="300" class="mobile" align="left" valign="top">
           <b>Email</b>
          </td>
        
          <td width="300" style="text-align: left;" class="mobile" align="center" valign="top">
           '.$recordems['email'].'
          </td>
        </tr>
		 <tr>
          <td width="300" class="mobile" align="left" valign="top">
           <b>Contact Number</b>
          </td>
        
          <td width="300" style="text-align: left;" class="mobile" align="center" valign="top">
           '.$recordems['contactno'].'
          </td>
        </tr>'; }
		$value.='<tr><td style="font-size: 23px;text-align: center;" colspan="2"><b>Finding when received</b></td></tr>';
		   $stmtjobrec = $dbh->query("SELECT * FROM jobrecord where jobcardId=$jobcard and findby='customer'");
           $jobcardrecordsemail = $stmtjobrec->fetchAll(); 
		$tot=0;
	       foreach($jobcardrecordsemail as $recordem){ $tot=$tot+$recordem['price'];
		$value.='<tr>
          <td width="300" class="mobile" align="left" valign="top">
           <b>Title</b>
          </td>
         <td width="300" style="text-align: left;" class="mobile" align="center" valign="top">
          '.$recordem['title'].'
          </td>
        </tr>
		
            <tr>
          <td width="300" class="mobile" align="left" valign="top">
           <b>Price</b>
          </td>
        
          <td width="300" style="text-align: left;" class="mobile" align="center" valign="top">
           '.$recordem['price'].'
          </td>
        </tr>'; }
		
		$value.='<tr><td style="font-size: 23px;text-align: center;" colspan="2"><b>Mechanic Findings (in addition):</b></td></tr>';
		   $stmtjobrec = $dbh->query("SELECT * FROM jobrecord where jobcardId=$jobcard and findby='mechanic'");
           $jobcardrecordsemail = $stmtjobrec->fetchAll(); 
		$tot1=0;
	       foreach($jobcardrecordsemail as $recordem){  $tot1=$tot1+$recordem['price'];
		  $value.='<tr>
          <td width="300" class="mobile" align="left" valign="top">
           <b>Title</b>
          </td>
         <td width="300" style="text-align: left;" class="mobile" align="center" valign="top">
          '.$recordem['title'].'
          </td>
        </tr>
		
            <tr>
          <td width="300" class="mobile" align="left" valign="top">
           <b>Price</b>
          </td>
        
          <td width="300" style="text-align: left;" class="mobile" align="center" valign="top">
           '.$recordem['price'].'
          </td>
        </tr>
		'; }
		$value.='<tr>
          <td width="300" class="mobile" align="left" valign="top">
           <b>Price Approved By Customer (Mechanic name and date):</b>
          </td>
         <td width="300" style="text-align: left;" class="mobile" align="center" valign="top">
          '.$jobcardrecords['priceapprovedby'].'
          </td>
        </tr>
		
		<tr>
          <td width="300" class="mobile" align="left" valign="top">
           <b>Total Price of Customer Findings:</b>
          </td>
         <td width="300" style="text-align: left;" class="mobile" align="center" valign="top">
          '.$tot.'
          </td>
        </tr>
		<tr>
          <td width="300" class="mobile" align="left" valign="top">
           <b>Total Price of Mechanic Findings (in addition to customer findings):</b>
          </td>
         <td width="300" style="text-align: left;" class="mobile" align="center" valign="top">
          '.$tot1.'
          </td>
        </tr>
		';
	 $stmtjobrec = $dbh->query("SELECT * FROM jobcard_image where jobcardId=$jobcard");
           $jobcardrecordsemail = $stmtjobrec->fetchAll(); 
		$tot1=0;
	       foreach($jobcardrecordsemail as $recordem){  $tot1=$tot1+$recordem['price'];
		  $value.='<tr>
          <td width="300" class="mobile" align="left" valign="top">
           <b>Image</b>
          </td>
         <td width="300" style="text-align: left;" class="mobile" align="center" valign="top">
          <img style="height: 119px;" src="'.$actual_link.'/jobcardapp/uploads/'.$recordem['image'].'">
          </td>
        </tr>';
		   }
        
          
   
$value.='</table></center>';  
// can aso be a url, starting with http..

// Convert the HTML string to a PDF using those parameters.  Note if you have a very long HTML string use POST rather than get.  See example #5
$result = file_get_contents("http://api.html2pdfrocket.com/pdf?apikey=" . urlencode($apikey) . "&value=" . urlencode($value));
 
// Save to root folder in website
$dpfname='pdf'.time().$ID.'.pdf';
file_put_contents('uploads/'.$dpfname, $result);
$mjobid=$jobcard;
$custIDDec=$custID;
$file='/var/www/html/jobcardapp/uploads/'.$dpfname;
//$mailto = $order_info['email'];
  $customername=$customerrecords['name'];
		   $mailto = $customerrecords['email'];
			$subject = "job card app ";
			$message = "<table><tr><td>Dear $customername</td></tr>
	                    <tr><td></td></tr>   		
	                    <tr><td></td></tr>   		
	                    <tr><td></td></tr>   		
	                    <tr><td>$emailmessage</td></tr>
						<tr><td></td></tr>   		
	                    <tr><td></td></tr>Take Survey<a href='http://223.130.4.100/jobcardapp/survey.php?jobID=$mjobid&customerId=$custIDDec'>http://223.130.4.100/jobcardapp/survey.php?jobID=$mjobid&customerId=$custIDDec</a></td></tr>"; 
						

						
			$mail = new PHPMailer(true);  
			$mail->CharSet = 'UTF-8';
			// Passing `true` enables exceptions
try {
    //Server settings
    $mail->SMTPDebug = 0;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'brainpulse.dev@gmail.com';                 // SMTP username
    $mail->Password = 'carbon!@';                           // SMTP password
    $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 465;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom($shopemail, $shopname);
    $mail->addAddress($mailto, $customername); 
    //$mail->addAddress($shopemail, $shopname);    // Add a recipient
    //$mail->addAddress('jobcard@byx.com.sg', 'Job Card');
//.','.$_SESSION['email'].',jobcard@byx.com.sg'
    //Attachments
  $pname="Byx  Job Card $jobcard";
    $mail->addAttachment($file, $pname);  
    $mail->isHTML(true);                                  
    $mail->Subject = $subject;
    $mail->Body    = $message;
    

    $mail->send();
   $updatejobcard = $dbh->query("update jobcard  set lastemail ='$currentDate' ,sendmail =1  where id=$jobcard");
   $sms="Mail sent successfuly";
    	
	} catch (Exception $e) {
		$sms= 'Message could not be sent. Mailer Error: '. $mail->ErrorInfo;
	}			
						
						
			/* $content = file_get_contents($file);
			$content = chunk_split(base64_encode($content));

			// a random hash will be necessary to send mixed content
			$separator = md5(time());

			// carriage return type (RFC)
			$eol = "\r\n";
		
			$from = $shopemail; 
			$from_name = $shopname;
			// main header (multipart mandatory)
			$headers = "From: $from_name <$from>" . $eol;
			$headers .= "MIME-Version: 1.0" . $eol;
			$headers .= "Content-Type: multipart/mixed; boundary=\"" . $separator . "\"" . $eol;
			$headers .= "Content-Transfer-Encoding: 7bit" . $eol;
			$headers .= "This is a MIME encoded message." . $eol;

			// message
			$body = "--" . $separator . $eol;
			$body .= "Content-Type: text/html; charset=\"iso-8859-1\"" . $eol;
			$body .= "Content-Transfer-Encoding: 8bit" . $eol;
			$body .= $message . $eol;

			// attachment
			$body .= "--" . $separator . $eol;
			$body .= "Content-Type: application/octet-stream; name=\"" . $dpfname . "\"" . $eol;
			$body .= "Content-Transfer-Encoding: base64" . $eol;
			$body .= "Content-Disposition: attachment" . $eol;
			$body .= $content . $eol;
			$body .= "--" . $separator . "--";

			//SEND Mail
			if(mail($mailto, $subject, $body, $headers)){
			
				$updatejobcard = $dbh->query("update jobcard  set lastemail ='$currentDate' ,sendmail =1  where id=$jobcard");
				$sms="Mail sent successfuly";
				
			}  */
			
 }
 ?>
 <main class="pt-5 mx-lg-5">
        <div class="container-fluid mt-5">
 <!--Grid row-->
            <div class="row wow fadeIn" style="visibility: visible; animation-name: fadeIn;">

                <!--Grid column-->
                <div class="col-md-12 mb-4">
				<a href="javascript: window.history.go(-1)" class="btn btn-primary btn-sm waves-effect waves-light">Back</a>			
<h4 style="color: #04a504;text-align: center;"><?=$sms?></h4>
                    <!--Card-->
                    <div class="card">

                        <!--Card content-->
                        <div class="card-body">
						
						<?php
								$jobcardID = $_GET['jobcard'];
								$stmt = $dbh->query("SELECT * FROM jobcard where id=$jobcardID");
								$jobcard = $stmt->fetch(); 
								$jcust=$jobcard['customer'];
								$stmtc = $dbh->query("SELECT * FROM customer where id='$jcust'");
								$jobcardc = $stmtc->fetch(); 
							
								if(!empty($jobcard)):
								?>
								<div class="row" style="background: #f9e4e4;text-align: center;padding-bottom: 13px;padding-top: 13px;font-size:23px;">
						<div class="col-md-12">
						<span>JOB NUMBER:-</span>
						<?php echo $jobcard['id'];?>
						</div>
					
						
						
						</div>	
						<div class="row">
						<div class="col-md-3">
						<span>BiCycle</span><br />
						<?php echo $jobcard['bicycle'];?>
						</div>
						<div class="col-md-3">
						<span>Date Opened</span><br />
						<?php echo $jobcard['dateOpened'];?>
						</div>
						<div class="col-md-3">
						<span>Date Received</span><br />
						<?php echo $jobcard['dateReceived'];?>
						</div>
						<div class="col-md-3">
						<span>Date Expected</span><br />
						<?php echo $jobcard['dateExpected'];?>
						</div>
						</div>
<hr />						
						<div class="row">
						<div class="col-md-3">
						<span>Date Of Collection</span><br />
						<?php echo $jobcard['dateCollection'] ? $jobcard['dateCollection']:'NL';?>
						</div>
						<div class="col-md-3">
						<span>Date Of Warrenty End</span><br />
						<?php echo $jobcard['dateOfWarrantyEnd'] ? $jobcard['dateOfWarrantyEnd']:'NL';?>
						</div>
						<div class="col-md-3">
						<span>Received By</span><br />
						<?php echo $jobcard['receivedBy'] ? $jobcard['receivedBy']:'NL' ;?>
						</div>
						<div class="col-md-3">
						<span>Service Performed By</span><br />
						<?php echo $jobcard['servicePerformedBy'] ? $jobcard['servicePerformedBy']:'NL' ;?>
						</div>
						</div>
						<hr />
						<div class="row">
						<div class="col-md-3">
						<span>HandOver By</span><br />
						<?php echo $jobcard['handoverBy'];?>
						</div>
						<div class="col-md-3">
						<span>Current Status</span><br />
						<?php echo $jobcard['status'];?>
						</div>
						<div class="col-md-3">
						<?php //echo $jobcard['receivedBy'];?>
						</div>
						<div class="col-md-3">
						<?php //echo $jobcard['servicePerformedBy'];?>
						</div>
						</div>	
						<hr />
							<div class="row">
						<div class="col-md-3">
						<span>Customer Name</span><br />
						<?php echo $jobcardc['name'];?>
						</div>
						<div class="col-md-3">
						<span>Customer Email</span><br />
						<?php echo $jobcardc['email'];?>
						</div>
						<div class="col-md-3">
						<span>Customer Phone</span><br />
						<?php echo $jobcardc['contactno'];?>
						</div>
							<div class="col-md-3">
						<span>Date Created</span><br />
						<?php echo $jobcardc['dateCreated'];?>
						</div>
						</div>	
						<hr />
						<div class="row">
						<div class="col-md-3">
						<span>Service Type</span><br />
						<?php echo $jobcard['serviceType'];?>
						</div>
						<div class="col-md-3">
						<span>Comments</span><br />
						<?php echo $jobcard['comments'];?>
						</div>
						</div>	
<hr />
<div class="row">
						<div class="col-md-3">
						<span>Title</span><br />
						<?php echo $record['title']; ?>
						</div>
						<div class="col-md-3">
						<span>Price</span><br />
						<?php echo $record['price']; ?>
						</div>
						<div class="col-md-3">
						<span>Find By</span><br />
						<?php echo $record['findby']; ?>
						</div>
						<div class="col-md-3">
					
						
						</div>
						</div>
							<?php
							//echo "SELECT * FROM jobrecord where jobcardId=$jobcard";
							$cusprice=0;
							$mechprice=0;
							$lopinter=0;
								$stmt = $dbh->query("SELECT * FROM jobrecord where jobcardId=$jobcardID");
								$jobcardrecords = $stmt->fetchAll(); 
								if(!empty($jobcardrecords)): foreach($jobcardrecords as $record){
									if($record['findby']=='customer'){
										$cusprice=$cusprice+$record['price'];
										
									}else {
										$mechprice=$mechprice+$record['price'];
									}
								?>
						<div class="row">
						<div class="col-md-3">
						<br />
						<?php echo $record['title']; ?>
						</div>
						<div class="col-md-3">
					<br />
						<?php echo $record['price']; ?>
						</div>
						<div class="col-md-3">
						<br />
						<?php echo $record['findby']; ?>
						</div>
					
						</div>
						
						
					
						
						
						
					
								<?php $lopinter++;} endif; ?>	
	<hr />
<p><b>Price Approved By Customer (Mechanic name and date):&nbsp;&nbsp;&nbsp;&nbsp;</b><?=$jobcard['priceapprovedby']?></p>
<p><b>Total Price of Customer Findings:&nbsp;&nbsp;&nbsp;&nbsp;</b> <?=$cusprice?></p>
<p><b>Total Price of Mechanic Findings (in addition to customer findings): &nbsp;&nbsp;&nbsp;&nbsp;</b><?=$mechprice?></p>
					<hr />
<div class="row">
						<div class="col-md-3">
						<span>Images</span><br />
						
						</div>
						<? $stmt = $dbh->query("SELECT * FROM jobcard_image where jobcardID=$jobcardID");
						    $jobcardsimages = $stmt->fetchAll();  $im=0;
							foreach($jobcardsimages as $jobcardimg){?>
						<div class="col-md-1">
						<img style="height: 88px;" id="myImg<?=$im?>" src="uploads/<?=$jobcardimg['image']?>">
						</div>
					<div id="myModal<?=$im?>" class="modal">
  <span class="closemain close<?=$im?>">&times;</span>
  <img class="modal-content" id="img01<?=$im?>">
  <div id="caption<?=$im?>"></div>
</div>
<script>
// Get the modal
var modal = document.getElementById('myModal'+<?=$im?>);

// Get the image and insert it inside the modal - use its "alt" text as a caption
var img = document.getElementById('myImg'+<?=$im?>);
var modalImg = document.getElementById("img01"+<?=$im?>);
var captionText = document.getElementById("caption"+<?=$im?>);
img.onclick = function(){
    modal.style.display = "block";
    modalImg.src = this.src;
    captionText.innerHTML = this.alt;
}

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close"+<?=$im?>)[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() { 
    modal.style.display = "none";
}
</script>	
						
						
						
						<? $im++;}?>
						</div>	
						<!-- The Modal -->

						<hr />
						
<?php if($jobcard['status']==='Open'): ?>
<a href="javascript:closedjobfn();" class="btn btn-primary btn-sm waves-effect waves-light">Close Job</a>	
<?php endif;?>
<a href="javascript:sendmail();" class="btn btn-primary btn-sm waves-effect waves-light">Send Mail To Customer</a>	
<a href="surveyresponse.php?jobcarid=<?=$_REQUEST['jobcard']?>" class="btn btn-primary btn-sm waves-effect waves-light">Survey Details</a>	
<?php endif ;?>	
<div style="display:none" id="hello" title="SEND MAIL TO CUSTOMER">
<form action="jobcarddetails.php?jobcard=<?=$_REQUEST['jobcard']?>" method="post">
<input type="hidden" name="sendmail" value="yes">
<textarea rows="10" cols="10" name="message" placeholder="Message" required style="margin-top: 0px;
    margin-bottom: 0px;
    height: 154px;
    width: 266px;"> </textarea>
<input type="submit" value="Send Mail">
</form>
</div>	

<div style="display:none" id="closedjob" title="CLOSED JOB">
<form action="jobactions.php?jobcard=<?php echo $jobcard['id']; ?>&action=close" method="post">
<div class="row form-group">
<div class="col-md-30">
<label for="dateexpected" class="pr-1 ">Date Of Collection</label>
<input placeholder="Date Of Collection" required id="dateCollection" name="dateCollection" type="date" class="form-control">
</div>
</div>
<div class="row form-group">
<div class="col-md-30">
<label for="dateexpected" class="pr-1 ">Date Of Warrenty End</label>
<input placeholder="Date Of Warrenty End" required id="dateOfWarrantyEnd" name="dateOfWarrantyEnd" type="date" class="form-control">
</div>
</div>
<div class="row form-group">
<div class="col-md-30">
<label for="dateexpected" class="pr-1 ">Service Performed By</label>
<input placeholder="Service Performed By" required id="servicePerformedBy" name="servicePerformedBy" type="text" class="form-control">
</div>
</div>
<div class="row form-group">
<div class="col-md-30">
<label for="dateexpected" class="pr-1 ">HandOver By</label>
<input placeholder="HandOver By" required id="handoverBy" name="handoverBy" type="text" class="form-control">
</div>
</div>
<? if($jobcard['priceapprovedby']==NULL) {?>
<div class="row form-group">
<div class="col-md-30">
<label for="dateexpected" class="pr-1 ">Price approved by customer (Mechanic name and date)</label>
<input placeholder="Price Approved By" required id="priceapprovedby" name="priceapprovedby" type="text" class="form-control">
</div>
</div>
<?}?>
<input type="submit" class="btn btn-primary btn-sm waves-effect waves-light" value="Close Job">
</form>
</div>



				
						
						</div>
						</div>
						</div>
						</div>
						</div>
						</main>
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script>
function sendmail()
{
	$( "#hello" ).dialog({ autoOpen: true });
}
function closedjobfn()
{
	$( "#closedjob" ).dialog({ autoOpen: true });
}
</script>						
	
	
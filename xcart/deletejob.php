<?php 
error_reporting(E_ALL);
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';
include('header.php'); 
    $jobcard=$_REQUEST['jobcarid']; 
	$currentDate = date('Y-m-d:h:i:s');
	$jobcardId=$jobcard;
    $redirect = $_SERVER['HTTP_REFERER'];
  
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
			$subject = "Workshop job opened/edited for you bike at Byx";
			$message = "<table><tr><td>Dear $customername</td></tr>
	                    <tr><td></td></tr>   		
	                    <tr><td>We thank you for servicing your bike in our workshop. Your Byx workshop job #$mjobid is open and its details are attached to this emai; </br></td></tr><tr><td></td></tr>	
						<tr><td> We seek your consent to carry out the work as documented in the job card based on our mechanic’s observation and recommendations. They may vary from what was suggested or quoted when you submitted the bike and based on our careful examination.</td></tr> <tr><td></td></tr>	
	                    <tr><td>Please give your consent by replying to this email.</td></tr>   		
	                    <tr><td>In case you do not accept the quote, or have any questions you may state so in your response or call our workshop at 6235 5221.</td></tr>  	<tr><td></td></tr><tr><td></td></tr>
	                    <tr><td>You may find the full list of our service types and costs in the following link: <a href='www.byx.com.sg/service-fulltable/'>www.byx.com.sg/service-fulltable/</a></td></tr>
<tr><td></td></tr>						
<tr><td></td></tr>	<tr><td></td></tr><tr><td></td></tr>					
<tr><td>With thanks,</td></tr>						
<tr><td>Byx Workshop Team </td></tr><tr><td>www.byx.com.sg </td></tr><tr><td>403 River Valley</td></tr><tr><td> Tel +65 6235 5221</td></tr></table>"; 
						

				
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
						
	echo 1;	
	
die;

?>

	



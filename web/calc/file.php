<?php
require 'PHPMailer-master/PHPMailerAutoload.php';
ob_start();
			if(isset($_POST['email']))
			{
				// the message
				$msg = "Firm Name - ".$_POST['firm_name']."\nNumber of Lawyers - ".$_POST['lawyers_num']."\nNumber of Partners - ".$_POST['partners_num']."\nNumber of Surveys - ".$_POST['surveys_num']."\nAmLaw Ranking - ".$_POST['ranking_num']."\nAvg Partner Billing Rate - ".$_POST['billing_rate']."\nPrice Per Partner Per Year YEAR 1- $".$_POST['year_1_price']."\n".$_POST['year_1_mins']." - MINUTES OF A BILLABLE HOUR PER YEAR\nPrice Per Partner Per Year YEAR 1- $".$_POST['year_2_price']."\n".$_POST['year_2_mins']." - MINUTES OF A BILLABLE HOUR PER YEAR\nYEAR 1 - LICENSE - $".$_POST['year_1_license']."\nYEAR 2 - SUBSCRIPTION - $".$_POST['year_2_subscription']."/mo\n";

				$date = date("dmY-Gi");
				
				$filename = "details-".$date.'.txt';
+				!$handle = fopen($filename, 'w');
+				fwrite($handle, $msg);
+				fclose($handle);
+				// multiple recipients
+				//$to  = 'george@lextrack.com'; // note the comma
+				$to  = 'aperyan.evgine@gmail.com'; // note the comma
+
+				// subject
+				$subject = 'Calculated details';
+
+				// message
+				$message = '
+				<html>
+				<head>
+				  <title>Birthday Reminders for August</title>
+				</head>
+				<body>
+				  <h1>hello22</h1>
+				</body>
+				</html>
+				';
+
+				// To send HTML mail, the Content-type header must be set
+				$headers  = 'MIME-Version: 1.0' . "\r\n";
+				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
+
+				// Additional headers
+				$headers .= 'To: Mary <mary@example.com>, Kelly <kelly@example.com>' . "\r\n";
+				$headers .= 'From: Birthday Reminder <birthday@example.com>' . "\r\n";
+				$headers .= 'Cc: birthdayarchive@example.com' . "\r\n";
+				$headers .= 'Bcc: birthdaycheck@example.com' . "\r\n";
+				// Mail it
+				var_dump(mail($to, $subject, $message, $headers));

			}
?>	
<?php 
			ob_start();
			if(isset($_POST['firm_name']))
			{
				// the message
				$msg = "Firm Name - ".$_POST['firm_name']."\nNumber of Lawyers - ".$_POST['lawyers_num']."\nNumber of Partners - ".$_POST['partners_num']."\nNumber of Surveys - ".$_POST['surveys_num']."\nAmLaw Ranking - ".$_POST['ranking_num']."\nAvg Partner Billing Rate - ".$_POST['billing_rate']."\nPrice Per Partner Per Year YEAR 1- $".$_POST['year_1_price']."\n".$_POST['year_1_mins']." - MINUTES OF A BILLABLE HOUR PER YEAR\nPrice Per Partner Per Year YEAR 1- $".$_POST['year_2_price']."\n".$_POST['year_2_mins']." - MINUTES OF A BILLABLE HOUR PER YEAR\nYEAR 1 - LICENSE - $".$_POST['year_1_license']."\nYEAR 2 - SUBSCRIPTION - $".$_POST['year_2_subscription']."/mo\n";

				$date = date("dmY-Gi");
				
				$filename = "details-".$date.'.txt';
				$handle = fopen('calculate_details/'.$filename, 'w');
				fwrite($handle, $msg);
				fclose($handle);
				// multiple recipients
				//$to  = 'george@lextrack.com, marsha@lextrack.com'; // note the comma
				$to  = 'aperyan.evgine@gmail.com, aram.webtech@gmail.com'; // note the comma

				// subject
				$subject = $_POST['firm_name'].' - Calculated details';

				// message
				$message = "Firm Name - ".$_POST['firm_name']."<br>Number of Lawyers - ".$_POST['lawyers_num']."<br>Number of Partners - ".$_POST['partners_num']."<br>Number of Surveys - ".$_POST['surveys_num']."<br>AmLaw Ranking - ".$_POST['ranking_num']."<br>Avg Partner Billing Rate - ".$_POST['billing_rate']."<br>Price Per Partner Per Year YEAR 1- $".$_POST['year_1_price']."<br>".$_POST['year_1_mins']." - MINUTES OF A BILLABLE HOUR PER YEAR<br>Price Per Partner Per Year YEAR 1- $".$_POST['year_2_price']."<br>".$_POST['year_2_mins']." - MINUTES OF A BILLABLE HOUR PER YEAR<br>YEAR 1 - LICENSE - $".$_POST['year_1_license']."<br>YEAR 2 - SUBSCRIPTION - $".$_POST['year_2_subscription']."/mo<br>";

				// To send HTML mail, the Content-type header must be set
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

				// Additional headers
				$headers .= 'To: George <george@lextrack.com>, <marsha@lextrack.com>' . "\r\n";
				$headers .= 'From: LexLists <support@lexlist.com>' . "\r\n";				
				// Mail it
				if(mail($to, $subject, $message, $headers))
				{
					echo 1;
				}
				else
				{
					echo 0;
				}

			}
?>	
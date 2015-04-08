<?php
ob_start();
			if(isset($_POST['email']))
			{
				// the message
				$msg = "Firm Name - ".$_POST['firm_name']."\nNumber of Lawyers - ".$_POST['lawyers_num']."\nNumber of Partners - ".$_POST['partners_num']."\nNumber of Surveys - ".$_POST['surveys_num']."\nAmLaw Ranking - ".$_POST['ranking_num']."\nAvg Partner Billing Rate - ".$_POST['billing_rate']."\nPrice Per Partner Per Year YEAR 1- $".$_POST['year_1_price']."\n".$_POST['year_1_mins']." - MINUTES OF A BILLABLE HOUR PER YEAR\nPrice Per Partner Per Year YEAR 1- $".$_POST['year_2_price']."\n".$_POST['year_2_mins']." - MINUTES OF A BILLABLE HOUR PER YEAR\n";$filename = 'calculate.txt';
					!$handle = fopen($filename, 'w');
					fwrite($handle, $msg);
					fclose($handle);


					header("Cache-Control: public");
					header("Content-Description: File Transfer");
					header("Content-Length: ". filesize("$filename").";");
					header("Content-Disposition: attachment; filename=$filename");
					header("Content-Type: application/octet-stream; "); 
					header("Content-Transfer-Encoding: binary");
				/*header("Content-type: text/plain");
  				header("Content-Disposition: attachment; filename=savethis.txt");*/
				// use wordwrap() if lines are longer than 70 characters
				
				echo $msg;
				// send email
				//mail("someone@example.com","My subject",$msg);	
			}
		?>	
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="../css/bootstrap.css">
<style type="text/css">
.green_div {
	/*width: 290px; */
	min-height: 190px; 
	background-color: #85c441;
	color: white; 
	font-size: 16px;
	font-weight: bold;
	text-align: center;
	margin: 0 auto;
	border-radius: 8px;
}
</style>
</head>

<body>
	<div class="col-sm-6 col-md-6 col-lg-6 col-sm-offset-3 col-md-offset-3 col-lg-offset-3">

		<div class="form-group">
			<div class="row">
				<h3 style="text-align:center; font-weight:bold;">LexTrack PRICING CALCULATOR</h3>
			</div>
		</div>

		<div class="form-group">
			<div class="row">
				<div class="col-sm-1 col-md-1 col-lg-1"></div>
				<form action="#" method="post" id="calc_form" name="calc">
				<div class="col-sm-3 col-md-3 col-lg-3" style="padding-right:0;">
					<label>Firm Name:</label>
				</div>
				<div class="col-sm-7 col-md-7 col-lg-7">
					<input type="text" class="form-control" name="firm_name" required>
				</div>
				<div class="col-sm-1 col-md-1 col-lg-1"></div>
			</div>
		</div>

		<div class="form-group">
			<div class="row">
				<div class="col-sm-1 col-md-1 col-lg-1"></div>
				<div class="col-sm-3 col-md-3 col-lg-3" style="padding-right:0;">
					<label>Number of Lawyers:</label>
				</div>
				<div class="col-sm-7 col-md-7 col-lg-7">
					<input type="number" class="form-control" min="1" max="5000" name="num_lawyers" required>
				</div>
				<div class="col-sm-1 col-md-1 col-lg-1"></div>
			</div>
		</div>

		<div class="form-group">
			<div class="row">
				<div class="col-sm-1 col-md-1 col-lg-1"></div>
				<div class="col-sm-3 col-md-3 col-lg-3" style="padding-right:0;">
					<label>Number of Partners:</label>
				</div>
				<div class="col-sm-7 col-md-7 col-lg-7">
					<input type="number" class="form-control" min="1" max="5000" name="num_partners" required>
				</div>
				<div class="col-sm-1 col-md-1 col-lg-1"></div>
			</div>
		</div>

		<div class="form-group">
			<div class="row">
				<div class="col-sm-1 col-md-1 col-lg-1"></div>
				<div class="col-sm-3 col-md-3 col-lg-3" style="padding-right:0;">
					<label>Number of Surveys:</label>
				</div>
				<div class="col-sm-7 col-md-7 col-lg-7">
					<input type="number" class="form-control" min="1" max="1000" name="num_surveys" required>
				</div>
				<div class="col-sm-1 col-md-1 col-lg-1"></div>
			</div>
		</div>

		<div class="form-group">
			<div class="row">
				<div class="col-sm-1 col-md-1 col-lg-1"></div>
				<div class="col-sm-3 col-md-3 col-lg-3" style="padding-right:0;">
					<label>AmLaw Ranking:</label>
				</div>
				<div class="col-sm-7 col-md-7 col-lg-7">
					<input type="number" class="form-control" min="1" max="300" name="amlaw_rank" required>
				</div>
				<div class="col-sm-1 col-md-1 col-lg-1"></div>
			</div>
		</div>

		<div class="form-group">
			<div class="row">
				<div class="col-sm-1 col-md-1 col-lg-1"></div>
				<div class="col-sm-3 col-md-3 col-lg-3" style="padding-right:0;">
					<label>Avg Partner Billing Rate:</label>
				</div>
				<div class="col-sm-7 col-md-7 col-lg-7">
					<input type="number" class="form-control" min="100" max="2000" name="bill_rate" required>
				</div>
				<div class="col-sm-1 col-md-1 col-lg-1"></div>
			</div>
		</div>

		<div class="form-group">
			<div class="row">
				<div class="col-sm-1 col-md-1 col-lg-1"></div>
				<div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 col-sm-offset-3 col-md-offset-3 col-lg-offset-3">
					<input type="checkbox" value="Use BTI 2014 Survey" id="bti_2014" name="bti_2014">
				</div>
				<div class="col-sm-5 col-md-5 col-lg-5" style="padding-left:0;">
					<label>Use BTI 2014 Survey</label>
				</div>
			</div>
		</div>

		<div class="form-group">
			<div class="row" style="text-align: center;">
				<input type="submit" class="btn btn-default" style="width: 84px; background-color:grey; color:white;" id="calc" name="calculate" value="Calculate">				
				<button type="button" class="btn btn-default" style="width: 84px; background-color:grey; color:white;" id="reset">Reset</button> 
			</div>
		</form>
		</div>

		<form action="file.php" method="post" name="email_form" id="hidden_form">
			<input type="text" name="firm_name" style="display:none;">
			<input type="text" name="lawyers_num" style="display:none;">
			<input type="text" name="partners_num" style="display:none;">
			<input type="text" name="surveys_num" style="display:none;">
			<input type="text" name="ranking_num" style="display:none;">
			<input type="text" name="billing_rate" style="display:none;">

			<input type="text" name="year_1_price" style="display:none;">
			<input type="text" name="year_1_mins" style="display:none;">
			<input type="text" name="year_2_price" style="display:none;">
			<input type="text" name="year_2_mins" style="display:none;">

			<input type="text" name="year_1_license" style="display:none;">
			<input type="text" name="year_2_subscription" style="display:none;">

			<input type="submit" name="email" id="bl" class="btn btn-primary" value="Download Details" style="margin: 0 auto; display:none;">
		</form>

		<br>
		<div class="col-sm-12 col-md-12 col-lg-12" style="height:1px; border-top: 1px dashed lightgray;"></div>
		<br><br>
			

		<div class="form-group calc_result" style="display:none;">
			<div class="row">
				<div class="col-sm-6 col-md-6 col-lg-6">
					<div class="green_div">
						<p>YEAR 1</p>
						<p id="year_1"></p>
					</div>
				</div>
				<div class="col-sm-6 col-md-6 col-lg-6">
					<div class="green_div">
						<p>YEAR 2</p>
						<p id="year_2"></p>						
					</div>
				</div>
			</div>
		</div>	

		<div class="form-group calc_result" style="display:none;">
			<div class="row">
				<div class="col-sm-6 col-md-6 col-lg-6">
					<div class="green_div">
						<p>YEAR 1 - LICENSE</p>
						<p id="year_1_license"></p>
					</div>
				</div>
				<div class="col-sm-6 col-md-6 col-lg-6">
					<div class="green_div">
						<p>YEAR 2 - SUBSCRIPTION</p>
						<p id="year_2_subscription"></p>						
					</div>
				</div>
			</div>
		</div>	

		

	</div>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script type="text/javascript">
$('#bti_2014').on('change', function() {
	if($('#bti_2014').is(":checked"))
	{
	  	var num_lawyers = parseInt($('input[name=num_lawyers]').val());
	  	

	  	if(num_lawyers <= 399)
		{
			$('input[name=bill_rate]').val(482);
		
		}	
		if(num_lawyers >= 400 && num_lawyers <= 699)
		{
			$('input[name=bill_rate]').val(580);
		
		}		
		if(num_lawyers >= 700 && num_lawyers <= 899)
		{
			$('input[name=bill_rate]').val(745);
	
		}	
		if(num_lawyers >= 900)
		{
			$('input[name=bill_rate]').val(829);
		
		}
	}
	else
	{
		$('input[name=bill_rate]').val('');
	}
	
});

$('#calc_form').submit(function(event){
	event.preventDefault();
	$('#bl').css({"display":'block'});


	var firm_name = $('input[name=firm_name]').val();
	var num_lawyers = $('input[name=num_lawyers]').val();
	var num_partners = $('input[name=num_partners]').val();
	var num_surveys = $('input[name=num_surveys]').val();
	var amlaw_rank = $('input[name=amlaw_rank]').val();
	var bill_rate = 0;

	var SM = 20000;
	var MED = 30000;
	var LG = 50000;
	var MEG = 75000;
	var MEGAPLUS = 95000;
	var PCT = 0.65;
	var firm_size = '';
	var y1 = 0;
	var y2 = 0;
	var B1 = 0;
	var B2 = 0;
	var C1_mins = 0;
	var C2_mins = 0;

	if(num_lawyers <= 399)
	{
		y1 = SM;
		y2 = PCT*SM;
		firm_size = 'small';
	}
	
	if(num_lawyers >= 400 && num_lawyers <= 699)
	{
		y1 = MED;
		y2 = PCT*MED;
		firm_size = 'medium';
	}	
	
	if(num_lawyers >= 700 && num_lawyers <= 899)
	{
		y1 = LG;
		y2= PCT*LG;
		firm_size = 'large';
	}
	
	if(num_lawyers >= 900 && num_lawyers <= 1499)
	{
		y1 = MEG;
		y2 = PCT*MEG;
		firm_size = 'mega';
	}
	
	if(num_lawyers >= 1500)
	{
		y1 = MEGAPLUS;
		y2 = PCT*MEGAPLUS;
		firm_size = 'megaplus';
	} 
	
	if($('input[name=bti_2014]').is(":checked"))
	{
		if(firm_size == 'small')
		{
			bill_rate = 482;
		}		
		else if(firm_size == 'medium')
		{
			bill_rate = 580;
		}
		else if(firm_size == 'large')
		{
			bill_rate = 745;
		}
		else
		{
			bill_rate = 829;
		}
	}
	else
	{
		bill_rate = $('input[name=bill_rate]').val();
	}

	B1 = y1/num_partners;
	C1_mins = (B1*60)/bill_rate;
	B2 = y2/num_partners;
	C2_mins = (B2*60)/bill_rate;

	B1 = Number((B1).toFixed(0));
	B2 = Number((B2).toFixed(0));
	C1_mins = Number((C1_mins).toFixed(0));
	C2_mins = Number((C2_mins).toFixed(0));

	$('input[name=firm_name]').val(firm_name);
	$('input[name=lawyers_num]').val(num_lawyers);
	$('input[name=partners_num]').val(num_partners);
	$('input[name=surveys_num]').val(num_surveys);
	$('input[name=ranking_num]').val(amlaw_rank);
	$('input[name=billing_rate]').val(bill_rate);
	$('input[name=year_1_price]').val(B1);
	$('input[name=year_1_mins]').val(C1_mins);
	$('input[name=year_2_price]').val(B2);
	$('input[name=year_2_mins]').val(C2_mins);
	$('input[name=year_1_license]').val(y1);
	$('input[name=year_2_subscription]').val(Number((y2/12).toFixed(0)));

	var hidden_form = $('#hidden_form').serialize();
	
	$.ajax({
	  method: "POST",
	  url: "file.php",
	  data: hidden_form
	})
	  .done(function( msg ) {
	    alert( "Data Saved: " + msg );
	  });

	
	$('.calc_result').fadeIn();

	$('#year_1').html( "<h1>$"+B1+"</h1><p>per partner/year</p><p>OR</p><p>"+C1_mins+" MINUTES OF BILLABLE TIME PER YEAR</p>" );
	$('#year_2').html( "<h1>$"+B2+"</h1><p>per partner/year</p><p>OR</p><p>"+C2_mins+" MINUTES OF BILLABLE TIME PER YEAR</p>" );

	$('#year_1_license').html( "<h1>$"+y1+"</h1><p>(one time)</p>" );
	$('#year_2_subscription').html( "<h1>$"+Number((y2/12).toFixed(0))+"/mo</h1>" );
	
	

	
});
$('#reset').click(function(){	
	$('input[name=firm_name]').val('');
	$('input[name=num_lawyers]').val('');
	$('input[name=num_partners]').val('');
	$('input[name=num_surveys]').val('');
	$('input[name=amlaw_rank]').val('');
	$('input[name=bill_rate]').val('');
	if($('input[name=bti_2014]').is(":checked"))
	{
		$('input[name=bti_2014]').click();
	}
	$('.calc_result').fadeOut();
});
</script>


</body>
</html>
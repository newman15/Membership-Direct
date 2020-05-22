<?php
    session_start();

    // Import Nav Bar
    require "includes/portal-nav.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Portal - Account</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

 <style>
    a.nav-link:hover, a.nav-link:active{
        font-size: 150%;
    }
    
	.column_left{
		font-weight: bold;
		margin-left: 15px;
		margin-right: 20px;
	}

    .top-link{
		margin-left: 11%;
		font-family: 'Varela Round', sans-serif;
		font-weight: bold;
    }

    .nav-link{
        color: black;
    }

    .tab-body-text{
        font-size: 1.1em;
    }

    #more-info-tabs{
        font-size: 1.5em;
    }

    .btn{
      background-color: #2b6f94;
    }

    h1{
        text-align: center;
        font-size: 3em;
    }

  </style>

</head>

<body>    <br />

    <br /><br />
    <center><h1>Account</h1></center>
	
	 <!--------------- More Info Tabs ------------------>
        <br/><br/><br/>
        <div class="container">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist" id="more-info-tabs">
                <li class="nav-item">
                    <a class="nav-link active" id="nav-link" data-toggle="tab" href="#about_me">About Me</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="nav-link" data-toggle="tab" href="#payment">Billing & Payment</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="nav-link" data-toggle="tab" href="#insurance">Insurance</a>
                </li>
            </ul>
        
            <!-- Tab panes -->
            <div class="tab-content">
			
				<!-- About Me tab -->
                <div id="about_me" class="container tab-pane active"><br>
					<h3>Contact </h3>	
					<div class="row">
						<div class="column_left">
							Full Name:			<br/>
							Email Address:		<br/>
							Phone Number:		<br/>
							Home Address:		<br/>
							State:				<br/>
							Zip Code:			<br/>
						</div>
						<div class="column_right">
							Jane Doe				<br/>
							something@darkside.com	<br/>
							808-555-0123			<br/>
							1492 Columbus St		<br/>
							CO						<br/>
							12345					<br/>
						</div>
					</div>
					<!-- TODO: Edit Contact Info button -->
					
					<br/><br/>
					<h3>Membership</h3>
					<div class="row">
						<div class="column_left">
							Member Type:		<br/>
							Member Status:		<br/>
						</div>
						<div class="column_right">
							Silver				<br/>
							Active				<br/>
						</div>
					</div>
                </div>
				
				<!-- Billing & Payment tab -->
                <div id="payment" class="container tab-pane fade"><br>
					<h3>Payment Status</h3>
					<div class="row">
						<div class="column_left">
							Current Standing:	<br/>
							Payment Due: 	<br/>
						</div>
						
						<div class="column_right">
							Good				<br/>
							$121.64 (December 31, 2021)	<br/>
						</div>
					</div>
					
					<!-- TODO: Pay Now button -->
					<br/><br/>
					<!-- TODO: Add Card button -->
					
                    <div class="row">
						<div class="column_left">
							John (primary):		<br/><br/>
							<br/>
							Jane:				<br/><br/>
							<br/>
						</div>
						
						<div class="column_right">
							VISA ending in 1234				<br/>
							Exp: 3/2022				<br/>
							<br/>
							VISA ending in 5678		<br/>
							Exp: 8/2021				<br/>
							<br/>
						</div>
					</div>
                </div>
				
				<!-- Insurance tab -->
				<div id="insurance" class="container tab-pane fade"><br>
					<h3>Insurance</h3>
                    <div class="row">
						<div class="column_left">
							Provider:		<br/>
							Policy Number:		<br/>
							Number of Claims:		<br/>
							Business ID:			<br/>
						</div>
						
						<div class="column_right">
							Geico				<br/>
							1357				<br/>
							5				<br/>
							129512			<br/>
						</div>
					</div>
					
					<br/><br/>
					<h3>Vehicle</h3>
                    <div class="row">
						<div class="column_left">
							Make:		<br/>
							Model:		<br/>
							Year:		<br/>
						</div>
						
						<div class="column_right">
							Honda				<br/>
							Acura				<br/>
							2099				<br/>
						</div>
					</div>
                </div>
            </div>
        </div>
	
</body>

</html>
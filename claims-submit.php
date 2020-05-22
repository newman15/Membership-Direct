<?php
    session_start();

    // Import Nav Bar
    require "includes/portal-nav.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Portal - Payment</title>
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

    #claim-form{
        text-align: center;
    }
</style>
</head>

<body>
    <!-- New Claim Form -->
    <br /><br />
    <div class="container" id="claim-form">
        <h2>File a new claim</h2><br/>

        <form method="POST">

            <!-- Choose Vehicle -->
            <div class="form-group">
                <label for="vehicle-choice">Choose Vehicle (select one):</label>
                <select class="form-control" id="vehicle-choice" name="vehicle-choice">
                    <option>Vehicle 1</option>
                    <option>Vehicle 2</option>
                    <option>Vehicle 3</option>
                </select>
            </div><br /><br />

            <!-- Auto Shop Info -->
            <div class="form-group" id="auto-shop-info">
                <label for="auto-shop-name">Auto Body Information</label>
                <input type="text" class="form-control" placeholder="Enter Auto Shop Name" id="auto-shop-name" name="auto-shop-name">
                <input type="text" class="form-control" placeholder="Enter Billing Address" id="billing-address" name="billing-address">
                <input type="tel" class="form-control" placeholder="Phone Number (111-222-3333)" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" id="business-contact-number" name="business-contact-number">
            </div><br /><br />

            <!-- Upload Insurance Doc -->
            <div class="form-group" id="upload-claim">
                <label for="upload-claim-document">Upload proof of insurance claim</label>
                <input type="file" class="form-control-file border" id="insurance-claim-doc" name="insurance-claim-doc">
            </div><br /><br />

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

</body>

</html>
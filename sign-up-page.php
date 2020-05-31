<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Sign Up - Membership Direct</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

  <script src="functions.js"></script>

  <script>
    $(document).ready(function(){
      $("#sign-up-btn").hide();
      $("#agree-btn").click(function(){
        $("#sign-up-btn").show();
      });
    });

  </script>

  <style>

    .top-link{
    margin-left: 11%;
    font-family: 'Varela Round', sans-serif;
    font-weight: bold;
    }

    h1{
      text-align: center;
    }

    .btn{
      background-color: #2b6f94;
    }

    #membership-type label + label{
      padding: 20px;
    }

    #terms-and-conditions{
      text-align: center;
    }

    .modal-body embed{
      width: 100%;
      height: 400px;
    }

    .error-message{
        color: red;
        font-weight: bold;
    }

  </style>
</head>

<body>

  <!-- Top Link -->
  <br />
  <div class="top-link">
    <a href="index.html" style="color: #333a3d;"><h5>Membership Direct</h5><h6>Deductible Savings</h6></a>
  </div><br /><br /><br />

  <div class="container" id="sign-up-form">
    <h1>Sign Up</h1><br /><br />

    <!-- Sign Up Form -->
    <form method="POST" action="sign-up.php">

      <!-- Profile Info -->
      <div class="form-group" id="profile-info">
        <label for="profile-info">Enter Email & Password</label>
        <?php 
            if (isset($_GET['error'])){
                if(isset($_GET['error']) == "existingemail"){
                    echo '<p class="error-message">There is an existing account with this email!</p>';
                }

                else if(isset($_GET['error']) == "invalidemail"){
                    echo '<p class="error-message">Invalid Email!</p>';
                }
            }
        ?>
        <input type="email" class="form-control" placeholder="Email" id="email" name="email" required>
        <input type="password" class="form-control" placeholder="Password" id="pswd" name="pswd" required>
        <input type="password" class="form-control" placeholder="Verify Password" id="pswd-verify" name="pswd-verify" required>
      </div><br /><br />

      <!-- Contact Info -->
      <div class="form-group" id="personal-info">
        <label for="contact-info">Enter Your Contact Information</label>
        <input type="text" class="form-control" placeholder="First Name" id="first-name" name="first-name" value="<?php echo isset($_GET["first-name"]) ? $_GET["first-name"] : ''; ?>" required>
        <input type="text" class="form-control" placeholder="Last Name" id="last-name" name="last-name" value="<?php echo isset($_GET["last-name"]) ? $_GET["last-name"] : ''; ?>" required>
        <input type="text" class="form-control" placeholder="Address" id="address" name="address" value="<?php echo isset($_GET["address"]) ? $_GET["address"] : ''; ?>" required>
        <input type="text" class="form-control" placeholder="City" id="city" name="city" value="<?php echo isset($_GET["city"]) ? $_GET["city"] : ''; ?>" required>
        <input type="text" class="form-control" placeholder="State" id="state" name="state" value="<?php echo isset($_GET["state"]) ? $_GET["state"] : ''; ?>" required>
        <input type="number" class="form-control" placeholder="Zip Code" id="zip" name="zip" value="<?php echo isset($_GET["zip"]) ? $_GET["zip"] : ''; ?>" required>
        <input type="tel" class="form-control" placeholder="Phone Number (111-222-3333)" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" id="contact-number" name="contact-number" value="<?php echo isset($_GET["contact-number"]) ? $_GET["contact-number"] : ''; ?>" required>
      </div><br /><br />

      <!-- Vehicle & Insurance Info -->
      <div class="form-group" id="insurance-info">
        <label for="insurance-info">Enter Your Vehicle & Insurance Info</label>
        <input type="text" class="form-control" placeholder="Vehicle Make" id="vehicle-make" name="vehicle-make" value="<?php echo isset($_GET["vehicle-make"]) ? $_GET["vehicle-make"] : ''; ?>" required>
        <input type="text" class="form-control" placeholder="Vehicle Model" id="vehicle-model" name="vehicle-model" value="<?php echo isset($_GET["vehicle-model"]) ? $_GET["vehicle-model"] : ''; ?>" required>
        <input type="number" class="form-control" placeholder="Vehicle Year" id="vehicle-year" name="vehicle-year" value="<?php echo isset($_GET["vehicle-year"]) ? $_GET["vehicle-year"] : ''; ?>" required>
        <input type="text" class="form-control" placeholder="Vehicle Color" id="vehicle-color" name="vehicle-color" value="<?php echo isset($_GET["vehicle-color"]) ? $_GET["vehicle-color"] : ''; ?>" required>
        <input type="text" class="form-control" placeholder="Vehicle Vin" id="vehicle-vin" name="vehicle-vin" value="<?php echo isset($_GET["vehicle-vin"]) ? $_GET["vehicle-vin"] : ''; ?>" required>
        <input type="text" class="form-control" placeholder="Insurance Provider" id="insur-prov" name="insur-prov" value="<?php echo isset($_GET["insur-prov"]) ? $_GET["insur-prov"] : ''; ?>" required>
        <input type="number" class="form-control" placeholder="Policy Number" id="pol-num" name="pol-num" value="<?php echo isset($_GET["pol-num"]) ? $_GET["pol-num"] : ''; ?>" required>
      </div><br />

      <!-- Membership Type -->
      <div class="form-check-inline" id="membership-type">
        <label class="form-check-label" for="silver">
          <input type="radio" class="form-check-input" id="silver" name="member-selection" value="Silver" required>Silver
        </label>

        <label class="form-check-label" for="gold">
          <input type="radio" class="form-check-input" id="gold" name="member-selection" value="Gold">Gold
        </label>
      </div><br/><br/>

      <!-- Optional Business Id -->
      <div class="form-group" id="business-id">
        <label for="business-id">Have a business ID? Enter it here:</label>
        <input type="number" class="form-control" placeholder="Business Id" id="bus-id" name="bus-id">
      </div><br /><br />

      <!-- Terms & Conditions -->
      <div class="container" id="terms-and-conditions">

        <!-- Button to Open the Modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#terms">
          Terms & Conditions
        </button>
      
        <!-- Terms Modal -->
        <div class="modal fade" id="terms">
          <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
            
              <!-- Modal Header -->
              <div class="modal-header">
                <h1 class="modal-title">Membership Direct</h1>
                <button type="button" class="close" data-dismiss="modal">×</button>
              </div>
              
              <!-- Modal body -->
              <div class="modal-body">
                <embed src="docs/terms.pdf">
              </div>
              
              <!-- Modal footer -->
              <div class="modal-footer">
                <button type="button" class="btn btn-success" id="agree-btn" data-dismiss="modal" 
                onclick="termsAgreeColor(); termsAgreeIcon()">I Agree</button>
              </div>
              
            </div>
          </div>
        </div>
        <i class="material-icons" id="terms-agreement" style="color:red">report_problem</i>
      </div><br /><br />

      <button type="submit" class="btn btn-primary" name="sign-up-btn" id="sign-up-btn">Submit</button>
    </form><br /><br /><br /><br />

  </div>

</body>

</html>
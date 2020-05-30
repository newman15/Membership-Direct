<?php

  // User has signed in successfully
  // Create a session variable
  session_start();

  if(isset($_SESSION['sessionEmail'])){
    //echo "Session Recognized";
    header("Location: member-portal.php");
  }

  else{
    //echo "Session NOT Recognized";

    // html code
    echo <<<HTML
    <!DOCTYPE html>
    <html lang="en">
    <head>
      <title>Login - Membership Direct</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
      <script src="functions.js"></script>
    
      <style>
        #form-title{
          text-align: center;
        }
        #sign-up{
          text-align: center;
        }
        .top-link{
        margin-left: 11%;
        font-family: 'Varela Round', sans-serif;
        font-weight: bold;
        }
      </style>
    </head>
    
    <body>
      <br />
      <div class="top-link">
        <a href="index.html" style="color: #333a3d;"><h5>Membership Direct</h5><h6>Deductible Savings</h6></a>
      </div><br />
    
      <!--------------- Login & Sign Up Form ------------------>
      <br /><br />
      <div class="container">
        <h2 id="form-title">Member Login</h2>
    
        <form method="POST" action="includes/login.php">
          <div class="form-group">
            <label for="email-label">Email:</label>
            <input type="text" class="form-control" id="email" placeholder="Enter email" name="email" required>
          </div>
    
          <div class="form-group">
            <label for="pwd">Password:</label>
            <input type="password" class="form-control" id="pswd" placeholder="Enter password" name="pswd" required>
          </div>
          
          <button id="login-btn" name="login-btn" type="submit" class="btn btn-primary">Login</button>
          <!-- <a href="member-portal.html" class="btn btn-primary btn-lg">Login</a> -->
    
          <br /><br />
          <div id="sign-up">
            <p>Not a member? Sign up today!</p>
            <a href="sign-up.html" class="btn btn-primary btn-md">Sign Up</a>
          </div>
    
        </form>
      </div>
    </body>
    </html>
    HTML;
  }


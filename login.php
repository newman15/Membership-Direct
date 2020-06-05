<?php
    session_start();
    // Check if user has logged in using 'login' page btn
    // Protects against person entering via URL Manipulation
    if (isset($_POST['login-btn'])){

        // Store Form Variables
        $email = $_POST['email'];
        $pswd = $_POST['pswd'];

        // If user left a field empty
        if(empty($email) || empty($pswd)){
            header("Location: login-page.php");
            exit();
        }

        // Else continue with login
        else{

            // DB Interaction
            try{
                // Connection to DB
                require "db-info.php";
                $dbh = new PDO("mysql:host=$serverName; dbname=$dbName", $userName, $password);
                $dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
                
                // SQL Email Check
                $stmt = $dbh->prepare("SELECT * FROM member WHERE email=?");
                $stmt->execute([$email]);
                $user = $stmt->fetch();

                // Stored hashed password from database
                $hashedPass = $user['password'];

                // No account matching entered credentials
                if(!$user){
                    header("Location: login-page.php?error=noaccount&email=".$email);
                    exit(); // Stop script if no email detected
                }

                // Checks if DB returned any data at all
                // If so, then compare passwords
                if($user && password_verify($pswd, $hashedPass)){

                    // User has signed in successfully
                    // Create a session variable
                    $_SESSION['sessionEmail'] = $user['email'];
                    $_SESSION['sessionName'] = $user['first_name'];
                    header("Location: member-portal.php");

                }

                // Username and Password do not match
                else{
                    header("Location: login-page.php?error=failedlogin&email=".$email);
                }
    
                $dbh = null;
                $stmt = null;
    
            } catch(PDOException $e){       // Need to set_exception_handler() to protect DB
                throw new \PDOException($e->getMessage(), (int)$e->getCode());
                //die();
            }
        }
    }

    else{

        // // Sends user back to home page if using URL Manipulation
        header("Location: index.html");
        exit();
        
    }

?>
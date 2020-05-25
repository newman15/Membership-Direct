<?php

    // Store Form Variables
    $email = $_POST['email'];
    $pswd = $_POST['pswd'];

    // Check if user has logged in using 'login' page btn
    // Protects against person entering via URL Manipulation
    if (isset($_POST['login-btn'])){

        // Connection to DB
        require "db-info.php";

        // If user left a field empty
        if(empty($email) || empty($pswd)){
            header("Location: ../login-page.html");
            exit();
        }

        // Else continue with login
        else{
            echo"Field is not empty. You are entering SQL Check Now...";

            // DB Interaction
            try{
                // Connection to DB
                require "db-info.php";
                $dbh = new PDO("mysql:host=$serverName; dbname=$dbName", $userName, $password);
                $dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
                echo "<br/><br/>";
                
                // SQL Email Check
                $stmt = $dbh->prepare("SELECT * FROM member WHERE email=?");
                $stmt->execute([$email]);
                $user = $stmt->fetch();

                // Checks if DB returned any data at all
                // If so, then compare passwords
                if($user && password_verify($pswd, $user['password'])){
                    echo "valid!";
                    echo "Logging Into User Portal...";

                    // User has signed in successfully
                    // Create a session variable
                    session_start();
                    $_SESSION['sessionEmail'] = $user['email'];
                    $_SESSION['sessionName'] = $user['first_name'];
                    header("Location: ../member-portal.php");

                }
                else{
                    echo "INVALID!";
                    echo '<a class="btn btn-large btn-primary" href="../login-page.php" style="font-size: 100%; border-color: rgb(252, 252, 252); border-width: thick;">Return To Login</a>';
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
        // header("Location: ../login-page.html");
        echo "ERROR! You did not login via the login page btn";
        exit();
        
    }

?>
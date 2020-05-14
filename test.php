<?php

    // Store Variables from form
    $formElements = array(
        0,
        $firstName = $_POST["first-name"],
        $lastName= $_POST["last-name"],
        $address = $_POST["address"],
        $state = $_POST["state"],
        $zipCode = $_POST["zip"],
        $email = $_POST["email"],
        $password = $_POST["pswd"],
        $memberStatus = 0,
        $memberType = $_POST["member-selection"],
        $vehicleMake = $_POST["vehicle-make"],
        $vehicleModel = $_POST["vehicle-model"],
        $vehicleYear = $_POST["vehicle-year"],
        $insuranceProvider = $_POST["insur-prov"],
        $policyNum = $_POST["pol-num"],
        $numClaims = 0,
        $businessId = $_POST["bus-id"]
        //$phoneNum = $_POST["contact-number"],
        
    );

    // Database Connection
    $serverName = "localhost";
    $userName = "root";
    $password = "A@n3w1515";
    //Add phone number to db
    //claim number

    // $stmt = $dbh->prepare("INSERT INTO member (first_name, last_name, address, state, zip_code, email, password, member_status, 
    //         member_type, vehicle_make, vehicle_model, vehicle_year, car_insurance, policy_number, number_of_claims, business_id) 
    //         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // "INSERT INTO member (first_name, last_name, address, state, zip_code, email, password, member_status, 
    // member_type, vehicle_make, vehicle_model, vehicle_year, car_insurance, policy_number, number_of_claims, business_id) 
    // VALUES ('Aaron', 'Newman', '1234 address lane', 'WA', '98466', 'test@email.com', 'MyP@ssword!', '1', 'Gold', 
    // 'Pontiac', 'G6', '2008', 'Progressive', '001234', '0', '000001')");

    try{
        $dbh = new PDO("mysql:host=$serverName; dbname=membership_direct", $userName, $password);
        echo "You have connected!";
        echo "<br/><br/>";
        
        $stmt = $dbh->prepare("INSERT INTO member (first_name, last_name, address, state, zip_code, email, password, member_status, 
            member_type, vehicle_make, vehicle_model, vehicle_year, car_insurance, policy_number, number_of_claims, business_id) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        for ($i = 1; $i < 17; $i++){
            $stmt->bindParam($i, $formElements[$i]);
        }

        $stmt->execute();
        echo "New Record Created Successfully";

    } catch(PDOException $e){       // Need to set_exception_handler() to protect DB
        echo $sqlTest . "<br/>" . $e->getMessage();
        exit();
    }

?>
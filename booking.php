<!-- Davis Djaja, 17981197 -->
<!-- This file consist of the backend work for creating a booking -->

<?php

    require_once('../../config/assign2.php');

    $conn = @mysqli_connect($sql_host, $sql_user, $sql_pass, $sql_db);

    if(!$conn){
        echo "<p>Database connection failed!</p>";
    } else {
            
        //Assign variables from form
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $unitNum = $_POST['unitNum'];
        $streetNum = $_POST['sNum'];
        $streetName = $_POST['stName'];
        $suburb = $_POST['sbName'];
        $dsbSuburb = $_POST['dsbName'];
        $date = $_POST['date'];
        $time = $_POST['time'];
        $dateTime = $date . " " . $time;
        $bookingDate = date("Y-m-d h:i");   //Generate the current date and time for a booking once created

        $fiveDigitRandomNumber = mt_rand(10000,99999); //Generate a random five digit number for the booking reference
        $bookingRef = "BRN" . strval($fiveDigitRandomNumber);
        $status = "Unassigned";

        //Query to check booking ref duplicates
        $checkBookingRef = "SELECT bookingNum FROM $sql_table";
        $checkQuery = mysqli_query($conn, $checkBookingRef);


        //If number of rows 0 then database empty, just insert the booking
        if(mysqli_num_rows($checkQuery) == 0){
            $insertQuery = "INSERT INTO $sql_table(bookingNum, name, phone, unitnumber, streetnumber, streetname, suburb, dsbname, datetime, status, bookingdate) 
            VALUES('$bookingRef', '$name', '$phone', '$unitNum', '$streetNum', '$streetName', '$suburb', '$dsbSuburb', '$dateTime', '$status', '$bookingDate')";
            $checkInsert = mysqli_query($conn, $insertQuery);
            if(!$checkInsert){
                echo "<p>No Rows!</p>";
            } else {
                $formatDate = date("d/m/Y", strtotime($date));
                echo "<h3>Thank you for your booking!</h3>";
                echo "<p>Booking reference number: $bookingRef</p>";
                echo "<p>Pickup time: $time </p>";
                echo "<p>Pickup date: $formatDate</p>";
                echo "<br/>";
            }
        } else {
            while($row = mysqli_fetch_row($checkQuery)){

                //Row0 in the database contains booking references
                if($row[0] == $bookingRef){
                    //If booking ref exist then generate a new booking ref
                    do{
                        $bookingRef = "BRN" . strval($fiveDigitRandomNumber);
                    } while($row[0] == $bookingRef);    //keep generating until booking ref does not exist in database

                    $insertQuery = "INSERT INTO $sql_table(bookingNum, name, phone, unitnumber, streetnumber, streetname, suburb, dsbname, datetime, status, bookingdate) 
                    VALUES('$bookingRef', '$name', '$phone', '$unitNum', '$streetNum', '$streetName', '$suburb', '$dsbSuburb', '$dateTime', '$status', '$bookingDate')";
                    $checkInsert = mysqli_query($conn, $insertQuery);

                    if(!$checkInsert){
                        "<p>Insert query invalid!</p>";
                    } else {
                        $formatDate = date("d/m/Y", strtotime($date));
                        echo "<h3>Thank you for your booking!</h3>";
                        echo "<p>Booking reference number: $bookingRef</p>";
                        echo "<p>Pickup time: $time </p>";
                        echo "<p>Pickup date: $formatDate</p>";
                        echo "<br/>";
                    }
                } else {
                    //If booking ref not duplicate, insert new booking                     
                    $insertQuery = "INSERT INTO $sql_table(bookingNum, name, phone, unitnumber, streetnumber, streetname, suburb, dsbname, datetime, status, bookingdate) 
                    VALUES('$bookingRef', '$name', '$phone', '$unitNum', '$streetNum', '$streetName', '$suburb', '$dsbSuburb', '$dateTime', '$status', '$bookingDate')";
                    $checkInsert = mysqli_query($conn, $insertQuery);

                    if(!$checkInsert){
                        "<p>Insert query invalid!</p>";
                    } else {
                        $formatDate = date("d/m/Y", strtotime($date));
                        echo "<h3>Thank you for your booking!</h3>";
                        echo "<p>Booking reference number: $bookingRef</p>";
                        echo "<p>Pickup time: $time </p>";
                        echo "<p>Pickup date: $formatDate</p>";
                        echo "<br/>";
                    }
                }

            }
            mysqli_free_result($checkResults);
        }
    }

?>
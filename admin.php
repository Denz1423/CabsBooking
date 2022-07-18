<!-- Davis Djaja, 17981197 -->
<!-- PHP file to handle the backend work for searching a booking -->

<?php

    require_once('../../config/assign2.php');

    $conn = @mysqli_connect($sql_host, $sql_user, $sql_pass, $sql_db);

    if(!$conn){
        echo "<p>Database connection failed!</p>";
    } else {

        $bSearch = $_POST['bsearch'];
        $time = new DateTime();
        $date = $time->format('Y-m-d');
        $time = $time->format('H:i');
        
        //Date and Time variables for searching
        $currentDateTime = $date . ' ' . $time;
        $newDateTime = date("Y-m-d H:i", strtotime('+2 hours'));

        //Query to check booking ref exist
        $checkBookingRef = "SELECT * FROM $sql_table WHERE bookingNum = '$bSearch'";
        $checkQuery = mysqli_query($conn, $checkBookingRef);

        //If number of rows 0 then entry does not exist
        if(mysqli_num_rows($checkQuery) == 0){

            //Retrieve bookings that are two hours from current time
            $getBookings = "SELECT * FROM $sql_table WHERE datetime BETWEEN '$currentDateTime' AND '$newDateTime' AND status = 'Unassigned'";
            $retrieveBookings = mysqli_query($conn, $getBookings);

            if(!$retrieveBookings){
                echo "<p>No Rows!</p>";
            } else {
                //If search is blank then display bookings 2 hours from current time
                if($bSearch == ""){
                //Display found bookings
                echo "<table width='100%' border='1' id='searchtable'>";
                echo "<tr><th>Booking Reference Number</th><th>Customer Name</th>
                <th>Phone</th><th>Pickup Suburb</th><th>Destination Suburb</th><th>Pickup Date and Time</th><th>Status</th><th>Assign</th></tr>";

                while ($row = mysqli_fetch_row($retrieveBookings)){
                    $ref = json_encode($row[0]);
                    echo "<tr>";
                    echo "<tr><td>{$row[0]}</td>";  //Row 0 contains booking ref
                        echo "<td>{$row[1]}</td>";  //Row 1 customer name
                        echo "<td>{$row[2]}</td>";  //phone number
                        echo "<td>{$row[6]}</td>";  //pick up suburb
                        echo "<td>{$row[7]}</td>";  //destination suburb
                        echo "<td>{$row[8]}</td>";  //date and time
                        echo "<td id=$ref>{$row[9]}</td>";  //status
                        echo "<td><input
                        type='button'
                        id='assignbutton'
                        name='assignbutton'
                        value='Assign'
                        classname='resultbutton'
                        onclick='assign($ref); this.disabled=true;'
                       /></td>        
                        </tr>";                     
                    echo "</tr>";
                }
                echo "</table>";
                mysqli_free_result($retrieveBookings);
                } else {
                    //If random string entered
                    echo "<p id='error-message'>Must be in BRN##### format and booking exist!</p>";
                }
                
            }
        } else {
            //Booking exist
            //Display the booking
            echo "<table width='100%' border='1'>";
            echo "<tr><th>Booking Reference Number</th><th>Customer Name</th>
            <th>Phone</th><th>Pickup Suburb</th><th>Destination Suburb</th><th>Pickup Date and Time</th><th>Status</th><th>Assign</th></tr>";

            while ($row = mysqli_fetch_row($checkQuery)){
                $ref = json_encode($row[0]);
                echo "<tr>";
                echo "<tr><td>{$row[0]}</td>";  //Row 0 contains booking ref
                    echo "<td>{$row[1]}</td>";  //Row 1 customer name
                    echo "<td>{$row[2]}</td>";  //phone number
                    echo "<td>{$row[6]}</td>";  //pick up suburb
                    echo "<td>{$row[7]}</td>";  //destination suburb
                    echo "<td>{$row[8]}</td>";  //date and time
                    echo "<td id=$ref>{$row[9]}</td>";  //status
                    //if status of the booking is assigned then button does not have a onclick function
                    if($row[9] == "Assigned"){
                        echo "<td><input
                        type='button'
                        id='assignbutton'
                        name='assignbutton'
                        value='Assign'
                        /></td>        
                    </tr>";  
                    } else {
                        echo "<td><input
                        type='button'
                        id='assignbutton'
                        name='assignbutton'
                        value='Assign'
                        onclick='assign($ref); this.disabled=true;'
                       /></td>        
                        </tr>"; 
                    }
                echo "</tr>";
            }
            echo "</table>";
            mysqli_free_result($checkResults);
        }
    }

?>
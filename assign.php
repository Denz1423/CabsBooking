<!-- Davis Djaja, 17981197 -->
<!-- PHP file to handle when an admin assign a booking -->

<?php

    require_once('../../config/assign2.php');

    $conn = @mysqli_connect($sql_host, $sql_user, $sql_pass, $sql_db);

    if(!$conn){
        echo "<p>Database connection failed!</p>";
    } else {
        $bookingRef = $_POST['assignbutton'];

        $updateQuery = "UPDATE $sql_table SET status='Assigned' WHERE bookingNum='$bookingRef'";
        $retrieveBookings = mysqli_query($conn, $updateQuery);
        echo "<p id='result'>Congragulations! Booking request " . $bookingRef . " has been assigned!</p>";

    }
?>
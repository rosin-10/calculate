<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'external';

// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
} else {
    echo '<h2>Database connected</h2>';
}

// Handle form submission for registration
if (isset($_POST['register'])) {
    // Get form data
    $id = $_POST['id'];
    $name = $_POST['name'];
    $m1 = intval($_POST['m1']);
    $m2 = intval($_POST['m2']);
    $m3 = intval($_POST['m3']);
    $m4 = intval($_POST['m4']);
    $m5 = intval($_POST['m5']);
    
    // Calculate total marks
    $total = $m1 + $m2 + $m3 + $m4 + $m5;

    // Check if ID already exists
    $check = "SELECT * FROM student WHERE id='$id'";
    $res = $conn->query($check);

    if ($res->num_rows > 0) {
        echo '<h2>ID must be unique</h2>';
    } else {
        // Insert new student data into database
        $insert = "INSERT INTO student(id, name, m1, m2, m3, m4, m5, total) 
                   VALUES('$id', '$name', $m1, $m2, $m3, $m4, $m5, $total)";

        if ($conn->query($insert)) {
            echo '<h2>1 row(s) added successfully</h2>';
        } else {
            die("Error: " . $conn->error);
        }
    }
}
if (isset($_POST['search']))
{
$name = $_POST['suser'];
    // Fetch and display all student records
    $sel = "SELECT * FROM student WHERE name='$name'";
    $r = $conn->query($sel);

    if ($r->num_rows > 0) {
	echo "<h2>Name: ".$name."</h2>";
	echo "<h2>Result: </h2>";
        echo "<table border=1 style='text-align: center; justify-content: center;'><tr><th>details</th><th>result</th></tr>";
        while ($row = $r->fetch_assoc()) {
            // Check pass/fail status for each subject
	    $stot = ($row['total']>250) ? 'Pass' : 'Fail';
            // Display student record with status
            echo "<tr>
                    <td style='padding: 15px;'><b>ID</td><td style='padding: 15px;'>" . $row['id'] . "</td></tr><tr>
                    <td style='padding: 15px;'><b>name</td><td style='padding: 15px;'>" . $row['name'] . "</td></tr><tr>
                    <td style='padding: 15px;'><b>mark 1</b></td><td style='padding: 15px;'>" . $row['m1'] . "</td></tr><tr>
                    <td style='padding: 15px;'><b>mark 2</b></td><td style='padding: 15px;'>" . $row['m2'] . "</td></tr><tr>
                    <td style='padding: 15px;'><b>mark 3</b></td><td style='padding: 15px;'>" . $row['m3'] . "</td></tr><tr>
                    <td style='padding: 15px;'><b>mark 4</b></td><td style='padding: 15px;'>" . $row['m4'] . "</td></tr><tr>
                    <td style='padding: 15px;'><b>mark 5</b></td><td style='padding: 15px;'>" . $row['m5'] . "</td></tr><tr>
                    <td style='padding: 15px;'><b>total</b></td><td style='padding: 15px;'>" . $row['total'] . "</td></tr><tr>
		    <td style='padding: 15px;'><b>result</b></td><td style='padding: 15px;'>" . $stot . "</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<script>alert('No records found');</script>";
    }
}

?>

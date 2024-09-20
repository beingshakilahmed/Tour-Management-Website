<?php
// Display errors for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "tour";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $nid = $_POST['nid'];
    $email = $_POST['email'];
    $number_of_persons = $_POST['number_of_persons'];
    $package = $_POST['package'];
    $destination = $_POST['destination'];
    $price = $_POST['price']; // New variable to hold the price
    $redirect_ur = $_POST['redirect_ur'];
    // Calculate total cost
    $total_cost = $price * $number_of_persons;

    // Connect to database (replace with your database credentials)
    

    // Prepare and bind SQL statement
    $stmt = $conn->prepare("INSERT INTO bookings (name, phone_number, nid, email, nof_persons, package_name, destination, total_cost) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssissd", $name, $phone, $nid, $email, $number_of_persons, $package, $destination, $total_cost);

    // Execute SQL statement
    if ($stmt->execute()) {
        echo "Booking saved successfully!Additional Information Will Be Email TO You";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close connection
    $stmt->close();
    $conn->close();
    header("Location: $redirect_ur");
    exit();
} else {
    echo "Invalid request method.";
}
?>


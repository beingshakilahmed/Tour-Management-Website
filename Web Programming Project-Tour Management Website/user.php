<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Database connection
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

// Get user information
$user = $_SESSION['username'];
$sql_user = "SELECT * FROM users WHERE username='$user'";
$result_user = $conn->query($sql_user);

if ($result_user->num_rows > 0) {
    $row_user = $result_user->fetch_assoc();
    $name = $row_user['name'];
    $email = $row_user['email'];
    $phone = $row_user['phone_number'];
    $username = $row_user['username'];
}
// Get booking history
$sql_booking = "SELECT * FROM bookings WHERE email = '$email' OR phone_number = '$phone'";

$result_booking = $conn->query($sql_booking);
$booking_count = $result_booking->num_rows;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="profile.css">
    <style>

body {
            font-family: Arial, sans-serif;
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 60%;
          
            max-height: 80vh; /* Adjusted to make the container responsive */
            margin: auto;
            background-image: url('IMG/pr.png');
            background-color: rgba(255, 255, 255, 0.9);
            background-repeat: repeat; /* Semi-transparent white background */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow-y: auto; /* Enables vertical scrolling */
        }

        .profile-icon {
            width: 100px;
            height: 100px;
            background-image: url('IMG/pro.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            border-radius: 50%;
            margin: 0 auto 20px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        p {
            text-align: left;
            margin-left: 22%;
            color: #666;
        }

        ul {
            margin-left: 35px;
            list-style-type: none;
            padding: 0;
        }

        li {
            width: 60%;
            margin-left: 18%;
            margin-bottom: 10px;
            padding: 10px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }


    </style>
</head>
<body>
    <div class="container">
        <h2>User Profile</h2>
        <div>
            <p><strong>Name:</strong> <?php echo $name; ?></p>
            <p><strong>Email:</strong> <?php echo $email; ?></p>
            <p><strong>Phone Number:</strong> <?php echo $phone; ?></p>
            <p><strong>Username:</strong> <?php echo $username; ?></p>
            <p><strong>Booking History:</strong></p>
            <ul>
                <?php
                if ($booking_count > 0) {
                    while ($row_booking = $result_booking->fetch_assoc()) {
                        $package = $row_booking['package_name'];
                        $destination = $row_booking['destination'];
                        $date = $row_booking['timestamp']; // Assuming there's a 'date' field in the 'bookings' table
                        echo "<li>Package: $package, Destination: $destination, Date: $date</li>";
                    }
                } else {
                    echo "<li>No bookings history found.</li>";
                }
                ?>
            </ul>
            <p><strong>Total Lifetime Bookings:</strong> <?php echo $booking_count; ?></p>
        </div>
        <a href="index.html">Logout</a>
    </div>
</body>
</html>


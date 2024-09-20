<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="login.css">
    <style>
        #a {
            background-color: rgb(143, 226, 134);
            border-radius: 5px;
            text-align: center;
            padding-top: 10px;
            height: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Sign Up</h2>

        <?php
       
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

            // Get form data
            $name = $_POST['name'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $user = $_POST['username'];
            $pass = $_POST['password'];

            // Insert data into database
            $sql = "INSERT INTO users (name, email, phone_number, username, password) VALUES ('$name', '$email', '$phone', '$user', '$pass')";

            if ($conn->query($sql) === TRUE) {
                $_SESSION['username'] = $user;
                echo "Registration successful!";
                echo "<script>setTimeout(function() { window.location.href = 'login.php'; }, 2000);</script>";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
       
            header("Location: login.php");
            exit();
            $conn->close();
        }
        ?>

        <form action="signup.php" method="POST">
            <input type="text" name="name" placeholder="Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="tel" name="phone" placeholder="Phone Number" required>
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" value="Sign Up">
        </form>
        <p id="a">Already have an account? <a href="login.php">Log in here</a>.</p>
    </div>
</body>
</html>

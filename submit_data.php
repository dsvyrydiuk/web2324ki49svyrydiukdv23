<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "feedback";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = $_POST['name'];
$age = (int) $_POST['age'];
$response = $_POST['response'];
$rating = (int) $_POST['rating'];

// Підготовка SQL
$sql = "INSERT INTO feedback (name, age, response, rating) VALUES (?, ?, ?, ?)";

// Підготовка заяви
if ($stmt = $conn->prepare($sql)) {


    $stmt->bind_param("sisi", $name, $age, $response, $rating);
    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();

    
} else {

    echo "Error preparing statement: " . $conn->error;
}

$conn->close();


?>

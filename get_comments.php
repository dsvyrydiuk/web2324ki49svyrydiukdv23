<?php
// Параметри для з’єднання
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "feedback";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL-запит --- feedback
$sql = "SELECT * FROM feedback";

$result = $conn->query($sql);

$comments = array();

while ($row = $result->fetch_assoc()) {
    $comment = array(
        "name" => $row['name'],
        "age" => $row['age'],
        "response" => $row['response'],
        "rating" => $row['rating'],
        "date" => $row['date']
    );
    $comments[] = $comment;
}
echo json_encode($comments);
$conn->close();


?>

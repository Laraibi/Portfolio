<?php
// echo "hello world";
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Origin: *");
$rp = json_decode(file_get_contents('php://input'), true);
$name = htmlspecialchars($rp['Name']);
$email = htmlspecialchars($rp['Email']);
$subject = htmlspecialchars($rp['Subject']);
$message = htmlspecialchars($rp['Message']);
$query = "INSERT INTO contacts (name,email,subject,message,created_at) VALUES (?,?,?,?,NOW())";

$servername = "localhost";
$username = "devloppe";
$password = "zyfiofqu";
$dbname = "devloppe_portfollio_db";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare($query);
$stmt->bind_param(
    "ssss",
    $name,
    $email,
    $subject,
    $message
);
$stmt->execute();
$rowsCount = $stmt->affected_rows;
$stmt->close();
mysqli_close($conn);

echo json_encode(array("rowCount" => $rowsCount));

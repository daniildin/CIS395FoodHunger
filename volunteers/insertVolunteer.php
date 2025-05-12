<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include '../db.php';

$volunteer_id = $_POST['volunteer_id'];
$name = $_POST['name'];
$email = $_POST['email'];
$notes = $_POST['notes'];

echo '<!DOCTYPE html><html lang="en"><head>
<link href="../css/bootstrap.min.css" rel="stylesheet">
</head><body class="p-4 bg-light">';

if (!preg_match('/^\d{8}$/', $volunteer_id)) {
    echo '<div class="alert alert-danger shadow"><strong>Error:</strong> Volunteer ID must be exactly 8 digits.</div>';
    echo '</body></html>';
    exit;
}

if (!preg_match("/^[a-zA-Z\s.'-]{2,100}$/", $name)) {
    echo '<div class="alert alert-danger shadow"><strong>Error:</strong> Name must contain only letters, spaces, and basic punctuation (2–100 characters).</div>';
    echo '</body></html>';
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo '<div class="alert alert-danger shadow"><strong>Error:</strong> Invalid email format.</div>';
    echo '</body></html>';
    exit;
}

$checkID = $conn->prepare("SELECT volunteer_id FROM volunteers WHERE volunteer_id = ?");
$checkID->bind_param("s", $volunteer_id);
$checkID->execute();
$checkID->store_result();
if ($checkID->num_rows > 0) {
    echo '<div class="alert alert-danger shadow"><strong>Error:</strong> Volunteer ID already exists.</div>';
    echo '</body></html>';
    $checkID->close();
    exit;
}
$checkID->close();

$checkEmail = $conn->prepare("SELECT email FROM volunteers WHERE email = ?");
$checkEmail->bind_param("s", $email);
$checkEmail->execute();
$checkEmail->store_result();
if ($checkEmail->num_rows > 0) {
    echo '<div class="alert alert-danger shadow"><strong>Error:</strong> This email is already used by another volunteer.</div>';
    echo '</body></html>';
    $checkEmail->close();
    exit;
}
$checkEmail->close();

$stmt = $conn->prepare("INSERT INTO volunteers (volunteer_id, name, email, notes) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $volunteer_id, $name, $email, $notes);

if ($stmt->execute()) {
    echo '<div class="alert alert-success shadow"><strong>Success!</strong> Volunteer added successfully.</div>';
} else {
    echo '<div class="alert alert-danger shadow"><strong>Database Error:</strong> ' . $stmt->error . '</div>';
}

$stmt->close();
$conn->close();

echo '</body></html>';
?>


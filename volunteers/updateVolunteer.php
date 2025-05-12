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
    echo '<div class="alert alert-danger shadow"><strong>Error:</strong> Name must be 2–100 characters, letters, and basic punctuation only.</div>';
    echo '</body></html>';
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo '<div class="alert alert-danger shadow"><strong>Error:</strong> Invalid email format.</div>';
    echo '</body></html>';
    exit;
}

$check = $conn->prepare("SELECT volunteer_id FROM volunteers WHERE volunteer_id = ?");
$check->bind_param("s", $volunteer_id);
$check->execute();
$check->store_result();
if ($check->num_rows === 0) {
    echo '<div class="alert alert-danger shadow"><strong>Error:</strong> Volunteer ID does not exist.</div>';
    echo '</body></html>';
    $check->close();
    exit;
}
$check->close();

$checkEmail = $conn->prepare("SELECT volunteer_id FROM volunteers WHERE email = ? AND volunteer_id != ?");
$checkEmail->bind_param("ss", $email, $volunteer_id);
$checkEmail->execute();
$checkEmail->store_result();
if ($checkEmail->num_rows > 0) {
    echo '<div class="alert alert-danger shadow"><strong>Error:</strong> Email is already used by another volunteer.</div>';
    echo '</body></html>';
    $checkEmail->close();
    exit;
}
$checkEmail->close();

$stmt = $conn->prepare("UPDATE volunteers SET name = ?, email = ?, notes = ? WHERE volunteer_id = ?");
$stmt->bind_param("ssss", $name, $email, $notes, $volunteer_id);

if ($stmt->execute()) {
    echo '<div class="alert alert-success shadow"><strong>Success!</strong> Volunteer updated successfully.</div>';
} else {
    echo '<div class="alert alert-danger shadow"><strong>Database Error:</strong> ' . $stmt->error . '</div>';
}

$stmt->close();
$conn->close();
echo '</body></html>';
?>

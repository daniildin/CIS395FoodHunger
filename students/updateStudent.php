<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include '../db.php';

$student_id = $_POST['student_id'];
$full_name = $_POST['full_name'];
$email = $_POST['email'];
$status = $_POST['status'];
$approved = $_POST['approved'];

echo '<!DOCTYPE html><html lang="en"><head>
<link href="../css/bootstrap.min.css" rel="stylesheet">
</head><body class="p-4 bg-light">';

if (!preg_match('/^\d{8}$/', $student_id)) {
    echo '<div class="alert alert-danger shadow"><strong>Error:</strong> Student ID must be exactly 8 digits.</div>';
    echo '</body></html>';
    exit;
}

if (!preg_match("/^[a-zA-Z\s.'-]{2,100}$/", $full_name)) {
    echo '<div class="alert alert-danger shadow"><strong>Error:</strong> Full name must contain only letters, spaces, and basic punctuation (2–100 characters).</div>';
    echo '</body></html>';
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo '<div class="alert alert-danger shadow"><strong>Error:</strong> Invalid email format.</div>';
    echo '</body></html>';
    exit;
}

$check = $conn->prepare("SELECT * FROM students WHERE student_id = ?");
$check->bind_param("i", $student_id);
$check->execute();
$result = $check->get_result();

if ($result->num_rows === 0) {
    echo '<div class="alert alert-danger shadow"><strong>Error:</strong> Student ID does not exist in the database.</div>';
    echo '</body></html>';
    $check->close();
    exit;
}
$check->close();

$dup = $conn->prepare("SELECT * FROM students WHERE email = ? AND student_id != ?");
$dup->bind_param("si", $email, $student_id);
$dup->execute();
$dupResult = $dup->get_result();

if ($dupResult->num_rows > 0) {
    echo '<div class="alert alert-danger shadow"><strong>Error:</strong> Email already in use by another student.</div>';
    echo '</body></html>';
    $dup->close();
    exit;
}


$stmt = $conn->prepare("UPDATE students SET full_name = ?, email = ?, status = ?, approved = ? WHERE student_id = ?");
$stmt->bind_param("ssssi", $full_name, $email, $status, $approved, $student_id);

if ($stmt->execute()) {
    echo '<div class="alert alert-success shadow"><strong>Success!</strong> Student updated successfully.</div>';
} else {
    echo '<div class="alert alert-danger shadow"><strong>Error:</strong> ' . $stmt->error . '</div>';
}

$stmt->close();
$conn->close();
echo '</body></html>';
?>

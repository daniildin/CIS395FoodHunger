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

$check_email = "SELECT * FROM students WHERE email = '$email'";
$result = $conn->query($check_email);

if ($result && $result->num_rows > 0) {
    echo '<div class="alert alert-danger shadow"><strong>Error:</strong> This email is already registered.</div>';
    echo '</body></html>';
    exit;
}

$sql = "INSERT INTO students (student_id, full_name, email, status, approved)
        VALUES ('$student_id', '$full_name', '$email', '$status', '$approved')";

if ($conn->query($sql) === TRUE) {
    echo '<div class="alert alert-success shadow"><strong>Success!</strong> Student successfully registered.</div>';
} else {
    echo '<div class="alert alert-danger shadow"><strong>Database Error:</strong> ' . $conn->error . '</div>';
}

echo '</body></html>';
?>

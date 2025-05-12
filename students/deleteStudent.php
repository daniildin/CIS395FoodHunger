<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include '../db.php';

$action = $_POST['action'] ?? 'delete_single';

// Set redirect target
$redirectUrl = 'displayStudents.php';
echo '<!DOCTYPE html><html lang="en"><head>
<meta http-equiv="refresh" content="3;url=' . $redirectUrl . '">
<link href="../css/bootstrap.min.css" rel="stylesheet">
</head><body class="p-4 bg-light">';

if ($action === 'delete_all') {
    $stmt = $conn->prepare("DELETE FROM students");
    if ($stmt->execute()) {
        echo '<div class="alert alert-success shadow"><strong>Success!</strong> All students deleted successfully. Redirecting...</div>';
    } else {
        echo '<div class="alert alert-danger shadow"><strong>Database Error:</strong> ' . $stmt->error . '</div>';
    }
    $stmt->close();
} else {
    $student_id = $_POST['student_id'];

    if (!preg_match('/^\d{8}$/', $student_id)) {
        echo '<div class="alert alert-danger shadow"><strong>Error:</strong> Student ID must be exactly 8 digits.</div></body></html>';
        exit;
    }

    $check = $conn->prepare("SELECT student_id FROM students WHERE student_id = ?");
    $check->bind_param("s", $student_id);
    $check->execute();
    $check->store_result();

    if ($check->num_rows === 0) {
        echo '<div class="alert alert-danger shadow"><strong>Error:</strong> No student found with this ID.</div></body></html>';
        $check->close();
        $conn->close();
        exit;
    }
    $check->close();

    $stmt = $conn->prepare("DELETE FROM students WHERE student_id = ?");
    $stmt->bind_param("s", $student_id);

    if ($stmt->execute()) {
        echo '<div class="alert alert-success shadow"><strong>Success!</strong> Student deleted successfully. Redirecting...</div>';
    } else {
        echo '<div class="alert alert-danger shadow"><strong>Database Error:</strong> ' . $stmt->error . '</div>';
    }
    $stmt->close();
}

$conn->close();
echo '</body></html>';
?>

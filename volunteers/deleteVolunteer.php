<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include '../db.php';

$action = $_POST['action'] ?? 'delete_single';

$redirectUrl = 'displayVolunteers.php';
echo '<!DOCTYPE html><html lang="en"><head>
<meta http-equiv="refresh" content="3;url=' . $redirectUrl . '">
<link href="../css/bootstrap.min.css" rel="stylesheet">
</head><body class="p-4 bg-light">';

if ($action === 'delete_all') {
    $stmt = $conn->prepare("DELETE FROM volunteers");
    if ($stmt->execute()) {
        echo '<div class="alert alert-success shadow"><strong>Success!</strong> All volunteers deleted successfully. Redirecting...</div>';
    } else {
        echo '<div class="alert alert-danger shadow"><strong>Database Error:</strong> ' . $stmt->error . '</div>';
    }
    $stmt->close();
} else {
    $volunteer_id = $_POST['volunteer_id'] ?? '';

    if (trim($volunteer_id) === '') {
        echo '<div class="alert alert-danger shadow"><strong>Error:</strong> Volunteer ID field cannot be empty. Redirecting...</div>';
        echo '</body></html>';
        exit;
    }

    if (!preg_match('/^\d{8}$/', $volunteer_id)) {
        echo '<div class="alert alert-danger shadow"><strong>Error:</strong> Volunteer ID must be exactly 8 digits. Redirecting...</div>';
        echo '</body></html>';
        exit;
    }

    $check = $conn->prepare("SELECT volunteer_id FROM volunteers WHERE volunteer_id = ?");
    $check->bind_param("s", $volunteer_id);
    $check->execute();
    $check->store_result();

    if ($check->num_rows === 0) {
        echo '<div class="alert alert-danger shadow"><strong>Error:</strong> Volunteer ID not found. Redirecting...</div>';
        echo '</body></html>';
        $check->close();
        exit;
    }
    $check->close();

    $stmt = $conn->prepare("DELETE FROM volunteers WHERE volunteer_id = ?");
    $stmt->bind_param("s", $volunteer_id);

    if ($stmt->execute()) {
        echo '<div class="alert alert-success shadow"><strong>Success!</strong> Volunteer deleted successfully. Redirecting...</div>';
    } else {
        echo '<div class="alert alert-danger shadow"><strong>Database Error:</strong> ' . $stmt->error . '</div>';
    }
    $stmt->close();
}

$conn->close();
echo '</body></html>';
?>
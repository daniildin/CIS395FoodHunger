<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include '../db.php';

$action = $_POST['action'] ?? 'delete_single';

echo '<!DOCTYPE html><html lang="en"><head>
<meta http-equiv="refresh" content="3;url=displayMeals.php">
<link href="../css/bootstrap.min.css" rel="stylesheet">
</head><body class="p-4 bg-light">';

if ($action === 'delete_all') {
    $stmt = $conn->prepare("DELETE FROM meals");
    if ($stmt->execute()) {
        echo '<div class="alert alert-success shadow"><strong>Success!</strong> All meals deleted successfully. Redirecting...</div>';
    } else {
        echo '<div class="alert alert-danger shadow"><strong>Database Error:</strong> ' . $stmt->error . '</div>';
    }
    $stmt->close();
} else {
    $meal_id = $_POST['meal_id'];

    if (!preg_match('/^\d+$/', $meal_id)) {
        echo '<div class="alert alert-danger shadow"><strong>Error:</strong> Meal ID must be a valid number.</div></body></html>';
        exit;
    }

    $check = $conn->prepare("SELECT meal_id FROM meals WHERE meal_id = ?");
    $check->bind_param("i", $meal_id);
    $check->execute();
    $check->store_result();

    if ($check->num_rows === 0) {
        echo '<div class="alert alert-danger shadow"><strong>Error:</strong> Meal ID does not exist.</div></body></html>';
        $check->close();
        $conn->close();
        exit;
    }
    $check->close();

    $stmt = $conn->prepare("DELETE FROM meals WHERE meal_id = ?");
    $stmt->bind_param("i", $meal_id);

    if ($stmt->execute()) {
        echo '<div class="alert alert-success shadow"><strong>Success!</strong> Meal deleted successfully. Redirecting...</div>';
    } else {
        echo '<div class="alert alert-danger shadow"><strong>Database Error:</strong> ' . $stmt->error . '</div>';
    }
    $stmt->close();
}

$conn->close();
echo '</body></html>';
?>

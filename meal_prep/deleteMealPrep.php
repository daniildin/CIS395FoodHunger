<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include '../db.php';

$action = $_POST['action'] ?? '';
$prep_id = $_POST['prep_id'] ?? '';

$message = '';
$type = '';

if ($action === 'delete_all') {
    $sql = "DELETE FROM meal_prep";
    if ($conn->query($sql)) {
        $message = "All meal prep entries deleted.";
        $type = "success";
    } else {
        $message = "Database Error: " . $conn->error;
        $type = "danger";
    }
} elseif ($action === 'delete_single') {
    if (!preg_match('/^\d+$/', $prep_id)) {
        $message = "Prep ID must be a valid number.";
        $type = "danger";
    } else {
        $check = $conn->prepare("SELECT prep_id FROM meal_prep WHERE prep_id = ?");
        $check->bind_param("i", $prep_id);
        $check->execute();
        $check->store_result();
        if ($check->num_rows === 0) {
            $message = "Prep ID does not exist.";
            $type = "danger";
        } else {
            $st mt = $conn->prepare("DELETE FROM meal_prep WHERE prep_id = ?");
            $stmt->bind_param("i", $prep_id);
            if ($stmt->execute()) {
                $message = "Meal prep entry deleted.";
                $type = "success";
            } else {
                $message = "Database Error: " . $stmt->error;
                $type = "danger";
            }
            $stmt->close();
        }
        $check->close();
    }
} else {
    $message = "Invalid action.";
    $type = "danger";
}

$conn->close();

// HTML output with redirect
echo <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <meta http-equiv="refresh" content="3;url=displayMealPrep.php">
</head>
<body class="p-4 bg-light">
    <div class="alert alert-$type shadow">
        <strong>$message</strong><br>
        Redirecting to Meal Prep Logs...
    </div>
</body>
</html>
HTML;

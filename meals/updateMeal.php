<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include '../db.php';

$meal_id = $_POST['meal_id'];
$meal_type = trim($_POST['meal_type']);
$ingredients = trim($_POST['ingredients']);
$meal_day = trim($_POST['meal_day']);
$pickup_location = trim($_POST['pickup_location']);

echo '<!DOCTYPE html><html lang="en"><head>
<link href="../css/bootstrap.min.css" rel="stylesheet">
</head><body class="p-4 bg-light">';


if (!preg_match('/^\d+$/', $meal_id)) {
    echo '<div class="alert alert-danger shadow"><strong>Error:</strong> Invalid Meal ID format.</div>';
    echo '</body></html>';
    exit;
}

if (strlen($meal_type) < 2 || strlen($meal_type) > 100) {
    echo '<div class="alert alert-danger shadow"><strong>Error:</strong> Meal type must be 2–100 characters.</div>';
    echo '</body></html>';
    exit;
}

if (strlen($ingredients) < 2 || strlen($ingredients) > 255) {
    echo '<div class="alert alert-danger shadow"><strong>Error:</strong> Ingredients must be 2–255 characters.</div>';
    echo '</body></html>';
    exit;
}

if (!in_array($meal_day, ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'])) {
    echo '<div class="alert alert-danger shadow"><strong>Error:</strong> Invalid meal day.</div>';
    echo '</body></html>';
    exit;
}

if (strlen($pickup_location) < 2 || strlen($pickup_location) > 100) {
    echo '<div class="alert alert-danger shadow"><strong>Error:</strong> Pickup location must be 2–100 characters.</div>';
    echo '</body></html>';
    exit;
}


$check = $conn->prepare("SELECT meal_id FROM meals WHERE meal_id = ?");
$check->bind_param("i", $meal_id);
$check->execute();
$check->store_result();

if ($check->num_rows === 0) {
    echo '<div class="alert alert-danger shadow"><strong>Error:</strong> Meal ID does not exist.</div>';
    echo '</body></html>';
    $check->close();
    $conn->close();
    exit;
}
$check->close();


$stmt = $conn->prepare("UPDATE meals SET meal_type=?, ingredients=?, meal_day=?, pickup_location=? WHERE meal_id=?");
$stmt->bind_param("ssssi", $meal_type, $ingredients, $meal_day, $pickup_location, $meal_id);

if ($stmt->execute()) {
    echo '<div class="alert alert-success shadow"><strong>Success!</strong> Meal updated successfully.</div>';
} else {
    echo '<div class="alert alert-danger shadow"><strong>Database Error:</strong> ' . $stmt->error . '</div>';
}

$stmt->close();
$conn->close();
echo '</body></html>';
?>

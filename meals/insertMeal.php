<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include '../db.php';

$meal_type = trim($_POST['meal_type']);
$ingredients = trim($_POST['ingredients']);
$meal_day = trim($_POST['meal_day']);
$pickup_location = trim($_POST['pickup_location']);

echo '<!DOCTYPE html><html lang="en"><head>
<link href="../css/bootstrap.min.css" rel="stylesheet">
</head><body class="p-4 bg-light">';

// Validate inputs
if (strlen($meal_type) < 2 || strlen($meal_type) > 100) {
    echo '<div class="alert alert-danger shadow"><strong>Error:</strong> Meal type must be between 2 and 100 characters.</div>';
    echo '</body></html>';
    exit;
}

if (strlen($ingredients) < 2 || strlen($ingredients) > 255) {
    echo '<div class="alert alert-danger shadow"><strong>Error:</strong> Ingredients must be between 2 and 255 characters.</div>';
    echo '</body></html>';
    exit;
}

if (!in_array($meal_day, ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'])) {
    echo '<div class="alert alert-danger shadow"><strong>Error:</strong> Invalid day selected.</div>';
    echo '</body></html>';
    exit;
}

if (strlen($pickup_location) < 2 || strlen($pickup_location) > 100) {
    echo '<div class="alert alert-danger shadow"><strong>Error:</strong> Pickup location must be between 2 and 100 characters.</div>';
    echo '</body></html>';
    exit;
}

// Insert meal
$stmt = $conn->prepare("INSERT INTO meals (meal_type, ingredients, meal_day, pickup_location) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $meal_type, $ingredients, $meal_day, $pickup_location);

if ($stmt->execute()) {
    echo '<div class="alert alert-success shadow"><strong>Success!</strong> Meal added successfully.</div>';
} else {
    echo '<div class="alert alert-danger shadow"><strong>Database Error:</strong> ' . $stmt->error . '</div>';
}

$stmt->close();
$conn->close();
echo '</body></html>';
?>

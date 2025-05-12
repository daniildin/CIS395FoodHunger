<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include '../db.php';

$meal_id = $_POST['meal_id'];
$volunteer_id = $_POST['volunteer_id'];
$prep_date = $_POST['prep_date'];

echo '<!DOCTYPE html><html lang="en"><head>
<link href="../css/bootstrap.min.css" rel="stylesheet">
</head><body class="p-4 bg-light">';

if (!preg_match('/^\d+$/', $meal_id)) {
    echo '<div class="alert alert-danger shadow"><strong>Error:</strong> Meal ID must be numeric.</div></body></html>'; exit;
}
if (!preg_match('/^\d{8}$/', $volunteer_id)) {
    echo '<div class="alert alert-danger shadow"><strong>Error:</strong> Volunteer ID must be exactly 8 digits.</div></body></html>'; exit;
}
if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $prep_date)) {
    echo '<div class="alert alert-danger shadow"><strong>Error:</strong> Invalid date format.</div></body></html>'; exit;
}

$checkMeal = $conn->prepare("SELECT meal_id FROM meals WHERE meal_id = ?");
$checkMeal->bind_param("i", $meal_id);
$checkMeal->execute();
$checkMeal->store_result();
if ($checkMeal->num_rows === 0) {
    echo '<div class="alert alert-danger shadow"><strong>Error:</strong> Meal ID does not exist.</div></body></html>'; exit;
}
$checkMeal->close();

$checkVol = $conn->prepare("SELECT volunteer_id FROM volunteers WHERE volunteer_id = ?");
$checkVol->bind_param("s", $volunteer_id);
$checkVol->execute();
$checkVol->store_result();
if ($checkVol->num_rows === 0) {
    echo '<div class="alert alert-danger shadow"><strong>Error:</strong> Volunteer ID does not exist.</div></body></html>'; exit;
}
$checkVol->close();

$stmt = $conn->prepare("INSERT INTO meal_prep (meal_id, volunteer_id, prep_date) VALUES (?, ?, ?)");
$stmt->bind_param("iss", $meal_id, $volunteer_id, $prep_date);

if ($stmt->execute()) {
    echo '<div class="alert alert-success shadow"><strong>Success!</strong> Meal prep entry added successfully.</div>';
} else {
    echo '<div class="alert alert-danger shadow"><strong>Database Error:</strong> ' . $stmt->error . '</div>';
}

$stmt->close();
$conn->close();
echo '</body></html>';
?>

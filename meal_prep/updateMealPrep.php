<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include '../db.php';

$prep_id = $_POST['prep_id'];
$meal_id = $_POST['meal_id'];
$volunteer_id = $_POST['volunteer_id'];
$prep_date = $_POST['prep_date'];

echo '<!DOCTYPE html><html lang="en"><head>
<link href="../css/bootstrap.min.css" rel="stylesheet">
</head><body class="p-4 bg-light">';

if (!preg_match('/^\d+$/', $prep_id)) {
    echo '<div class="alert alert-danger shadow"><strong>Error:</strong> Invalid Prep ID.</div></body></html>';
    exit;
}

$check = $conn->prepare("SELECT prep_id FROM meal_prep WHERE prep_id = ?");
$check->bind_param("i", $prep_id);
$check->execute();
$check->store_result();
if ($check->num_rows === 0) {
    echo '<div class="alert alert-danger shadow"><strong>Error:</strong> Meal Prep ID does not exist.</div></body></html>';
    $check->close();
    exit;
}
$check->close();

if (!empty($meal_id)) {
    $mealCheck = $conn->prepare("SELECT meal_id FROM meals WHERE meal_id = ?");
    $mealCheck->bind_param("i", $meal_id);
    $mealCheck->execute();
    $mealCheck->store_result();
    if ($mealCheck->num_rows === 0) {
        echo '<div class="alert alert-danger shadow"><strong>Error:</strong> Meal ID does not exist.</div></body></html>';
        $mealCheck->close();
        exit;
    }
    $mealCheck->close();
}

if (!empty($volunteer_id)) {
    $volCheck = $conn->prepare("SELECT volunteer_id FROM volunteers WHERE volunteer_id = ?");
    $volCheck->bind_param("i", $volunteer_id);
    $volCheck->execute();
    $volCheck->store_result();
    if ($volCheck->num_rows === 0) {
        echo '<div class="alert alert-danger shadow"><strong>Error:</strong> Volunteer ID does not exist.</div></body></html>';
        $volCheck->close();
        exit;
    }
    $volCheck->close();
}

$updateFields = [];
$params = [];
$types = '';

if (!empty($meal_id)) {
    $updateFields[] = "meal_id = ?";
    $params[] = $meal_id;
    $types .= 'i';
}
if (!empty($volunteer_id)) {
    $updateFields[] = "volunteer_id = ?";
    $params[] = $volunteer_id;
    $types .= 'i';
}
if (!empty($prep_date)) {
    $updateFields[] = "prep_date = ?";
    $params[] = $prep_date;
    $types .= 's';
}

if (empty($updateFields)) {
    echo '<div class="alert alert-warning shadow"><strong>Notice:</strong> No fields to update.</div></body></html>';
    exit;
}

$sql = "UPDATE meal_prep SET " . implode(', ', $updateFields) . " WHERE prep_id = ?";
$params[] = $prep_id;
$types .= 'i';

$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);

if ($stmt->execute()) {
    echo '<div class="alert alert-success shadow"><strong>Success!</strong> Meal prep entry updated.</div>';
} else {
    echo '<div class="alert alert-danger shadow"><strong>Database Error:</strong> ' . $stmt->error . '</div>';
}

$stmt->close();
$conn->close();
echo '</body></html>';
?>

<?php
// criteria_form.php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $criteria = [
        'Max Classes Per Day Professor' => (int)$_POST['professor_max_classes_per_day'] ?? 1,
        'Max Classes Per Week Professor' => (int)$_POST['professor_max_classes_per_week'] ?? 6,
        'Max Classes Per Day Associate' => (int)$_POST['associate_max_classes_per_day'] ?? 2,
        'Max Classes Per Week Associate' => (int)$_POST['associate_max_classes_per_week'] ?? 12,
        'Max Classes Per Day Assistant' => (int)$_POST['assistant_max_classes_per_day'] ?? 2,
        'Max Classes Per Week Assistant' => (int)$_POST['assistant_max_classes_per_week'] ?? 12,
    ];

    // Save criteria to a session or database
    session_start();
    $_SESSION['criteria'] = $criteria;

    echo "Criteria updated successfully!";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Enter Criteria</title>
</head>
<body>
    <form method="post">
        <h3>Criteria for Timetable Generation</h3>
        <label>Max Classes Per Day (Professor):</label>
        <input type="number" name="professor_max_classes_per_day" value="1" required><br>

        <label>Max Classes Per Week (Professor):</label>
        <input type="number" name="professor_max_classes_per_week" value="6" required><br>

        <label>Max Classes Per Day (Associate Professor):</label>
        <input type="number" name="associate_max_classes_per_day" value="2" required><br>

        <label>Max Classes Per Week (Associate Professor):</label>
        <input type="number" name="associate_max_classes_per_week" value="12" required><br>

        <label>Max Classes Per Day (Assistant Professor):</label>
        <input type="number" name="assistant_max_classes_per_day" value="2" required><br>

        <label>Max Classes Per Week (Assistant Professor):</label>
        <input type="number" name="assistant_max_classes_per_week" value="12" required><br>

        <button type="submit">Save Criteria</button>
    </form>
</body>
</html>
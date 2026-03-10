<?php
include "db.php";
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Fetch batch details
if (isset($_GET['id'])) {
    $batch_id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM batch WHERE id = ?");
    $stmt->bind_param("i", $batch_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $batch = $result->fetch_assoc();
    $stmt->close();

    if (!$batch) {
        die("Batch not found.");
    }
} else {
    die("Invalid request.");
}

// Update batch details
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_batch'])) {
    $batch_name = $_POST['batch_name'];

    // Check for duplicate batch name excluding the current batch
    $check_stmt = $conn->prepare("SELECT * FROM batch WHERE name = ? AND id != ?");
    $check_stmt->bind_param("si", $batch_name, $batch_id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows > 0) {
        $error_message = "Batch with this name already exists.";
    } else {
        // Update batch name if no duplicate found
        try {
            $update_stmt = $conn->prepare("UPDATE batch SET name = ? WHERE id = ?");
            $update_stmt->bind_param("si", $batch_name, $batch_id);
            $update_stmt->execute();
            $update_stmt->close();

            // Redirect to batch management page
            header("Location: batches.php");
            exit();
        } catch (mysqli_sql_exception $e) {
            $error_message = "An error occurred: " . $e->getMessage();
        }
    }
    $check_stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Batch</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background: #f4f4f9 url('image.jpg') no-repeat center center fixed;
            background-size: cover;
        }

        .container {
            width: 90%;
            margin: 0 auto;
            max-width: 600px;
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            margin-top: 50px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form input, form button {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ddd;
            box-sizing: border-box;
        }

        form button {
            background-color: #007BFF;
            color: #fff;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        form button:hover {
            background-color: #0056b3;
        }

        .error-message {
            padding: 10px;
            background-color: #f8d7da;
            color: #721c24;
            border-radius: 5px;
            margin-bottom: 20px;
            font-weight: 500;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Edit Batch</h1>

    <!-- Display error message -->
    <?php if (isset($error_message)): ?>
        <div class="error-message"><?= htmlspecialchars($error_message) ?></div>
    <?php endif; ?>

    <!-- Edit Batch Form -->
    <form method="POST">
        <input type="text" name="batch_name" value="<?= htmlspecialchars($batch['name']) ?>" required>
        <button type="submit" name="update_batch">Update Batch</button>
    </form>
</div>
</body>
</html>

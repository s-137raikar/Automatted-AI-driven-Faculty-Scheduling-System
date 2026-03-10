<?php
include "db.php";
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Add Batch
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_batch'])) {
    $batch_id = $_POST['batch_ID'];
    $batch_name = $_POST['batch_name'];

    // Check for duplicate batch name
    $check_stmt = $conn->prepare("SELECT * FROM batch WHERE name = ?");
    $check_stmt->bind_param("s", $batch_name);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows > 0) {
        // Duplicate entry found
        $error_message = "Batch with this name already exists.";
    } else {
        // Insert new batch if no duplicate found
        $stmt = $conn->prepare("INSERT INTO batch (ID ,name) VALUES (?,?)");
        $stmt->bind_param("is", $ID ,$batch_name);
        $stmt->execute();
        $stmt->close();

        // Redirect to batch.php
        header("Location: batches.php");
        exit();
    }
    $check_stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Batch Management System</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background: #f4f4f9 url('im1.jpg') no-repeat center center fixed;
            background-size: cover;
        }

        .container {
            width: 90%;
            margin: 0 auto;
            max-width: 1200px;
        }

        header {
            display: flex;
            justify-content: space-between;
            margin: 20px 0;
        }

        h1 {
            color: #fff;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
        }

        a.logout {
            display: flex;
            align-items: center;
            color: #fff;
            background-color: #ff5722;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
        }

        form {
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            margin-bottom: 20px;
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
    <header>
        <h1>Batch Management System</h1>
        <a href="logout.php" class="logout">Logout</a>
    </header>

    <!-- Display Error Message -->
    <?php if (isset($error_message)): ?>
        <div class="error-message"><?= htmlspecialchars($error_message) ?></div>
    <?php endif; ?>

    <!-- Add Batch Form -->
    <form method="POST">
    <input type="number" name="batch_ID" placeholder="Batch id" >
        <input type="text" name="batch_name" placeholder="Batch Name" required>
        <button type="submit" name="add_batch">Add Batch</button>
    </form>
</div>
</body>
</html>

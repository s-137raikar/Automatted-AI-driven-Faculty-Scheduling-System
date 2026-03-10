<?php
include "db.php";
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Add Faculty
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_faculty'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $role = $_POST['role'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];

    // Check for duplicate faculty number
    $check_stmt = $conn->prepare("SELECT * FROM faculty WHERE id = ?");
    $check_stmt->bind_param("i", $id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows > 0) {
        $error_message = "Faculty with this number already exists.";
    } else {
        // Insert new faculty if no duplicate found
        $stmt = $conn->prepare("INSERT INTO faculty (id, name, role, email, phone_number) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $id, $name, $role, $email, $phone_number);

        if ($stmt->execute()) {
            // Redirect to faculty.php after successful insertion
            header("Location: faculty.php");
            exit();
        } else {
            $error_message = "Failed to add faculty. SQL Error: " . $stmt->error;
        }
        $stmt->close();
    }
    $check_stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Faculty</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background:rgb(140, 140, 199) url('image.jpg') no-repeat center center fixed;
            background-size: cover;
            
        }
        .container {
            width: 90%;
            margin: 0 auto;
            max-width: 1200px;
        }
        header {
            margin: 20px 0;
        }
        h1 {
            color: #fff;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
        }
        form {
            background: rgba(90, 87, 87, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        form input, form select, form button {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ddd;
            box-sizing: border-box;
            background: rgba(176, 173, 173, 0.9);
        }
        form button {
            background-color:rgb(71, 79, 88);
            color: #fff;
            font-weight: 500;
            cursor: pointer;
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
        <h1>Add Faculty</h1>
    </header>

    <!-- Display Error Message -->
    <?php if (isset($error_message)): ?>
        <div class="error-message"><?= htmlspecialchars($error_message) ?></div>
    <?php endif; ?>

    <!-- Add Faculty Form -->
    <form method="POST">
        <input type="number" name="id" placeholder="Faculty Number" required>
        <input type="text" name="name" placeholder="Faculty Name" required>
        <select name="role" required>
            <option value="">Select Designation</option>
            <option value="HOD">HOD</option>
            <option value="Professor">Professor</option>
            <option value="Associate Professor">Associate Professor</option>
            <option value="Assistant Professor">Assistant Professor</option>
        </select>
        <input type="email" name="email" placeholder="Faculty Email" required>
        <input type="text" name="phone_number" placeholder="Phone Number">
        <button type="submit" name="add_faculty">Add Faculty</button>
    </form>
</div>
</body>
</html>

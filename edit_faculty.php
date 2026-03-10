<?php
include "db.php";
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Fetch faculty details for editing
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Use prepared statement to fetch faculty data
    $stmt = $conn->prepare("SELECT * FROM faculty WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $faculty = $result->fetch_assoc();

    if (!$faculty) {
        echo "<script>alert('Faculty not found!'); window.location.href='faculty.php';</script>";
        exit();
    }

    $stmt->close();
} else {
    header("Location: faculty.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $designation = $_POST['role'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];

    // Update faculty details using prepared statement
    $stmt = $conn->prepare("UPDATE faculty SET name = ?, role = ?, email = ?, phone_number = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $name, $designation, $email, $phone_number, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Faculty details updated successfully!'); window.location.href='admin.php';</script>";
    } else {
        echo "<script>alert('Failed to update faculty details.');</script>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Faculty</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background: #f4f4f9;
            background: url("image.jpg"), #000;
  background-position: center;
  background-size: cover;
        }
        .container {
            width: 90%;
            margin: 0 auto;
            max-width: 600px;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background: rgba(190, 178, 178, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        form {
            background: rgba(211, 172, 172, 0.9);
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
             background: rgba(176, 173, 173, 0.9);
            
        }
        form button {
            background-color: rgb(70, 95, 121);
            color: #fff;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Faculty</h1>
        <form method="POST">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($faculty['name']) ?>" required>

            <label for="role">Designation:</label>
            <select id="role" name="role" required>
                <option value="HOD" <?= $faculty['role'] === 'HOD' ? 'selected' : '' ?>>HOD</option>
                <option value="Professor" <?= $faculty['role'] === 'Professor' ? 'selected' : '' ?>>Professor</option>
                <option value="Associate Professor" <?= $faculty['role'] === 'Associate Professor' ? 'selected' : '' ?>>Associate Professor</option>
                <option value="Assistant Professor" <?= $faculty['role'] === 'Assistant Professor' ? 'selected' : '' ?>>Assistant Professor</option>
            </select>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($faculty['email']) ?>" required>

            <label for="phone_number">Phone Number:</label>
            <input type="text" id="phone_number" name="phone_number" value="<?= htmlspecialchars($faculty['phone_number']) ?>" required>

            <button type="submit">Update</button>
        </form>
    </div>
</body>
</html>

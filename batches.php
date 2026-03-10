<?php
include "db.php";
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Delete Batch
if (isset($_GET['delete_batch'])) {
    $id = $_GET['delete_batch'];
    $conn->query("DELETE FROM batch WHERE ID = $id");
}

// Update Batch
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_batch'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];

    $stmt = $conn->prepare("UPDATE batch SET name = ? WHERE ID = ?");
    $stmt->bind_param("si", $name, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Batch updated successfully!');</script>";
    } else {
        echo "<script>alert('Failed to update batch.');</script>";
    }
    $stmt->close();

    header("Location: batch.php");
    exit();
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
            background: url("image.jpg"), #000  no-repeat center center fixed;;
  background-position: center;
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
            align-items: center;
            margin: 20px 0;
        }
        h1 {
            color: #fff;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
        }
        nav {
            background: rgb(70, 95, 121);
            border-radius: 5px;
            overflow: hidden;
        }
        nav ul {
            display: flex;
            list-style: none;
            margin: 0;
            padding: 0;
        }
        nav ul li {
            flex: 1;
        }
        nav ul li a {
            display: block;
            text-align: center;
            padding: 15px;
            color: #fff;
            text-decoration: none;
            font-weight: bold;
        }
        nav ul li a:hover {
            background:rgb(110, 132, 155);
        }
        form, table {
            margin-top: 20px;
            background: rgba(255, 255, 255, 0.9);
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
        }
        form button {
            background-color: #007BFF;
            color: #fff;
            cursor: pointer;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table th, table td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        table th {
            background-color: rgb(70, 95, 121);
            color: #fff;
        }
        .action-btn {
            background-color: #28a745;
            color: white;
            padding: 6px 12px;
            text-decoration: none;
            border-radius: 5px;
        }
        .delete-btn {
            background-color: #dc3545;
            color: white;
            padding: 6px 12px;
            text-decoration: none;
            border-radius: 5px;
        }
        .delete-btn:hover {
            background-color: #c82333;
        }
        a:link, a:visited, a:hover, a:active {
  text-decoration: none;
}
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>BATCHES</h1>
        </header>

        <!-- Navigation Menu -->
        <nav>
            <ul>
                <li><a href="admin.php">Home</a></li>
                <li><a href="add-batch.php">Add Batch</a></li>
                <li><a href="login.php">Logout</a></li>
            </ul>
        </nav>

        <!-- Table to Display Batches -->
        <table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Batch Name</th>
            <th>Courses</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $result = $conn->query("SELECT * FROM batch");
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['ID']}</td>
                    <td>{$row['name']}</td>
                    <td>
                        <a href='course.php?batch_name=" . urlencode($row['name']) . "'>Manage Courses</a>
                    </td>
                    <td>
                       <a href='edit_batch.php?id=" . $row['id'] . "' class='action-btn'>Edit</a>

                        <a href='?delete_batch={$row['ID']}' class='delete-btn' onclick='return confirm(\"Are you sure you want to delete this batch?\")'>Delete</a>
                    </td>
                </tr>";
        }
        ?>
    </tbody>
</table>
    </div>
</body>
</html>

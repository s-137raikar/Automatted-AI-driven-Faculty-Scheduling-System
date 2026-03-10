<?php
include "db.php";
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['batch_name'])) {
    header("Location: batches.php");
    exit();
}
$batch_name = $_GET['batch_name'];


// Add Course
if (isset($_POST['add_course'])) {
    $course_code = $_POST['course_id'];
    $course_name = $_POST['course_name'];

    // Check if the Course Name is unique across all batches
    $check_name = $conn->prepare("SELECT * FROM courses WHERE course_name = ?");
    $check_name->bind_param("s", $course_name);
    $check_name->execute();
    $name_result = $check_name->get_result();

    if ($name_result->num_rows > 0) {
        echo "<script>alert('Course Name must be unique across all batches. Please choose a different name.');</script>";
    } else {
        // Insert the Course if the name is unique
        $stmt = $conn->prepare("INSERT INTO courses (batch_name, course_id, course_name) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $batch_name, $course_id, $course_name);
        $stmt->execute();
    }
}

// Delete Course
if (isset($_GET['delete_course'])) {
    $course_id = $_GET['delete_course'];
    $conn->query("DELETE FROM courses WHERE id = $course_id");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Courses</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        form {
            margin-bottom: 20px;
        }
        form input, form button {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th, table td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        table th {
            background: #007bff;
            color: #fff;
        }
        .delete-btn {
            color: red;
            text-decoration: none;
        }
        a:link, a:visited, a:hover, a:active {
         text-decoration: none;
        }
        .center-link {
    display: block; /* Makes it behave like a block element */
    text-align: center; /* Centers the text inside the block */
    margin: 20px auto; /* Centers the element horizontally and adds spacing */
    width: 200px; /* Sets a fixed width for the link */
    padding: 10px 15px; /* Adds padding inside the link */
    background-color: #007bff; /* Background color (blue) */
    color: #fff; /* Text color (white) */
    border: 2px solid #0056b3; /* Border color (darker blue) */
    border-radius: 5px; /* Rounds the corners */
    text-decoration: none; /* Removes underline */
    font-weight: bold; /* Makes the text bold */
    font-size: 16px; /* Adjusts the font size */
}

.center-link:hover {
    background-color: #0056b3; /* Darker blue on hover */
    color: #fff; /* Keeps text white on hover */
    border-color: #003d80; /* Darker border on hover */
    transition: 0.3s; /* Smooth transition effect */
}


    </style>
</head>
<body>
    <div class="container">
        <h1>Manage Courses for Batch #<?php echo $batch_name; ?></h1>
        <form method="POST">
            <input type="text" name="course_id" placeholder="Enter Course Code" required>
            <input type="text" name="course_name" placeholder="Enter Course Name" required>
            <button type="submit" name="add_course">Add Course</button>
        </form>
        <table>
            <thead>
                <tr>
                    <th>Course id</th>
                    <th>Course Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
               $batch_name = $conn->real_escape_string($_GET['batch_name']); // Use batch_name from the request
               $result = $conn->query("SELECT * FROM courses WHERE batch_name = '$batch_name'");
               while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['course_id']}</td>
                            <td>{$row['course_name']}</td>
                            <td>
                               <a href='?delete_batch=" . $row['id'] . "' class='delete-btn'>Delete</a>
                            </td>
                        </tr>";
                }
                ?>
            </tbody>
        </table>
        <a href="batches.php" class="center-link">Batches</a>
        </div>
</body>
</html>

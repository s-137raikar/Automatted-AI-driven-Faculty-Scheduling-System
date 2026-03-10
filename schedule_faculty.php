<?php
include 'db.php';

// Fetch courses, sections, faculty, and subjects
$courses = $conn->query("SELECT id, name FROM courses");
$sections = $conn->query("SELECT id, name, semester FROM sections");
$faculty = $conn->query("SELECT id, name, role FROM faculty");
$subjects = $conn->query("SELECT id, name FROM subjects");

?>

<!DOCTYPE html>
<html>
<head>
    <title>Schedule Faculty</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background: url('https://via.placeholder.com/1920x1080') no-repeat center center fixed;
            background-size: cover;
            color: #fff;
        }
        h1 {
            text-align: center;
            margin-top: 30px;
            font-size: 2.5rem;
            color: #ffcc00;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
        }
        form {
            background-color: rgba(0, 0, 0, 0.8);
            border-radius: 10px;
            padding: 20px;
            width: 60%;
            margin: 20px auto;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }
        label {
            font-size: 1.1rem;
            font-weight: bold;
        }
        select, input[type="checkbox"] {
            margin: 10px 0;
            padding: 10px;
            width: 100%;
            border-radius: 5px;
            border: none;
            font-size: 1rem;
        }
        select {
            background-color: #333;
            color: #fff;
        }
        button {
            background-color: #ffcc00;
            color: #333;
            border: none;
            padding: 12px 25px;
            font-size: 1.2rem;
            border-radius: 5px;
            cursor: pointer;
            margin: 20px 0;
            width: 100%;
        }
        button:hover {
            background-color: #ffaa00;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            padding: 10px;
            text-align: center;
            border: 1px solid #555;
        }
        th {
            background-color: #444;
            color: #ffcc00;
        }
        td {
            background-color: #222;
        }
        hr {
            border: 1px solid #555;
            margin: 20px 0;
        }
        input[type="checkbox"] + label {
            display: inline-block;
            margin-left: 10px;
        }
        @media (max-width: 768px) {
            form {
                width: 90%;
            }
            h1 {
                font-size: 2rem;
            }
            button {
                font-size: 1rem;
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <h1>Schedule Faculty</h1>
    <form action="generate_timetable.php" method="POST">
        <label for="course">Select Course:</label>
        <select name="course_id" id="course" required>
            <option value="" disabled selected>--Select Course--</option>
            <?php while ($row = $courses->fetch_assoc()) { ?>
                <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
            <?php } ?>
        </select><br><hr>

        <label for="section">Select Section:</label>
        <select name="section_id" id="section" required>
            <option value="" disabled selected>--Select Section--</option>
            <?php while ($row = $sections->fetch_assoc()) { ?>
                <option value="<?= $row['id'] ?>"><?= $row['name'] ?> (Semester: <?= $row['semester'] ?>)</option>
            <?php } ?>
        </select><br><hr>

        <label for="faculty">Select Faculty:</label><br>
        <?php while ($row = $faculty->fetch_assoc()) { ?>
            <input type="checkbox" name="faculty_ids[]" value="<?= $row['id'] ?>" id="faculty_<?= $row['id'] ?>">
            <label for="faculty_<?= $row['id'] ?>"><?= $row['name'] ?> (<?= $row['role'] ?>)</label><br>
        <?php } ?><hr>

        <label for="subjects">Select Subjects:</label><br>
        <?php while ($row = $subjects->fetch_assoc()) { ?>
            <input type="checkbox" name="subject_ids[]" value="<?= $row['id'] ?>" id="subject_<?= $row['id'] ?>">
            <label for="subject_<?= $row['id'] ?>"><?= $row['name'] ?></label><br>
        <?php } ?><br><hr>

        <h3>Specify Number of Classes per Day:</h3>
        <table>
            <tr>
                <th>Day</th>
                <th>Number of Classes</th>
            </tr>
            <?php 
            $days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
            foreach ($days as $day) { ?>
                <tr>
                    <td><?= $day ?></td>
                    <td>
                        <select name="classes_per_day[<?= $day ?>]" required>
                            <option value="" disabled selected>--Select--</option>
                            <?php 
                            $max_classes = ($day === "Saturday") ? 3 : 7;
                            for ($i = 0; $i <= $max_classes; $i++) { ?>
                                <option value="<?= $i ?>"><?= $i ?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
            <?php } ?>
        </table>
        <br>

        <button type="submit">Schedule Timetable</button>
    </form>
</body>
</html
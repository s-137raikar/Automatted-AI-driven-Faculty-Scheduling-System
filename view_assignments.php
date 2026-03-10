<?php
include 'db.php';

// Fetch timetable data
$result = $conn->query("
    SELECT 
        s.day, 
        s.time_slot, 
        c.name AS course_name, 
        sec.name AS section_name, 
        sub.name AS subject_name, 
        f.name AS faculty_name 
    FROM schedule s
    JOIN courses c ON s.course_id = c.id
    JOIN sections sec ON s.section_id = sec.id
    JOIN subjects sub ON s.subject_id = sub.id
    JOIN faculty f ON s.faculty_id = f.id
    ORDER BY FIELD(s.day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'), s.time_slot
");

// Define days and time slots
$days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
$time_slots = [
    "Monday" => ["9:00-10:00", "10:00-11:00", "11:00-12:00", "12:00-1:00", "2:00-3:00", "3:00-4:00", "4:00-5:00"],
    "Tuesday" => ["9:00-10:00", "10:00-11:00", "11:00-12:00", "12:00-1:00", "2:00-3:00", "3:00-4:00", "4:00-5:00"],
    "Wednesday" => ["9:00-10:00", "10:00-11:00", "11:00-12:00", "12:00-1:00", "2:00-3:00", "3:00-4:00", "4:00-5:00"],
    "Thursday" => ["9:00-10:00", "10:00-11:00", "11:00-12:00", "12:00-1:00", "2:00-3:00", "3:00-4:00", "4:00-5:00"],
    "Friday" => ["9:00-10:00", "10:00-11:00", "11:00-12:00", "12:00-1:00", "2:00-3:00", "3:00-4:00", "4:00-5:00"],
    "Saturday" => ["9:00-10:00", "10:00-11:00", "11:00-12:00"]
];

// Initialize timetable matrix
$timetable = [];
foreach ($days as $day) {
    foreach ($time_slots[$day] as $time) {
        $timetable[$day][$time] = "No Class";
    }
}

// Populate timetable matrix with data from the database
while ($row = $result->fetch_assoc()) {
    $timetable[$row['day']][$row['time_slot']] = 
        "Course: " . $row['course_name'] . "<br>" .
        "Section: " . $row['section_name'] . "<br>" .
        "Subject: " . $row['subject_name'] . "<br>" .
        "Faculty: " . $row['faculty_name'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Weekly Timetable</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Weekly Timetable</h1>
    <table>
        <thead>
            <tr>
                <th>Day</th>
                <?php foreach ($time_slots["Monday"] as $time) { ?>
                    <th><?= $time ?></th>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($days as $day) { ?>
                <tr>
                    <td><?= $day ?></td>
                    <?php foreach ($time_slots[$day] as $time) { ?>
                        <td><?= $timetable[$day][$time] ?: "No Class" ?></td>
                    <?php } ?>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>
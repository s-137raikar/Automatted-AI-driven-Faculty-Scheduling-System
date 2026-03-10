<?php
include 'db.php';

// Function to check if a value exists in the specified table
function valueExists($conn, $table, $id) {
    $query = "SELECT COUNT(*) as count FROM $table WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    return $result['count'] > 0;
}

// Function to get maximum number of classes a faculty can handle per day
function getMaxClassesPerDay($conn, $faculty_id) {
    $stmt = $conn->prepare("SELECT max_classes_per_day FROM faculty WHERE id = ?");
    $stmt->bind_param("i", $faculty_id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    return $result['max_classes_per_day'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course_id = $_POST['course_id'];
    $section_id = $_POST['section_id'];
    $faculty_ids = $_POST['faculty_ids'];
    $subject_ids = $_POST['subject_ids'];
    $days_of_week = $_POST['days_of_week']; // Array of days and number of classes per day

    // Process each day and assign classes
    foreach ($days_of_week as $day => $num_classes) {
        // Ensure faculty can handle the number of classes specified
        $faculty_count = count($faculty_ids);
        $max_classes = 0;

        foreach ($faculty_ids as $faculty_id) {
            if (valueExists($conn, 'faculty', $faculty_id)) {
                $max_classes += getMaxClassesPerDay($conn, $faculty_id);
            }
        }

        // Check if total number of classes exceeds
        if ($max_classes < $num_classes) {
            die("Error: Number of classes exceeds the maximum limit for faculty.");
        }

        // Generate schedule for this day
        $time_slots = ['9:00-10:00', '10:00-11:00', '11:00-12:00'];
        if ($day != 'Saturday') {
            $time_slots = array_merge($time_slots, ['12:00-1:00', '2:00-3:00', '3:00-4:00', '4:00-5:00']);
        }

        for ($i = 0; $i < $num_classes; $i++) {
            $time_slot = $time_slots[$i];
            $subject_id = $subject_ids[array_rand($subject_ids)];
            $faculty_id = $faculty_ids[array_rand($faculty_ids)];

            // Ensure the selected faculty can handle the number of classes in this day
            if (!valueExists($conn, 'faculty', $faculty_id)) {
                die("Error: Invalid faculty ID.");
            }

            // Validate the number of classes for each faculty
            $assigned_classes = 0;
            foreach ($faculty_ids as $fid) {
                $assigned_classes += getMaxClassesPerDay($conn, $fid);
            }

            if ($assigned_classes > $num_classes) {
                die("Error: Faculty cannot handle the number of classes specified for this day.");
            }

            $stmt = $conn->prepare("INSERT INTO schedule (course_id, section_id, day, time_slot, subject_id, faculty_id) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("iissii", $course_id, $section_id, $day, $time_slot, $subject_id, $faculty_id);
            if (!$stmt->execute()) {
                die("Error: " . $stmt->error);
            }
        }
    }

    echo "Timetable generated successfully.";
}
?>
<?php
require 'config.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $group_id = $_POST['group_id'];
    $scores = $_POST['scores'];
    echo $group_id;

    // Fetch rubric criteria
    $rubric = $conn->query("SELECT criteria_demo3_id, weightage FROM criteria_demo3");
    $totalMarks = 0;
    $marksData = [];

    $index = 0;
    while ($rubricRow = $rubric->fetch_assoc()) {
        $criteria_id = $rubricRow['criteria_demo3_id'];
        $weightage = $rubricRow['weightage'];
        $score = isset($scores[$index]) ? (int)$scores[$index] : 0;

        // Calculate total per aspect
        $total = ($score / 4) * $weightage;
        $totalMarks += $total;

        // Store each row’s data
        $marksData[] = "($group_id, $criteria_id, $score, $total)";
        $index++;
        echo $criteria_id;
        echo $weightage;
        echo $score;
    }

    // Insert all scores
    if (!empty($marksData)) {
        $sql = "INSERT INTO panel_demo3_marks (group_id, criteria_id, score, total) VALUES " . implode(",", $marksData);
        if (!$conn->query($sql)) {
            echo "<script>alert('Error saving marks: " . $conn->error . "'); </script>";
            exit();
        }
    }

    // Insert Grand Total
    $insertTotal = $conn->prepare("INSERT INTO panel_demo3_total (group_id, grand_total) VALUES (?, ?) 
                                   ON DUPLICATE KEY UPDATE grand_total = VALUES(grand_total)");
    $insertTotal->bind_param("id", $group_id, $totalMarks);

    if ($insertTotal->execute()) {
        echo "<script>alert('Marks submitted successfully. Grand Total: $totalMarks'); window.location.href='panel_demo.php';</script>";
    } else {
        echo "<script>alert('Error saving total marks: " . $conn->error . "'); </script>";
    }

    $insertTotal->close();
}

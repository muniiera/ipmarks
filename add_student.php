<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $group_id = $_POST['group_id'];
    $matric_num = $_POST['matric_num'];
    $name = $_POST['name'];
    $project_title = $_POST['project_title'];
    $project_description = $_POST['project_description'];
    $track = $_POST['track'];
    $supervisor_id = $_POST['supervisor_id'];
    $semester_id = $_POST['semester_id'];
    $user_id = $_POST['user_id']; // Panel ID

    $stmt = $conn->prepare("INSERT INTO students (group_id, matric_num, name, project_title, project_description, track, supervisor_id, semester_id, user_id) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssssii", $group_id, $matric_num, $name, $project_title, $project_description, $track, $supervisor_id, $semester_id, $user_id);

    if ($stmt->execute()) {
        echo "<script>alert('Student added successfully'); window.location.href='dashboard.php';</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "'); window.location.href='dashboard.php';</script>";
    }
    $stmt->close();
}
$conn->close();

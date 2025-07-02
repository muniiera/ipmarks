<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $event_name = $_POST['event_name'];
    $semester_id = $_POST['semester_id'];

    $sql = "INSERT INTO events (event_name, semester_id) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $event_name, $semester_id);

    if ($stmt->execute()) {
        echo "<script>alert('Event created successfully!'); window.location.href='dashboard.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }
}

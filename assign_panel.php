<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $event_id = $_POST['event_id'];
    $user_id = $_POST['user_id'];

    $sql = "INSERT INTO panels (event_id, user_id) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $event_id, $user_id);

    if ($stmt->execute()) {
        echo "<script>alert('Panel assigned successfully!'); window.location.href='dashboard.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }
}

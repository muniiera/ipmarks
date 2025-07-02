<?php
include 'config.php';

if (isset($_GET['track'])) {
    $track = $_GET['track'];

    // Debugging: Check if the track value is received
    if (empty($track)) {
        echo "<option value=''>Select Supervisor</option>";
        exit;
    }

    // Fetch supervisors based on the selected track
    $stmt = $conn->prepare("SELECT id, name FROM supervisors WHERE track = ?");
    $stmt->bind_param("s", $track);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<option value=''>Select Supervisor</option>";
        while ($row = $result->fetch_assoc()) {
            echo "<option value='{$row['id']}'>{$row['name']}</option>";
        }
    } else {
        echo "<option value=''>No supervisors available</option>";
    }
}

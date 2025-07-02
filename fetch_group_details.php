<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $group_id = $_POST['group_id'];

    // Fetch project details
    $projectQuery = $conn->prepare("SELECT project_title, project_description, supervisors.name AS supervisor
                                    FROM students 
                                    JOIN supervisors ON students.supervisor_id = supervisors.id 
                                    WHERE students.group_id = ? LIMIT 1");
    $projectQuery->bind_param("s", $group_id);
    $projectQuery->execute();
    $projectResult = $projectQuery->get_result()->fetch_assoc();

    // Fetch rubric criteria
    $rubricQuery = $conn->query("SELECT id, aspect, demo_score1, demo_score2, demo_score3, demo_score4, weightage FROM criteria_demo3");
    $rubric = [];
    while ($row = $rubricQuery->fetch_assoc()) {
        $rubric[] = $row;
    }

    echo json_encode([
        'success' => true,
        'project_title' => $projectResult['project_title'],
        'project_description' => $projectResult['project_description'],
        'supervisor' => $projectResult['supervisor'],
        'rubric' => $rubric
    ]);
}

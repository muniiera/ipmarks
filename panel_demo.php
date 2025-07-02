<?php

session_start();
require 'config.php'; // Ensure database connection

if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] != 'Panel Demo 3') {
    header("Location: login.php");
    exit();
}


// Fetch students assigned to the panel (user_id as panel_id)
$panel_id = $_SESSION['user_id']; // Change this dynamically based on logged-in user
$students = $conn->query("SELECT s.id,s.group_id, s.matric_num, s.name, s.project_title, s.project_description, su.name AS supervisor
FROM students s
JOIN supervisors su ON s.supervisor_id = su.id JOIN users u ON s.user_id = u.id
WHERE s.user_id = $panel_id");

$rubric = $conn->query("SELECT * FROM criteria_demo3");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Demo 3</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-4">
        <h2>Panel Demo 3 - Assign Marks</h2>

        <!-- Student Selection -->
        <form method="post" action="save_marks.php">
            <div class="mb-3">
                <label for="student" class="form-label">Select Group Id:</label>
                <select name="group_id" id="group_id" class="form-control" required>
                    <option value="">-- Select Group Id --</option>
                    <?php while ($row = $students->fetch_assoc()): ?>
                        <option value="<?= $row['id']; ?>"
                            data-name="<?= $row['name']; ?>"
                            data-title="<?= $row['project_title']; ?>"
                            data-description="<?= $row['project_description']; ?>"
                            data-supervisor="<?= $row['supervisor']; ?>">
                            <?= $row['group_id']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <!-- Project Details -->
            <div id="projectDetails" style="display: none;">
                <h4>Project Details</h4>
                <p><strong>Student Name:</strong> <span id="name"></span></p>
                <p><strong>Title:</strong> <span id="projectTitle"></span></p>
                <p><strong>Description:</strong> <span id="projectDescription"></span></p>
                <p><strong>Supervisor:</strong> <span id="supervisorName"></span></p>
            </div>

            <!-- Rubric Table -->
            <table class="table table-bordered mt-3" id="rubricTable">
                <thead>
                    <tr>
                        <th>Aspect</th>
                        <th>Score 1</th>
                        <th>Score 2</th>
                        <th>Score 3</th>
                        <th>Score 4</th>
                        <th>Weightage</th>
                        <th>Score</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($rubricRow = $rubric->fetch_assoc()): ?>
                        <tr>
                            <td><input type="hidden" name="criteria_id[]" value="<?php echo $rubricRow['criteria_demo3_id']; ?>"><?php echo $rubricRow['aspect']; ?></td>
                            <td><?= $rubricRow['demo_score1']; ?></td>
                            <td><?= $rubricRow['demo_score2']; ?></td>
                            <td><?= $rubricRow['demo_score3']; ?></td>
                            <td><?= $rubricRow['demo_score4']; ?></td>
                            <td><?= $rubricRow['weightage']; ?></td>
                            <td>
                                <select name="scores[]" class="score-select form-control" data-weightage="<?= $rubricRow['weightage']; ?>">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                            </td>
                            <td class="total-score">0</td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="7" class="text-end">Total Marks:</th>
                        <th id="grandTotal">0</th>
                    </tr>
                </tfoot>
            </table>

            <button type="submit" class="btn btn-primary">Submit Marks</button>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            // Update project details on student selection
            $("#group_id").change(function() {
                let selected = $(this).find(":selected");
                $("#name").text(selected.data("name"));
                $("#projectTitle").text(selected.data("title"));
                $("#projectDescription").text(selected.data("description"));
                $("#supervisorName").text(selected.data("supervisor"));
                $("#projectDetails").show();
            });

            // Auto-calculate total score per row and grand total
            $(".score-select").change(function() {
                let score = parseFloat($(this).val());
                let weightage = parseFloat($(this).data("weightage"));
                let total = (score / 4) * weightage;
                $(this).closest("tr").find(".total-score").text(total.toFixed(2));

                calculateGrandTotal();
            });

            function calculateGrandTotal() {
                let grandTotal = 0;
                $(".total-score").each(function() {
                    grandTotal += parseFloat($(this).text());
                });
                $("#grandTotal").text(grandTotal.toFixed(2));
            }
        });
    </script>
</body>

</html>
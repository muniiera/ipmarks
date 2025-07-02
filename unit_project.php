<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] != 'Unit Project') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Unit Project Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/load_supervisors.js"></script>
</head>

<body>
    <div class="container mt-5">
        <h2>Unit Project Dashboard</h2>
        <a href="logout.php" class="btn btn-danger">Logout</a>
        <hr>
        <ul class="nav nav-tabs">
            <li class="nav-item"><a class="nav-link active" href="#students" data-bs-toggle="tab">Manage Students</a></li>
            <li class="nav-item"><a class="nav-link" href="#supervisors" data-bs-toggle="tab">Manage Supervisors</a></li>
            <li class="nav-item"><a class="nav-link" href="#events" data-bs-toggle="tab">Manage Events</a></li>
            <li class="nav-item"><a class="nav-link" href="#semesters" data-bs-toggle="tab">Manage Semesters</a></li>
            <li class="nav-item"><a class="nav-link" href="#rubricsdemo3" data-bs-toggle="tab">Manage Rubric Demo 3</a></li>
        </ul>
        <div class="tab-content mt-3">
            <!-- Manage Students -->
            <div class="tab-pane fade show active" id="students">
                <h4>Student Groups</h4>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStudentModal">Add Student Group</button>
                <table class="table mt-3">
                    <tr>
                        <th>Group</th>
                        <th>Matric No</th>
                        <th>Name</th>
                        <th>Project Title</th>
                        <th>Project Description</th>
                        <th>Track</th>
                        <th>Supervisor Name</th>
                        <th>Semester Year</th>
                        <th>Panel Name</th>
                        <th>Actions</th>
                    </tr>
                    <?php
                    $result = $conn->query("
                        SELECT s.group_id, s.matric_num, s.name, s.project_title, s.project_description, 
                            s.track, sup.name AS supervisor_name, sem.semester, sem.year, u.full_name AS panel_name 
                        FROM students s
                        LEFT JOIN supervisors sup ON s.supervisor_id = sup.id
                        LEFT JOIN semesters sem ON s.semester_id = sem.id
                        LEFT JOIN users u ON s.user_id = u.id
                    ");
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr><td>{$row['group_id']}</td><td>{$row['matric_num']}</td><td>{$row['name']}</td><td>{$row['project_title']}</td><td>{$row['project_description']}</td><td>{$row['track']}</td><td>{$row['supervisor_name']}</td> <td>{$row['semester']}/{$row['year']}</td><td>{$row['panel_name']}</td>
                          <td>
                              <button class='btn btn-warning' data-bs-toggle='modal' data-bs-target='#editStudentModal'>Edit</button>
                              <button class='btn btn-danger' data-bs-toggle='modal' data-bs-target='#deleteStudentModal'>Delete</button>
                          </td></tr>";
                    }
                    ?>
                </table>
            </div>
            <!-- Manage Supervisors -->
            <div class="tab-pane fade" id="supervisors">
                <h4>Supervisors</h4>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSupervisorModal">Add Supervisor</button>
                <table class="table mt-3">
                    <tr>
                        <th>Name</th>
                        <th>Track</th>
                        <th>Actions</th>
                    </tr>
                    <?php
                    $result = $conn->query("SELECT * FROM supervisors");
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr><td>{$row['name']}</td><td>{$row['track']}</td>
                          <td>
                              <button class='btn btn-warning' data-bs-toggle='modal' data-bs-target='#editSupervisorModal'>Edit</button>
                              <button class='btn btn-danger' data-bs-toggle='modal' data-bs-target='#deleteSupervisorModal'>Delete</button>
                          </td></tr>";
                    }
                    ?>
                </table>
            </div>

            <!-- Manage Events -->
            <div class="tab-pane fade" id="events">
                <h4>Events</h4>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEventModal">Add Event</button>
                <table class="table mt-3">
                    <tr>
                        <th>Event Name</th>
                        <th>Semester</th>
                        <th>Actions</th>
                    </tr>
                    <?php
                    $result = $conn->query("SELECT events.id, events.event_name, CONCAT(semesters.semester, ' ', semesters.year) AS semester FROM events JOIN semesters ON events.semester_id = semesters.id");
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr><td>{$row['event_name']}</td><td>{$row['semester']}</td>
                          <td>
                              <button class='btn btn-warning' data-bs-toggle='modal' data-bs-target='#editEventModal' onclick='editEvent({$row['id']}, \"{$row['event_name']}\", \"{$row['semester']}\")'>Edit</button>
                              <button class='btn btn-danger' data-bs-toggle='modal' data-bs-target='#deleteEventModal' onclick='deleteEvent({$row['id']})'>Delete</button>
                          </td></tr>";
                    }
                    ?>
                </table>
            </div>
            <!-- Manage Semesters -->
            <div class="tab-pane fade" id="semesters">
                <h4>Semesters</h4>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSemesterModal">Add Semester</button>
                <table class="table mt-3">
                    <tr>
                        <th>Semester</th>
                        <th>Year</th>
                        <th>Actions</th>
                    </tr>
                    <?php
                    $result = $conn->query("SELECT * FROM semesters");
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr><td>{$row['semester']}</td><td>{$row['year']}</td>
                          <td>
                              <button class='btn btn-warning' data-bs-toggle='modal' data-bs-target='#editSemesterModal' onclick='editSemester({$row['id']}, \"{$row['semester']}\", \"{$row['year']}\")'>Edit</button>
                              <button class='btn btn-danger' data-bs-toggle='modal' data-bs-target='#deleteSemesterModal' onclick='deleteSemester({$row['id']})'>Delete</button>
                          </td></tr>";
                    }
                    ?>
                </table>
            </div>
            <!-- Manage Rubric -->
            <div class="tab-pane fade" id="rubricsdemo3">
                <h4>Rubric Demo 3</h4>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRubricModal">Add Rubric Demo 3</button>
                <table class="table mt-3">
                    <tr>
                        <th>Aspect</th>
                        <th>Very Good</th>
                        <th>Good</th>
                        <th>Fair</th>
                        <th>Week</th>
                        <th>Weightage</th>
                        <th>Actions</th>
                    </tr>
                    <?php
                    $result = $conn->query("SELECT * FROM criteria_demo3");
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr><td>{$row['aspect']}</td><td>{$row['demo_score1']}</td><td>{$row['demo_score2']}</td><td>{$row['demo_score3']}</td><td>{$row['demo_score4']}</td><td>{$row['weightage']}</td>
                          <td>
                              <button class='btn btn-warning' data-bs-toggle='modal' data-bs-target='#editRubricModal' onclick='editRubric({$row['criteria_demo3_id']})'>Edit</button>
                              <button class='btn btn-danger' data-bs-toggle='modal' data-bs-target='#deleteRubricModal' onclick='deleteRubric({$row['criteria_demo3_id']})'>Delete</button>
                          </td></tr>";
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>

    <!-- Modals for Add/Edit/Delete -->
    <div class="modal fade" id="addStudentModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Student Group</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="add_student.php" method="post">
                        <input type="text" class="form-control mb-2" name="group_id" placeholder="Group ID">
                        <input type="text" class="form-control mb-2" name="matric_num" placeholder="Matric Number">
                        <input type="text" class="form-control mb-2" name="name" placeholder="Student Name">
                        <input type="text" class="form-control mb-2" name="project_title" placeholder="Project Title">
                        <input type="text" class="form-control mb-2" name="project_description" placeholder="Project Description">
                        <select class="form-control mb-2" name="track" id="trackSelect" required>
                            <option value="">Select Track</option>
                            <option value="SAD">Software Application Development</option>
                            <option value="NS">Network System</option>
                            <option value="IS">Information Security</option>
                        </select>
                        <!-- Supervisor Selection (Filtered by Track) -->
                        <select class="form-control mb-2" name="supervisor_id" id="supervisorDropdown" required>
                            <option value="">Select Supervisor</option>
                        </select>

                        <!-- Semester Selection -->
                        <select class="form-control mb-2" name="semester_id" required>
                            <option value="">Select Semester</option>
                            <?php
                            $semesters = $conn->query("SELECT id, CONCAT(semester, ' ', year) AS sem_name FROM semesters");
                            while ($sem = $semesters->fetch_assoc()) {
                                echo "<option value='{$sem['id']}'>{$sem['sem_name']}</option>";
                            }
                            ?>
                        </select>

                        <!-- Panel Selection -->
                        <select class="form-control mb-2" name="user_id" required>
                            <option value="">Select Panel Demo 3</option>
                            <?php
                            $panels = $conn->query("SELECT id, full_name FROM users WHERE level_id IN (3)");
                            while ($panel = $panels->fetch_assoc()) {
                                echo "<option value='{$panel['id']}'>{$panel['full_name']}</option>";
                            }
                            ?>
                        </select>
                        <button type="submit" class="btn btn-success">Add</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modals for Add/Edit/Delete Supervisors -->
    <div class="modal fade" id="addSupervisorModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Supervisor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="add_supervisor.php" method="post">
                        <input type="text" class="form-control mb-2" name="name" placeholder="Supervisor Name">
                        <select class="form-control mb-2" name="track">
                            <option value="SAD">Software Application Development</option>
                            <option value="NS">Network System</option>
                            <option value="IS">Information Security</option>
                        </select>
                        <button type="submit" class="btn btn-success">Add</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editSupervisorModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Supervisor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="edit_supervisor.php" method="post">
                        <input type="hidden" id="editSupervisorId" name="id">
                        <input type="text" class="form-control mb-2" id="editSupervisorName" name="name">
                        <select class="form-control mb-2" id="editSupervisorTrack" name="track">
                            <option value="SAD">Software Application Development</option>
                            <option value="NS">Network System</option>
                            <option value="IS">Information Security</option>
                        </select>
                        <button type="submit" class="btn btn-warning">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteSupervisorModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Supervisor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="delete_supervisor.php" method="post">
                        <input type="hidden" id="deleteSupervisorId" name="id">
                        <p>Are you sure you want to delete this supervisor?</p>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modals for Add/Edit/Delete Events -->
    <div class="modal fade" id="addEventModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="add_event.php" method="post">
                        <input type="text" class="form-control mb-2" name="event_name" placeholder="Event Name" required>
                        <select class="form-control mb-2" name="semester_id">
                            <?php
                            $semesters = $conn->query("SELECT id, CONCAT(semester, ' ', year) AS sem_name FROM semesters");
                            while ($sem = $semesters->fetch_assoc()) {
                                echo "<option value='{$sem['id']}'>{$sem['sem_name']}</option>";
                            }
                            ?>
                        </select>
                        <button type="submit" class="btn btn-success">Add</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editEventModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="edit_event.php" method="post">
                        <input type="hidden" id="editEventId" name="id">
                        <input type="text" class="form-control mb-2" id="editEventName" name="event_name">
                        <input type="text" class="form-control mb-2" id="editEventSemester" name="semester">
                        <button type="submit" class="btn btn-warning">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteEventModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="delete_event.php" method="post">
                        <input type="hidden" id="deleteEventId" name="id">
                        <p>Are you sure you want to delete this event?</p>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modals for Add/Edit/Delete Semesters -->
    <div class="modal fade" id="addSemesterModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Semester</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="add_semester.php" method="post">
                        <input type="text" class="form-control mb-2" name="semester" placeholder="Semester">
                        <input type="text" class="form-control mb-2" name="year" placeholder="Year">
                        <button type="submit" class="btn btn-success">Add</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editSemesterModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Semester</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="edit_semester.php" method="post">
                        <input type="hidden" id="editSemesterId" name="id">
                        <input type="text" class="form-control mb-2" id="editSemesterName" name="semester">
                        <input type="text" class="form-control mb-2" id="editSemesterYear" name="year">
                        <button type="submit" class="btn btn-warning">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteSemesterModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Semester</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="delete_semester.php" method="post">
                        <input type="hidden" id="deleteSemesterId" name="id">
                        <p>Are you sure you want to delete this semester?</p>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modals for Add/Edit/Delete -->
    <div class="modal fade" id="addRubricModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Rubric Demo 3</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="add_rubricdemo3.php" method="post">
                        <input type="textarea" class="form-control mb-2" name="aspect" placeholder="Aspect">
                        <input type="textarea" class="form-control mb-2" name="verygood" placeholder="Very Good">
                        <input type="textarea" class="form-control mb-2" name="good" placeholder="Good">
                        <input type="textarea" class="form-control mb-2" name="fair" placeholder="Fair">
                        <input type="textarea" class="form-control mb-2" name="weak" placeholder="Weak">
                        <input type="textarea" class="form-control mb-2" name="weightage" placeholder="Weightage">
                        <button type="submit" class="btn btn-success">Add</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function editStudent(id) {
            document.getElementById('editStudentId').value = id;
        }

        function deleteStudent(id) {
            document.getElementById('deleteStudentId').value = id;
        }

        function editSupervisor(id, name, track) {
            document.getElementById('editSupervisorId').value = id;
            document.getElementById('editSupervisorName').value = name;
            document.getElementById('editSupervisorTrack').value = track;
        }

        function deleteSupervisor(id) {
            document.getElementById('deleteSupervisorId').value = id;
        }

        function editEvent(id, name, semester) {
            document.getElementById('editEventId').value = id;
            document.getElementById('editEventName').value = name;
            document.getElementById('editEventSemester').value = semester;
        }

        function deleteEvent(id) {
            document.getElementById('deleteEventId').value = id;
        }

        function editSemester(id, semester, year) {
            document.getElementById('editSemesterId').value = id;
            document.getElementById('editSemesterName').value = semester;
            document.getElementById('editSemesterYear').value = year;
        }

        function deleteSemester(id) {
            document.getElementById('deleteSemesterId').value = id;
        }
    </script>

</body>

</html>
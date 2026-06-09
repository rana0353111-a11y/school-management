<?php
include '../config.php';

// Add result
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id  = $_POST['student_id'];
    $subject     = $_POST['subject'];
    $marks       = $_POST['marks'];
    $total_marks = $_POST['total_marks'];
    $exam_type   = $_POST['exam_type'];

    $sql = "INSERT INTO results (student_id, subject, marks, total_marks, exam_type) 
            VALUES ('$student_id', '$subject', '$marks', '$total_marks', '$exam_type')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Result Added!'); window.location='add.php';</script>";
    }
}

// Delete result
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM results WHERE id=$id");
    header("Location: add.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Results</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family: Arial, sans-serif; background:#f4f4f4; }
        .navbar { background:#2c3e50; color:white; padding:15px 30px; font-size:20px; font-weight:bold; }
        .sidebar { width:220px; background:#34495e; height:100vh; position:fixed; padding-top:20px; }
        .sidebar a { display:block; color:white; padding:15px 20px; text-decoration:none; }
        .sidebar a:hover { background:#2c3e50; }
        .main { margin-left:220px; padding:30px; }
        .form-box { background:white; padding:25px; border-radius:10px; margin-bottom:25px; box-shadow:0 2px 5px rgba(0,0,0,0.1); max-width:500px; }
        input, select { width:100%; padding:10px; margin:8px 0 15px 0; border:1px solid #ddd; border-radius:5px; }
        label { font-weight:bold; color:#555; }
        table { width:100%; background:white; border-collapse:collapse; border-radius:10px; overflow:hidden; box-shadow:0 2px 5px rgba(0,0,0,0.1); }
        th { background:#2c3e50; color:white; padding:12px; text-align:left; }
        td { padding:12px; border-bottom:1px solid #eee; }
        tr:hover { background:#f9f9f9; }
        .btn { background:#2c3e50; color:white; padding:12px 30px; border:none; border-radius:5px; cursor:pointer; font-size:15px; }
        .btn:hover { background:#34495e; }
        .btn-delete { background:#e74c3c; color:white; padding:6px 12px; border-radius:4px; text-decoration:none; }
        .grade-A { color:green; font-weight:bold; }
        .grade-B { color:blue; font-weight:bold; }
        .grade-C { color:orange; font-weight:bold; }
        .grade-F { color:red; font-weight:bold; }
    </style>
</head>
<body>

<div class="navbar">🏫 School Management System</div>

<div class="sidebar">
    <a href="../index.php">🏠 Dashboard</a>
    <a href="../students/add.php">👨‍🎓 Add Student</a>
    <a href="../students/view.php">📋 View Students</a>
    <a href="../teachers/add.php">👨‍🏫 Add Teacher</a>
    <a href="../teachers/view.php">📋 View Teachers</a>
    <a href="../attendance/mark.php">✅ Attendance</a>
    <a href="../fees/manage.php">💰 Fees</a>
    <a href="add.php">📊 Results</a>
</div>

<div class="main">
    <div class="form-box">
        <h2 style="margin-bottom:20px;">📊 Add Result</h2>
        <form method="POST">
            <label>Student</label>
            <select name="student_id" required>
                <option value="">-- Select Student --</option>
                <?php 
                $students = mysqli_query($conn, "SELECT * FROM students ORDER BY name");
                while($s = mysqli_fetch_assoc($students)): ?>
                <option value="<?php echo $s['id']; ?>">
                    <?php echo $s['name'] . " (Class " . $s['class'] . ")"; ?>
                </option>
                <?php endwhile; ?>
            </select>

            <label>Subject</label>
            <select name="subject">
                <option>Mathematics</option>
                <option>Science</option>
                <option>English</option>
                <option>Urdu</option>
                <option>Islamiat</option>
                <option>Computer</option>
                <option>History</option>
                <option>Geography</option>
            </select>

            <label>Marks Obtained</label>
            <input type="number" name="marks" required>

            <label>Total Marks</label>
            <input type="number" name="total_marks" value="100" required>

            <label>Exam Type</label>
            <select name="exam_type">
                <option>Monthly Test</option>
                <option>Mid Term</option>
                <option>Final Term</option>
            </select>

            <button type="submit" class="btn">Add Result</button>
        </form>
    </div>

    <table>
        <tr>
            <th>Student</th>
            <th>Class</th>
            <th>Subject</th>
            <th>Marks</th>
            <th>Percentage</th>
            <th>Grade</th>
            <th>Exam</th>
            <th>Action</th>
        </tr>
        <?php 
        $results = mysqli_query($conn, "SELECT results.*, students.name, students.class 
                                        FROM results 
                                        JOIN students ON results.student_id = students.id 
                                        ORDER BY results.id DESC");
        while($row = mysqli_fetch_assoc($results)):
            $percent = round(($row['marks'] / $row['total_marks']) * 100);
            if($percent >= 80) $grade = 'A';
            elseif($percent >= 60) $grade = 'B';
            elseif($percent >= 40) $grade = 'C';
            else $grade = 'F';
        ?>
        <tr>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['class']; ?></td>
            <td><?php echo $row['subject']; ?></td>
            <td><?php echo $row['marks'] . "/" . $row['total_marks']; ?></td>
            <td><?php echo $percent; ?>%</td>
            <td class="grade-<?php echo $grade; ?>"><?php echo $grade; ?></td>
            <td><?php echo $row['exam_type']; ?></td>
            <td>
                <a href="add.php?delete=<?php echo $row['id']; ?>" 
                   class="btn-delete"
                   onclick="return confirm('Delete karna chahte ho?')">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

</body>
</html>
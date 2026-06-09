<?php
include '../config.php';

// Save attendance
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $date = $_POST['date'];
    $students = $_POST['students'];
    $status = $_POST['status'];

    foreach ($students as $student_id) {
        $st = $status[$student_id];
        // Check already marked
        $check = mysqli_fetch_assoc(mysqli_query($conn, 
            "SELECT id FROM attendance WHERE student_id=$student_id AND date='$date'"));
        
        if ($check) {
            mysqli_query($conn, 
                "UPDATE attendance SET status='$st' WHERE student_id=$student_id AND date='$date'");
        } else {
            mysqli_query($conn, 
                "INSERT INTO attendance (student_id, date, status) VALUES ($student_id, '$date', '$st')");
        }
    }
    echo "<script>alert('Attendance Saved!'); window.location='mark.php';</script>";
}

$selected_date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
$students = mysqli_query($conn, "SELECT * FROM students ORDER BY class, roll_no");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Attendance</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family: Arial, sans-serif; background:#f4f4f4; }
        .navbar { background:#2c3e50; color:white; padding:15px 30px; font-size:20px; font-weight:bold; }
        .sidebar { width:220px; background:#34495e; height:100vh; position:fixed; padding-top:20px; }
        .sidebar a { display:block; color:white; padding:15px 20px; text-decoration:none; }
        .sidebar a:hover { background:#2c3e50; }
        .main { margin-left:220px; padding:30px; }
        table { width:100%; background:white; border-collapse:collapse; border-radius:10px; overflow:hidden; box-shadow:0 2px 5px rgba(0,0,0,0.1); }
        th { background:#2c3e50; color:white; padding:12px; text-align:left; }
        td { padding:12px; border-bottom:1px solid #eee; }
        tr:hover { background:#f9f9f9; }
        .date-box { background:white; padding:20px; border-radius:10px; margin-bottom:20px; box-shadow:0 2px 5px rgba(0,0,0,0.1); display:flex; gap:15px; align-items:center; }
        input[type="date"] { padding:10px; border:1px solid #ddd; border-radius:5px; font-size:15px; }
        .btn { background:#2c3e50; color:white; padding:10px 20px; border:none; border-radius:5px; cursor:pointer; font-size:15px; text-decoration:none; }
        .btn:hover { background:#34495e; }
        select { padding:8px; border:1px solid #ddd; border-radius:5px; }
        .present { color:green; font-weight:bold; }
        .absent { color:red; font-weight:bold; }
        .leave { color:orange; font-weight:bold; }
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
    <a href="mark.php">✅ Attendance</a>
    <a href="../fees/manage.php">💰 Fees</a>
    <a href="../results/add.php">📊 Results</a>
</div>

<div class="main">
    <div class="date-box">
        <form method="GET">
            <label><b>Date Select Karo:</b></label>
            <input type="date" name="date" value="<?php echo $selected_date; ?>">
            <button type="submit" class="btn">Load Students</button>
        </form>
    </div>

    <form method="POST">
        <input type="hidden" name="date" value="<?php echo $selected_date; ?>">
        <table>
            <tr>
                <th>Roll No</th>
                <th>Name</th>
                <th>Class</th>
                <th>Section</th>
                <th>Status</th>
            </tr>
            <?php 
            $students = mysqli_query($conn, "SELECT * FROM students ORDER BY class, roll_no");
            while($row = mysqli_fetch_assoc($students)): 
                $att = mysqli_fetch_assoc(mysqli_query($conn, 
                    "SELECT status FROM attendance WHERE student_id={$row['id']} AND date='$selected_date'"));
                $current = $att ? $att['status'] : 'present';
            ?>
            <tr>
                <td><?php echo $row['roll_no']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['class']; ?></td>
                <td><?php echo $row['section']; ?></td>
                <td>
                    <input type="hidden" name="students[]" value="<?php echo $row['id']; ?>">
                    <select name="status[<?php echo $row['id']; ?>]">
                        <option value="present" <?php if($current=='present') echo 'selected'; ?>>✅ Present</option>
                        <option value="absent" <?php if($current=='absent') echo 'selected'; ?>>❌ Absent</option>
                        <option value="leave" <?php if($current=='leave') echo 'selected'; ?>>🟡 Leave</option>
                    </select>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
        <br>
        <button type="submit" class="btn">💾 Save Attendance</button>
    </form>
</div>

</body>
</html>
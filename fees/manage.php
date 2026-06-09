<?php
include '../config.php';

// Add fee record
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['student_id'];
    $amount     = $_POST['amount'];
    $paid_date  = $_POST['paid_date'];
    $status     = $_POST['status'];

    $sql = "INSERT INTO fees (student_id, amount, paid_date, status) 
            VALUES ('$student_id', '$amount', '$paid_date', '$status')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Fee Record Added!'); window.location='manage.php';</script>";
    }
}

// Delete fee record
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM fees WHERE id=$id");
    header("Location: manage.php");
}

$fees = mysqli_query($conn, "SELECT fees.*, students.name, students.class 
                              FROM fees 
                              JOIN students ON fees.student_id = students.id 
                              ORDER BY fees.id DESC");

$students = mysqli_query($conn, "SELECT * FROM students ORDER BY name");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Fees Management</title>
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
        .paid { background:#d4edda; color:#155724; padding:4px 10px; border-radius:20px; font-size:13px; }
        .unpaid { background:#f8d7da; color:#721c24; padding:4px 10px; border-radius:20px; font-size:13px; }
        .btn { background:#2c3e50; color:white; padding:12px 30px; border:none; border-radius:5px; cursor:pointer; font-size:15px; }
        .btn:hover { background:#34495e; }
        .btn-delete { background:#e74c3c; color:white; padding:6px 12px; border-radius:4px; text-decoration:none; }
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
    <a href="manage.php">💰 Fees</a>
    <a href="../results/add.php">📊 Results</a>
</div>

<div class="main">
    <div class="form-box">
        <h2 style="margin-bottom:20px;">💰 Add Fee Record</h2>
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

            <label>Amount (Rs.)</label>
            <input type="number" name="amount" required>

            <label>Date</label>
            <input type="date" name="paid_date" value="<?php echo date('Y-m-d'); ?>">

            <label>Status</label>
            <select name="status">
                <option value="paid">✅ Paid</option>
                <option value="unpaid">❌ Unpaid</option>
            </select>

            <button type="submit" class="btn">Add Fee Record</button>
        </form>
    </div>

    <table>
        <tr>
            <th>ID</th>
            <th>Student Name</th>
            <th>Class</th>
            <th>Amount</th>
            <th>Date</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php 
        $fees = mysqli_query($conn, "SELECT fees.*, students.name, students.class 
                                     FROM fees 
                                     JOIN students ON fees.student_id = students.id 
                                     ORDER BY fees.id DESC");
        while($row = mysqli_fetch_assoc($fees)): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['class']; ?></td>
            <td>Rs. <?php echo $row['amount']; ?></td>
            <td><?php echo $row['paid_date']; ?></td>
            <td>
                <span class="<?php echo $row['status']; ?>">
                    <?php echo ucfirst($row['status']); ?>
                </span>
            </td>
            <td>
                <a href="manage.php?delete=<?php echo $row['id']; ?>" 
                   class="btn-delete" 
                   onclick="return confirm('Delete karna chahte ho?')">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

</body>
</html>
<?php
include '../config.php';

// Delete student
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM students WHERE id=$id");
    header("Location: view.php");
}

$students = mysqli_query($conn, "SELECT * FROM students");
?>
<!DOCTYPE html>
<html>
<head>
    <title>View Students</title>
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
        .btn-edit { background:#3498db; color:white; padding:6px 12px; border-radius:4px; text-decoration:none; }
        .btn-delete { background:#e74c3c; color:white; padding:6px 12px; border-radius:4px; text-decoration:none; }
        .btn-add { background:#2c3e50; color:white; padding:10px 20px; border-radius:5px; text-decoration:none; display:inline-block; margin-bottom:20px; }
    </style>
</head>
<body>

<div class="navbar">🏫 School Management System</div>

<div class="sidebar">
    <a href="../index.php">🏠 Dashboard</a>
    <a href="add.php">👨‍🎓 Add Student</a>
    <a href="view.php">📋 View Students</a>
    <a href="../teachers/add.php">👨‍🏫 Add Teacher</a>
    <a href="../teachers/view.php">📋 View Teachers</a>
    <a href="../attendance/mark.php">✅ Attendance</a>
    <a href="../fees/manage.php">💰 Fees</a>
    <a href="../results/add.php">📊 Results</a>
</div>

<div class="main">
    <a href="add.php" class="btn-add">+ Add New Student</a>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Roll No</th>
            <th>Class</th>
            <th>Section</th>
            <th>Phone</th>
            <th>Action</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($students)): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['roll_no']; ?></td>
            <td><?php echo $row['class']; ?></td>
            <td><?php echo $row['section']; ?></td>
            <td><?php echo $row['phone']; ?></td>
            <td>
                <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn-edit">Edit</a>
                <a href="view.php?delete=<?php echo $row['id']; ?>" class="btn-delete" onclick="return confirm('Delete karna chahte ho?')">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

</body>
</html>
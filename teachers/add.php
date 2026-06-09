<?php
include '../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name    = $_POST['name'];
    $subject = $_POST['subject'];
    $phone   = $_POST['phone'];
    $email   = $_POST['email'];

    $sql = "INSERT INTO teachers (name, subject, phone, email) 
            VALUES ('$name', '$subject', '$phone', '$email')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Teacher Added!'); window.location='view.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Teacher</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family: Arial, sans-serif; background:#f4f4f4; }
        .navbar { background:#2c3e50; color:white; padding:15px 30px; font-size:20px; font-weight:bold; }
        .sidebar { width:220px; background:#34495e; height:100vh; position:fixed; padding-top:20px; }
        .sidebar a { display:block; color:white; padding:15px 20px; text-decoration:none; }
        .sidebar a:hover { background:#2c3e50; }
        .main { margin-left:220px; padding:30px; }
        .form-box { background:white; padding:30px; border-radius:10px; max-width:500px; box-shadow:0 2px 5px rgba(0,0,0,0.1); }
        input, select { width:100%; padding:10px; margin:8px 0 15px 0; border:1px solid #ddd; border-radius:5px; }
        label { font-weight:bold; color:#555; }
        button { background:#2c3e50; color:white; padding:12px 30px; border:none; border-radius:5px; cursor:pointer; font-size:16px; }
        button:hover { background:#34495e; }
    </style>
</head>
<body>

<div class="navbar">🏫 School Management System</div>

<div class="sidebar">
    <a href="../index.php">🏠 Dashboard</a>
    <a href="../students/add.php">👨‍🎓 Add Student</a>
    <a href="../students/view.php">📋 View Students</a>
    <a href="add.php">👨‍🏫 Add Teacher</a>
    <a href="view.php">📋 View Teachers</a>
    <a href="../attendance/mark.php">✅ Attendance</a>
    <a href="../fees/manage.php">💰 Fees</a>
    <a href="../results/add.php">📊 Results</a>
</div>

<div class="main">
    <div class="form-box">
        <h2 style="margin-bottom:20px;">👨‍🏫 Add Teacher</h2>
        <form method="POST">
            <label>Full Name</label>
            <input type="text" name="name" required>

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

            <label>Phone</label>
            <input type="text" name="phone">

            <label>Email</label>
            <input type="email" name="email">

            <button type="submit">Add Teacher</button>
        </form>
    </div>
</div>

</body>
</html>
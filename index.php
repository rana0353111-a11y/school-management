<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>School Management System</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f4f4f4; }
        
        .navbar {
            background: #2c3e50;
            color: white;
            padding: 15px 30px;
            font-size: 22px;
            font-weight: bold;
        }
        
        .sidebar {
            width: 220px;
            background: #34495e;
            height: 100vh;
            position: fixed;
            padding-top: 20px;
        }
        
        .sidebar a {
            display: block;
            color: white;
            padding: 15px 20px;
            text-decoration: none;
            font-size: 16px;
        }
        
        .sidebar a:hover { background: #2c3e50; }
        
        .main {
            margin-left: 220px;
            padding: 30px;
        }
        
        .cards {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }
        
        .card {
            background: white;
            padding: 30px;
            border-radius: 10px;
            width: 200px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .card h2 { font-size: 40px; color: #2c3e50; }
        .card p { color: #888; margin-top: 5px; }
    </style>
</head>
<body>

<div class="navbar">🏫 School Management System</div>

<div class="sidebar">
    <a href="index.php">🏠 Dashboard</a>
    <a href="students/add.php">👨‍🎓 Add Student</a>
    <a href="students/view.php">📋 View Students</a>
    <a href="teachers/add.php">👨‍🏫 Add Teacher</a>
    <a href="teachers/view.php">📋 View Teachers</a>
    <a href="attendance/mark.php">✅ Attendance</a>
    <a href="fees/manage.php">💰 Fees</a>
    <a href="results/add.php">📊 Results</a>
</div>

<div class="main">
    <h2 style="margin-bottom:20px;">Dashboard</h2>
    <div class="cards">
        
        <?php
        $students = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM students"));
        $teachers = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM teachers"));
        $fees = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM fees WHERE status='unpaid'"));
        ?>
        
        <div class="card">
            <h2><?php echo $students['total']; ?></h2>
            <p>Total Students</p>
        </div>
        
        <div class="card">
            <h2><?php echo $teachers['total']; ?></h2>
            <p>Total Teachers</p>
        </div>
        
        <div class="card">
            <h2><?php echo $fees['total']; ?></h2>
            <p>Unpaid Fees</p>
        </div>
        
    </div>
</div>

</body>
</html>
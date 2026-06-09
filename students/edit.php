<?php
include '../config.php';

$id = $_GET['id'];
$student = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM students WHERE id=$id"));

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name    = $_POST['name'];
    $roll_no = $_POST['roll_no'];
    $class   = $_POST['class'];
    $section = $_POST['section'];
    $phone   = $_POST['phone'];
    $address = $_POST['address'];

    $sql = "UPDATE students SET 
            name='$name', roll_no='$roll_no', class='$class', 
            section='$section', phone='$phone', address='$address' 
            WHERE id=$id";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Student Updated!'); window.location='view.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family: Arial, sans-serif; background:#f4f4f4; }
        .navbar { background:#2c3e50; color:white; padding:15px 30px; font-size:20px; font-weight:bold; }
        .sidebar { width:220px; background:#34495e; height:100vh; position:fixed; padding-top:20px; }
        .sidebar a { display:block; color:white; padding:15px 20px; text-decoration:none; }
        .sidebar a:hover { background:#2c3e50; }
        .main { margin-left:220px; padding:30px; }
        .form-box { background:white; padding:30px; border-radius:10px; max-width:500px; box-shadow:0 2px 5px rgba(0,0,0,0.1); }
        input, select, textarea { width:100%; padding:10px; margin:8px 0 15px 0; border:1px solid #ddd; border-radius:5px; }
        label { font-weight:bold; color:#555; }
        button { background:#2c3e50; color:white; padding:12px 30px; border:none; border-radius:5px; cursor:pointer; font-size:16px; }
        button:hover { background:#34495e; }
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
    <div class="form-box">
        <h2 style="margin-bottom:20px;">✏️ Edit Student</h2>
        <form method="POST">
            <label>Full Name</label>
            <input type="text" name="name" value="<?php echo $student['name']; ?>" required>

            <label>Roll No</label>
            <input type="text" name="roll_no" value="<?php echo $student['roll_no']; ?>" required>

            <label>Class</label>
            <select name="class">
                <?php for($i=1; $i<=10; $i++): ?>
                <option value="<?php echo $i; ?>" <?php if($student['class']==$i) echo 'selected'; ?>>
                    <?php echo $i; ?>
                </option>
                <?php endfor; ?>
            </select>

            <label>Section</label>
            <select name="section">
                <?php foreach(['A','B','C'] as $sec): ?>
                <option value="<?php echo $sec; ?>" <?php if($student['section']==$sec) echo 'selected'; ?>>
                    <?php echo $sec; ?>
                </option>
                <?php endforeach; ?>
            </select>

            <label>Phone</label>
            <input type="text" name="phone" value="<?php echo $student['phone']; ?>">

            <label>Address</label>
            <textarea name="address" rows="3"><?php echo $student['address']; ?></textarea>

            <button type="submit">Update Student</button>
        </form>
    </div>
</div>

</body>
</html>
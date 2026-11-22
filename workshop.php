<?php

include "db.php";

session_start();


// Check student login

if (!isset($_SESSION["role"]) || $_SESSION["role"] != "student") {

    header("Location: login.php");

    exit();

}


// Connect database

$conn = mysqli_connect("localhost", "root", "", "workshop_db");

$message = "";


// Check registration button

if (isset($_POST["register"])) {

    // Get student details

    $name = $_SESSION["username"];

    $email = $_SESSION["email"];

    $student_id = $_POST["student_id"];

    $department = $_POST["department"];

    $workshop = $_POST["workshop"];


    // Insert registration details

    $sql = "INSERT INTO registrations
    (name, student_id, email, department, workshop)
    VALUES (?, ?, ?, ?, ?)";


    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "sssss",
        $name,
        $student_id,
        $email,
        $department,
        $workshop
    );


    if (mysqli_stmt_execute($stmt)) {

        $message = "Workshop registration successful!";

    }

    else {

        $message = "Registration failed!";

    }

}

?>


<!DOCTYPE html>
<html>

<head>

    <title>Student Dashboard</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>


    <header>

        <h1>Student Dashboard</h1>

        <p>Welcome, <?php echo htmlspecialchars($_SESSION["username"]); ?></p>

        <nav>

            <a href="index.html">Home</a>

            <a href="workshop.php">Register Workshop</a>

            <a href="logout.php">Logout</a>

        </nav>

    </header>


    <section>

        <h2>Available Workshops</h2>

        <div class="workshop-container">

            <div class="card">

                <h3>Web Development</h3>

                <p>Learn HTML, CSS, JavaScript and PHP.</p>

                <p>Duration: 2 Days</p>

            </div>


            <div class="card">

                <h3>Python Programming</h3>

                <p>Learn Python programming.</p>

                <p>Duration: 3 Days</p>

            </div>


            <div class="card">

                <h3>Database Management</h3>

                <p>Learn SQL and databases.</p>

                <p>Duration: 2 Days</p>

            </div>

        </div>

    </section>


    <section>

        <h2>Workshop Registration</h2>


        <form method="POST">

            <label>Student ID</label>

            <input type="text" name="student_id" required>


            <label>Department</label>

            <select name="department" required>

                <option value="">Select Department</option>

                <option value="IT">IT</option>

                <option value="Computer Science">Computer Science</option>

                <option value="Software Engineering">Software Engineering</option>

                <option value="Management">Management</option>

            </select>


            <label>Select Workshop</label>

            <select name="workshop" required>

                <option value="">Select Workshop</option>

                <option value="Web Development">Web Development</option>

                <option value="Python Programming">Python Programming</option>

                <option value="Database Management">Database Management</option>

            </select>


            <button type="submit" name="register">

                Register Now

            </button>


            <p class="message">

                <?php echo htmlspecialchars($message); ?>

            </p>

        </form>

    </section>


</body>

</html>
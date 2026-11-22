<?php

session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "student") {
    header("Location: login.php");
    exit();
}

include "db.php";

$message = "";

if (isset($_POST["register"])) {

    $user_id = $_SESSION["user_id"];
    $program_id = $_POST["program_id"];

    // Check whether the student already registered

    $check = $conn->prepare(
        "SELECT id FROM registrations WHERE user_id = ? AND program_id = ?"
    );

    $check->bind_param("ii", $user_id, $program_id);
    $check->execute();

    $result = $check->get_result();

    if ($result->num_rows > 0) {

        $message = "You have already registered for this program.";

    } else {

        $stmt = $conn->prepare(
            "INSERT INTO registrations (user_id, program_id)
             VALUES (?, ?)"
        );

        $stmt->bind_param("ii", $user_id, $program_id);

        if ($stmt->execute()) {
            $message = "Registration successful!";
        } else {
            $message = "Registration failed.";
        }
    }
}

// Get all available programs

$programs = $conn->query("SELECT * FROM programs");

?>

<!DOCTYPE html>
<html>
<head>
    <title>Available Programs</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<header>

    <h1>Available Programs</h1>

    <nav>
        <a href="programs.php">Programs</a>
        <a href="my_registrations.php">My Registrations</a>
        <a href="logout.php">Logout</a>
    </nav>

</header>

<div class="container">

    <h2>Welcome <?php echo htmlspecialchars($_SESSION["username"]); ?></h2>

    <h3>Courses, Workshops and Training Programs</h3>

    <p><?php echo $message; ?></p>

    <div class="cards">

        <?php while ($row = $programs->fetch_assoc()) { ?>

            <div class="card">

                <h3>
                    <?php echo htmlspecialchars($row["program_name"]); ?>
                </h3>

                <p>
                    Type:
                    <?php echo htmlspecialchars($row["program_type"]); ?>
                </p>

                <p>
                    <?php echo htmlspecialchars($row["description"]); ?>
                </p>

                <p>
                    Duration:
                    <?php echo htmlspecialchars($row["duration"]); ?>
                </p>

                <form method="POST">

                    <input type="hidden" name="program_id"
                           value="<?php echo $row["id"]; ?>">

                    <button type="submit" name="register">
                        Register
                    </button>

                </form>

            </div>

        <?php } ?>

    </div>

</div>

</body>
</html>
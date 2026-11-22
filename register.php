<?php

session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "student") {
    header("Location: login.php");
    exit();
}

include "db.php";

$user_id = $_SESSION["user_id"];

$stmt = $conn->prepare(
    "SELECT programs.program_name,
            programs.program_type,
            programs.duration,
            registrations.registration_date

     FROM registrations

     JOIN programs
     ON registrations.program_id = programs.id

     WHERE registrations.user_id = ?"
);

$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html>
<head>
    <title>My Registrations</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<header>

    <h1>My Registrations</h1>

    <nav>
        <a href="programs.php">Programs</a>
        <a href="my_registrations.php">My Registrations</a>
        <a href="logout.php">Logout</a>
    </nav>

</header>

<h2 style="text-align:center;">My Registered Programs</h2>

<table>

    <tr>
        <th>Program Name</th>
        <th>Type</th>
        <th>Duration</th>
        <th>Registration Date</th>
    </tr>

    <?php while ($row = $result->fetch_assoc()) { ?>

    <tr>

        <td><?php echo htmlspecialchars($row["program_name"]); ?></td>

        <td><?php echo htmlspecialchars($row["program_type"]); ?></td>

        <td><?php echo htmlspecialchars($row["duration"]); ?></td>

        <td><?php echo htmlspecialchars($row["registration_date"]); ?></td>

    </tr>

    <?php } ?>

</table>

</body>
</html>
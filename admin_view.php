<?php

session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "admin") {
    header("Location: login.php");
    exit();
}

include "db.php";

$sql = "SELECT users.username,
               users.email,
               programs.program_name,
               programs.program_type,
               registrations.registration_date

        FROM registrations

        JOIN users
        ON registrations.user_id = users.id

        JOIN programs
        ON registrations.program_id = programs.id";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<header>

    <h1>Admin Dashboard</h1>

    <nav>
        <a href="admin_view.php">Registrations</a>
        <a href="logout.php">Logout</a>
    </nav>

</header>

<h2 style="text-align:center;">Student Registrations</h2>

<table>

    <tr>
        <th>Student Name</th>
        <th>Email</th>
        <th>Program</th>
        <th>Type</th>
        <th>Registration Date</th>
    </tr>

    <?php while ($row = $result->fetch_assoc()) { ?>

    <tr>

        <td><?php echo htmlspecialchars($row["username"]); ?></td>

        <td><?php echo htmlspecialchars($row["email"]); ?></td>

        <td><?php echo htmlspecialchars($row["program_name"]); ?></td>

        <td><?php echo htmlspecialchars($row["program_type"]); ?></td>

        <td><?php echo htmlspecialchars($row["registration_date"]); ?></td>

    </tr>

    <?php } ?>

</table>

</body>
</html>
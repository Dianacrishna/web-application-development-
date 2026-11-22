<?php

include "db.php";

$conn = mysqli_connect("localhost", "root", "", "workshop_db");


// Admin details

$name = "Admin";

$email = "admin@gmail.com";

$password = password_hash("admin123", PASSWORD_DEFAULT);

$role = "admin";


// Insert admin details

$sql = "INSERT INTO users
(username, email, password, role)
VALUES (?, ?, ?, ?)";


$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "ssss",
    $name,
    $email,
    $password,
    $role
);


if (mysqli_stmt_execute($stmt)) {

    echo "Admin account created successfully!";

}

else {

    echo "Admin already exists or an error occurred!";

}

?>
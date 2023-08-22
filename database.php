<?php
require('config.php');
if ($conn) {
    $tableName = 'Persons';
    // Drop all tables in the database
    $conn->query("SET FOREIGN_KEY_CHECKS = 0"); // Disable foreign key checks temporarily
    $conn->query("DROP TABLE $tableName");
    $conn->query("SET FOREIGN_KEY_CHECKS = 1"); // Enable foreign key checks again
    $sql = 'CREATE TABLE Persons (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            age int(200),
             INDEX idx_id (id)
        );';

    if ($conn->query($sql) === TRUE) {
        echo 'Table MyGuests created successfully';
    } else {
        echo 'Error creating table: ' . $conn->error;
    }
    $conn->close();
}

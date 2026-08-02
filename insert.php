<?php

include "db.php";


// Insert new person
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST["name"];
    $age = $_POST["age"];


    // Prepared statement for security
    $stmt = $conn->prepare(
        "INSERT INTO people (name, age) VALUES (?, ?)"
    );

    $stmt->bind_param("si", $name, $age);


    if ($stmt->execute()) {
        echo "Person added successfully";
    } else {
        echo "Error: " . $conn->error;
    }


    $stmt->close();
    exit();
}



// Get all people records
$result = $conn->query("SELECT * FROM people ORDER BY id DESC");


$people = [];


while ($row = $result->fetch_assoc()) {
    $people[] = $row;
}


// Return JSON for JavaScript
echo json_encode($people);


$conn->close();

?>

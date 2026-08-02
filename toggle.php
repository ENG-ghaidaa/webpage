<?php

include "db.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {


    $id = $_POST["id"];


    // Get current status
    $result = $conn->query(
        "SELECT status FROM people WHERE id = $id"
    );


    $row = $result->fetch_assoc();


    // Change status
    $newStatus = ($row["status"] == 0) ? 1 : 0;



    // Update status using prepared statement
    $stmt = $conn->prepare(
        "UPDATE people SET status = ? WHERE id = ?"
    );


    $stmt->bind_param(
        "ii",
        $newStatus,
        $id
    );


    if ($stmt->execute()) {

        echo json_encode([
            "success" => true,
            "status" => $newStatus
        ]);

    } else {

        echo json_encode([
            "success" => false
        ]);

    }


    $stmt->close();

}


$conn->close();

?>

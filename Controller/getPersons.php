<?php
session_start();
include("../dbConnection.php");

try {
    $sql = "SELECT * FROM tbl_person";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $persons = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($persons);
} catch (PDOException $e) {
    echo json_encode(array("error" => "Veritabanı hatası: " . $e->getMessage()));
}
?>

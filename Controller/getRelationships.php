<?php
session_start();
include("../dbConnection.php");

try {
    $sql = "SELECT * FROM tbl_relationship";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $relationships = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($relationships);
} catch (PDOException $e) {
    echo json_encode(array("error" => "Veritabanı hatası: " . $e->getMessage()));
}
?>

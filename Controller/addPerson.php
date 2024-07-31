
<?php
session_start();
include ("../dbConnection.php");

try {
    $personID = $_POST['personID'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $birthDate = $_POST['birthDate'];
    $deathDate = $_POST['deathDate'];
    $gender = $_POST['gender'];
    $relation = $_POST['relation'];
    
    $sql = "INSERT INTO tbl_person (firstName, lastName, birthDate, deathDate, gender)
    VALUES (:firstName, :lastName, :birthDate, :deathDate, :gender)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':firstName', $firstName);
    $stmt->bindParam(':lastName', $lastName);
    $stmt->bindParam(':birthDate', $birthDate);
    $stmt->bindParam(':deathDate', $deathDate);
    $stmt->bindParam(':gender', $gender);
    $stmt->execute();

    $lastPersonID = $conn->lastInsertId();
    $sqlRelation = "INSERT INTO tbl_relationship (personID, childNo, wifeNo)
                    VALUES (:personID, :childNo, :wifeNo)";
    $stmtRelation = $conn->prepare($sqlRelation);
    
    // Parametreleri bağlayın
    $stmtRelation->bindParam(':personID', $personID);
    $stmtRelation->bindParam(':childNo', $childNo, PDO::PARAM_INT);
    $stmtRelation->bindParam(':wifeNo', $wifeNo, PDO::PARAM_INT);

    // `childNo` ve `wifeNo` değerlerini `NULL` olarak ayarlayın
    $childNo = null;
    $wifeNo = null;

    // İlişki türüne göre uygun parametreyi ayarlayın
    if ($relation == "cocuk") {
        $childNo = $lastPersonID;
    } elseif ($relation == "es") {
        $wifeNo = $lastPersonID;
    }

    // Sorguyu çalıştırın
    $stmtRelation->execute();
} catch (PDOException $e) {
    echo "Veritabanı hatası: " . $e->getMessage();
}
?>
 
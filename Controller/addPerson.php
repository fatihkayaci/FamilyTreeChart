
<?php
session_start();
include ("../dbConnection.php");

try {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $gender = $_POST['gender'];
    $birthDate = $_POST['birthDate']; // Kullanıcıdan gelen tarih: "15 Temmuz 2024"
    $deathDate = $_POST['deathDate'];
    
    $parentNo = $_POST['parentNo'];
    $wifeNo = $_POST['wifeNo'];

    $sql = "INSERT INTO tbl_person (firstName, lastName, gender, birthDate, deathDate)
    VALUES (:firstName, :lastName, :gender, :birthDate, :deathDate)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':firstName', $firstName);
    $stmt->bindParam(':lastName', $lastName);
    $stmt->bindParam(':gender', $gender);
    $stmt->bindParam(':birthDate', $birthDate);
    $stmt->bindParam(':deathDate', $deathDate);
    $stmt->execute();

    // Yeni eklenen kişinin ID'sini al
    $personID = $conn->lastInsertId();
    
    // parentNo boş değilse, ilişkileri ekle
    if (!empty($parentNo) || !empty($wifeNo)) {
        $sqlRelation = "INSERT INTO tbl_relationship (personID, parentNo, wifeNo)
        VALUES (:personID, :parentNo, :wifeNo)";
        $stmtRelation = $conn->prepare($sqlRelation);
        $stmtRelation->bindParam(':personID', $personID);
        $stmtRelation->bindParam(':parentNo', $parentNo);
        $stmtRelation->bindParam(':wifeNo', $wifeNo);
        $stmtRelation->execute();
    }
} catch (PDOException $e) {
    echo "Veritabanı hatası: " . $e->getMessage();
}
?>
 
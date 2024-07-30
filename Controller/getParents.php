<?php
session_start();
include("../dbConnection.php");

try {
    // `wifeNo` 0'dan büyük olan kişileri çekiyoruz
    $sql = "SELECT p.personID, CONCAT(p.firstName, ' ', p.lastName) AS fullName, r.wifeNo
            FROM tbl_person p
            JOIN tbl_relationship r ON p.personID = r.personID
            WHERE r.wifeNo > 0
            ORDER BY r.wifeNo, p.firstName, p.lastName";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // `wifeNo` değerlerini toplamak için bir dizi oluşturuyoruz
    $wifeNos = [];
    foreach ($results as $result) {
        $wifeNo = $result['wifeNo'];
        if (!isset($wifeNos[$wifeNo])) {
            $wifeNos[$wifeNo] = [
                'wifeNo' => $wifeNo,
                'persons' => [],
            ];
        }
        // Kişi bilgilerini ekleyin
        $wifeNos[$wifeNo]['persons'][] = [
            'personID' => $result['personID'],
            'fullName' => $result['fullName']
        ];
    }

    // Her `wifeNo` için isimleri birleştiriyoruz
    $output = [];
    foreach ($wifeNos as $wifeNo => $data) {
        // İsimleri virgülle ayırarak birleştiriyoruz
        $names = array_map(function($person) {
            return $person['fullName'];
        }, $data['persons']);

        $output[] = [
            'wifeNo' => $wifeNo,
            'persons' => $data['persons'], // Tam bilgi ile döndür
            'names' => implode(' ve ', $names) // İsimleri virgülle ayırarak birleştiriyoruz
        ];
    }

    echo json_encode($output);
} catch (PDOException $e) {
    echo json_encode(array("error" => "Veritabanı hatası: " . $e->getMessage()));
}
?>

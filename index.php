<!DOCTYPE html>
<html lang="tr">
<head>
    <?php
        session_start();
        include("dbConnection.php");
        
        try {
            // Kişileri çek
            $sqlPersons = "SELECT * FROM tbl_person";
            $stmtPersons = $conn->prepare($sqlPersons);
            $stmtPersons->execute();
            $persons = $stmtPersons->fetchAll(PDO::FETCH_ASSOC);    
           
            // İlişkileri çek
            $sqlRelations = "SELECT * FROM tbl_relationship";
            $stmtRelations = $conn->prepare($sqlRelations);
            $stmtRelations->execute();
            $relations = $stmtRelations->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            echo json_encode(array("error" => "Veritabanı hatası: " . $e->getMessage()));
        }?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Family Tree</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<?php 
foreach ($persons as $person) { ?>
    <div class="tree-container" id="treeContainer">
            <div class="circleContainer">
                <div class="content">
                    <div class="firstName" id="firstName" value="<?php echo $person['firstName'] ?>"><?php echo $person['firstName'] ?></div>
                    <div class="lastName" id="lastName" value="<?php echo $person['lastName'] ?> "><?php echo $person['lastName'] ?></div>
                </div>
                <div class="plus-sign" data-userid="<?php echo $person['personID'] ?>">+</div>
            </div>
    </div>
    <?php } ?>

    <!-- Popup Form -->
    <div id="popupForm" class="popup" >
        <div class="popup-content">
            <span class="close">&times;</span>
            <form id="personForm">
                <label for="firstName">First Name:</label>
                <input type="text" id="firstName" name="firstName" required><br>
                <label for="lastName">Last Name:</label>
                <input type="text" id="lastName" name="lastName" required><br>
                <label for="birthDate">Birth Date:</label>
                <input type="date" id="birthDate" name="birthDate"><br>
                <label for="deathDate">Death Date:</label>
                <input type="date" id="deathDate" name="deathDate"><br>
                <label for="gender">Cinsiyet:</label>
                <select id="gender" name="gender">
                    <option value="male">Erkek</option>
                    <option value="female">Kadın</option>
                </select><br>
                <label for="relation">Relation:</label>
                <select id="relation" name="relation">
                    <option value="cocuk">Çocuk</option>
                    <option value="es">Eş</option>
                </select><br>
                <button type="button" id="addPerson">Add Person</button>
            </form>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Family Tree Chart</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Buton -->
    <button id="openPopup">Yeni Kişi Ekle</button>

    <!-- Popup -->
    <div id="popup" class="popup">
        <div class="popup-content">
            <span class="close">&times;</span>
            <h2>Yeni Kişi Ekle</h2>
            <form id="addPersonForm">
                <label for="firstName">İsim:</label>
                <input type="text" id="firstName" name="firstName" required><br><br>
                <label for="lastName">Soyisim:</label>
                <input type="text" id="lastName" name="lastName" required><br><br>
                <label for="birthDate">Doğum Tarihi:</label>
                <input type="date" id="birthDate" name="birthDate"><br><br>
                <label for="deathDate">Ölüm Tarihi:</label>
                <input type="date" id="deathDate" name="deathDate"><br><br>
                <label for="gender">Cinsiyet:</label>
                <select id="gender" name="gender">
                    <option value="male">Erkek</option>
                    <option value="female">Kadın</option>
                </select><br><br>
                <label for="parentNo">Aile No:</label>
                <input type="number" id="parentNo" name="parentNo"><br><br>
                <label for="wifeNo">Eş No:</label>
                <input type="number" id="wifeNo" name="wifeNo"><br><br>
                <button type="button" id="addPerson">Ekle</button>
            </form>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="script.js"></script>
</body>
</html>

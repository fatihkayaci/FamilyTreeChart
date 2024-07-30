
document.addEventListener('DOMContentLoaded', function() {
    var popup = document.getElementById('popup');
    var openPopupButton = document.getElementById('openPopup');
    var closePopupButton = document.getElementsByClassName('close')[0];

    // Butona tıklanınca popup'ı aç
    openPopupButton.onclick = function() {
        popup.style.display = 'block';
    }

    // Kapatma butonuna tıklanınca popup'ı kapat
    closePopupButton.onclick = function() {
        popup.style.display = 'none';
    }

    // Popup'ın dışında bir yere tıklanırsa popup'ı kapat
    window.onclick = function(event) {
        if (event.target == popup) {
            popup.style.display = 'none';
        }
    }
    function loadPersons() {
        $.ajax({
            url: 'Controller/getPersons.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.error) {
                    alert(response.error);
                    return;
                }
                displayPersons(response);
            },
            error: function(xhr, status, error) {
                alert('Bir hata oluştu: ' + error);
            }
        });
    }

    // <img src="path/to/default/avatar.png" alt="${person.firstName}" class="avatar-img">
    function displayPersons(persons) {
        // Örneğin, bir container içinde kişilerle ilgili bilgileri gösterebilirsiniz
        var container = document.getElementById('personsContainer');
        container.innerHTML = '';
        persons.forEach(function(person) {
            var personDiv = document.createElement('div');
            personDiv.className = 'person-avatar';
            personDiv.innerHTML = `
                <p>${person.firstName}<br> ${person.lastName}</p>
            `;
            container.appendChild(personDiv);
        });
    }

    loadPersons(); // Sayfa yüklendiğinde kişileri getir
});
$(document).ready(function() {
    // Kişi ekleme
    $('#addPerson').on('click', function() {
        var firstName = $('#firstName').val();
        var lastName = $('#lastName').val();
        var birthDate = $('#birthDate').val();
        var deathDate = $('#deathDate').val();
        var gender = $('#gender').val();
        var parentNo = $('#parentNo').val() || null;
        var wifeNo = $('#wifeNo').val() || null;

        $.ajax({
            url: 'Controller/addPerson.php',  // PHP dosyasının yolu
            type: 'POST',
            data: {
                firstName: firstName,
                lastName: lastName,
                birthDate: birthDate,
                deathDate: deathDate,
                gender: gender,
                parentNo: parentNo,
                wifeNo: wifeNo
            },
            success: function(response) {
                alert("başarılı");
                location.reload();
            },
            error: function(xhr, status, error) {
                alert('Bir hata oluştu: ' + error);
            }
        });
    });
});

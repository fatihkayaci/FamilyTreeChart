document.addEventListener('DOMContentLoaded', function() {
    var popup = document.getElementById('popup');
    var openPopupButton = document.getElementById('openPopup');
    var closePopupButton = document.getElementsByClassName('close')[0];
    var parentSelect = document.getElementById('parentNo');
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

    // Kişi ekleme
    $('#addPerson').on('click', function() {
        var firstName = $('#firstName').val();
        var lastName = $('#lastName').val();
        var birthDate = $('#birthDate').val();
        var deathDate = $('#deathDate').val();
        var gender = $('#gender').val();
        var parentNo = $('#parentNo').val() || null;
        var wifeNo = $('#wifeNo').val() || null;
        console.log(parentNo);
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
                alert("Başarıyla eklendi");
                location.reload();
            },
            error: function(xhr, status, error) {
                alert('Bir hata oluştu: ' + error);
            }
        });
    });
   // Verileri yüklemek için fonksiyon
   function loadParentOptions() {
    $.ajax({
        url: 'Controller/getParents.php',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            if (data.error) {
                alert(data.error);
                return;
            }
            populateParentSelect(data);
        },
        error: function(xhr, status, error) {
            alert('Bir hata oluştu: ' + error);
        }
    });
}
function populateParentSelect(data) {
    parentSelect.innerHTML = '<option value="">Seçiniz</option>';
    let displayedWifeNos = new Set();

    data.forEach(function(group) {
        if (group.names.length > 0) {
            var option = document.createElement('option');
            // `group.persons` dizisinden ilk `personID`'yi alarak id olarak kullanıyoruz
            if (group.persons.length > 0) {
                option.value = group.persons[0].personID; // ilk kişinin `personID`'sini alıyoruz
            }

            option.textContent = group.names;

            // Eğer `wifeNo` değerini daha önce eklenmediyse listeye ekle
            if (!displayedWifeNos.has(group.wifeNo)) {
                parentSelect.appendChild(option);
                displayedWifeNos.add(group.wifeNo);
            }
        }
    });
}


loadParentOptions(); // Sayfa yüklendiğinde `select` seçeneklerini yükle
    function loadTree() {
        $.ajax({
            url: 'Controller/getRelationships.php',
            type: 'GET',
            dataType: 'json',
            success: function(relations) {
                if (relations.error) {
                    alert(relations.error);
                    return;
                }
                $.ajax({
                    url: 'Controller/getPersons.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function(persons) {
                        if (persons.error) {
                            alert(persons.error);
                            return;
                        }
                        drawFamilyTree(persons, relations);
                    },
                    error: function(xhr, status, error) {
                        alert('Bir hata oluştu: ' + error);
                    }
                });
            },
            error: function(xhr, status, error) {
                alert('Bir hata oluştu: ' + error);
            }
        });
    }
{/* <img src="path/to/default/avatar.png" alt="${person.firstName}" class="avatar-img"> */}
                        
    function drawFamilyTree(persons, relationships) {
        var container = document.getElementById('personsContainer');
        container.innerHTML = '';

        // Kişileri parentNo'ya göre grupla
        var parentMap = {};
        relationships.forEach(function(rel) {
            if (!parentMap[rel.parentNo]) {
                parentMap[rel.parentNo] = [];
            }
            parentMap[rel.parentNo].push(rel);
        });

        // Her bir parentNo grubunu çiz
        for (var parentNo in parentMap) {
            var rowDiv = document.createElement('div');
            rowDiv.className = 'person-row';

            parentMap[parentNo].forEach(function(rel) {
                var person = persons.find(p => p.personID == rel.personID);
                if (person) {
                    var personDiv = document.createElement('div');
                    personDiv.className = 'person-avatar';
                    personDiv.innerHTML = `
                        <p>${person.firstName}<br> ${person.lastName}</p>
                    `;
                    rowDiv.appendChild(personDiv);
                }
            });

            // Kişilerin parentNo değerine göre alt alta düzenlenmesi
            container.appendChild(rowDiv);
        }
    }

    loadTree(); // Sayfa yüklendiğinde ağaç verilerini getir
});

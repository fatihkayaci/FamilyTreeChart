$(document).ready(function() {
    // Formu göster/gizle
    $('#showFormButton').on('click', function() {
        $('#personForm').toggleClass('hidden');
    });

    // Kişi ekleme
    $('#addPerson').on('click', function() {
        var firstName = $('#firstName').val();
        var lastName = $('#lastName').val();
        var birthDate = $('#birthDate').val();
        var gender = $('#gender').val();
        var parentNo = $('#parentNo').val() || null;
        var wifeNo = $('#wifeNo').val() || null;

        $.ajax({
            url: 'addPerson.php',  // PHP dosyasının yolu
            type: 'POST',
            data: {
                firstName: firstName,
                lastName: lastName,
                birthDate: birthDate,
                gender: gender,
                parentNo: parentNo,
                wifeNo: wifeNo
            },
            success: function(response) {
                var data = JSON.parse(response);
                if (data.status === 'success') {
                    // Yeni eklenen kişiyi avatar olarak ekle
                   alert("başarılı");
                   location.reload();
                } else {
                    alert('Bir hata oluştu: ' + data.message);
                }
            },
            error: function(xhr, status, error) {
                alert('Bir hata oluştu: ' + error);
            }
        });
    });
});

$(document).ready(function() {
    var selectedPerson = null;
    // popup açıp kapatma işlemi
    $('.plus-sign').click(function() {
        selectedPerson = $(this).data('userid');
        $('#popupForm').show();
    });

    // Kapatma düğmesine tıklama olayını dinle
    $('.popup .close').click(function() {
        $('#popupForm').hide();
    });

    // Popup dışında bir yere tıklanırsa popup'ı kapat
    $(window).click(function(event) {
        if ($(event.target).is('#popupForm')) {
            $('#popupForm').hide();
        }
    });

    // add person
    $('#addPerson').click(function() {
        var formData = {
            firstName: $('input[name="firstName"]').val(),
            lastName: $('input[name="lastName"]').val(),
            birthDate: $('input[name="birthDate"]').val(),
            deathDate: $('input[name="deathDate"]').val() || null,
            gender: $('select[name="gender"]').val(),  // Burada select elemanının değerini alıyoruz 
            relation: $('select[name="relation"]').val(),  // Burada select elemanının değerini alıyoruz
            selectedPerson: selectedPerson
        }
        // console.log(formData.firstName);
        // console.log(formData.lastName);
        // console.log(formData.birthDate);
        // console.log(formData.deathDate);
        // console.log(formData.relation);
        // console.log(formData.selectedPerson);
        $.ajax({
            url: 'Controller/addPerson.php',
            type: 'POST',
            data: {
                personID:formData.selectedPerson,
                firstName: formData.firstName,
                lastName: formData.lastName,
                birthDate: formData.birthDate,
                deathDate: formData.deathDate,
                gender: formData.gender,
                relation: formData.relation
            },
            success: function(response) {
                alert(response);
                location.reload();
            },
            error: function(error) {
                console.error("AJAX hatası: ", error);
            }
        });
    });
});

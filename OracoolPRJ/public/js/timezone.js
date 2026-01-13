// Funzione per impostare il fuso orario dell'utente
function setTimezone() {

    // Ottiene il fuso orario dell'utente
    var userTimezone = Intl.DateTimeFormat().resolvedOptions().timeZone;

    $.ajax({
        url: '/set-timezone',
        type: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            timezone: userTimezone
        },
        success: function (response) {
            console.log('Timezone set successfully:', response);
        }
    });
}
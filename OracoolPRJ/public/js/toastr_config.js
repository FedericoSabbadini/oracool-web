// Configurazione di Toastr per le notifiche

toastr.options = {
    "closeButton": true,                        // Aggiunge un pulsante per chiudere la notifica
    "progressBar": true,                        // Mostra una barra di progresso
    "positionClass": "toast-bottom-right",      // Posizione delle notifiche (in alto a destra)
    "timeOut": "5000",                          // Durata della notifica in millisecondi (5 secondi)
    "extendedTimeOut": "1000",                  // Tempo extra dopo che l'utente passa sopra la notifica
    "showEasing": "swing",                      // Tipo di transizione quando appare
    "hideEasing": "linear",                     // Tipo di transizione quando scompare
    "showMethod": "fadeIn",                     // Come appare la notifica
    "hideMethod": "fadeOut",                    // Come scompare la notifica
    "newestOnTop": false,                       // Le notifiche più recenti appaiono in cima  
};
/**
 * Inizializza una DataTable con configurazioni personalizzate
 * @param {string} tableId - ID della tabella (default: 'dataTable')
 * @param {Object} options - Opzioni personalizzate per sovrascrivere quelle di default
 */
function initializeDataTable(tableId = 'dataTable', options = {}) {
    $(document).ready(function () {

        const defaultConfig = {
            // Configurazioni generali
            pageLength: 10,                     // Numero di righe per pagina
            searching: true,                    // Attiva ricerca
            ordering: true,                     // Attiva ordinamento
            paging: true,                       // Attiva paginazione
            info: true,                         // Mostra info sulle righe visualizzate
            lengthChange: true,                 // Permetti di cambiare il numero di righe per pagina
            autoWidth: false,                   // Disabilita la larghezza automatica delle colonne
            scrollX: false,                     // Disabilita la barra di scorrimento orizzontale
            pagingType: "simple_numbers",       // Tipo di paginazione (numeri semplici)
            responsive: true,                   // Rende la tabella reattiva

            // Personalizzazione layout: ricerca e paginazione nella stessa riga sopra la tabella
            dom: '<"row"<"col-6"f><"col-6 custom-pagination"p>>' +  // Per schermi più piccoli la paginazione e ricerca sono su righe separate
                '<"row"<"col-12"tr>>',

            // Personalizzare il comportamento delle colonne
            columnDefs: [
                {
                    orderable: false,
                    targets: 1 // Disabilita ordinamento sulla colonna della posizione
                }
            ],
            order: [[0, 'asc']], // Ordina per la prima colonna in ordine ascendente

            // Impostazioni per la ricerca
            language: {
                search: "_INPUT_", // Cambia la ricerca da "Search" a un input più pulito
                searchPlaceholder: "Cerca...", // Placeholder di default (può essere sovrascritto)
                paginate: {
                    previous: '<i class="fas fa-arrow-left"></i>',
                    next: '<i class="fas fa-arrow-right"></i>'
                },
            },
        };

        // Unisce la configurazione di default con le opzioni personalizzate
        const config = $.extend(true, {}, defaultConfig, options);
        const table = $('#' + tableId).DataTable(config);

        // Applicazioni di stile personalizzate
        applyCustomStyles(tableId);

        return table;
    });
}


function applyCustomStyles(tableId) {

    // Migliorare l'estetica del campo di ricerca
    $('.dataTables_filter input').addClass('form-control').css({
        'background-color': '#d7eaff',
        'height': '34px'
    });

    // Uniformare l'altezza delle barre di paginazione e ricerca
    $('.dataTables_length select').css('height', '38px');
    $('.dataTables_paginate').css('height', '38px');

    // Modificare la distanza dalla barra di paginazione e centrarla nella riga
    $('.dataTables_paginate').css({
        'margin-bottom': '20px',
    });

    // Disabilita la scrollbar orizzontale
    $('#' + tableId + '_wrapper').css('overflow-x', 'hidden');

    // Aggiungi un cursore a tutte le intestazioni
    $('#' + tableId).css('cursor', 'pointer');
}

// Esempio di utilizzo
//
// <script> initializeDataTable('myTableId', { pageLength: 20, searching: false }); </script>
//
// <script> 
// initializeDataTable('myTableId', {
//     columnDefs: [
//         { targets: 0, orderable: false }, // Disabilita ordinamento
//         { targets: 1, className: 'dt-body-center' } // Centra il testo della colonna
//     ],   
//     order: [[1, 'desc']] // Ordina per la seconda colonna in ordine discendente
// }); 
// </script>
//
$(document).ready(function() {
    $('#tabela1').DataTable( {
        dom: 'Bfrtip',
        "aaSorting": [],
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.12.1/i18n/pt-BR.json'
        },
        "responsive": true,
        buttons: [
            'excelHtml5',
            'pdfHtml5',
            "colvis"
        ]
    } );
} );
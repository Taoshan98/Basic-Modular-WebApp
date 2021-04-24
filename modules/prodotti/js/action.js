$(document).ready(function () {

    // Init Datatables
    var table = $('#mainTable').DataTable({

            "ajax": {url: "ajax/populateTable.php", dataSrc: '', async: false},
            "order": [[0, "asc"]],
            "columnDefs": [
                {
                    "targets": [0],
                    "visible": false
                }
            ],
        }
    );

    // Funzione Click Tabella
    $('#mainTable tbody').on('click', 'tr', function () {
        table.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
        let idSelectedRow = $('#mainTable').DataTable().row('.selected').data()[0];
        $('.btn-edit').attr("href", "form.php?type=edit&id=" + idSelectedRow)
        $('.btn-edit').removeClass('disabled');
        $('.btn-del').removeClass('disabled');
    });

    /** Doppio click per la view di edit */
    $('#mainTable tbody').on('dblclick', 'tr', function () {
        table.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
        let idSelectedRow = $('#mainTable').DataTable().row('.selected').data()[0];
        window.location.replace("form.php?type=edit&id=" + idSelectedRow);
    });

    /** Calcolo totale Ordine */
    $("#quantita, #prodotto").on("keypress change", function () {
        let idProdotto = $('#prodotto').val();
        let costoUnitario = $('#prodotto option[value="' + idProdotto + '"]').attr('data-costoUnitario')
        let quantita = $('#quantita').val();

        $('#totaleOrdine').val("€ " + (costoUnitario * quantita).toFixed(2));
    });

    $('#submit').on("click", function (){

        let data = {
            "descrizione" : $('#descrizione').val(),
            "costo_unitario" : $('#costo_unitario').val(),
        };

        $.ajax({
            method: "POST",
            url: "ajax/saveRecord.php?typeView=" + $('#typeView').val() + "&id=" + $('#idProdotto').val(),
            async: false,
            data: data,
            dataType: "json",
            success: function (res) {
                if (res['saved']){
                    window.location.replace("index.php");
                }else{
                    const swalWithBootstrapButtons = Swal.mixin({
                        customClass: {
                            cancelButton: 'btn btn-sm btn-secondary'
                        },
                        buttonsStyling: true
                    })
                    swalWithBootstrapButtons.fire({
                        title: "Attenzione",
                        text: "Compila i campi obbligatori (*)",
                        icon: 'warning',
                        showCancelButton: true,
                    })
                }

            }
        });
    });

    $('.btn-del').on('click', function (){
        let idSelectedRow = $('#mainTable').DataTable().row('.selected').data()[0];

        $.ajax({
            url: "ajax/deleteRecord.php?id=" + idSelectedRow,
            async: false,
            success: function () {
                window.location.reload();
            }
        });
    });


    let mainTableRows = [];

    $.each($('#mainTable').DataTable().rows({search: 'applied'}).data(), function (i, item) {
        mainTableRows.push({0: item[1], 1: item[2], 2: item[3], 3: item[4], 4: item[5]});
    });

    $("#pdf").on("click", function () {

        // Creato l'istanza chart sia per creare il report che il pie chart
        var chart = am4core.create("chartdiv", am4charts.PieChart);

        Promise.all([
            chart.exporting.pdfmake,
        ]).then(function (res) {

            let doc = {
                styles: {
                    header: {
                        fontSize: 18,
                        bold: true
                    },
                    tableHeader: {
                        bold: true,
                        fontSize: 13,
                        color: 'black',
                        alignment: 'center'
                    }
                },

                pageSize: "A4",
                pageOrientation: "portrait",
                pageMargins: [30, 30, 30, 30],
                content: [
                    {
                        text: 'Report Prodotti',
                        style: 'header',
                        alignment: 'center',
                    },
                    ' ',
                    ' ',
                    composeTable(mainTableRows, [
                        {text: 'Prodotto', style: 'tableHeader'},
                        {text: 'Costo Unitario', style: 'tableHeader'},
                    ], ['*', '*']),
                ]
            }
            pdfMake.createPdf(doc).download("Report Prodotti.pdf");
        });
    });


});

function buildTableBody(data, columns) {
    var body = [];

    body.push(columns);

    let columnNames = columns;

    if ('text' in columns[0]) {
        columnNames = columns.map(function (value) {
            return value['text'];
        })
    }

    data.forEach(function (row) {
        var dataRow = [];

        $.each(columnNames, function (i) {
            dataRow.push(row[i]);
        })

        body.push(dataRow);

    });

    return body;
}

function composeTable(data, columns, widths) {
    return {
        table: {
            widths: widths,
            body: buildTableBody(data, columns),
            pageBreak: 'after'
        }
    };
}

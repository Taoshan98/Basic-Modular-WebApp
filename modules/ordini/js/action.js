$(document).ready(function () {

    calcolaTotaleOrdine();
    // Init Datatables Tabella della dashboard
    var table = $('#mainTable').DataTable({
            "ajax": {url: "ajax/populateTable.php", dataSrc: '', async: false},
            "order": [[0, "asc"]],
            "columnDefs": [
                {
                    "targets": [0],
                    "visible": false
                }
            ],
        });

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
        calcolaTotaleOrdine();
    });

    $('#submit').on("click", function () {

        let data = {
            "id_operatore": $('#operatore').val(),
            "id_prodotto": $('#prodotto').val(),
            "quantita": $('#quantita').val(),
        };

        $.ajax({
            method: "POST",
            url: "ajax/saveRecord.php?typeView=" + $('#typeView').val() + "&id=" + $('#idOrdine').val(),
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

    $('.btn-del').on('click', function () {
        let idSelectedRow = $('#mainTable').DataTable().row('.selected').data()[0];

        $.ajax({
            url: "ajax/deleteRecord.php?id=" + idSelectedRow,
            async: false,
            success: function () {
                window.location.reload();
            }
        });
    });


    /***
     *
     * Codice per Report e grafico
     *
     */

    /**
     *  Prendo tutte le rghe attualmente visibili nella tabella
     */
    let mainTableRows = [];
    $.each($('#mainTable').DataTable().rows({search: 'applied'}).data(), function (i, item) {
        mainTableRows.push({0: item[1], 1: item[2], 2: item[3], 3: item[4], 4: item[5]});
    });

    /** Organizzo i i valore delle varie date per comporre il grafico */
    let ordersDate = mainTableRows.map(function (value) {
        return value[4];
    })

    let supportArrayDate = {}
    let valueCount = 0
    $.each(ordersDate, function (index, date) {

        valueCount = 0;
        if (date in supportArrayDate) {
            valueCount = supportArrayDate[date]['value'] += 1;
        }

        supportArrayDate[date] = {"day": date, "value": valueCount};
    });

    let filteredOrdersDate = [];
    let indexDay = 0;
    $.each(supportArrayDate, function (i, item) {
        filteredOrdersDate[indexDay] = item;
        indexDay++;
    });

    let chart = createChart("chartToHide", "value", "day");
    createChart("chartModal", "value", "day");

    /** Creo il report e lo faccio scaricare all'utente */
    $("#pdf").on("click", function () {

        Promise.all([
            chart.exporting.pdfmake,
            chart.exporting.getImage("png"),
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
                        text: 'Report Ordini',
                        style: 'header',
                        alignment: 'center',
                    },
                    ' ',
                    ' ',
                    composeTable(mainTableRows, [
                        {text: 'Operatore', style: 'tableHeader'},
                        {text: 'Prodotto', style: 'tableHeader'},
                        {text: 'Quantità', style: 'tableHeader'},
                        {text: 'Totale', style: 'tableHeader'},
                        {text: 'Data', style: 'tableHeader'},
                    ], ['*', '*', '*', '*', '*']),
                    {
                        image: res[1],
                        width: 535,
                        height: 210
                    }
                ]

            }
            pdfMake.createPdf(doc).download("Report Ordini.pdf");
        });
    });

    /**
     * Funzione che crea le righe della tabella
     * in base alla struttura che serve a makePdf
     *
     * @param data
     * @param columns
     * @returns {[]}
     */
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

    /**
     * Inizializza il tag della tabella
     *
     * @param data
     * @param columns
     * @param widths
     * @returns {{table: {pageBreak: string, widths, body: *[]}}}
     */
    function composeTable(data, columns, widths) {
        return {
            table: {
                widths: widths,
                body: buildTableBody(data, columns),
                pageBreak: 'after'
            },
        };
    }

    function createChart(chartDiv, value, category){
        // Creato l'istanza chart sia per creare il report che il pie chart
        let chart = am4core.create(chartDiv, am4charts.PieChart);

        chart.data = filteredOrdersDate;

        // Add and configure Series
        let pieSeries = chart.series.push(new am4charts.PieSeries());
        pieSeries.dataFields.value = value;
        pieSeries.dataFields.category = category;
        pieSeries.slices.template.stroke = am4core.color("#fff");
        pieSeries.slices.template.strokeOpacity = 1;

        // This creates initial animation
        pieSeries.hiddenState.properties.opacity = 1;
        pieSeries.hiddenState.properties.endAngle = -90;
        pieSeries.hiddenState.properties.startAngle = -90;
        chart.hiddenState.properties.radius = am4core.percent(0);

        return chart;
    }

    function calcolaTotaleOrdine(){
        let idProdotto = $('#prodotto').val();
        let costoUnitario = $('#prodotto option[value="' + idProdotto + '"]').attr('data-costoUnitario')
        let quantita = $('#quantita').val();

        $('#totaleOrdine').val("€ " + (costoUnitario * quantita).toFixed(2));
    }

    $('#chartToHide').hide()
});

<?php
include $_SERVER['DOCUMENT_ROOT'] . "/includes/header.php";
include $_SERVER['DOCUMENT_ROOT'] . "/includes/navbar.php";
?>

<main class="container">
    <div class="row">
        <div class="col-lg-12 col-xs-12 col-sm-12">
            <h2 class="mb-5">Ordini</h2>
            <div class="portlet light bordered">

                <div class="mb-3">
                    <button id="pdf" class="mb-1 btn btn-info">
                        <i class="fa fa-print"></i> Esporta PDF
                    </button>
                    <a href="form.php?type=add" class="mb-1 btn btn-success">
                        <i class="fa fa-plus"></i> Aggiungi
                    </a>
                    <a href="" class="mb-1 btn-edit disabled btn btn-primary">
                        <i class="fa fa-edit"></i> Modifica
                    </a>
                    <button type="button" class="mb-1 disabled btn-del btn btn-danger"><i class="fa fa-trash"></i> Elimina
                    </button>
                    <button type="button" class="mb-1 btn btn-warning" data-bs-toggle="modal" data-bs-target="#pieChart">
                        <i class="fas fa-chart-pie"></i> Grafico
                    </button>
                </div>

                <div class="portlet light portlet-fit portlet-datatable">

                    <div class="portlet-body">
                        <div class="table-container">
                            <!-- BEGIN TABLE  -->
                            <table id="mainTable" class="hover stripe display dt-responsive " style="width:100%">

                                <thead>
                                <tr>
                                    <th>id</th>
                                    <th>Operatore</th>
                                    <th>Prodotto</th>
                                    <th>Quantità</th>
                                    <th>Totale</th>
                                    <th>Data</th>
                                </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                            <!-- END TABLE -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="chart chartToHide" id="chartToHide"></div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="pieChart" tabindex="-1" aria-labelledby="pieChart" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="pieChartLabel">Percentuali ordini effettuati nei giorni</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="chart " id="chartModal"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php
include $_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php";
?>

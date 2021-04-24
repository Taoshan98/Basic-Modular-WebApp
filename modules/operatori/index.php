<?php
include $_SERVER['DOCUMENT_ROOT'] . "/includes/header.php";
include $_SERVER['DOCUMENT_ROOT'] . "/includes/navbar.php";
?>

<main class="container">
    <div class="row">
        <div class="col-lg-12 col-xs-12 col-sm-12">
            <h2 class="mb-5">Operatori</h2>
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
                </div>
                <div class="portlet light portlet-fit portlet-datatable">

                    <div class="portlet-body">
                        <div class="table-container">

                            <!-- BEGIN TABLE  table table-striped table-bordered dt-responsive nowrap" style="width:100%" -->
                            <!--<table id="mainTable" class="row-border hover display" >-->
                            <table id="mainTable" class="hover stripe display dt-responsive " style="width:100%">
                                <thead>
                                <tr>
                                    <th>id</th>
                                    <th>Nome</th>
                                    <th>Cognome</th>
                                </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                            <!-- END TABLE -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

</main>

<?php
include $_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php";
?>

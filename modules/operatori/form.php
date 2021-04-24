<?php
$dbConn = "";

include $_SERVER['DOCUMENT_ROOT'] . "/includes/header.php";
include $_SERVER['DOCUMENT_ROOT'] . "/includes/navbar.php";

$typeForm = "Aggiungi";
if (isset($_GET['type'])){
    $typeForm = ($_GET['type'] === "add" ? "Aggiungi" : "Modifica");
}

$operatore = ['nome' => '', "cognome" => ''];
if ($_GET['type'] === "edit"){
    $operatore = $dbConn->query("SELECT * FROM `operatori` WHERE `id` = :id", array("id" => $_GET['id']))[0];
}
?>

<main class="container">
    <input hidden id="typeView" value="<?= $_GET['type'] ?>">
    <input hidden id="idOperatore" value="<?= $_GET['id'] ?>">
    <h3 class="form-section mb-5"><?php echo "Operatori - " . $typeForm ?></h3>
    <form action="#" id="form" class="horizontal-form" enctype="multipart/form-data" autocomplete="off">
        <!-- BEGIN PAGE BASE CONTENT -->
        <div class="row">
            <div class="col-lg-12 col-xs-12 col-sm-12">
                <div class="portlet light bordered">
                    <div class="portlet-body form">
                        <!-- BEGIN FORM-->
                        <div class="form-body">
                            <!--/row-->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Nome * </label>
                                        <input id="nome" type="text" class="form-control" value="<?= $operatore['nome'] ?>">
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cognome" class="control-label">Cognome * </label>
                                        <input id="cognome" type="text" class="disabled form-control" value="<?= $operatore['cognome'] ?>">
                                    </div>
                                </div>
                            </div>
                            <!--/row-->
                        </div>
                        <!--/span-->
                    </div>
                </div>
            </div>
        </div>
        <!-- END PAGE BASE CONTENT -->

        <div class="mt-2 d-grid gap-2 d-md-flex justify-content-md-start">
            <button id="submit" class="btn btn-primary me-md-2" type="button">Salva</button>
            <a id="cancel" href="index.php" class="btn btn-secondary" type="button">Annulla</a>
        </div>
    </form>
</main>
<?php
include $_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php";
?>

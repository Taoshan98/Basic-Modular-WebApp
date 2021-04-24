<?php
$dbConn = "";

include $_SERVER['DOCUMENT_ROOT'] . "/includes/header.php";
include $_SERVER['DOCUMENT_ROOT'] . "/includes/navbar.php";

$typeForm = "Aggiungi";
if (isset($_GET['type'])){
    $typeForm = ($_GET['type'] === "add" ? "Aggiungi" : "Modifica");
}

$prodotto = ['descrizione' => '', "costo_unitario" => ''];
if ($_GET['type'] === "edit"){
    $prodotto = $dbConn->query("SELECT * FROM `prodotti` WHERE `id` = :id", array("id" => $_GET['id']))[0];
}
?>

<main class="container">
    <input hidden id="typeView" value="<?= $_GET['type'] ?>">
    <input hidden id="idProdotto" value="<?= $_GET['id'] ?>">
    <h3 class="form-section mb-5"><?php echo "Prodotti - " . $typeForm ?></h3>
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
                                        <label class="control-label">Descrizione * </label>
                                        <input id="descrizione" type="text" class="form-control" value="<?= $prodotto['descrizione'] ?>">
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="costo_unitario" class="control-label">Costo Unitario * </label>
                                        <input id="costo_unitario" type="text" class="disabled form-control" value="<?= $prodotto['costo_unitario'] ?>">
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

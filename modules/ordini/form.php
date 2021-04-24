<?php
$dbConn = "";

include $_SERVER['DOCUMENT_ROOT'] . "/includes/header.php";
include $_SERVER['DOCUMENT_ROOT'] . "/includes/navbar.php";

$typeForm = "Aggiungi";
if (isset($_GET['type'])) {
    $typeForm = ($_GET['type'] === "add" ? "Aggiungi" : "Modifica");
}

$ordine = ['nome' => '', "cognome" => '', 'quantita' => ''];
if ($_GET['type'] === "edit") {
    $ordine = $dbConn->query("SELECT * FROM `ordine` WHERE `id` = :id", array("id" => $_GET['id']))[0];
}

$prodotti = $dbConn->query("SELECT * FROM `prodotti`");
$operatori = $dbConn->query("SELECT * FROM `operatori`");

?>

<main class="container">
    <input hidden id="typeView" value="<?= $_GET['type'] ?>">
    <input hidden id="idOrdine" value="<?= $_GET['id'] ?>">
    <h3 class="form-section mb-5"><?php echo "Ordini - " . $typeForm ?></h3>
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
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Operatore *</label>
                                        <select id="operatore" class="form-select">
                                            <?php
                                            foreach ($operatori as $operatore) {
                                                $isSelected = ($ordine['id_operatore'] === $operatore['id'] ? "selected" : "");
                                                echo '<option ' . $isSelected . '  value="' . $operatore['id'] . '">' . $operatore['nome'] . ' ' . $operatore['cognome'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Prodotto *</label>
                                        <select id="prodotto" class="form-select" aria-label="Default select example">
                                            <?php
                                            foreach ($prodotti as $prodotto) {
                                                $isSelected = ($ordine['id_prodotto'] === $prodotto['id'] ? "selected" : "");
                                                echo '<option ' . $isSelected . ' data-costoUnitario="' . $prodotto['costo_unitario'] . '" value="' . $prodotto['id'] . '">' . $prodotto['descrizione'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Quantità * </label>
                                        <input id="quantita" type="text" class="form-control"
                                               value="<?= $ordine['quantita'] ?>">
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="totaleOrdine" class="control-label">Totale * </label>
                                        <input id="totaleOrdine" type="text" disabled class="disabled form-control">
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

        <div class="mt-2 d-grid gap-2 d-md-flex justify-content-md-start">
            <button id="submit" class="btn btn-primary me-md-2" type="button">Salva</button>
            <a id="cancel" href="index.php" class="btn btn-secondary" type="button">Annulla</a>
        </div>

        <!-- END PAGE BASE CONTENT -->
    </form>
</main>
<?php
include $_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php";
?>

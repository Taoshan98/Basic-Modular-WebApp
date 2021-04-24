<?php
$dbConn = '';

include $_SERVER['DOCUMENT_ROOT'] . "/includes/header.php";
include $_SERVER['DOCUMENT_ROOT'] . "/includes/navbar.php";

$ordini = $dbConn->query("SELECT * FROM `ordine`");
$prodotti = $dbConn->query("SELECT * FROM `prodotti`");
$operatori = $dbConn->query("SELECT * FROM `operatori`");

?>

<main class="container">

    <h2 class="mb-5">Dashboard</h2>

    <div class="row">

        <div class="col-md-4 col-xl-4">
            <div class="card bg-c-blue order-card dashboard-link" data-route="ordini">
                <div class="card-block">
                    <h4 class="m-b-20">Ordini</h4>
                    <h2 class="text-right"><i class="fa fa-cart-plus f-left"></i><span><?= count($ordini) ?></span></h2>
                    <a class="text-white text-right"><i class="fas fa-arrow-right f-center"></i></a>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-xl-4">
            <div class="card bg-c-green order-card dashboard-link" data-route="operatori">
                <div class="card-block">
                    <h4 class="m-b-20">Operatori</h4>
                    <h2 class="text-right"><i class="fa fa-users f-left"></i><span><?= count($operatori) ?></span></h2>
                    <a class="text-white text-right"><i class="fas fa-arrow-right f-center"></i></a>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-xl-4">
            <div class="card bg-c-pink order-card dashboard-link" data-route="prodotti">
                <div class="card-block">
                    <h4 class="m-b-20">Prodotti</h4>
                    <h2 class="text-right"><i class="fas fa-archive f-left"></i><span><?= count($prodotti) ?></span></h2>
                    <a class="text-white text-right"><i class="fas fa-arrow-right f-center"></i></a>
                </div>
            </div>
        </div>

    </div>
</main>

<?php
include $_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php";
?>

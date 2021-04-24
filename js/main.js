$(document).ready(function () {
    $("#logout").on("click", function () {
        $.ajax({
            url: "../../ajax/logout.php",
            success: function (){
                window.location.replace("../../../index.php");
            }
        });

    });


    $(".nav-link, .dashboard-link").on("click", function () {

        let route = $(this).data("route");

        $.ajax({
            url: "../../../index.php",
            method: "POST",
            data: {"m" : route},
            success: function (){
                window.location.replace("../../../modules/" + route);
            }
        });



    });
});

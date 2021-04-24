$(document).on('click', "#submit", function (event) {

    if ($("#username").val() !== "" && $("#password").val() !== "") {
        $.ajax({
            method: "POST",
            url: "ajax/userCheck.php",
            dataType: "json",
            async: false,
            data: {username: $("#username").val(), password: $("#password").val(), typeAction: 'login'},
            success: function (res) {
                if (!res['isVerified']) {

                    const swalWithBootstrapButtons = Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-sm btn-success',
                            cancelButton: 'btn btn-sm btn-secondary'
                        },
                        buttonsStyling: true
                    })

                    swalWithBootstrapButtons.fire({
                        title: 'Non sei registrato!',
                        text: "Vuoi registrarti con queste credenziali?",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Yes',
                        cancelButtonText: 'Cancel',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.value) {
                            $.ajax({
                                url: "ajax/userCheck.php",
                                method: 'POST',
                                dataType: "json",
                                async: false,
                                data: {
                                    username: $("#username").val(),
                                    password: $("#password").val(),
                                    typeAction: 'signUp'
                                },
                                success: function (ret) {
                                    if (ret['isVerified']) {
                                        window.location.replace("../../../index.php");
                                    } else {
                                        const swalWithBootstrapButtons = Swal.mixin({
                                            customClass: {
                                                cancelButton: 'btn btn-sm btn-secondary'
                                            },
                                            buttonsStyling: true
                                        })
                                        swalWithBootstrapButtons.fire({
                                            title: "Errore",
                                            text: "Errore durante la registrazione",
                                            icon: 'error',
                                            showCancelButton: true,
                                        })
                                    }
                                },
                            });
                        }
                    });
                } else {
                    window.location.replace("../../../index.php");
                }

            },
        });
    } else {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                cancelButton: 'btn btn-sm btn-secondary'
            },
            buttonsStyling: true
        })
        swalWithBootstrapButtons.fire({
            title: "Attenzione",
            text: "Inserire Credenziali",
            icon: 'warning',
            showCancelButton: true,
        })
    }
    event.preventDefault();
});

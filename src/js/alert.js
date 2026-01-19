document.addEventListener('DOMContentLoaded', function() {
    var alertButtons = document.querySelectorAll('.alert-button');

    alertButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            Swal.fire({
                title: '¿Desea guardar los Cambios?',
                text: 'Elige una opción',
                icon: 'question',
                showCancelButton: true,
                showDenyButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                denyButtonColor: '#aaaaaa',
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
                denyButtonText: 'Tal vez después'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                        '¡Acción Aceptada!',
                        'Los cambios se guardaron con éxtio',
                        'success'
                    )
                } else if (result.isDenied) {
                    Swal.fire(
                        'Acción Postergada',
                        'Has seleccionado la opción de Tal vez después.',
                        'info'
                    )
                } else if (result.isDismissed) {
                    Swal.fire(
                        'Acción Cancelada',
                        'Has cancelado la acción.',
                        'error'
                    )
                }
            });
        });
    });
});


document.addEventListener('DOMContentLoaded', function() {
    var confirmButtons = document.querySelectorAll('.confirm-button');

    confirmButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            Swal.fire({
                title: '¿Estás seguro de esta acción?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, ¡hazlo!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                        '¡Hecho!',
                        'Tu acción ha sido completada.',
                        'success'
                    )
                }
            })
        });
    });
});


document.addEventListener('DOMContentLoaded', function() {
    var successButton = document.getElementById('successButton');

    successButton.addEventListener('click', function() {
        Swal.fire({
            position: "top-end",
            icon: "success",
            title: "El registro se ha realizado exitósamente",
            showConfirmButton: false,
            timer: 1500
          });
    });
});

document.addEventListener('DOMContentLoaded', function() {
    var tripleButtons = document.querySelectorAll('.triple-button');

    tripleButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            Swal.fire({
                title: 'Elige una opción',
                text: 'Selecciona una de las siguientes acciones',
                icon: 'question',
                showCancelButton: true,
                showDenyButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                denyButtonColor: '#aaaaaa',
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
                denyButtonText: 'Tal vez después'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                        '¡Acción Aceptada!',
                        'Has seleccionado la opción de Aceptar.',
                        'success'
                    )
                } else if (result.isDenied) {
                    Swal.fire(
                        'Acción Postergada',
                        'Has seleccionado la opción de Tal vez después.',
                        'info'
                    )
                } else if (result.isDismissed) {
                    Swal.fire(
                        'Acción Cancelada',
                        'Has cancelado la acción.',
                        'error'
                    )
                }
            });
        });
    });
});



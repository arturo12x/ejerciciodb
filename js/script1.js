//TAREA VALIDAR CON EXPRESIONES REGULARES O SUBSTRINGS EL DOMINIO UTLAGUNA.EDU.MX

$(document).ready(function () {
    $('#form1').validate({
        rules: {
            nombre: {
                required: true
            },
            apelido: {
                required: true
            },
            edad: {
                required: true
            },
            email: {
                required: true,
                email: true
            }
        }
    });

    $('#add').click(function () {

        if ($('#form1').valid()) {
            const $result = $('#warning');
            const email = $('#email').val();
            $result.text('');

            if (!validaremail(email)) {
                $result.text('Invalid Address');
                return;
            }

            console.log('email valido');

            var formData = $('#form1').serialize();
            formData += "&accion=agregar";
            $.ajax({
                data: formData,
                type: 'POST',
                url: 'php/crud.php',
                success: function (data) {

                    resp1 = JSON.parse(data);
                    var codigo = resp1.code;
                    var mensaje = resp1.desc;
                    var idst = resp1.idstu;
                    if (codigo == 1000) {
                        alert(mensaje)

                    }

                    if (codigo == 1001) {
                        alert(mensaje + " " + idst);

                    }
                    if (codigo == 1002) {
                        alert(mensaje);
                    }
                }
            });

        }
    });

    $('#update').click(function () {
        var formData = $('#form1').serialize();
        formData += "&accion=actualizar";

        $.ajax({
            data: formData,
            type: 'POST',
            url: 'php/crud.php',
            success: function (data) {
                resp1 = JSON.parse(data);

                var codigo = resp1.code;
                var mensaje = resp1.desc;
                var idst = resp1.idstu;

                if (codigo == 2000) {
                    alert(mensaje);

                }

                if (codigo == 2001) {
                    alert(mensaje + " " + idst);

                }
                if (codigo == 2002) {
                    alert(mensaje);
                }

            }
        });
    });


    $('#delete').click(function () {
        var formData = $('#form1').serialize();
        formData += "&accion=eliminar";

        $.ajax({
            data: formData,
            type: 'POST',
            url: 'php/crud.php',
            success: function (data) {

                resp1 = JSON.parse(data);

                var codigo = resp1.code;
                var mensaje = resp1.desc;
                var idst = resp1.idstu;

                if (codigo == 3000) {
                    alert(mensaje);

                }

                if (codigo == 3001) {
                    alert(mensaje + " " + idst);


                }
                if (codigo == 3002) {
                    alert(mensaje);

                }


            }
        });
    });


});

function validaremail(email) {
    console.log('validacion de email');
    const re = /^[a-zA-Z0-9_.+-]+@?(utlaguna.edu.mx|UTLAGUNA.EDU.MX)$/g
    return re.test(email);
}

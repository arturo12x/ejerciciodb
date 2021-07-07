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
            formData += ""; //TODO: REGRESAR EL ACTION AGREGAR PARA QUE FUNCIONE
            $.ajax({
                data: formData,
                type: 'POST',
                url: 'php/crud.php',
                success: function (data) {

                    resp1 = JSON.parse(data);
                    var codigo = resp1.code;
                    var mensaje = resp1.desc;
                    var idst = resp1.idstu;
                    alert(mensaje + " " + idst);

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

                alert(mensaje + " " + idst);

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

                alert(mensaje + " " + idst);


            }
        });
    });


});

function validaremail(email) {
    console.log('validacion de email');
    const re = /^[a-zA-Z0-9_.+-]+@?(utlaguna.edu.mx|UTLAGUNA.EDU.MX)$/g
    return re.test(email);
}

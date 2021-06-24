$(document).ready(function () {
$('#form1').validate({
    rules:{
nombre:{
    required:true
},
        apelido:{
            required:true
        },
        edad:{
            required:true
        },
        email:{
            required:true,
email: true
        }





    }



});

    $('#add').click(function () {

        if($('#form1').valid())
        {

        var formData = $('#form1').serialize();
        formData += "&accion=agregar";
        $.ajax({
            data: formData,
            type: 'POST',
            url: 'php/crud.php',
            success: function (data) {

                    if (data==1000) {
                        alert('There is an error')

                    }

                if (data==1001) {
                    alert('Student added succesfully');

                }
                if (data==1002) {
                    alert('You have an error in your sql statement');

                }



            }
        });
            }else{
            console.log('Algo no estas escribiendo');
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


                if (data==2000) {
                    alert('The student doesnt exist');

                }

                if (data==2001) {
                    alert('Student updated succesfully');

                }
                if (data==2002) {
                    alert('You have an error in your sql statement');

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



                if (data==3000) {
                    alert('The student doesnt exist');

                }

                if (data==3001) {
                    alert('Student deleted succesfully');

                }
                if (data==3002) {
                    alert('You have an error in your sql statement');

                }


            }
        });
    });
});

//TAREA VALIDAR CON EXPRESIONES REGULARES O SUBSTRINGS EL DOMINIO UTLAGUNA.EDU.MX

$(document).ready(function () {

  loadgrid();


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


function loadgrid(){
  var grid = $("#bgrid").bootgrid({
    ajax: true,
    post: function ()
    {
        return {
            id: "b0df282a-0d67-40e5-8558-c9e93b7befed"
        };
    },
    url: "php/bgrid.php",
    formatters: {
        "commands": function(column, row)
        {
            return "<button type=\"button\" class=\"btn btn-xs btn-default command-edit\" data-row-id=\"" + row.id + "\"><span class=\"fa fa-pencil\"></span></button> " + 
                "<button type=\"button\" class=\"btn btn-xs btn-default command-delete\" data-row-id=\"" + row.id + "\"><span class=\"fa fa-trash-o\"></span></button>";
        }
    }
}).on("loaded.rs.jquery.bootgrid", function()
{
    /* Executes after data is loaded and rendered */
    grid.find(".command-edit").on("click", function(e)
    {
        alert("You pressed edit on row: " + $(this).data("row-id"));
    }).end().find(".command-delete").on("click", function(e)
    {
        alert("You pressed delete on row: " + $(this).data("row-id"));
    });
});
}

function setwhite(){
$('#nombre').css('background-color','white');
$('#apellido').css('background-color','white');
$('#edad').css('background-color','white');
$('#email').css('background-color','white');
$('#id').css('background-color','white');
}

function setcolor(field,color){

  switch(field){
    case "name":
      $('#nombre').css('background-color',color);
    break;
    
    case "lastanme":
      $('#apellido').css('background-color',color);
    break;
    
    case "email":
      $('#email').css('background-color',color);
    break;
    
    case "age":
      $('#edad').css('background-color',color);
    break;
    
    case "id":
      $('#id').css('background-color',color);
    break;
    default:
      break;
    }


}

  $("#add").click(function () {
    if ($("#form1").valid()) {
      const $result = $("#warning");
      const email = $("#email").val();
      $result.text("");

      if (!validaremail(email)) {
        $result.text("Invalid Address");
        return;
      }

      console.log("email valido");

      var formData = $("#form1").serialize();
      formData += "&accion=agregar"; //TODO: REGRESAR EL ACTION AGREGAR PARA QUE FUNCIONE
      $.ajax({
        data: formData,
        type: "POST",
        url: "php/crud.php",
        success: function (data) {
          resp1 = JSON.parse(data);
          var mensaje = resp1.desc;
          var idst = resp1.idstu;
          var field=resp1.field;
          var color=resp1.color;
          alert(mensaje + " " + idst);
          setwhite();

setcolor(field,color)



        },
      });
    }
  });

  $("#update").click(function () {
    var formData = $("#form1").serialize();
    formData += "&accion=actualizar";

    $.ajax({
      data: formData,
      type: "POST",
      url: "php/crud.php",
      success: function (data) {
        resp1 = JSON.parse(data);
        var mensaje = resp1.desc;
        var idst = resp1.idstu;
        var field=resp1.field;
        var color=resp1.color;
        alert(mensaje + " " + idst);
        setwhite();

setcolor(field,color)
      },
    });
  });

  $("#delete").click(function () {
    var formData = $("#form1").serialize();
    formData += "&accion=eliminar";

    $.ajax({
      data: formData,
      type: "POST",
      url: "php/crud.php",
      success: function (data) {
         resp1 = JSON.parse(data);
          var mensaje = resp1.desc;
          var idst = resp1.idstu;
          var field=resp1.field;
          var color=resp1.color;
          alert(mensaje + " " + idst);
          setwhite();

setcolor(field,color)
        alert(mensaje + " " + idst);
      },
    });
  });
});

function validaremail(email) {
  console.log("validacion de email");
  const re = /^[a-zA-Z0-9_.+-]+@?(utlaguna.edu.mx|UTLAGUNA.EDU.MX)$/g;
  return re.test(email);
}

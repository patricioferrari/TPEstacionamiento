//$(document).ready(function () )
//{      }

function MostrarGrilla() {

    var pagina = "./nexoAdministrador.php";

    $.ajax({
        type: 'POST',
        url: pagina,
        dataType: "text",
        data: {queHago: "mostrarGrilla"},
        async: true
        })
        .then(function ok(tabla) {
            
            $("#divGrilla").html(tabla);
        }
        ,function error(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
        });

}

function CargarFormAuto() {

    var pagina = "./nexoAdministrador.php";

    $.ajax({
        type: 'POST',
        url: pagina,
        dataType: "text",
        data: {queHago: "cargarForm"},
        async: true
        })
        .then(function ok (form) {

            $("#divFrm").html(form);
        }
        ,function error (jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
        });
}

function CargarFormEliminarAuto() {

    var pagina = "./nexoAdministrador.php";

    $.ajax({
        type: 'POST',
        url: pagina,
        dataType: "text",
        data: {queHago: "cargarFormEliminar"},
        async: true
        }).then(function ok(form)
        {
            $("#divFrm").html(form);

        },function error(jqXHR, textStatus, errorThrown)
        {
            alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown); 
        });

}

function AgregarAuto() {

    var pagina = "nexoAdministrador.php";

    var auto = {
                    "patente":$("#txtPatente").val()
                };//crear objeto JSON
    $.ajax({
        type: 'POST',
        url: pagina,
        dataType: "json",
        data: {
            queHago: "agregarAuto",
            auto: auto
        },
        async: true
    }).then(function ok(objJson)
        {
        if (!objJson.Exito) {
            alert(objJson.Mensaje);
            return;
        }
        alert(objJson.Mensaje);

    },function error(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
    });

}

function EliminarAuto() {

    if (!confirm("Desea ELIMINAR el auto??")) {
        return;
    }

    var pagina  = "./nexoAdministrador.php";
    var auto = {
                    "patente":$("#txtPatente").val()
                };


    $.ajax({
        type: 'POST',
        url: pagina,
        dataType: "json",
        data: {
            queHago: "eliminarAuto",
            auto: auto
        },
        async: true
    }).then(function ok(objJson){

        if (!objJson.Exito) {
            alert(objJson.Mensaje);
            return;
        }
        alert(objJson.Mensaje);

    }, function error(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
    });
}


function Validar(objJson) {

    alert("Implementar validaciones...");

    return true;
}
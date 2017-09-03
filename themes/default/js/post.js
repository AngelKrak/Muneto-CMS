//Mostramos Textarea para Editar el Post
$(".editarPost").click(function(e) {
    ruta = $(".post_content .muneto_contenido").html();

    $.ajax({
        type: "POST",
        url: "../php/editarPost.php",
        data: "postTextarea="+ruta+"&editarPost="+this,
        success: function(done) {
        	$("head").append('<script src="../tinymce/tinymce.min.js"></script>');
        	$("body").append("<div id='contenedor_textareas'></div>");
          $("#contenedor_textareas").html(done);
          $(".conteiner_editar_post").css("transform", "scale(1)");
        }
    }); //Terminamos la Funcion Ajax
    return false; //Agregamos el Return para que no Recargue la Pagina al Enviar el Formulario
}); //Terminamos la Funcion Click

//Metodo Ajax para Eliminar Post's
$(".eliminarPost").click(function(e) {
    e.preventDefault();
    ruta = $('#post').attr("data-ruta");
    idEliminar = $(this).attr("data-ideliminar");

    $.ajax({
        type: "POST",
        url: "../php/ame.php",
        data: "eliminar="+ruta+"&ideliminar="+idEliminar,
        success: function(done) {
            $("body").append('<div id="alr" style="transform: translateX(-100%);transition: all 1s ease-in;"></div>');
            setTimeout(function() {
                $("#alr").css({
                "transform": "translate(0)",
                "left": "10px"
                });
                document.querySelector("#alr").innerHTML = done; //Escribimos mediante Ajax el texto que mostrara cuando se ahiga Eliminado el Post
            }, 300);
        }
    }); //Terminamos la Funcion Ajax
    return false; //Agregamos el Return para que no Recargue la Pagina al Enviar el Formulario
}); //Terminamos la Funcion Click

//Movemos los Tags al Div Correspondiente
$(document).ready(function() {
    $(".bootstrap-tagsinput .tag.label.label-info").appendTo(".conte_tags");
});

// Boton para ir al Inicio del Post
$("#arriba").click(function() {
    return $("html, body").animate({
        scrollTop: 0
    }, 400), !1
});

//Texto de Destacar o no en el Boton
var detectar_destacado = $("#destacado").data("destacado");
if(detectar_destacado == 'no') {
    $(".star.btn").append("<span> Destacar</span>");
} else {
    $(".star.btn").append("<span> No Destacar</span>");
}

//Metodo Ajax para Destacar o No los Post's
$(".star.btn").click(function(e) {
    e.preventDefault();
    destacado = $('#destacado').data("destacado");
    idDestacar = $(this).attr("data-ideliminar");
    if (destacado == 'no') {
        destacar = "si";
    } else {
        destacar = "no";
    }

    $.ajax({
        type: "POST",
        url: "../php/ame.php",
        data: "destacar="+destacar+"&ideliminar="+idDestacar,
        success: function(done) {
            if (destacado == "no") {
              $(".star.btn span").html(" No Destacar");
              $("#destacado").data("destacado", "si");
            } else {
              $(".star.btn span").html(" Destacar");
              $("#destacado").data("destacado", "no");
            }
        }
    }); //Terminamos la Funcion Ajax
    return false;
}); //Terminamos la Funcion Click
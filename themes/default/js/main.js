function main() {
//Comprobamos si existen post, si no mostramos mensaje de Error
contenedor = document.getElementById('posts'); //Obtenemos la Direccion del Contenedor de Post
post = contenedor.getElementsByClassName('post').length; //Contamos cuantos Post hay
if (post <= 0) { //Agregamos la Condicion de que si no hay Post muestre Mensaje de Error
	 contenedor.innerHTML = "<span class='Pempty'>No se han Encontrado Post</span>"; //Este es nuestro mensaje de Error
}

//Estadisticas
document.querySelector("#estadisticas .total.posts").innerHTML = '<div class="post_totales">Post Totales</div><div class="count_post">'+ post +' Post</div>'; //Mostramos cuantos Post hay en Total

//Comprobacion de los Post de Hoy
var d = new Date;
var n = d.getDate();
var dias = new Array();
dias[0] = 'Domingo';
dias[1] = 'Lunes';
dias[2] = 'Martes';
dias[3] = 'Miércoles';
dias[4] = 'Jueves';
dias[5] = 'Viernes';
dias[6] = 'Sábado';
var day = dias[d.getDay()];

var mes = new Array();
mes[0] = 'Enero';
mes[1] = 'Febrero';
mes[2] = 'Marzo';
mes[3] = 'Abril';
mes[4] = 'Mayo';
mes[5] = 'Junio';
mes[6] = 'Julio';
mes[7] = 'Agosto';
mes[8] = 'Septiembre';
mes[9] = 'Octubre';
mes[10] = 'Noviembre';
mes[11] = 'Diciembre';
var m = mes[d.getMonth()];
var year = d.getFullYear();
var dat = document.getElementById("post");
var fecha = document.querySelectorAll('div[data-fecha="'+n+ " "+m+" " +year+'"]');
if (fecha = n+ " de "+m+" " +year) {
	var sd = document.querySelectorAll('div[data-fecha="'+day+' '+n+' de '+m+' de '+year+'"]').length;
    document.querySelector("#estadisticas .total.hoy").innerHTML = '<div class="post_totales">Post de Hoy</div><div class="count_post">'+ sd +' Post</div>'; //Mostramos cuantos Post hay en Total
} else {
	document.querySelector("#estadisticas .total.hoy").innerHTML = '<div class="post_totales">Post de Hoy</div><div class="count_post">0 Post</div>'; //Mostramos cuantos Post hay en Total
}

//Mostrar Descripcion Mediante Hover
  $('.post').hover(function() {
    $(this).find('#de').stop().animate({
      height: "toggle",
      opacity: "toggle"
    }, 500);
  });
} //Aqui termina la Funcion main();
main();

//Abrir Modal Automaticamente
$("#Modal_Muneto").modal("show");

function alert() {
    $("#error").slideDown("slow");
    setTimeout(function() {
    $("#error").slideUp("slow");
    }, 10000);
}

$("#arriba").click(function() {
    return $("html, body").animate({
        scrollTop: 0
    }, 400), !1
});

//Metodo Ajax para Eliminar Post's
$(".eliminarPost").click(function(e) {
    e.preventDefault();
    ruta = $(this).attr("data-ruta");
    idEliminar = $(this).attr("data-ideliminar");

    $.ajax({
        type: "POST",
        url: ruta,
        data: "eliminar="+ruta+"&ideliminar="+idEliminar,
        success: function(done) {
            $("body").append('<div id="alr" style="transform: translateX(-100%);transition: all 1s ease-in;"></div>');
            setTimeout(function() {
                $("#alr").css({
                "transform": "translate(0)",
                "left": "10px"
                });
                document.querySelector("#alr").innerHTML = done; //Escribimos mediante Ajax el texto que mostrara cuando se haya Eliminado el Post
            }, 300);
            document.querySelector('div[data-id="'+idEliminar+'"]').remove();
            main(); //Recargamos las Estadisticas
            main2(); //Recargamos las Estadisticas
        }
    }); //Terminamos la Funcion Ajax
}); //Terminamos la Funcion Click

// Scroll Oculta/Muestra Menu Nav
let lastScrollTop = 0;
$(window).scroll(function(e) {
  var stop = $(this).scrollTop(),
      _header = document.getElementsByTagName("header")[0];

  if (stop > lastScrollTop) {
    $(".navbar-fixed-top").css('top', "-51px");
  } else {
    $(".navbar-fixed-top").css('top', "0");
  }
  lastScrollTop = stop;
});

// Categorias Select en la Home
$(".categoriasSelect .cat.default").click(function(event) {
  $(this).toggleClass('active');
  $(".categoriasSelect .cats").slideToggle(500);
});
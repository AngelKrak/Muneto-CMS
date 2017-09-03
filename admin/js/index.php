<?php
require '../../php/config.php';
session_start();
@$G = $_SESSION['usuario'];
$Rango = $_SESSION['rango'];

if ($Rango != "Usuario") {
?>
function main() {
//Fecha en Español con Dia, Mes y Año
var d = new Date;
var n = d.getDate(); //Obtenemos el Dia en Numero
var dias = new Array();
dias[0] = 'Domingo';
dias[1] = 'Lunes';
dias[2] = 'Martes';
dias[3] = 'Miércoles';
dias[4] = 'Jueves';
dias[5] = 'Viernes';
dias[6] = 'Sábado';
var day = dias[d.getDay()]; //Obtenemos el Dia de la Semana en Español

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
var m = mes[d.getMonth()]; //Obtenemos el Mes en Español
var year = d.getFullYear(); //Obtenemos el Año Actual

//Mostrar Fecha en Español
document.getElementById("fecha_form").value = day+' '+n+' de '+m+' de '+year;

//Agregamos Fecha por Separado a los Input
document.getElementById("FechaDataDia").value = n;
document.getElementById("FechaDataMes").value = m;

//Mostrar Descripcion Mediante Hover
  $('.post').hover(function() {
    $(this).find('#de').stop().animate({
      height: "toggle",
      opacity: "toggle"
    }, 80);
  });
} //Aqui termina la Funcion main();
main();

//Funcion para mostrar la Hora Actual
function doClock() {
  t = new Date;
  m = t.getMonth();
  d = t.getDay();
  dt = t.getDate();
  y = t.getFullYear();
  h = t.getHours();
  if (h < 12) {
    ap = "AM"
  } else {
    ap = "PM";
    h = h - 12
  }
  mn = pad(t.getMinutes());
  s = pad(t.getSeconds());
  if (h == 0) {
    h = 12
  }
  clockID.value = + h + ":" + mn + ":" + s + " " + ap;
  setclock = setTimeout("doClock()");
}

function pad(a) {
  if (a < 10) {
    a = "0" + a
  }
  return a
};
clockID = document.getElementById('hour_form');
doClock();

//Detenemos el Contador de la Hora Actual
document.querySelector(".fa-pause").addEventListener("click", doClockStop);
function doClockStop()  {
    clearTimeout(setclock);
}
//Iniciamos el Contador de la Hora Actual
document.querySelector(".fa-play").addEventListener("click", doClockPlay);
function doClockPlay()  {
    doClock();
}
<?php
}
?>
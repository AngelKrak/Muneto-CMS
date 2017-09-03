$(document).ready(function() {
  //Editor TinyMCE
  tinymce.init({
    selector: 'textarea#contenido_form',
    theme: 'modern',
    skin: 'custom',
    height: 150,
    setup: function (editor) {
      editor.on('change', function () {
          tinymce.triggerSave();
      });
    },
    plugins: [
      'advlist autolink lists link image charmap print preview hr anchor pagebreak',
      'searchreplace wordcount visualblocks visualchars code fullscreen',
      'insertdatetime media nonbreaking save table contextmenu directionality',
      'emoticons template paste textcolor colorpicker textpattern imagetools'
    ],
    table_default_attributes: {
      class: 'table table-bordered table-hover'
    },
    toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
    toolbar2: 'print preview media | forecolor backcolor emoticons',
    image_advtab: true,
    pre_id: 'elm1=my_id',
    templates: [
      { title: 'Test template 1', content: 'Test 1' },
      { title: 'Test template 2', content: 'Test 2' }
    ],
    content_css: [
      '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
      'http://getbootstrap.com/dist/css/bootstrap.min.css'
    ],
    content_style: "body {margin: 8px !important;}body img {max-width: 100%;}"
  });

  // Iniciamos DataTables Plugin
  var DataTables = $('table#categorias, table#usuarios').DataTable({
    "language": {
      "url": "//cdn.datatables.net/plug-ins/1.10.13/i18n/Spanish.json"
    },
    responsive: {
      details: {
        type: 'inline'
      }
    }
  });

  //DataTables.draw('full-reset');

  function alert(id) {
      $("#"+id+"").slideDown("slow");
      setTimeout(function() {
      $("#"+id+"").slideUp("slow");
      }, 10000);
  }

  $('[data-toggle="popover"]').popover({
  html: true,
    trigger: 'hover',
    placement: 'top',
    content: function(){return '<img src="'+$(this).data('img') + '" />';}
  });

  //Metodo Ajax para agregar Post's
  $(".enviar").on("click", function(event) {
      event.preventDefault();

          //Obtenemos el valor del campo Titulo
          var titulo = $("input[name='titulo']").val();
          //Validamos el campo Titulo, simplemente miramos que no esté vacío
          if (titulo.trim() == "") {
              alert('Agregarerror');
              document.getElementById("Agregarerror").innerHTML = "Debe de introducir un Titulo Valido";
              $("input[name='titulo']").focus();
              return false;
          }

          //Obtenemos el valor del campo Descripcion
          var descripcion = $("input[name='descripcion']").val();
          //Validamos el campo Descripcion, simplemente miramos que no esté vacío
          if (descripcion.trim() == "") {
              alert('Agregarerror');
              document.getElementById("Agregarerror").innerHTML = "Debe de introducir una Descripcion Valida";
              $("input[name='descripcion']").focus();
              return false;
          }
          //Validamos el campo Descripcion, Le agregamos la Condicion de que de error si hay mas de 255 Caracteres en el input
          if (descripcion.length > 255) {
              alert('Agregarerror');
              document.getElementById("Agregarerror").innerHTML = "La Descripcion no puede Contener mas de 255 Caracteres";
              $("input[name='descripcion']").focus();
              return false;
          }

          //Obtenemos el valor del campo Imagen
          var imagen = $("input[name='imagen']").val();
          //Validamos el campo Imagen, simplemente miramos que no esté vacío
          if (imagen.trim() == "") {
              alert('Agregarerror');
              document.getElementById("Agregarerror").innerHTML = "Debe de introducir una Imagen(URL) Valida";
              $("input[name='imagen']").focus();
              return false;
          }

          //Obtenemos el valor del campo Autor
          var autor = $("input[name='autor']").val();
          //Validamos el campo Autor, simplemente miramos que no esté vacío
          if (autor.trim() == "") {
              alert('Agregarerror');
              document.getElementById("Agregarerror").innerHTML = "Debe de introducir un Autor(Creador) Valido";
              $("input[name='autor']").focus();
              return false;
          }

          //Obtenemos el valor del campo Fecha
          var fecha = $("input[name='fecha']").val();
          //Validamos el campo Fecha, simplemente miramos que no esté vacío
          if (fecha.trim() == "") {
              alert('Agregarerror');
              document.getElementById("Agregarerror").innerHTML = "Debe de introducir una Fecha Valida";
              $("input[name='fecha']").focus();
              return false;
          }

          //Obtenemos el valor del campo Hora
          var hora = $("input[name='hora']").val();
          //Validamos el campo Hora, simplemente miramos que no esté vacío
          if (hora.trim() == "") {
              alert('Agregarerror');
              document.getElementById("Agregarerror").innerHTML = "Debe de introducir una Hora Valida";
              $("input[name='hora']").focus();
              return false;
          }

          //Obtenemos el valor del campo Contenido
          var contenido = $("textarea[name='contenido']").val();
          //Validamos el campo Contenido, simplemente miramos que no esté vacío
          if (contenido.trim() == "") {
              alert('Agregarerror');
              document.getElementById("Agregarerror").innerHTML = "Debe de introducir un Contenido Valido";
              $("textarea[name='contenido']").focus();
              return false;
          }

          var textarea = $("textarea[name='contenido']").val();
          if (/<?php/.test(textarea)) {
              alert('Agregarerror');
              document.getElementById("Agregarerror").innerHTML = "Lo sentimos el Campo no puede Contener <strong>Codigo PHP</strong>";
              $("textarea[name='contenido']").focus();
              return false;
          }

          //Creamos la Variable que recibira el "Value" de todos los Input que esten dentro del Form
          var obtener = $("#agregar_form").serialize();
          $.ajax({
              type: "POST",
              url: "../php/ame.php",
              data: obtener+'&agregarPost=si',
              success: function(data) {
                  //Volvemos a Recargar las Estadisticas
                  main();

                  //Limpiamos los Input
                  $("#titulo_form, #descripcion_form, #imagen_form, #contenido_form, #agregar_form input").val("");
                  tinymce.activeEditor.setContent('');

                  $("#Agregarerror").slideUp("slow");
                  //Mensaje de Error y Success
                  $("#agregarAlert").html(data);
                  $("#Agregarsuccess").slideDown("slow");

                  setTimeout(function() {
                  $("#Agregarsuccess").slideUp("slow");
                  }, 10000);

                  return true;
              }
          }); //Terminamos la Funcion Ajax
          return true;
      }); //Terminamos la Funcion Click

  // Gestionar Base de Datos
  $(".dbBTN .btnDB.gestionarDB").click(function(e) {
    var dbruta = $(this).data('dbruta');

    $.ajax({
      type: "POST",
      url: "../php/db.php",
      data: 'gestionarDB=si&rutaDB='+dbruta,
      success: function(db) {
        $(".tabContentDB[data-option='gestionarDB']").html(db);
        $(".tabBTNDB[data-option='gestionarDB']").trigger('click');
      }
    }); //Terminamos la Funcion Ajax
  });

  //Editar la Configuracion
  $(".editar_config").click(function(event) {
    //Obtenemos el valor del campo Titulo de la Web
    var titulo_web = $("input[name='titulo_web']");
    //Validamos el campo Titulo de la Web, simplemente miramos que no esté vacío
    if (titulo_web.val().trim() == "") {
        $("#EC_mensaje #error").slideDown("slow");
        setTimeout(function() {
        $("#EC_mensaje #error").slideUp("slow");
        }, 10000);
        document.querySelector("#EC_mensaje #error").innerHTML = "Debe de introducir el Titulo de la Web";
        $(titulo_web).focus();
        return false;
    }

    //Obtenemos el valor del campo Slogan
    var slogan = $("input[name='slogan']");
    //Validamos el campo Slogan, simplemente miramos que no esté vacío
    if (slogan.val().trim() == "") {
        $("#EC_mensaje #error").slideDown("slow");
        setTimeout(function() {
        $("#EC_mensaje #error").slideUp("slow");
        }, 10000);
        document.querySelector("#EC_mensaje #error").innerHTML = "Debe de introducir el Slogan de la Web";
        $(slogan).focus();
        return false;
    }

    document.querySelector("#editar_config").submit();
  });

  $("input[name='editar_titulo_web']").click(function(event) {
    //Obtenemos el valor del campo Titulo de la Web
    var titulo_web = $("input[name='titulo_web']");
    //Validamos el campo Titulo de la Web, simplemente miramos que no esté vacío
    if (titulo_web.val().trim() == "") {
        $("#EC_mensaje #error").slideDown("slow");
        setTimeout(function() {
        $("#EC_mensaje #error").slideUp("slow");
        }, 10000);
        document.querySelector("#EC_mensaje #error").innerHTML = "Debe de introducir el Titulo de la Web";
        $(titulo_web).focus();
        return false;
    }

    document.querySelector("#editar_config").submit();
  });

  //Editar la Configuracion
  $("input[name='editar_slogan']").click(function(event) {
    //Obtenemos el valor del campo Slogan
    var slogan = $("input[name='slogan']");
    //Validamos el campo Slogan, simplemente miramos que no esté vacío
    if (slogan.val().trim() == "") {
        $("#EC_mensaje #error").slideDown("slow");
        setTimeout(function() {
        $("#EC_mensaje #error").slideUp("slow");
        }, 10000);
        document.querySelector("#EC_mensaje #error").innerHTML = "Debe de introducir el Slogan de la Web";
        $(slogan).focus();
        return false;
    }

    document.querySelector("#editar_config").submit();
  });

  //Mostramos la Contraseña Encriptada
  $("input#hash").on("keydown keyup", function(event) {
    //Creamos la Variable que recibira el "Value" de todos los Input que esten dentro del Form
    var obtener = $("#encriptar #hash").val();
    $.ajax({
      type: "POST",
      url: "php/encriptar.php",
      data: "hash="+obtener,
      success: function(data) {
        $("#encriptar_mensaje span").html(data);
      }
    }); //Terminamos la Funcion Ajax

    event.stopPropagation();
  });

  //Mostramos el Preview del Post en un Modal
  $(".btn.preview").click(function(event) {
    //Obtenemos el valor del campo Titulo
    var tittle = $("input[name='titulo']").val();
    //Validamos el campo Titulo, simplemente miramos que no esté vacío
    if (tittle.trim() == "") {
        alert('Agregarerror');
        document.getElementById("Agregarerror").innerHTML = "Debe de introducir Primero un Titulo para Previsualizarlo";
        $("input[name='titulo']").focus();
        return false;
    }
    //Obtenemos el valor del campo Titulo
    var conttenido = $("textarea[name='contenido']").val();
    //Validamos el campo Titulo, simplemente miramos que no esté vacío
    if (conttenido.trim() == "") {
        alert('Agregarerror');
        document.getElementById("Agregarerror").innerHTML = "Debe de introducir Primero algo de Contenido para Previsualizarlo";
        $("textarea[name='contenido']").focus();
        return false;
    }

    var textarea = $("textarea[name='contenido']").val();
    if (/<?php/.test(textarea)) {
          alert('Agregarerror');
          document.getElementById("Agregarerror").innerHTML = "Lo sentimos no puede haber <strong>Codigo PHP</strong>";
          $("textarea[name='contenido']").focus();
          return false;
    }

    //Abrimos el Modal
    $("#Modal_Muneto").modal("show");
    //Obtenemos lo que este Escrito en el Input Titulo y lo Mostramos en el Modal Title
    modal_title_preview = document.getElementById("titulo_form").value;
    document.querySelector("#Modal_Muneto .modal-title .modal_title_preview").innerHTML = "<strong>"+modal_title_preview+"</strong>";
    //Obtenemos lo que este Escrito en el Textarea Contenido y lo Mostramos en el Modal Body
    modal_content_preview = document.getElementById("contenido_form").value;
    document.querySelector("#Modal_Muneto .modal-body").innerHTML = modal_content_preview;
  });

  //Seleccionar Themes
  $(".theme_sel").click(function(e) {
      ruta = $(this).attr("value");
      selected = $(this);

      $.ajax({
          type: "POST",
          url: "../php/editar_theme.php",
          data: "themes="+ruta,
          success: function(done) {
            $(".tema_actual span").html(done);
          }
      }); //Terminamos la Funcion Ajax
      return false; //Agregamos el Return para que no Recargue la Pagina al Enviar el Formulario
  }); //Terminamos la Funcion Click
  $("picture#preview").click(function(event) {
    $("#selected_theme").remove();
    $(".selected", this).append("<span id='selected_theme'>TEMA SELECCIONADO</span>");
  });

  //Eliminar Post Permanente
  $(".eliminar.forever").click(function(e) {
      e.preventDefault();

      idEliminar = $(this).attr("data-ideliminar");
      titulo = $(this).closest('#post').find('#titulo').html();

      $.ajax({
          type: "POST",
          url: "../php/ame.php",
          data: "delForever="+idEliminar+"&tituloPost="+titulo+"&ideliminar="+idEliminar,
          success: function(done) {
            $(".mensj span").html(done);
            $(".mensj .alert").slideDown("slow");
            document.querySelector('#post[data-id="'+idEliminar+'"]').remove();
          }
      }); //Terminamos la Funcion Ajax
      return false; //Agregamos el Return para que no Recargue la Pagina al Enviar el Formulario
  }); //Terminamos la Funcion Click

  //Publicar Post Eliminados(Trash -> Posts)
  $(".publicar.now").click(function(e) {
      e.preventDefault();
      idPublicar = $(this).attr("data-idpublicar");

      $.ajax({
          type: "POST",
          url: "../php/ame.php",
          data: "paburisshu="+idPublicar+"&ideliminar="+idPublicar,
          success: function(done) {
            $(".mensj span").html(done);
            $(".mensj .alert").slideDown("slow");
            document.querySelector('#post[data-id="'+idPublicar+'"]').remove();
          }
      }); //Terminamos la Funcion Ajax
      return false; //Agregamos el Return para que no Recargue la Pagina al Enviar el Formulario
  }); //Terminamos la Funcion Click

  //Mostrar Mensaje si no hay Post en la Papelera
  var contar = $("#post").length;
  if (contar == "0") {
    $(".postsTrash").html('<div class="alert" style="display: block;width: 100%;"><div class="deleted" style="text-align: center;">No se han Encontrado Post en la Papelera</div></div>');
  }

  // Mostrar Menu2(Sidebar)
  var menu2btn = false;
  $(".menu2btn").click(function(e) {
    if (menu2btn === false) {
      $(".menu2").delay(200).css('margin-left', '0');
      $("#fullpage").delay(200).css('margin-left', '180px');
      menu2btn = true;
    } else {
      $(".menu2").delay(200).removeAttr('style');
      $("#fullpage").delay(200).css('margin-left', '0');
      menu2btn = false;
    }
  });

  // Marcar como Active el Menu que se Selecciono de la Administracion
  $(".menu2 a").click(function(e) {
    $(".menu2 a").removeClass('active');
    $(this).addClass('active');
  });
  $(window).scroll(function(e) {
    var hash = location.hash;
    $(".menu2 a").removeClass('active');
    $(".menu2 a[href='"+hash+"']").addClass('active');
  });
  var hash = location.hash;
  $(".menu2 a[href='"+hash+"']").addClass('active');

  // Tabs de Categorias
  $("#tabs .tabBTN").click(function(e) {
    var option = $(this).data('option');
    $(".categoriasContent .tabContent, #tabs .tabBTN").removeClass('active');
    $(".categoriasContent .tabContent").hide(500);
    $(".categoriasContent .tabContent[data-option='"+option+"'], .categoriasContent .tabBTN[data-option='"+option+"']").addClass('active');
    $(".categoriasContent .tabContent[data-option='"+option+"']").show(500);
  });
  $("#tabs1 .tabBTN").click(function(e) {
    var option = $(this).data('option');
    $(".tabsContentCuenta .tabContent, #tabs1 .tabBTN").removeClass('active');
    $(".tabsContentCuenta .tabContent").hide(500);
    $(".tabsContentCuenta .tabContent[data-option='"+option+"'], .tabBTN[data-option='"+option+"']").addClass('active');
    $(".tabsContentCuenta .tabContent[data-option='"+option+"']").show(500);
  });
  $("#tabs2 .tabBTN").click(function(e) {
    var option = $(this).data('option');
    $(".usuariosContent .tabContent, #tabs2 .tabBTN").removeClass('active');
    $(".usuariosContent .tabContent").hide(500);
    $(".usuariosContent .tabContent[data-option='"+option+"'], .usuariosContent .tabBTN[data-option='"+option+"']").addClass('active');
    $(".usuariosContent .tabContent[data-option='"+option+"']").show(500);
  });
  $("#tabsDB .tabBTNDB").click(function(e) {
    dataOption = $(this).data('option');

    claseActiva = $(".tabBTNDB[data-option='"+dataOption+"']").hasClass('active');
    if (claseActiva) {
      $(".tabContentDB[data-option='"+dataOption+"']").css('transform', 'scale(1)');
    } else {
      $(".tabBTNDB").removeClass('active').removeAttr('style');
      $(".tabBTNDB[data-option='"+dataOption+"']").addClass('active');
      $(".tabContentDB").removeClass('active').removeAttr('style');
      $(".tabContentDB[data-option='"+dataOption+"']").addClass('active').css('transform', 'scale(0)');
      setTimeout(function() {
        $(".tabContentDB[data-option='"+dataOption+"']").css('transform', 'scale(1)');
      }, 100);
    }
  });

  // Metodo Ajax para Agregar Categorias
  $(".tabContent #agregarCategoria").click(function(e) {
    e.preventDefault();
    var catNew = $("#categoriaNueva").val();
    var categoriaNum = $("table#categorias tbody tr").last().data('num')+1;

    $.ajax({
      type: "POST",
      url: "php/addCategorias.php",
      data: "categoriaNueva="+catNew,
      success: function(done) {
        $("#categoriaNueva").val("");
        $("#tags_cat select").append('<option value="'+catNew+'">'+catNew+'</option>');
        $("table#categorias tbody").append('<tr data-num="'+categoriaNum+'" data-categorianame="'+catNew+'"><td data-num="'+categoriaNum+'" tabindex="0" class="sorting_1">'+categoriaNum+'</td><td data-categorianame="'+catNew+'">'+catNew+'</td><td><a href="#categoriass" data-toggle="modal" data-target="#editCategoria" data-categorianame="'+catNew+'" style="padding-right: 10px;"><i class="fa fa-pencil" aria-hidden="true" style="font-size: 1.2em;"></i></a> <a href="#categoriass" class="delCategoria" data-categorianame="'+catNew+'" style="padding-right: 10px;"><i class="fa fa-trash" aria-hidden="true" style="font-size: 1.2em;"></i></a></td></tr>');
      }
    }); //Terminamos la Funcion Ajax
  });

  // Metodo Ajax para Editar Categorias
  $("table#categorias a").click(function(e) {
    var categoriaName = $(this).data("categorianame");
    $("#editCategoria #categoriaEditar").attr("data-categorianame", ""+categoriaName+"");
  });
  $("#editCategoria #editarCategoria").click(function(e) {
    e.preventDefault();
    var catEdit = $("#categoriaEditar").val();
    var cat = $("#categoriaEditar").data("categorianame");

    $.ajax({
      type: "POST",
      url: "php/editCategorias.php",
      data: "categoriaEditar="+catEdit+"&categoria="+cat,
      success: function(done) {
        $("#categoriaEditar").val("");
        $('td[data-categorianame="'+cat+'"]').html(catEdit);
      }
    }); //Terminamos la Funcion Ajax
  });

  // Metodo Ajax para Eliminar Categorias
  $(".delCategoria").click(function(e) {
      categoria = $(this).data("categorianame");

      $.ajax({
          type: "POST",
          url: "php/delCategorias.php",
          data: "categoriaEliminar="+categoria,
          success: function(done) {
            document.getElementById("categoriasAlert").innerHTML = done; //Escribimos mediante Ajax el texto que mostrara cuando se ahiga Eliminado el Post
            alert('categoriasAlert'); //Mostramos Mensaje de que se ha Borrado
            document.querySelector('tr[data-categorianame="'+categoria+'"]').remove();
          }
      }); //Terminamos la Funcion Ajax

      e.preventDefault();
      e.stopPropagation();
  }); //Terminamos la Funcion Click


});
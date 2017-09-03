<?php
session_start();
if (isset($_REQUEST['editarPost'])) {
  $text = $_REQUEST['postTextarea'];
}

if (isset($_REQUEST['edit_post'])) {
	$cuenta_nombre = $_REQUEST["new"];
}

$url = $_SESSION['url'];
$post = file_get_contents(realpath('../posts/posts.json'));
  $getJSON2 = json_decode($post);
  for($i = 0; $i < count($getJSON2->post); $i++) {
    if ($getJSON2->post[$i]->url == $url) {
      $getJSON = $getJSON2->post[$i];
      break;
    }
  }
?>

	<div class="modal_editar_post">
		<div class="conteiner_editar_post">
		<div class="close_modal"><i class="fa fa-times" aria-hidden="true"></i></div>
			<div class="title">
				<div id="tabs">
          <div class="tabBTN active" data-option="contenido" style="border-radius: 3px 0 0 0">Editar Contenido</div>
          <div class="tabBTN" data-option="datos" style="border-radius: 0 3px 0 0">Editar Informacion</div>
        </div>
			</div>

      <div class="overflow">
        <form method="post" id="formEdit">
          <div class="tabContent active" data-option="contenido">
      			<textarea name="new" id="new"><?php echo $text; ?></textarea>
          </div>
          <div class="tabContent" data-option="datos">
            <div id="EC_content" style="padding: 0;box-shadow: none;display: block;margin: 5px 10px;">
              <div class="Editar_Configg">
                <label class="editar_label">Titulo</label>
                <input type="text" id="titulop" class="editarPostI" name="titulop" placeholder="Introduce el Titulo" value="<?php echo $getJSON->datos->titulo; ?>" />
                <a href="#" class="faa-parent animated-hover">
                  <i class="fa fa-pencil faa-pulse fa-fw" aria-hidden="true"></i>
                  <input type="submit" class="editarPostI" name="editar_titulo" value="Editar" />
                </a>
              </div>

              <div class="Editar_Configg">
                <label class="editar_label">Descripcion</label>
                <input type="text" id="descripcionp" class="editarPostI" name="descripcionp" placeholder="Introduce la Descripcion" value="<?php echo $getJSON->datos->descripcion; ?>" />
                <a href="#" class="faa-parent animated-hover">
                  <i class="fa fa-pencil faa-pulse fa-fw" aria-hidden="true"></i>
                  <input type="submit" class="editarPostI" name="editar_descripcion" value="Editar" />
                </a>
              </div>

              <div class="Editar_Configg">
                <label class="editar_label">Portada</label>
                <a href="#" class="preview_config" data-toggle="popover" title="Preview de la Portada" data-img="<?php echo $getJSON->datos->portada; ?>"><input type="text" id="portadap" class="editarPostI" name="portadap" placeholder="Introduce url de la Portada" value="<?php echo $getJSON->datos->portada; ?>" /></a>
                <a href="#" class="faa-parent animated-hover">
                  <i class="fa fa-pencil faa-pulse fa-fw" aria-hidden="true"></i>
                  <input type="submit" class="editarPostI" name="editar_portada" value="Editar" />
                </a>
              </div>

              <div class="Editar_Configg">
                <label class="editar_label">Tags</label>
                <input type="text" id="tagsp" class="editarPostI" name="tagsp" placeholder="Introduce los Tags" value="<?php echo $getJSON->info->tags; ?>" />
                <a href="#" class="faa-parent animated-hover">
                  <i class="fa fa-pencil faa-pulse fa-fw" aria-hidden="true"></i>
                  <input type="submit" class="editarPostI" name="editar_tags" value="Editar" />
                </a>
              </div>

              <div class="Editar_Configg">
                <label class="editar_label">Categoria</label>
                <?php
                  require '../admin/php/categorias.php';
                  asort($categorias);
                  $contarCat = count($categorias);
                 ?>
                 <select name="categoriap" class="editarPostI categorias <?php if ($contarCat == 0){echo "none";} ?>" id="categoriap">
                 <?php
                 if ($contarCat == 0) {
                   echo '<option value="" selected>No Hay Categorias</option>';
                 }
                 foreach ($categorias as $categoria) {
                   if ($getJSON->info->categoria == $categoria) {
                     echo '<option class="selected" value="'.$categoria.'" selected>'.$categoria.'</option>';
                   } else {
                    echo '<option value="'.$categoria.'">'.$categoria.'</option>';
                  }
                 }
                 ?>
                 </select>
                <a href="#" class="faa-parent animated-hover">
                  <i class="fa fa-pencil faa-pulse fa-fw" aria-hidden="true"></i>
                  <input type="submit" class="editarPostI" name="editar_categoria" value="Editar" />
                </a>
              </div>
            </div>
          </div>
        </form>

  			<footer>
  				<button name="edit_post" class="edit_post" data-idpost="<?php echo $getJSON->id; ?>">Editar</button>
  			</footer>
      </div>
		</div>
	</div>

<script type="text/javascript">
//Editar Post con el Nuevo Contenido y Mostrarlo
$(".edit_post").click(function(e) {
    post = $("#post").attr("data-ruta");
    textarea = $("#new").val();
    form = $("#formEdit").serialize();
    idPost = $(this).data("idpost");
    tituloPost = $(".modal_editar_post #titulop").val();
    tagsPost = $(".modal_editar_post #tagsp").val();
    categoriaPost = $(".modal_editar_post #categoriap").val();

    tagsToArray = tagsPost.split(',');
    tagsCount = tagsToArray.length;

    $.ajax({
        type: "POST",
        url: "../php/ame.php",
        data: form+"&editar=editarPost&ideliminar="+idPost,
        success: function(done) {
          setTimeout(function() { //Ocultar hasta los 3 Segundos
            $(".conteiner_editar_post").css("transform", "scale(0)");
          }, 3000); //3 Segundos
          setTimeout(function() { //Remover hasta los 4 Segundos
						$("#contenedor_textareas").remove();
					}, 4000); //4 Segundos
          $('<div class="alert edit alert-success" style="display: none;width: 95%;">El Post ha sido Editado Correctamente'+done+'</div>').insertAfter($(".close_modal"));
          $(".alert.edit").slideDown("slow");
          $(".muneto_contenido").html(textarea);
          $(".post_content .post_content_titulo").text(tituloPost);
          $(".categorias strong").text(categoriaPost);
          $(".tagss .conte_tags").html('');
          for (var i=0; i<tagsCount; i++) {
            $(".tagss .conte_tags").append('<span class="tag label label-info">'+tagsToArray[i]+'<span data-role="remove"></span></span>');
          }
        }
    }); //Terminamos la Funcion Ajax
}); //Terminamos la Funcion Click

//Cambiar entre Ventanas
$("#tabs .tabBTN").click(function(e) {
  dataOption = $(this).data('option');

  claseActiva = $(".tabBTN[data-option='"+dataOption+"']").hasClass('active');
  if (claseActiva) {
    $(".tabContent[data-option='"+dataOption+"']").css('transform', 'scale(1)');
  } else {
    $(".tabBTN").removeClass('active').removeAttr('style');
    $(".tabBTN[data-option='"+dataOption+"']").addClass('active');
    $(".tabContent").removeClass('active').removeAttr('style');
    $(".tabContent[data-option='"+dataOption+"']").addClass('active').css('transform', 'scale(0)');
    setTimeout(function() {
      $(".tabContent[data-option='"+dataOption+"']").css('transform', 'scale(1)');
    }, 100);
  }
});

$('[data-toggle="popover"]').popover({
  html: true,
  trigger: 'hover',
  placement: 'top',
  content: function(){return '<img src="'+$(this).data('img') + '">';}
});

//Cerrar Modal
$(".close_modal").click(function(e) {
	$(".conteiner_editar_post").css("transform", "scale(0)");
	setTimeout(function() { //Remover hasta los 1 Segundos
		$("#contenedor_textareas").remove();
	}, 1000); //1 Segundos

	e.preventDefault();
});

tinymce.init({
  selector: 'textarea#new',
  theme: 'modern',
  skin: 'custom',
  height: 'auto',
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
  content_style: "body {margin: 8px !important;}span{display:block;}blockquote {font-size: 1em !important;margin: 0 !important;padding: 0 !important;}blockquote p {padding: 15px !important;margin: 0 !important;}body img {max-width: 100%;}"
});
</script>
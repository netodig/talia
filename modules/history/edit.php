<?php
import("classes.helper");
import("upload");
import('funciones');

$history= new HistoryExtend();

$cnombre = $_REQUEST['nombre'];
$clanref = $_REQUEST['lanref'];
$cdesc = $_REQUEST['desc'];
$clevel = $_REQUEST['level'];
$ccat = $_REQUEST['cat'];
$ccreador = "";

$titulo=$lang->g('LISTADO_PARRAFOS');

$cfoto = "";
$cidfoto = "";

$cid= $_REQUEST['cid'];
if($cid)
{
	$history=$history->getHistoria($cid);
	if($history[0])
	{
		
		$history= $history[0];
		
		$cnombre =$history->g('nombre');
		$clanref =$history->g('idiomaref');
		$cfoto=$history->g('nombrearchivo');
		$cidfoto=$history->g('idfoto');
		
		$cdesc =$history->g('descripcion');
		$clevel =$history->g('level');
		$ccat = $history->g('cat');
	
		$titulo=$lang->g('EDITAR_HISTORIA').$cnombre;

	}
}
global $com;

?>

<form action="" method="post" id="formusuario" enctype="multipart/form-data" name="formusuario">
  <h1 class="fl"><?php echo $titulo ?></h1>
  <ul class="submenu">
  	<li><a class="fr back" href="<?php echo Url::sitelink("parrafo/listado","cid=$cid") ?>"><?php echo $lang->g('PARRAFOS') ?></a> </li>
    <li><span class="separator">|</span></li>
    <li><a class="fr back" href="<?php echo Url::sitelink("history/listado","") ?>"><?php echo $lang->g('VOLVER_LISTADO') ?></a> </li>
  </ul>
  <?php
  Msg::show();
  ?>
  <fieldset class="row col-md-12 fl" >
    <legend></legend>
    <div class="fl col-md-6">
      <label class="" >
      <?php
		$fo=$cfoto;
		if(!$fo)
		{
			$fo="sinimagen.png";
		}
		?>
      <div class="sulogotipo tc" id="dropbox" style="width: 90%;">
        <div class="progress progress-info" id="progupload">
          <div class="bar" style="width: 0%;"></div>
        </div>
        <div id="cntimage">
          <div id="imgcontent">
            <?php
        if($cfoto)
		{
		?>
            <a href="javascript:void(0)" onclick="delfotonew('historia','<?php echo $cidfoto; ?>','imgcontent')" class="del delmig"></a>
            <?php 
		}
		?>
            <a class="gallery-item" title="" href="<?php echo Url::thumfoto2("historia",$fo,800,800) ?>"> <img src="<?php echo Url::thumfoto2("historia",$fo,300,300) ?>" class=""/> </a> </div>
          <div id="spanshow"> <br />
            <a href="#" id="openfile"
data-idopenfile="fotoprincipal"><?php echo $lang->g('SELECCIONE_IMAGEN') ?></a>
            <input type="file" id="fotoprincipal"
name="fotoprincipal" class="fileoculto" />
          </div>
        </div>
      </div>
      </label>
    </div>
    <div class="fl col-md-5">
    	<div class="col-md-12">
      <label><?php echo $lang->g('TITULO') ?>:<br />
        <input type="text" id="nombre" size="30" name="nombre" value="<?php echo $cnombre; ?>" />
      </label>
      <label class="mr2p" ><?php echo $lang->g('IDIOMA_REFERENCIA') ?>:<br />
        <?php 
			$idiomasref= new IdiomasTExtend();
			$idiomasref=$idiomasref->getIdiomas();
			$idiref= array();
			$idiref[""]=$lang->g('SELECCIONAR');
			foreach($idiomasref as $p)
			{
			$idiref[$p->g('abv')]=$p->g('nombre');
			}
			
			$array=array();
			if($cid)
			$array[]="disabled='disabled'";
			
			
			echo THelper::select('lanref', $idiref, $clanref,false,$array);
			?>
      </label>
      
      <label class="mr2p"><?php echo $lang->g('CATEGORIA') ?>:<br />
        <?php 
			$catslist= new CodTiposExtend();
			$catslist=$catslist->getListTipos(1,"",$lang->g('SELECCIONAR'));

			echo THelper::select('cat', $catslist, $ccat,false);
			?>
      </label>
      </div>
      <div class="col-md-12">
      	 <label><?php echo $lang->g('LEVEL') ?>:<br />
        <input type="text" id="level" size="50" name="level" value="<?php echo $clevel; ?>" />
      </label>
       <label class="w100p"><?php echo $lang->g('DESCRIPCION') ?>:<br />
       <textarea name="desc" id="desc" class="w100p" cols="40" rows="3"><?php echo $cdesc ?></textarea>
      </label>
      </div>
      
      <?php if($cid)
	  {
		  include("idiomassoportados.php");
	  }
	  ?>
    </div>
  </fieldset>
  <div class="w100p tc fl">
    <input class="cb" type="Submit" name="Submit" value="<?php echo $lang->g('GUARDAR') ?>" />
  </div>
  <input type="hidden" name="controller" value="general" />
  <input type="hidden" name="task" value="savehistory" />
  <input type="hidden" name="cid" value="<?php echo $cid ?>" />
  
  <input type="hidden" name="tipofoto" value="1" />
 <input type="hidden" name="cidfoto" value="<?php echo $cidfoto ?>" />
</form>
<script type="text/javascript">
	$("#formusuario").validate({
		rules: {
			nombre: {"required":true},
			lanref: {"required":true},
			},
		messages: {
			nombre: {"required":"<?php echo $lang->g('DATO_REQUERIDO') ?>"},
			lanref: {"required":"<?php echo $lang->g('DATO_REQUERIDO') ?>"},
		},
		debug: true,
		errorElement: 'div',		
		submitHandler: function(form){
		
		form.submit();
		}
	});
	
	var dropbox = $('#dropbox'),
                message = $('.message', dropbox);
        dropbox.filedrop({
            // The name of the $_FILES entry:
            paramname: 'fotoprincipal',
            maxfiles: 1,
            maxfilesize: 2,
			//url a la que se va a subir la imagen
            url: '<?php echo Url::subirimg(1,$cid,ID_REST,'fotoprincipal','historias',$cidfoto); ?>',
            uploadFinished: function (i, file, response) {                
                jQuery('#progupload').hide();
				
				//mando el mensaje de guardado               
            },
            error: function (err, file) {
                switch (err) {
                    case 'BrowserNotSupported':
                        alert('Your browser does not support HTML5 file uploads!');
                        break;
                    case 'TooManyFiles':
                        alert('Too many files! Please select 5 at most! (configurable)');
                        break;
                    case 'FileTooLarge':
                        alert(file.name + ' is too large! Please upload files up to 10mb (configurable).');
                        break;
                    default:
                        break;
                }
            },
            // Called before each upload is started
            beforeEach: function (file) {
                if (!file.type.match(/^image\//)) {
                    alert('Only images are allowed!');                    
                    return false;
                }
            },
            uploadStarted: function (i, file, len) {               
                CartaFile.Initialize({'file': file, 'dropbox': dropbox, 'idTextEmptyDropBox': 'spanshow', 'idContentParentImage': 'imgcontent'}).createImage();
            },
            progressUpdated: function (i, file, progress) {
                //$.data(file).find('.progress').width(progress);

                jQuery('#progupload').show().find('.bar').width(progress);
            }


        });
		
		 CartaFile.Initialize({'file': '', 'dropbox': dropbox, 'idTextEmptyDropBox': 'spanshow', 'idContentParentImage': 'imgcontent'});
		CartaFile.openFile('openfile');
	
$('.gallery-item').magnificPopup({
  type: 'image',
  tLoading:'Cargando...',
  tClose:'Cerrar',
  gallery:{
    enabled:true,
	tPrev: 'Anterior',
	tNext: 'Siguiente',
	tCounter: '<div class="mfp-counter">%curr% de %total%</div>'

	
  }
});
</script>
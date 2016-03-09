<form action="" method="post" id="formfotos" name="formfotos" enctype="multipart/form-data">
  <fieldset class="w100p dvc mt1p" >
    <legend><?php echo $titlefotos ?></legend>
    <?
if($caso)
{
	$clase="ok";
	if($caso>1)
	$clase="error";
	?>
    <h2 class="<?php echo $clase ?>"><? echo $message; ?></h2>
    <?
}
?>
    <div class="contenfoto">
      <?php 
	//busco las fotos
	
	$fotos = new FotosExtend();
	$fotos=$fotos->getFotos2($tipoFoto, $cid,$idtext2);
	
	if($fotos[0])
	{
		
	foreach($fotos as $f)
	{
		?>
      <div class="foto" id="divdelfoto<?php echo $f->g('idfoto') ?>">
      	<input type="hidden" value="1" id="save<?php echo $f->g('idfoto') ?>" />
        <a href="javascript:void(0)" onclick="delfoto('<?php echo $carpeta ?>','<?php echo $f->g('idfoto'); ?>','divdelfoto<?php echo $f->g('idfoto') ?>')" class="del delmig"></a>
        <!--<input type="checkbox" id="delfoto<?php echo $f->g('idfoto') ?>" name="delfoto<?php echo $f->g('idfoto') ?>" value="<?php echo $f->g('idfoto') ?>" class="del delfoto">-->
        <?php 
		$class="";
		if($f->g('idfoto')==$principal)
		$class="imgpactive";
		?>
        <a href="javascript:void(0)" id="buttonmod<?php echo $f->g('idfoto') ?>" onclick="setModif('<?php echo $f->g('idfoto') ?>','<?php echo $f->g('pie') ?>','<?php echo $f->g('orden') ?>')" class="mod"></a>
        
        <a href="javascript:void(0)" id="imgprincipal<?php echo $f->g('idfoto') ?>" class="imgprincipal <?php echo $class ?>" title="Definir como imagen principal" onclick="SetPrincipal(<?php echo $f->g('idfoto') ?>)" ></a>
         <div class="cfoto">
        <a href="<?php echo Url::thumfoto2($carpeta,$f->g('nombrearchivo'),800,800) ?>" class="gallery-item" ><img src="<?php echo Url::thumfoto2($carpeta,$f->g('nombrearchivo'),150,150) ?>"></a>
         </div>
         <div class="infopie" id="infofoto<?php echo $f->g('idfoto') ?>">
        <?php echo $f->g('pie') ?><br>Orden: <?php echo $f->g('orden') ?>
        </div>
      </div>
      <?
	}
	?>
      <!--<input type="button" class="botonelimina" name="eliminafotos" id="eliminafotos" onclick="eliminaFotosall()" value="Eliminar fotos seleccionadas">-->
      <?
	}
	else
	{
		echo "No tiene fotos";
	}
	?>
    </div>
    <div class="tablediv">
   
      <table class="fl cb" width="80%" >
        
        <tr>
          <td colspan="2 "> <h2 class="fl">Agregar nuevas fotos</h2></td>
          <td align="center">Pie foto</td>
          <td align="center">Orden</td>
        </tr>
        <tr>
          <td><strong>Foto 1</strong></td>
          <td align="left"><input type="file" name="foto1" id="foto1"></td>
          <td align="center"><input type="text" name="pie1" id="pie1"></td>
          <td align="center"><input type="text" size="5" name="orden1" id="orden1"></td>
        </tr>
        <tr>
          <td><strong>Foto 2</strong></td>
          <td align="left"><input type="file" name="foto2" id="foto2"></td>
          <td align="center"><input type="text" name="pie2" id="pie2"></td>
          <td align="center"><input name="orden2" type="text" id="orden2" size="5"></td>
        </tr>
        <tr>
          <td><strong>Foto 3</strong></td>
          <td align="left"><input type="file" name="foto3" id="foto3"></td>
          <td align="center"><input type="text" name="pie3" id="pie3"></td>
          <td align="center"><input name="orden3" type="text" id="orden3" size="5"></td>
        </tr>
        <tr>
          <td><strong>Foto 4</strong></td>
          <td align="left"><input type="file" name="foto4" id="foto4"></td>
          <td align="center"><input type="text" name="pie4" id="pie4"></td>
          <td align="center"><input name="orden4" type="text" id="orden4" size="5"></td>
        </tr>
        <tr>
          <td><strong>Foto 5</strong></td>
          <td align="left"><input type="file" name="foto5" id="foto5"></td>
          <td align="center"><input type="text" name="pie5" id="pie5"></td>
          <td align="center"><input name="orden5" type="text" id="orden5" size="5"></td>
        </tr>
        <tr>
          <td colspan="4" align="center"><input type="submit" name="enviarfotos" id="enviarfotos" value="Enviar fotos"></td>
        </tr>
        <tr>
      </table>
    </div>
  </fieldset>
  <input type="hidden" name="controller" value="general">
  <input type="hidden" name="task" value="savefotos">
  <input type="hidden" name="tipo" value="<?php echo $tipoFoto ?>">
  <input type="hidden" name="idtext2" value="<?php echo $idtext2 ?>">
  <input type="hidden" name="carpeta" id="carpeta" value="<?php echo $carpeta ?>">
  <input type="hidden" name="id" id="id" value="<?php echo $cid ?>">
  <input type="hidden" name="principal" id="principal" value="<?php echo $principal ?>">
</form>
<script type="text/javascript">
$('.gallery-item').magnificPopup({
  type: 'image',
  tLoading:'Cargando',
  tClose:'Cerrar',
  gallery:{
    enabled:true,
	tPrev: 'Anterior',
	tNext: 'Siguiente',
	tCounter: '<div class="mfp-counter">%curr% de %total%</div>'
  }
});
</script>

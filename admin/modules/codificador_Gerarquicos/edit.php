<?php
import("classes.helper");
import("upload");
import('funciones');

global $com;

$cods= new CodTiposExtend();

$txt="";

$tipocod = $_REQUEST['tipocod'];
$cid= $_REQUEST['cid'];
$cidpadre = $_REQUEST['idpadre'];

$cod_nivel = new CodNivelExtend();
$desc_nivel=$cod_nivel->getNombreNivelHijodelpadre($cidpadre);

if($desc_nivel)
{
$txt=$desc_nivel->g('o');
}
 
$titulo="Agregar ".$txt;

if($cid)
{
	$cods=$cods->getCodTiposById($cid);
	if($cods[0])
	{
		$cods= $cods[0];
		$corden = $cods->g('orden');
		$cnombre = $cods->g('nombre');
        $calias = $cods->g('alias');
		$cnivel = $cods->g('nivel');
		$cidpadre = $cods->g('idpadre');
		
        $cod_nivel = new CodNivelExtend();
        $desc_nivel=$cod_nivel->getNombreNivel($cnivel,$tipocod);
		
        if($desc_nivel)
		{
		   $txt=$desc_nivel->g('o');
		}
		else
		$txt="codificador";
		
		$titulo="Editar $txt";
	}	
}    
?>

<form action="" method="post" id="formcod" enctype="multipart/form-data" name="formcod">
    <h1 class="fl"><?php echo $titulo ?></h1>
    <div class="bc">
        <div class="bc_txt">
        <a href="<?php echo Url::adminlink("codificador_Gerarquicos/listado","tipocod=".$tipocod) ?>">Listado</a> 
        </div>
        <?php
        if(!$cid)
        {
            if($cidpadre != 0)
                $camino=hormiga($cidpadre,$camino);
        }
        else 
            $camino=hormiga($cid,$camino);
			
        if($camino)
        {
            foreach ($camino as $c)
            {
                ?> &raquo;
        <a href="<?php echo Url::adminlink("codificador_Gerarquicos/edit","tipocod=".$tipocod."&cid=".$c->g('id')) ?>"> <?php echo $c->g('nombre'); ?></a>
                <?php
                
            }
            $list=  array_reverse($camino);
            $cidpad=$list[1];
            if($cidpad)
            {
			 $idp=$cidpad->g('id');
			}
        }
        ?>    

    </div>
    <?php 
	
	$funcion="edit";
	if(!$cidpadre)
	{
		$funcion="listado";
	}
	
	if(!$cid && !$cidpadre)
	{
		$funcion="listado";
	}
	?>
    
  <a class="fr back" href="<?php echo Url::adminlink("codificador_Gerarquicos/$funcion","tipocod=".$tipocod."&cid=".$cidpadre) ?>">Volver a al listado</a>
  <?
	  if($com["message"])
	  {
    ?>
  <h2 class="<?php echo $com["clase"] ?>"><? echo $com["message"] ?></h2>
  <?
	 }
	 ?>
  <fieldset class="w100p fl" >
    <legend></legend>
    <div class="fl w100p">
      <div class="fl w100p"	>
        <label class="w40p" >Nombre:<br />
          <input type="text" id="nombre" size="50" name="nombre" value="<?php echo $cnombre; ?>" />
        </label>
        <label class="w40p" >Alias:<br />
          <input type="text" id="alias" size="50" name="alias" value="<?php echo $calias; ?>" />
        </label>
        <label >Orden:<br />
          <input class="num" type="text" id="orden" size="5" name="orden" value="<?php echo $corden; ?>" />
        </label>
      </div>
      
    </div>
  </fieldset>
  <div class="w100p tc fl">
    <input class="cb" type="Submit" name="Submit" value="Guardar" />
  </div>
  <input type="hidden" name="controller" value="general" />
  <input type="hidden" name="task" value="savecod" />
  <input type="hidden" name="cid" value="<?php echo $cid ?>" />
  <input type="hidden" name="tipocod" value="<?php echo $tipocod ?>" />
  <input type="hidden" name="idpadre" value="<?php echo $cidpadre ?>" />
</form>
<div class="cont fl w100p mt2p">
    <?php
        if($cid)
        {
            include("modules/codificador_Gerarquicos/listado.php");
        }
    ?>
</div>
<script type="text/javascript">
	$("#formcod").validate({
		rules: {
			nombre: {"required":true},
			orden: {"number":true}
			},
		messages: {
			nombre: {"required":"Nombre requerido"},
			orden: {"number":"Debe ser número"}
		},
		debug: true,
		errorElement: 'div',		
		submitHandler: function(form){
		
		form.submit();
		}
	});
</script>
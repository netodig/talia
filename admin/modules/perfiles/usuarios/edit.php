<?
import("classes.helper");
import("upload");
import('funciones');

$usuario= new UserinterExtend();

$cnombre = $_REQUEST['nombre'];
$cclave = $_REQUEST['clave'];

$capellidos = $_REQUEST['apellidos'];
$cdni = $_REQUEST['dni'];
$cnombrereal = $_REQUEST['nombrereal'];

$ctipo = $_REQUEST['tipo'];
$cemail = $_REQUEST['email'];

$cid= $_REQUEST['cid'];
if($cid)
{
	$usuario=$usuario->getUserinterById($cid);
	if($usuario[0])
	{
		
		$usuario= $usuario[0];
		
		$cnombre =$usuario->g('name');
		$cclave =$usuario->g('clave');
		$cemail=$usuario->g('email');
		$ctipo=$usuario->g('tipo');
		$titulo="Editar Tipo de Usuario ".$ctiponombre;
	}
}
global $com;

?>

<form action="" method="post" id="formusuario" enctype="multipart/form-data" name="formusuario">
  <h1 class="fl"><?php echo $titulo ?></h1>
  <ul class="submenu">
    <li><a class="fr back" href="<?php echo Url::adminlink("perfiles/usuarios/listado","tipo=$tipo") ?>">Volver al listado</a> </li>
  </ul>
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
      <label >Nombre:<br />
        <input type="text" id="nombrereal" size="30" name="nombrereal" value="<?php echo $cnombrereal; ?>" />
      </label>
      <label>Apellidos:<br />
        <input type="text" size="30" id="apellidos" name="apellidos" value="<?php echo $capellidos; ?>" />
      </label>
      <label>Dni:<br />
        <input type="text" size="30" id="dni" name="dni" value="<?php echo $dni; ?>" />
      </label>
    </div>
    <div class="fl w100p">
      <label >Nombre de usuario:<br />
        <input type="text" id="nombre" size="30" name="nombre" value="<?php echo $cnombre; ?>" />
      </label>
      <label >Clave:<br />
        <input type="text" size="30" id="clave" name="clave" value="<?php echo $cclave; ?>" />
      </label>
      <label class="mr2p">Email:<br />
        <input class="arrob" type="text" size="20" id="email" name="email" value="<?php echo $cemail; ?>" />
      </label>
        <label class="cb" >Perfil:<br />
         	<?php 
			$perfiles= new PerfilesExtend();
			$perfiles=$perfiles->getperfiles();
			$perfs= array();
			$perfs[""]="Seleccionar";
			foreach($perfiles as $p)
			{
				$perfs[$p->g('id')]=$p->g('nombre');
			}
			
			echo THelper::select('tipo', $perfs, $ctipo,false);
			?>
        </label>
    </div>
  </fieldset>
  <div class="w100p tc fl">
    <input class="cb" type="Submit" name="Submit" value="Guardar" />
  </div>
  <input type="hidden" name="controller" value="usuarios" />
  <input type="hidden" name="task" value="saveruser" />
  <input type="hidden" name="cid" value="<?php echo $cid ?>" />
</form>
<script type="text/javascript">
	$("#formusuario").validate({
		rules: {
			nombre: {"required":true},
			clave: {"required":true},
			email: {"email":true,"required":true},
			tipo: {"required":true}
			},
		messages: {
			nombre: {"required":"Nombre requerido"},
			clave: {"required":"Clave requerida"},
			email: {"required":"Email requerido","email":"Email inválido"},
			tipo: {"required":"Perfil requerido"}
		},
		debug: true,
		errorElement: 'div',		
		submitHandler: function(form){
		
		form.submit();
		}
	});
	

</script>
<?


import("classes.helper");
import('funciones');

global $com;
$titulo="Listado de tablas";

?>

<h1><?php echo $titulo ?></h1>
<?
	  if($com["message"])
	  {
    	?>
		<h2 class="<?php echo $com["clase"] ?>"><? echo $com["message"] ?></h2>
        <br />
		<?
	 }
	 ?>
<?php 
  $traducciones= new TraduccionExtend();
  $traducciones=$traducciones->getTablas();
  
  $tablas= new TraduccionTablasExtend();
  $tablas= $tablas->getTablasDesc();
  
  $datostabla=array();
  $idtablas=array();
  
  foreach($tablas as $t)
  {
	  $datostabla[$t->g('nombretabla')]=$t->g('titulotabla');
	  $idtablas[$t->g('nombretabla')]=$t->g('campoid');
  }
  
  ?>
    <form action="" method="post" id="formtraduce" enctype="multipart/form-data" name="formtraduce">
<div class="tablediv">
  <div class="tablediv">
    <table width="100%" border="0" cellspacing="0">
      <tr>
        <th width="60%">Tabla</th>
        <th width="30%">Título</th>
        <th width="30%">Campo Id</th>
        <th width="10%">Opciones</th>
      </tr>
      <?php 
		$par="";
		$i=0;
		foreach($traducciones as $t)
		{
			$i++
		?>
      	<tr class="<?php echo $par ?>" id="row<?php echo $t->g('Tables_in_'.DATABASE) ?>">
        <td><?php echo $t->g('Tables_in_'.DATABASE) ?></td>
        <td><?php 

		if(!$datostabla[$t->g('Tables_in_'.DATABASE)])
		{
			$datostabla[$t->g('Tables_in_'.DATABASE)]=$t->g('Tables_in_'.DATABASE);
		}
		?>
        
        <input size="25" type="text" name="<?php echo $t->g('Tables_in_'.DATABASE) ?>" value="<?php echo $datostabla[$t->g('Tables_in_'.DATABASE)] ?>" /></td>
        
         <td><?php 

		if(!$idtablas[$t->g('Tables_in_'.DATABASE)])
		{
			$idtablas[$t->g('Tables_in_'.DATABASE)]="id".$t->g('Tables_in_'.DATABASE);
		}
		?>
        
        <input size="25" type="text" name="ids<?php echo $t->g('Tables_in_'.DATABASE) ?>" value="<?php echo $idtablas[$t->g('Tables_in_'.DATABASE)] ?>" /></td>
        
        <td><a href="<?php echo Url::adminlink("traduccion/traduce/tabla","tabla=".$t->g('Tables_in_'.DATABASE)) ?>" class="mod"></a></td>
      </tr>
      <?php
		if(!$par)
		$par="par";
		else
		$par=""; 
		}
		?>
    </table>
    <br />
    <div class="w100p tc fl">
    <input class="cb" type="Submit" name="Submit" value="Guardar" />
    </div><br />
<br />
  </div>
</div>
 
     <input type="hidden" name="controller" value="traduccion" />
  <input type="hidden" name="task" value="saveTablas" />
</form>

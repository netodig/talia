<?
//busco los modulos

$mod= new PmodulosExtend();
$mod=$mod->getmodulos();

foreach($mod as $m)
{
	?>

<fieldset class="w17p" style="display:inline-block">
  <legend><?php echo $m->g('nombre') ?></legend>
  <div class="fl w100p box tablediv">
    <table width="100%" border="0">
      <tr>
        <th colspan="2">Vista
          </th>
      </tr>
      <?php 
	  $tasks= new PmodulosTaskExtend();
	  $tasks= $tasks->getModulePermisos($cid,$m->g('id'));
	  
	  foreach($tasks as $t)
	  {
	  ?>
      <tr>
        <td align="center"><input name="permiso<?php echo $t->g('id') ?>" <? if($t->g('idpermiso')) { ?> checked<? } ?> type="checkbox" value="1"></td>
        <td align="center"><?php echo $t->g('nombre') ?></td>
      </tr>
      <?php 
	  }
	  ?>
    </table>
    <?php 
	 $tasks= new PmodulosTaskExtend();
	 $tasks= $tasks->getModulePermisos($cid,$m->g('id'),2);
	 if($tasks[0])
	 {
	?>
    <table width="100%" border="0">
      <tr>
        <th colspan="2">Controllador
          </th>
      </tr>
      <?php 
	 
	  
	  foreach($tasks as $t)
	  {
	  ?>
      <tr>
        <td align="center"><input name="permiso<?php echo $t->g('id') ?>" <? if($t->g('idpermiso')) { ?> checked<? } ?> type="checkbox" value="1"></td>
        <td align="center"><?php echo $t->g('nombre') ?></td>
      </tr>
      <?php 
	  }
	  ?>
    </table>
    <?php 
	 }
	?>
  </div>
</fieldset>
<?
}

?>

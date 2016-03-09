<?php 
$idiomassoport= new HistorylangExtend();
$idiomassoport=$idiomassoport->getIdiomasSoport($cid)

?>
<div class="col-md-12 tc">
	<h3><?php echo $lang->g("IDIOMAS_SOPORTADOS") ?></h3>
<div class="tablediv">
    <table width="100%" border="0" cellspacing="0">
      <tr>
        <th width="30%"><?php echo $lang->g('IDIOMA') ?></th>
        <th width="70%"><?php echo $lang->g('TITULO') ?></th>
      </tr>
      <?php 
		$par="";
		$i=0;
		foreach($idiomassoport as $c)
		{
			$i++
		?>
      <tr class="<?php echo $par ?>" id="row<?php echo $c->g('id') ?>">
        <td><?php echo $c->g('idioma') ?></td>
        <td><?php echo $c->g('nombreh') ?></td>
      </tr>
      <?php
		if(!$par)
		$par="par";
		else
		$par=""; 
		}
		?>
    </table>
  </div>
  
  <a href="<?php echo Url::sitelink("history/editidiomassoportados","cid=$cid") ?>"><?php echo $lang->g('EDITAR_IDIOMAS') ?></a>
  </div>
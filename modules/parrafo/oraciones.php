<?php 
global $clang;

$oraciones= new OracionExtend();
$oraciones= $oraciones->getOraciones($cid, $clang);

?>
<h3 class="tc"><?php echo $lang->g('ORACIONES_DIVIDIDAS') ?></h3>
<?php
foreach($oraciones as $o)
{
	?>
    <label class="w100p">
    	[<?php echo $o->g('numero') ?>] <input name="oracion<?php echo $o->g('numero') ?>" class="oracion" type="text" value='<?php echo $o->g('texto') ?>'>  
        
        <input name="saltooracion<?php echo $o->g('numero') ?>" class="saltos" type="checkbox" <?php if($o->g('salto')){?> checked <?php } ?> value="1">
    </label>
    <?php
}
?>
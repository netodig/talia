<?
//tratamiento de mensajes
$cidm=$_REQUEST['idm'];

global $com;

if($_SESSION['cmessage'.$cidm])
{
	$com["message"]=$_SESSION['cmessage'.$cidm];
	$com["clase"]=$_SESSION['ccase'.$cidm];
	
	$_SESSION['cmessage'.$cidm]="";
	$_SESSION['ccase'.$cidm]="";
}

class Msg
{	
	function __construct(){}
	
	public static function show($tipo="", $tag="h2",$classextra="")
	{
		global $com;

		  if($com["message"])
		  if(($tipo && $com["tipo"]==$tipo) || !$com["tipo"])
	 	 	{
			?>
        	<<?php echo $tag ?> class="<?php echo $classextra ?> <?php echo $com["clase"] ?>"><? echo $com["message"] ?></<?php echo $tag ?>>
        	<?php
		  	}
	}
	
}
?>
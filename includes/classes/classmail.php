<?php

class TMail
{ 
    static function SendMail($params = array(),$otroatach="",$nombrepdf="" ,$base="",$tipo="")
	{
	    $mail = new PHPMailer();		
		$mail->Host = HOST_SMTP;
		//$mail->AddAddress($email, 'Registro');
		$mail->FromName = $params['namefrom'];
		$mail->From = $params['emailfrom'];
		$mail->Subject = utf8_encode($params['asunto']);
		$mail->Body = $params['body']; //nl2br($params['body']);
		$mail->IsHTML(true);
			
		if(IS_SMTP_SERVER)
		  $mail->IsSMTP();
				 
		 if(IS_AUTH)
		 { 
		   $mail->SMTPAuth = true;
		   $mail->Username = USER_SMTP;
		   $mail->Password = PASS_SMTP;
		 }		
		 $mail->AddAddress($params['emailto'], $params['nameto']);	
		 
		 if($params['emailto2'])	 
		 $mail->AddAddress($params['emailto2'], $params['nameto2']);	
		 	 
		if($params['atach'][0])
		{
		foreach($params['atach'] as $t)
			{
			$mail-> AddAttachment($t['path'], $t['name']);
			}
		}
		
		if($otroatach)
		{
			$mail->AddStringAttachment($otroatach,$nombrepdf ,$base,$tipo);
		}
			
		if(!$mail->Send())
		return $mail->ErrorInfo;
		else
		return true;		
	}
	
}
?>
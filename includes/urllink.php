<?php 
class Url
{	
	function __construct(){}
	static function site()
		{
			return LIVE_SITE;
		}
		
		static function siteurl()
		{
			return LIVE_SITE;
		}
                
		static function admin()
		{
			return Url::siteurl().ADMIN_FOLDER;
		}
		
		static function registro($tipo)
		{

			return Url::siteurl()."/index.php?module=home/registro&tipo=$tipo";
		}
		
		static function sitelink($mod,$anotheroption="")
		{
			if($anotheroption)
			$anotheroption="&".$anotheroption;

			return Url::siteurl()."index.php?module=$mod"."$anotheroption";
		}
		
		static function subirimg($tipo,$id,$id2,$name,$carpeta,$fprev="",$task="savenfoto",$extra="")
		{
			if($anotheroption)
			$anotheroption="&".$anotheroption;

			return Url::siteurl().ADMIN_FOLDER."/index2.php?controller=general&task=$task&tipo=$tipo&idt=$id&idt2=$id2&name=$name&f=$carpeta&fprev=$fprev&extra=$extra";
		}
		
		static function adminlink($mod,$anotheroption="")
		{
			if($anotheroption)
			$anotheroption="&".$anotheroption;

			return Url::siteurl().ADMIN_FOLDER."/index.php?module=$mod"."$anotheroption";
		}

		static function popuplink($mod,$anotheroption="")
		{
			if($anotheroption)
			$anotheroption="&".$anotheroption;

			return Url::siteurl().ADMIN_FOLDER."/index2.php?module=$mod"."$anotheroption";
		}
		
		static function adminlsolo($mod)
		{
			return Url::siteurl().ADMIN_FOLDER."/$mod.php";
		}
		
		static function contacto()
		{
			return Url::site()."contacto.html";
		}
		
		static function informacion()
		{
			return Url::siteurl()."informacion.html";
		}
		
		static function micuenta()
		{
			return Url::siteurl()."index.php?module=home/micuenta";
		}
		
		static function urlactivacion($activacion)
		{
			return Url::siteurl()."activar-$activacion.html";
		}
		static function urlrecuperacambia($activacion)
		{
			return Url::siteurl()."recuperaclave-$activacion.html";
		}
		
		
		static function recupera()
		{
			return Url::siteurl()."recuperaclave.html";
		}

		
		static function login($extra="")
		{
			return Url::siteurl()."login.html";
		}
		
		static function loginredir()
		{
			return Url::siteurl()."index.php?module=home/login&redir=1";
		}
		static function loginvalora()
		{
			return Url::siteurl()."index.php?module=home/login&valora=1";
		}
		
		
		
		static function logout()
		{
			return Url::siteurl()."logout.html";
		}
		
		static function idioma($idioma)
		{
			
			$url=$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			$url=str_replace("/".$_SESSION['idioma']."/","/".$idioma."/",$url);
			
			//$url=LIVE_SITE."$idioma/";
			
			return "http://".$url;
		}
		
		
		static function foto($carpeta,$img)
		{
			return Url::siteurl()."volatil/$carpeta/$img";
		}
		
		static function thumfoto2($carpeta,$img,$w,$h,$water=0)
		{
			if (function_exists ( 'realpath' ) and @realpath ( dirname ( __FILE__ ) ) !== FALSE)
			$system_folder = realpath ( dirname ( __FILE__ ) );
			
			$system_folder=str_replace("includes","",$system_folder);
			
			$urlimagen="$system_folder".SEPARATOR."volatil".SEPARATOR."$carpeta".SEPARATOR."$img";
			$i=(@getimagesize($urlimagen));
			
			$wi=$i[0];
			$hi=$i[1];
			
			$wt="";
			$ht="";
			
			if($wi>$w)
			{
				//veo si la altura dimensionada es mayor
				$percent=$w*100/$wi;
				$xresult=$hi*$percent/100;
				
				if($xresult>$h)
				{
					$ht="h=$h";
				}
				else
				{
					$wt="w=$w";
				}
				
			}
			else
			{
				if($hi>$h)
				{
					$ht="h=$h";
				}
				else
				{
					$wt="w=$w";
				}
			}
				
			return Url::site()."thumbnail.php?thumb=$urlimagen&$wt&$ht&water=$water";
		}
		
		static function thumfoto($carpeta,$img,$w,$h,$water=0)
		{
		
			if (function_exists ( 'realpath' ) and @realpath ( dirname ( __FILE__ ) ) !== FALSE)
			$system_folder = realpath ( dirname ( __FILE__ ) );
			
			$system_folder=str_replace("includes","",$system_folder);
			
			$urlimagen="$system_folder".SEPARATOR."volatil".SEPARATOR."$carpeta".SEPARATOR."$img";
			$i=(@getimagesize($urlimagen));
			
			$wi=$i[0];
			$hi=$i[1];
			
			$wt="";
			$ht="";
			
			if($wi>$w)
			{
				//veo si la altura dimensionada es mayor
				$percent=$w*100/$wi;
				$xresult=$hi*$percent/100;
				
				if($xresult>$h)
				{
					$ht="h=$h";
				}
				else
				{
					$wt="w=$w";
				}
				
			}
			else
			{
				if($hi>$h)
				{
					$ht="h=$h";
				}
				else
				{
					$wt="w=$w";
				}
			}
				
			return Url::site()."img/$carpeta/$w-$h-$water-$img";
		}
		
		static function waterMark()
		{
			if (function_exists ( 'realpath' ) and @realpath ( dirname ( __FILE__ ) ) !== FALSE)
			$system_folder = realpath ( dirname ( __FILE__ ) );
			
			$system_folder=str_replace("includes","",$system_folder);
			
			$urlimagen="$system_folder".SEPARATOR."img".SEPARATOR."marcadeagua.png";
			
			
			return $urlimagen;
		}
		
		static function imgflag($bandera)
		{
		return Url::img()."flags/$bandera";
		}
		static function icon($icon)
		{
		return Url::img()."icon/$icon";
		}
		
		static function img()
		{
		return LIVE_SITE."assets/img/";
		}
		
		
		
		static function imgredes($ico)
		{
			return Url::img()."icoredes/$ico";
		}
	
	static public function formatText($texto, $espacioBlancoPor = '-')
	{
	  $ww = $texto;	  
	 // $ww = utf8_decode($ww);
	  $ww=strtolower($ww);
	  
	  $ww = trim($ww);
	  $ww=str_replace("�","a",$ww);
	  $ww=str_replace("�","e",$ww);
	  $ww=str_replace("�","i",$ww);
	  $ww=str_replace("�","o",$ww);
	  $ww=str_replace("�","u",$ww);
	  $ww=str_replace("�","a",$ww);
	  $ww=str_replace("�","e",$ww);
	  $ww=str_replace("�","i",$ww);
	  $ww=str_replace("�","o",$ww);
	  $ww=str_replace("�","u",$ww);
	  
	  $ww=str_replace("�","n",$ww);
	  $ww=str_replace(",","-",$ww);
	  $ww=str_replace(".","",$ww);
	  $ww=str_replace(")","",$ww);
	  $ww=str_replace("(","",$ww);
	  $ww=str_replace(":","",$ww);
	  $ww=str_replace("?","",$ww);
	  $ww=str_replace(";",$espacioBlancoPor,$ww);
	  $ww = str_ireplace(' / ',$espacioBlancoPor,$ww);
	  $ww = str_ireplace('/',$espacioBlancoPor,$ww);
	  $ww= str_replace(" y ",$espacioBlancoPor,$ww);
	  $ww = str_ireplace(' - ',$espacioBlancoPor,$ww);
	  $ww = str_ireplace(' ', $espacioBlancoPor, $ww); 	
	  $ww = str_ireplace('--', $espacioBlancoPor, $ww);  
	  
	  return $ww;
	}

}

<?
global $module;
global $seo;
global $template;

class NSEO
{
	static public function load()
	{
		global $module;
		global $seo;
		
		$seo= new SeoExtend();
		$seo=$seo->getSeoPagina($module);
		if($seo[0])
		$seo=$seo[0];
		else
		$seo=false;
	}
	
	static public function loaddata()
	{
		global $seo;
		global $template;
		
		if($seo)
		{
			$funcion=$seo->g('funcion');
			if($funcion)
			{
				if(method_exists($template,$funcion))
				{
					$template->$funcion($seo);
				}
				else
				{
					$template->fill($seo);
				}
			}
			else
				{
					$template->fill($seo);
				}
		}
	}
}

NSEO::load();
NSEO::loaddata();
?>
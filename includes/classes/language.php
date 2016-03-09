<?php 

/*error_reporting(E_ALL);
ini_set("display_errors","On");*/
class Language
{
	private $traducciones;
	private $codigoIdioma;
	
	public function __construct($codigoIdioma = 'es', $params=array())
	{
		$this->codigoIdioma = $codigoIdioma;
		
		$this->traducciones = parse_ini_file(PATH_IDIOMA."$codigoIdioma".SEPARATOR."general.ini");		
	}
	
	public function get($index)
	{
	
		if($this->traducciones[$index])
		 return $this->traducciones[$index];
		else return $index;
	}
	
	public function g($index)
	{
	   return $this->get($index);
	}
	
	public function getCodigoIdioma(){return $this->codigoIdioma;}
}
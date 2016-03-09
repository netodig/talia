<?php

class Template
{
	 var $titulo;
	 var $descripcion;
	 var $keywords;
	 
	 function __construct()
	 {
		 $this->titulo="Iembarazo";
		 $this->descripcion="Iembarazo";
		 $this->keywords="Iembarazo";
	 }
	 
	 public function fill($seovar)
	 {
		 $this->titulo=$seovar->g('titulo');
		 $this->descripcion=$seovar->g('descripcion');
		 $this->keywords=$seovar->g('descripcion');

	 }
}

global $template;
$template= new Template();
?>
<?php
    function __autoload($nameClass)
    {
    	$nameBaseClass = 'Base'.str_replace('Extend', '', $nameClass);
		import("lib.om.$nameBaseClass");    	
		import("lib.$nameClass");
    }    
  
?>
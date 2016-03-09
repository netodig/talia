<?php
  function import($file)
  {
   	$include= str_replace(".","/",$file);
	$include=ROOT.$include.".php";
	include_once($include);
  }

  import('lib.lib.dboHelper');
  import('lib.lib.jfactory');
  import('funciones');
  import('outoload');
  import('urllink');
  import("classes.paginator");
  ?>
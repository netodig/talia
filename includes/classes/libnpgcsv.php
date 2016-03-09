<?php

class NpgLinesCsv
{
  
  public function __construct($listNameOfField, $listValues)
  {
      $i = 0;
      foreach($listNameOfField as $key):
	$this->$key = $listValues[$i++];
      endforeach;    
  }
}

class NpgCsv
{
   private $items;
   
   /**
   * $linesCvs lista con las lineas del csv
   * $nameOfFiels nombre que va a recibir cada linea
   */
   public function __construct(array $linesCvs, array $nameOfFiels, $separator = ';', $firstLinesIsNameOfField = true)
   {
      $this->items = array();	        
      $i = $firstLinesIsNameOfField ? 1 : 0;
      	   
      $cntLines = count($linesCvs);
      for(; $i < $cntLines; $i++):    
        $this->items[] = new NpgLinesCsv($nameOfFiels, explode($separator, $linesCvs[$i]));
      endfor;
   }
   
   public function getItems(){return $this->items;} 
}

class ParseCsv
{  
    static private function getLines($string)
    {
        $match = array();
        preg_match_all("/.*\n?/", trim($string), $match);   
        return $match;
    }
    
    static public function getLinesCsv($pathFileCsv)
    {      
      $content =  file_get_contents($pathFileCsv);
      $lines = array();
      if($content)
        $lines = self::getLines($content);         
      return $lines;
    }
	
}
 
?>

<?php
class JFactory
{
    static private $conn;		
	
    static public function getDbo()
    {
       if(!self::$conn)
	    self::$conn = new Dbo(HOST, USER, PASS, DATABASE);
	   return self::$conn;
    }
}
<?
class Template
{
	
	public $template="";
	public $logo="";
	public $js="";
	public $title="";
	public $keywords="";
	public $descripcion="";
	public $url="";
	public $ObjConfig="";
	
	public $Menus=array();
	
	public $Modules=array();
	
	private $traducciones;
	
	public function __construct($template)
	{
		$this->template = $template;
		$this->url=Url::siteurl()."tpl/$template/";
	}
	
	public function addMenu($nombre, $menu)
	{
		$this->Menus[$nombre]=	$menu;
	}
	
	public function addModule($nombre, $module)
	{
		$this->Modules[$nombre]=	$module;
	}
}

class Menu
{
	public $links = array();
	
	public function __construct()
	{
	
	}	
	
	public function addLink($link)
	{
		$this->links[]=	$link;
	}
}

class LinkMenu
{
	public $nombre, $texto,$url;
	public $submenu=array();
	public $class=array();
	
	public function __construct($nombre,$texto,$class, $url,$submenu=NULL)
	{
		$this->nombre = $nombre;
		$this->texto = $texto;
		$this->class[]= $class;
		
		$module=$_REQUEST['module'];
		if(!$module)
		$module="home/general";
		
		$this->submenu = $submenu;
		
		if($module==$nombre)
		$this->class[]="selected";
		
		if(method_exists("Url",$url))
		$this->url=Url::$url();
	}	
	
	public function gclass()
	{
		return implode(" ",$this->class);
	}
}
?>
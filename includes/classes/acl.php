<?
class Acl
{
	public $tipo;
	public $sesion;
	public $modules=array();
	
	public function __construct($tipo=0,$sesion=1)
	{
		$this->tipo = $tipo;
		$this->sesion = $sesion;
		
		if($tipo)
		{
		//busco todo para el tipo
		$modulese= new PmodulosExtend();
		$modulese=$modulese->getModulesPermiso($tipo,$sesion);
		
		if($modulese[0])
		foreach($modulese as $m)
		{
			$mod= new aMocules($m->g('acceso'));
			
			//busco los task del modulo
			$taskes= new PmodulosTaskExtend();
			$taskes=$taskes->getTaskModule($tipo,$m->g('id'));
			foreach($taskes as $t)
			{
				$mod->addtask($t->g('task'));
			}
			
			$this->modules[$m->g('acceso')]=$mod;
		}
		}
	}
	
	public function has($mod,$tarea)
	{
		if($this->tipo==1)
		return true;
		else
		{
			
			if($this->modules[$mod])
			{
				if($this->modules[$mod]->task[$tarea])
				return true;
			}
		}
		
		return false;
	}
}

class aMocules
{
	public $module;
	public $task=array();
	
	public function __construct($module)
	{
		$this->module = $module;
		
	}
	
	public function addtask($taskes)
	{
		$this->task[$taskes]=$taskes;
	}
}
?>
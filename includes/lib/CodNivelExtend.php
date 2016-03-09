<?php
    
      class CodNivelExtend extends CodNivel
      {
            public function getNombreNivel($nivel,$tipocod="",$limit="")
            {
				
				$params=array();
				$params[]="c.nivel=$nivel";

				if($cid != 0)
                {
					$params[]=" co.id=$cid";
				}
				
				if($tipocod)
                {
					$params[]=" c.cod_tipo=$tipocod";
				}

				if(count($params))
				{
					$params="where ".implode(" and ", $params);
				}
				else
				$params="";
				
                               
               // $query="select SQL_CALC_FOUND_ROWS c.* from cod_nivel as c left join cod_tipos as co on c.nivel=co.nivel $params";
                $query="select c.* from cod_nivel as c $params";
				

				$result=$this->Select($query);
				
                return $result[0] ;
            }
			
			public function getNombreNivelHijodelpadre($cid,$limit="")
            {
				$params=array();
				if($cid != 0)
                {
					$params[]=" co.id=$cid";
				}

				if(count($params))
				{
					$params="where ".implode(" and ", $params);
				}
				else
				$params="";
				
                               
                $query="select SQL_CALC_FOUND_ROWS c.* from cod_nivel as c left join cod_tipos as co on c.nivel=(co.nivel+1) $params";
                $result=$this->Select($query);
				
                return $result[0] ;
            }
			
			
            public function getNombreNivelHijo($tipocod,$nivel,$limit="")
            {
                $query="select SQL_CALC_FOUND_ROWS c.* from cod_nivel as c where c.cod_tipo=$tipocod and c.nivel=$nivel $limit";
                $result=$this->Select($query);
                return $result[0];
            }
            public function getNombreNivelPadre($tipocod,$limit="")
            {
				return $this->getNombreNivelHijo($tipocod,0,$limit);
            }
			
			
            public function getNombreByNivel($nivel)
            {
                $query="select SQL_CALC_FOUND_ROWS * from cod_nivel as c where c.nivel=$nivel";
                $result=$this->Select($query);
                return $result[0] ;
            }
      }
    
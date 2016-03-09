<?php
class THelper
{
	public function __construct(){}

	/**
	 * @param string $id id del control
	 * @param string $value valor que va a quedar seleccionado en el control
	 * @param array  $attributes aqui se pasan todos los atributos extras Ej:
	 * @example array('class="nombreclass"', 'size="20"') y otrs atributos que se deseen agregar
	 * @return string control input type="radio"
	 * */
	 static function SendEmailByCode($data, $to,$name,$code)
	{
		$email= new EmailsExtend();
		$email=$email->getEmailCode($code);
		if($email[0])
		{
		$email=$email[0];
		
		$titulo=$email->g('titulo');
		$texto=$email->g('texto');
		$emailfrom=$email->g('emailde');
		
		if(!$emailfrom)
		$emailfrom=EMAILFROM;
		
		$variables=$email->g('variables');
		$variables=explode(",",$variables);
		
		foreach($variables as $v)
		{
			$v=trim($v);
			
			$replace=$data[$v];
			if(!$replace)
			$replace=" ";
			
		//	echo $v."=".$replace."<br>";
			$texto=str_replace($v,$replace,$texto);
			$titulo=str_replace($v,$replace,$titulo);
		}
		
		$params['namefrom'] = NAMEFROME;
		$params['emailfrom'] = $emailfrom;
		$params['emailto'] = $to;
		$params['nameto'] = $name;
		$params['asunto'] = utf8_decode($titulo);
		$msgreserva=$texto;
		$params['body'] = $msgreserva;	

		TMail::SendMail($params);
		}
	}
	static public function radioButton($id, $value, $name, $attributes = array())
	{
		$list_attrib = implode(' ', $attributes);
		return "<input type=\"radio\" name=\"$name\" id=\"$id\" value=\"$value\" $list_attrib />";
	}
	 
	/**
	 * @param string $id id del control
	 * @param string $value valor que va a quedar seleccionado en el control
	 * @param array  $attributes aqui se pasan todos los atributos extras Ej:
	 * @example array('class="nombreclass"', 'size="20"') y otrs atributos que se deseen agregar
	 * @return string control input type="text"
	 * */
	static public function textBox($id, $value, $attributes = array())
	{
		$list_attrib = implode(' ', $attributes);
		return "<input type=\"text\" name=\"$id\" id=\"$id\" value=\"$value\" $list_attrib />";
	}
	
	
	/**
	 * @param string $id id del control
	 * @param string $value valor que va a quedar seleccionado en el control
	 * @param array  $attributes aqui se pasan todos los atributos extras Ej:
	 * @example array('class="nombreclass"', 'size="20"') y otrs atributos que se deseen agregar
	 * @return string control input type="password"
	 * */
	static public function password($id, $value, $attributes = array())
	{
		$list_attrib = implode(' ', $attributes);
		return "<input type=\"password\" name=\"$id\" id=\"$id\" value=\"$value\" $list_attrib />";
	}
	
	 
	/**
	 * @param string $id id del control
	 * @param string $value valor que va a quedar seleccionado en el control
	 * @param array  $attributes aqui se pasan todos los atributos extras Ej:
	 * @example array('class="nombreclass"', 'size="20"') y otrs atributos que se deseen agregar
	 * @return string control input type="checkbox"
	 * */
	static public function checkBox($id, $value, $attributes = array())
	{
		$list_attrib = implode(' ', $attributes);
		$id_s = str_replace('[', '', $id);
		$id_s = str_replace(']', '', $id_s);
		return "<input type=\"checkbox\" name=\"$id\" id=\"$id_s\" value=\"$value\" $list_attrib />";
	}
	 
	/**
	 * @param string $id id del control
	 * @param string $value valor que va a quedar seleccionado en el control
	 * @param array  $attributes aqui se pasan todos los atributos extras Ej:
	 * @example array('class="nombreclass"', 'size="20"') y otrs atributos que se deseen agregar
	 * @return string control input type="button"
	 * */
	static public function button($id, $value, $attributes = array())
	{
		$list_attrib = implode(' ', $attributes);
		return "<input type=\"button\" name=\"$id\" id=\"$id\" value=\"$value\" $list_attrib />";
	}
	
	/**
	 * @param string $id id del control boton
	 * @param string $value valor del boton a mostrar
	 * @param string &urlImage imagen que se va a mostrar en el boton
	 * @param Array $attributes lista de propiedades del boton
	 * */
	static public function imageLinkButton($id, $value, $urlImage, $attributes = array())
	{
		$list_attrib = implode(' ', $attributes);
		return "<input type=\"image\" name=\"$id\" id=\"$id\" value=\"$value\" src=\"$urlImage\" $list_attrib />";
	}
	 
	/**
	 * @param string $id id del control
	 * @param string $value valor que va a quedar seleccionado en el control
	 * @param array  $attributes aqui se pasan todos los atributos extras Ej:
	 * @example array('class="nombreclass"', 'size="20"') y otrs atributos que se deseen agregar
	 * @return string control input type="submit"
	 * */
	static public function submit($id, $value, $attributes = array())
	{
		$list_attrib = implode(' ', $attributes);
		return "<input type=\"submit\" name=\"$id\" id=\"$id\" value=\"$value\" $list_attrib />";
	}
	 
	/**
	 * @param string $id id del control
	 * @param string $value valor que va a quedar seleccionado en el control
	 * @param array  $attributes aqui se pasan todos los atributos extras Ej:
	 * @example array('class="nombreclass"', 'size="20"') y otrs atributos que se deseen agregar
	 * @return string control input type="hidden"
	 * */
	static public function hidden($id, $value, $attributes = array())
	{
		$list_attrib = implode(' ', $attributes);
		$id_s = str_replace('[', '', $id);
		$id_s = str_replace(']', '', $id_s);
		return "<input type=\"hidden\" name=\"$id\" id=\"$id_s\" value=\"$value\" $list_attrib />";
	}
	 
	/**
	 * @param string $id id del control
	 * @param string $value valor que va a quedar seleccionado en el control
	 * @param int $cols ancho del control
	 * @param int $rows alto del control
	 * @param array  $attributes aqui se pasan todos los atributos extras Ej:
	 * @example array('class="nombreclass"', 'size="20"') y otrs atributos que se deseen agregar
	 * @return string control textarea
	 * */
	static public function textarea($id, $value, $cols = 45, $rows = 5, $attributes = array())
	{
		$list_attrib = implode(' ', $attributes);		
		return "<textarea name=\"$id\" id=\"$id\" cols=\"$cols\" rows=\"$rows\" $list_attrib>$value</textarea>";
	}
	 
	/**
	 * @param string $id id del control
	 * @param object objecto que debe llenarse con los valores que se van  a mostrar
	 * @param string $field_value este es e el valor que va a tener cada option del select
	 * @param string $field_show valor que se va a mostrar en el select
	 * @param array  $default_value aqui se pone el valor por defecto que debe tener el select
	 * @param string valor que va a quedar seleccionado
	 * @example   array('valor'=>'Valor Mostrar');
	 * @param bool $isHtmlEntities para usar la funci�n htmlentities se debe poner este par�metro en true
	 * @param array  $attributes aqui se pasan todos los atributos extras Ej:
	 * @example array('class="nombreclass"', 'size="20"') y otrs atributos que se deseen agregar
	 * @return string control Select
	 * */
	static public function selectObject($id, $object, $field_value, $field_show, $default_value = array(), $defaultValue = 0, $isHtmlEntities = false, $attributes = array())
	{
		$list_attrib = implode(' ', $attributes);
		$id_s = str_replace('[', '', $id);
		$id_s = str_replace(']', '', $id_s);
		$control = "<select name=\"$id\" id=\"$id_s\" $list_attrib>";

		//agrego los valores por defecto
		if($default_value)
		{
			foreach ($default_value as $key=>$value)
			{
				$key = $isHtmlEntities ? utf8_decode(htmlentities($key)) : $key;
				$value = $isHtmlEntities ? utf8_decode(htmlentities($value)) : $value;
								
				$selected = preg_match("/$key/", $defaultValue) ? 'selected="selected"' : '';
				$control .= "<option value=\"$key\" $selected>$value</option>";
			}
		}         
		//lleno el select con los valores de la base de datos
		foreach ($object as $items)
		{
			$val = $isHtmlEntities ? utf8_decode(htmlentities($items->getGenericField($field_value))) : $items->getGenericField($field_value);
			$value_Show = $isHtmlEntities ? utf8_decode(htmlentities($items->getGenericField($field_show))) : $items->getGenericField($field_show);
			$selected = ($items->getGenericField($field_value) == $defaultValue) ? 'selected="selected"' : '';
			$control .= "<option value=\"$val\" $selected>$value_Show</option>";
		}

		$control .= "</select>";

		return $control;
	}
	 
	/**
	 * @param string $id id del control
	 * @param array  $values listado de valores que se van  a mostrar en el listado
	 * @param string $defaultValue valor por defecto que va a quedar selccionado
	 * @example   array('valor'=>'Valor Mostrar', 'valor1'=>'Valor Mostrar1', 'valor2'=>'Valor Mostrar2');
	 * @param bool $isHtmlEntities para usar la funci�n htmlentities se debe poner este par�metro en true
	 * @param array  $attributes aqui se pasan todos los atributos extras Ej:
	 * @example array('class="nombreclass"', 'size="20"') y otrs atributos que se deseen agregar
	 * @return string control Select
	 * */
	static public function select($id, $values = array(), $defaultValue = 0, $isHtmlEntities = false, $attributes = array())
	{
		$list_attrib = implode(' ', $attributes);
		$name = $id;
		$id_s = str_replace('[', '', $id);
		$id_s = str_replace(']', '', $id_s);
		$control = "<select name=\"$name\" id=\"$id_s\" $list_attrib>";

		//lleno el select con los valores de la base de datos
		foreach ($values as $key => $value)
		{
			if($key==$defaultValue)
			 $selected='selected="selected"';
			 else
			 $selected='';
			 
			$key = $isHtmlEntities ? htmlentities($key) : $key;
			$value = $isHtmlEntities ? htmlentities($value) : $value;
			
			
           // $selected = preg_match("/^$key$/", $defaultValue) ? 'selected="selected"' : '';						
			$control .= "<option value=\"$key\" $selected>$value</option>";
	
		}


		$control .= "</select>";

		return $control;
	}
	
	
	static public function checkBoxC($id, $values = array(), $defaultValue = 0, $isHtmlEntities = false, $attributes = array())
	{
		$list_attrib = implode(' ', $attributes);
		$name = $id;
		$id_s = str_replace('[', '', $id);
		$id_s = str_replace(']', '', $id_s);

		//lleno el select con los valores de la base de datos
		foreach ($values as $key => $value)
		{
			if($key==$defaultValue)
			 $selected='checked="checked"';
			 else
			 $selected='';
			 
			$key = $isHtmlEntities ? htmlentities($key) : $key;
			$value = $isHtmlEntities ? htmlentities($value) : $value;
						
			$control .= "<input type=\"checkbox\" name=\"$id\" id=\"$id_s\" value=\"$key\" />&nbsp;".$value."&nbsp;&nbsp;";	
	
		}
		return $control;
	}
	static public function radioButtonC($id, $values = array(), $defaultValue = 0, $isHtmlEntities = false, $attributes = array())
	{
		$list_attrib = implode(' ', $attributes);
		$name = $id;
		$id_s = str_replace('[', '', $id);
		$id_s = str_replace(']', '', $id_s);

		//lleno el select con los valores de la base de datos
		foreach ($values as $key => $value)
		{
			if($key==$defaultValue)
			 $selected='checked="checked"';
			 else
			 $selected='';
			 
			$key = $isHtmlEntities ? htmlentities($key) : $key;
			$value = $isHtmlEntities ? htmlentities($value) : $value;
			$control .= '<div class="menu_mapa_row_radio">';
			$control .= '<input type="radio" name="'.$id.'"id="'.$id_s.'"value="'.$key.'" />&nbsp;';	
                        $control .= '<label for="radio" class="menu_mapa_row_radio_txt">'.$value.'</label>';
                        $control .= '</div>';
		}
		return $control;
	}
	/**
	 * @param string $id id del control
	 * @param string $value valor que va a quedar seleccionado en el control
	 * @param array  $attributes aqui se pasan todos los atributos extras Ej:
	 * @example array('class="nombreclass"', 'size="20"') y otrs atributos que se deseen agregar
	 * @return string control input type="hidden"
	 * */
	static public function file($id, $attributes = array())
	{
		$list_attrib = implode(' ', $attributes);
		$id_s = str_replace('[', '', $id);
		$id_s = str_replace(']', '', $id_s);
		return "<input type=\"file\" name=\"$id\" id=\"$id_s\" value=\"\" $list_attrib />";
	}
	 
}

?>
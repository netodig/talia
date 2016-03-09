//Version 2.0
/*var MENSAJE_REQUERIDO="<img src='"+INCLUDEIMG+"img/error.gif'' title='Campo requerido' alt='Campo requerido' >";
var MENSAJE_NUMBER="<img src='"+INCLUDEIMG+"img/error.gif'' title='Debe ser un valor numerico' alt='Debe ser un valor numerico' >";
var EMAIL_INVALIDO="<img src='"+INCLUDEIMG+"img/error.gif'' title='Email invalido' alt='Email invalido' >";*/
/*var MENSAJE_REQUERIDO="Campo requerido";
var MENSAJE_NUMBER="Debe ser un valor numerico";
var EMAIL_INVALIDO="Email invalido";*/
var INCLUDEAJAX='includes/ajaxphp/';
var CONSTANTEDIST=2000;
var SHOWERROR=false;
String.prototype.trim = function() {return this.replace(/^\s*|\s*$/g,"");} 

/*parte jquery*/

function CheckAll(selector, boolVall)
{
    var $list = $(selector);
    for(var i = 0; i < $list.length; i++)
       $list[i].checked = boolVall;
}

function CleanAll(selector, values)
{
    var $list = $(selector);
    for(var i = 0; i < $list.length; i++)
       $list[i].value=values;
}
/*
Para borrar los textos por defecto en focus
*/

function prevalida(objs)
{
	$(objs).each(function(index, elem){
			if (elem.value == elem.defaultValue)
           	 elem.value = '';
	});
}
function posvalida(objs)
{/*
	$(objs).each(function(index, elem){
		 if (elem.value.trim() == ''){
            elem.value = (elem.defaultValue ? elem.defaultValue : '');
        }
	});*/
}

function toggleonfocus(objs)
{
	 $(objs).focus(function() {
        if (this.value == this.defaultValue){
            this.value = '';
        }
        if(this.value != this.defaultValue){
            this.select();
        }
    });
	 $(objs).blur(function() {
        if (this.value.trim() == ''){
            this.value = (this.defaultValue ? this.defaultValue : '');
        }
    });
}


function g(id)
{
	try
	{
	//obj=$("#"+id);
	obj= document.getElementById(id);
	return obj;
	}
	catch(ex)
	{
		if(SHOWERROR)
		alert("Error en G con Id="+id+" error:"+ex.message);
	}
}


/*
*Se le pasa el id del objeto select y limpia el valor value
*/
function gcvs(id)
{
	try
	{
		selecte=g(id);
		while(selecte.options.length>0)
		{
			selecte.remove(0);
		}
	}
	catch(ex)
	{
		if(SHOWERROR)
		alert("Error en GCVS con Id="+id+" error:"+ex.message);
	}
}

/*
*Se le pasa el id del objeto y el valor de disabled
*/
function gd(id,value)
{
	try
	{
		g(id).disabled=value;
	}
	catch(ex)
	{
		if(SHOWERROR)
		alert("Error en GD con Id="+id+" error:"+ex.message);
	}
}

/*
*Se le pasa el nombre de la clase y el id de donde buscar y devuelve una lista
*/
function gclassid(clase,id)
{
	return g(id).getElementsByClassName(clase);
}

/*
*Se le pasa el nombre de la clase y devuelve una lista
*/
function gclass(clase)
{
	return document.getElementsByClassName(clase);
}
/*
*Se le pasa el id del objeto y limpia el valor value
*/
function gcv(id)
{
	try
	{
		g(id).value="";
	}
	catch(ex)
	{
		if(SHOWERROR)
		alert("Error en GCV con Id="+id+" error:"+ex.message);
	}
}
/*
*Se le pasa el id del objeto checkbox y devuelve si est'a checked o no
*/
function gvc(id)
{
	try{
	return g(id).checked;
	}
	catch(ex)
	{
		if(SHOWERROR)
		alert("Error en GVC con Id="+id+" error:"+ex.message);
	}
}

/*Se le pasa como parametro el Id y retorna un objeto
*Si no encuentra el objeto retorna null
*/
function wg(id)
{
try
	{
	obj=window.parent.document.getElementById(id);
	return obj;
	}
	catch(ex)
	{
		if(SHOWERROR)
		alert("Error en G con Id="+id+" error:"+ex.message);
	}	
}



/*
*Se le pasa como parametro el id del objeto y retorna su innerHTML
* return obj.value
*/
function gi(id)
{
	try
	{
		return g(id).innerHTML;
	}
	catch(ex)
	{
		if(SHOWERROR)
		alert("Error en GV con Id="+id+" error:"+ex.message);
	}
}

/*
*Se le pasa como parametro el id del objeto y retorna su valor
* return obj.value
*/
function gv(id)
{
	try
	{
		return g(id).value;
	}
	catch(ex)
	{
		if(SHOWERROR)
		alert("Error en GV con Id="+id+" error:"+ex.message);
	}
}

/*
*Se le pasa como parametro el Id y retorna true si el value del objeto = ""
*o a "0"
*/
function gve(id)
{
	try
	{
		obj=gv(id);
		
		if(obj=="" || obj==0)
		return true;
		else
		return false;
	}
	catch(ex)
	{
		return null;
	}
}

/*Se le pasa el id y devuelve true si el objeto tiene su valor por defecto*/
function gvedv(id)
{
	return g(id).defaultValue==g(id).value;
}

/*Se le pasa el id del objeto, y te devuelve true si esta vacio o esta en su valor por defecto*/
function gvefull(id)
{
	if(gve(id) || gvedv(id))
	return true;
	return false;
}

/*se le pasa el id del objeto y te devuelve si esta vacio*/
function gve0(id)
{
	try
	{
		obj=gv(id);

		if(obj=="")
		return true;
		else
		return false;
	}
	catch(ex)
	{
		return null;
	}
}

/*
*Se le pasa el objeto select y los valors de una opci'on y le agrega la opci'on
*/
function AOS(objCombo,valorOption,textOption)
{
 var oOption = document.createElement("OPTION");
        objCombo.options.add(oOption);
		oOption.text =textOption;
		oOption.value = valorOption;
}


//classe Ajax NPG
var AjaxNpg= function()
	{
		this.sendRequest= function(url,params,onSuccess ,datatype)
		{
		  try{
		  $.ajax({     
		  url : url+params,
		  type : 'POST',    
		  dataType : datatype,    
			  
		   success : function(response) 
		   {
			onSuccess(response);
		   },
	  
		   error : function(xhr, status) {
			   
		
			   alert('Disculpe, ha ocurrido un problema vuelva a intentarlo.');},	  
		   complete: function(){
			/*$.mobile.hidePageLoadingMsg();*/
		   // $('#blockscreen').hide();
		   }
 	 });
 	 }
  	catch(ex)
 	 {
     //$.mobile.hidePageLoadingMsg();
    // $('#blockscreen').hide();
     showMsg('sh-error', ex.message);     
  	}
	};	
};

AJAX=new AjaxNpg();


function replace(texto,s1,s2){
	return texto.split(s1).join(s2);
} 

function cambiartexto(area,s1,s2){
	// Obtenemos el valor del area de texto	
	texto = area.value;
	// Cambiamos su valor
	area.value = replace(texto,s1,s2);
}

/*se le pasa el objeto checkbox y el id del objeto a activar o desactivar con las activaciones/desactivaciones del checkbox*/
function dt(obj,id)
{
	t=g(id);
	
	if(obj.checked)
	{
		t.disabled=false;
	}
	else
	{
		t.disabled=true;
	}
}

/*te intercambia el valor disabled del id*/
function dti(id)
{
	t=g(id);
	t.disabled=!t.disabled;
}


function deltabla(id,idtabla)
{
	row=g(id);
	table=g(idtabla);
	table.deleteRow(row.rowIndex);
}


function gsd(id,d)
{
	g(id).style.display=d;
}

function gcd(id)
{
	if(g(id).style.display=="inline")
	gsd(id,'none');
	else
	gsd(id,'inline');
}

function gcd2(id)
{
	if(g(id).style.display=="inline")
	gsd(id,'none');
	else
	gsd(id,'');
}


function selectAllValues(idvalues)
{
	for(i=0;i<idvalues.length;i++)
	{
		g(idvalues[i]).selectedIndex=0;
	}
}

function chclass(obj,vieja, nueva)
{
	//while(obj.className.indexOf(vieja)>0)
	obj.className=obj.className.replace(vieja,nueva);
}

function co(type, id, css, inner)
{
	obj= document.createElement(type);
	try
	{
	obj.id=id;
	obj.className=css;
	if(inner)
	obj.innerHTML=inner;
	}
	catch(ex){};
	return obj;
}

function ade(ob,type,fn)
{
	if (ob.addEventListener) ob.addEventListener(type, fn, false);
	else 
	ob.attachEvent('on' + type, fn);
}
function rme(ob,type,fn)
{
	if (ob.removeEventListener) ob.removeEventListener(type, fn, false);
	else 
	ob.detachEvent('on' + type, fn);
}

var TimeUPDATEOUT= new Array();
var TimeUPDATESHOW=new Array();
var TIMEFADES=new Array();
var DISPLAYNONE=true;
var varr=new Array();

function fadeout(id,fn)
{
	varr[id]-=0.25;

	setOpa(id,varr[id]);
	
	if(varr[id]>0)
	{
		TimeUPDATEOUT[id]=setTimeout("fadeout('"+id+"',"+fn+");",TIMEFADES[id]);
	}
	else
	{
		try
		{
		varr[id]=1;
		setOpa(id,0);
		clearTimeout(TimeUPDATEOUT[id]);
		if(DISPLAYNONE)
		g(id).style.display='none';
		if(fn)
		fn();
		}
		catch(ex)
		{}
	}

}

function setOpa(id,varr)
{
	try
	{
	if(navigator.userAgent.indexOf("MSIE")>=0) 
	{
	g(id).style.filter="alpha(opacity="+varr*100+")";
	if(varr==1)
		{
			g(id).style.filter="";
		}
	}
	else
	g(id).style.opacity=varr;
	}
	catch(ex)
	{}
}

function fadein(id,fn)
{
	try
	{
	varr[id]+=0.25;
	setOpa(id,varr[id]);
	
	if(varr[id]<1)
	{
		TimeUPDATESHOW[id]=setTimeout("fadein('"+id+"',"+fn+")",TIMEFADES[id]);
	}
	else
	{
		varr[id]=0;
		setOpa(id,1);
		g(id).zoom=1;
		clearTimeout(TimeUPDATEOUT[id]);
		if(fn)
		fn();
	}
	}
	catch(ex)
	{}
	
}

function fade(id,type,fn)
{
	if(!TIMEFADES[id])
		TIMEFADES[id]=10;
	
	switch(type)
	{
		case "show":
		{
			try
			{
			g(id).style.display='inline';
			TimeUPDATEOUT[id]=0;
			varr[id]=0;
			fadein(id,fn);
			}
			catch(ex)
			{}
			
			break;
		}
		case "hide":
		{
			try
			{
			TimeUPDATEOUT[id]=0;
			varr[id]=1;
			fadeout(id,fn);
			}
			catch(ex)
			{}
			break;
		}
	}
}

function gram(ri,rs)
{
   aleatorio = Math.floor(Math.random()*(rs-(ri-1))) + ri;  
   return aleatorio;
}


function fadeTime(id,type,time)
{
	TIMEFADES[id]=time;
	fade(id,type);
}

function stopfadeing(id)
{
	clearTimeout(TimeUPDATESHOW[id]);
	clearTimeout(TimeUPDATEOUT[id]);
}

function putAvisoInter(texto,time, donde)
{
	g(donde).innerHTML=texto;
	setTimeout("fade('"+donde+"','hide');",time);
	fade(donde,"show");
}

function gsv(id,val)
{
	valore=0;
	eval("valore=g('"+id+"').style."+val+";");
	valore=valore.replace("px","");
	
	return valore;
}

var nav4 = window.Event ? true : false;
function IsNumber(evt){
// Backspace = 8, Enter = 13, ‘0' = 48, ‘9' = 57, ‘.’ = 46, ‘-’ = 43 ','=44
//var key = nav4 ? evt.which : evt.keyCode;
var key=evt.which;
if(!key)
	key=evt.keyCode;
	
return (key <= 13 || (key >= 48 && key <= 57) || key==45 || key==44 || key==46  ) ;
}

function sololetranumer(evt)
{
	return true;
	var key=evt.which;
if(!key)
	key=evt.keyCode;

return (key <= 13 || key==241 || key==46 || key==32 || key==225 || key==233 || key==237 || key==243 || key==250  || (key >= 48 && key <= 57) || (key >= 97 && key <= 122) || (key >= 65 && key <= 90)  ) ;
}
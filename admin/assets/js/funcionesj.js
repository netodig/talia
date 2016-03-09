
/*usando jquery*/

function deluser(id)
{
	BorrarBd(id,"deluser","el usuario",'usuario');
}
function delcod(id)
{
	BorrarBd(id,"delcod","el tipo",'tipo');
}
function delcodgerq(id)
{
	BorrarBd(id,"delcodgerq","el tipo",'tipo');
}


function delmodulo(id)
{
	BorrarBd(id,"delmodulo","el modulo",'modulo');
}




function delidioma(id)
{
	BorrarBd(id,"delidioma","el idioma",'idioma');
}

function deltaske(id)
{
	BorrarBd(id,"deltaske","la tarea",'tarea');
}


function delperfil(id)
{
	BorrarBd(id,"delperfil","el perfil",'perfil');
}
function setModif(id, valact,posact)
{
	
	if($("#save"+id).val()==1)
	{
	//pongo en el div infofoto los campos de texto para pie y orden
	$("#infofoto"+id).html('');
	$("#buttonmod"+id).addClass('save');
	
	$('<div></div>').attr({'id':'piefotodiv'+id}).appendTo("#infofoto"+id);
	$('<input>').attr({'id':'piefoto'+id,'value':$('#piefotor'+id).val(),'type':'text'}).addClass('piefototext').appendTo("#piefotodiv"+id);
	$('<span>Pie:</span>').appendTo("#piefotodiv"+id);
	
	
	$('<div></div>').attr({'id':'ordendiv'+id}).appendTo("#infofoto"+id);
	$('<input>').attr({'id':'orden'+id,'value':$('#ordenfor'+id).val(),'type':'text'}).addClass('orden').appendTo("#ordendiv"+id);
	$('<span>Orden:</span>').appendTo("#ordendiv"+id);
	
	
	$("#save"+id).val(2);
	
	}
	else
	{
		if(confirm("Está seguro que desea guardar?"))
		{
		//guardo
		saveOrdenPie($('#orden'+id).val(),$('#piefoto'+id).val(), id);
		$('#piefotor'+id).val($('#orden'+id).val());
		$('#ordenfor'+id).val($('#piefoto'+id).val());
		
		$("#infofoto"+id).html($('#piefoto'+id).val()+"<br>Orden: "+$('#orden'+id).val());
		$("#save"+id).val(1);
		$("#buttonmod"+id).removeClass('save');
		}
	}
}

function saveOrdenPie(orden,pie, id)
{

	param="?task=saveordenpie";
	param+="&orden="+orden;
	param+="&pie="+pie;
	param+="&id="+id;
	
	AJAX.sendRequest(SITEURLCOMPLETA+INCLUDEAJAX+'admininterface.php',param,function(resp){	

		},'html');
}




function delfotoconfig(imagen,src,idpadre)
{
	if(confirm("Are you sure you want to delete the photo?"))
	{
	param="?task=delfotoconfig";
	param+="&src="+src;
	param+="&imagen="+imagen;
	param+="&idcontent="+idpadre;

	AJAX.sendRequest(SITEURLCOMPLETA+INCLUDEAJAX+'admininterface.php',param,function(resp){	
		
		//pongo la respuesta
		resp=eval(resp);

		$("#"+idpadre).html(resp[0]);
		},'html');

	}

}

function delfoto(carpeta,id,idpadre)
{
	
	if(confirm("Está seguro que desea eliminar la foto?"))
	{
	param="?task=delfotoajax";
	param+="&ids="+id;
	param+="&carpeta="+carpeta;
	param+="&idcontent="+idpadre;
	

	AJAX.sendRequest(SITEURLCOMPLETA+INCLUDEAJAX+'admininterface.php',param,function(resp){	
		
		//pongo la respuesta
		resp=eval("("+resp+")");
		try
		{
		$("#"+idpadre).html(resp.img);
		}
		catch(ex)
		{}
	
		
		},'html');

	}

}

function SetPrincipal(id)
{
	if(confirm("Está seguro que desea seleccionar esta foto como principal?"))
	{
	
	param="?task=setPrincipal";
	param+="&id="+id;
	param+="&tabla="+$("#carpeta").val();
	param+="&idtabla="+$("#id").val();
	
		
	AJAX.sendRequest(SITEURLCOMPLETA+INCLUDEAJAX+'admininterface.php',param,function(resp){	
		//le quito la clase al que la tenia, y la pongo al nuevo, guardo en el viejo
		
		$("#imgprincipal"+$("#principal").val()).removeClass('imgpactive');
		$("#imgprincipal"+id).addClass('imgpactive');
		$("#principal").val(id);
		
		},'html');
	}
}
function BorrarBd(id,task,text,tabla)
{
	BorrarBdExt(id,task,text,tabla,'admininterface.php');
}

function BorrarBdExt(id,task,text,tabla,phpfile)
{
	if(confirm("Are you sure you want to delete "+text+"?"))
	{
	
	param="?task="+task;
	param+="&id="+id;

	AJAX.sendRequest(SITEURLCOMPLETA+INCLUDEAJAX+phpfile,param,function(resp){	
		//elimino de la tabla
		
		$('#row'+id).fadeOut(300,function(){
			$(this).remove();
			});
		},'html');
	}
}

function createMsg(css,msg,donde)
{
	content = $('<h2></h2>')
       .addClass(css)
       .html(msg);
       dvNotificar=$("#"+donde);
	   dvNotificar.html('');
      dvNotificar.append(content);
	  dvNotificar.stop();
	  dvNotificar.fadeIn(300).delay(10000).fadeOut(300);
}

function showMsg(cssClass, msg)
{
    var dvNotificar = $('#notif');
    var content = null;
    if(!dvNotificar.get(0))
    {
       $('<div></div>').attr('id','notif').css(
       {'position':'fixed','top':'500px', 'z-index':'25'}).addClass('ui-btn-corner-all notif')
       .appendTo('body').hide();
       
       dvNotificar = $('#notif');       
       
       var btnClose = $('<div></div>').css({'position':'absolute', 'right':'-1%', 'z-index':'26',
       'top':'-13px'}).html('+')
       .addClass('ui-btn ui-shadow ui-btn-corner-all btn-close')
       .click(function(){dvNotificar.stop(); 
       dvNotificar.fadeOut(300);});   
   
        //content = $('<div></div>')
		content = $('<h2></h2>')
       .addClass('nft-content '+cssClass)
       .html(msg);
       
       dvNotificar.append(btnClose).append(content);
    }
    else
    {
       content = dvNotificar.find('div.nft-content');
       content.removeClass('sh-ok').removeClass('sh-error').addClass(cssClass).html(msg);       
    }
    
    /*centrando segun el contenido que tenga el contenedor*/
    var w = $(document).width();    
    dvNotificar.css({'left':parseInt((w/2)-parseInt(dvNotificar.width()/2))+'px'});
    
    /*si antes habia un fade ejecutandose lo paro para hacer el nuevo*/
    dvNotificar.stop();
    
    //dvNotificar.fadeIn(300).delay(10000).fadeOut(300);
	dvNotificar.fadeIn(300).delay(10000);
}

function eliminaFotosall()
{
	
	if(confirm("Está seguro que desea eliminar las fotos?"))
	{
	checks=$(".delfoto::checked");
	
	ids="";
	idschecks="";
	coma="";
	for(i=0;i<checks.length;i++)
	{
		ids+=coma+checks[i].value;
		idschecks+=coma+checks[i].id;
		coma=",";
	}
	
	param="?task=delfotos";
	param+="&ids="+ids;
	param+="&carpeta="+$("#carpeta").val();
	
	if(ids)
	{
	
	AJAX.sendRequest(SITEURLCOMPLETA+INCLUDEAJAX+'admininterface.php',param,function(resp){	
		//elimino de la tabla
	
		
		deleteItem(idschecks, null, 'div');
		},'html');
	
	}
	}

}









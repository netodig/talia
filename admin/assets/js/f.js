// JavaScript Document
function cargacombos(idpadre,idcarga,idobj, task)
{
	param="?task="+task;
	param+="&idpadre="+idpadre;
	param+="&idobj="+idobj;

	$("#"+idcarga).html("Cargando...");
	
	AJAX.sendRequest(SITEURLCOMPLETA+INCLUDEAJAX+'extendinterface.php',param,function(resp){	
		
		//pongo la respuesta

		resp=eval(resp);

		$("#"+idcarga).html(resp[0]);
		},'html');

}

function cargaPoblacion(obj)
{
	cargacombos(obj.value,'cargadorpobla','poblacion', 'cargacoms');
}

function cargaasociados(idgrupo, selecte,selecte2)
{
	param="?task=cargaasociado";
	param+="&idgrupo="+idgrupo;
	param+="&selected="+selecte;
	param+="&selected2="+selecte2;
	

	$("#asociadocarga").html("Cargando...");
	
	AJAX.sendRequest(SITEURLCOMPLETA+INCLUDEAJAX+'extendinterface.php',param,function(resp){	
		
		//pongo la respuesta
		resp=eval(resp);

		$("#asociadocarga").html(resp[0]);
		},'html');

}

function BorrarBdext(id,task,text,tabla)
{
	BorrarBdExt(id,task,text,tabla,'extendinterface.php');
}


function delfotonew(carpeta,id,idpadre)
{
	delfotoInterno(carpeta,id,idpadre,true);
}

function delfotoInterno(carpeta,id,idpadre,muestroAlBorrar)
{
	
	if(confirm("Are you sure you want to delete the photo?"))
	{
	param="?task=delfotoajax";
	param+="&ids="+id;
	param+="&carpeta="+carpeta;
	param+="&idcontent="+idpadre;
	

	AJAX.sendRequest(SITEURLCOMPLETA+INCLUDEAJAX+'admininterface.php',param,function(resp){	
		//pongo la respuesta
		resp=eval("("+resp+")");
			if(!muestroAlBorrar)
			{
			$("#"+idpadre).html("");
			}
		else
		{
		try
		{
		$("#"+idpadre).html(resp.img);
		}
		catch(ex)
		{}
		}
		
		},'html');

	}

}

function delhistory(id)
{
	BorrarBdext(id,"delhistory","the history",'history');
}

function delparrafo(id)
{
	BorrarBdext(id,"delparrafo","the paragrahp",'parrafo');
}

function actualizaParrafoTrans()
{
	icant= $('#cantoraciones').val();
	
	textaa="";
	for(i=1;i<=icant;i++)
	{
		textaa+=$("#oracion"+i).val();
		if($("#oracion"+i).val())
		textaa+=". ";
		if($("#saltooracion"+i).attr("checked"))
		textaa+="\n";
	}
	$('#textop').val(textaa);
	
}







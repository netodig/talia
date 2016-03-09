LETRAACTIVE='';
INACTVITE=false;

CONAUDIO=true;

function setLetra(letra)
{
	
	if(LETRAACTIVE!=letra && !INACTVITE)
	{
		INACTVITE=true;
		if(LETRAACTIVE!="")
		{
		$("#letra"+LETRAACTIVE).removeClass('active');
		$("#"+LETRAACTIVE+"letra").animate(
        	{opacity : "0"},500, function (){
				
				$("#"+LETRAACTIVE+"letra").hide();
				gstop("audiop"+LETRAACTIVE);
				
				
				$("#"+letra+"letra").show();
				$("#letra"+letra).addClass('active');
				$("#"+letra+"letra").animate(
        			{opacity : "1"},500, function (){
						
					LETRAACTIVE=letra;
					gplay("audiop"+letra);
					INACTVITE=false;
					});
				
				});
				
		}
		else
		{
			$("#"+letra+"letra").show();
				$("#letra"+letra).addClass('active');
				$("#"+letra+"letra").animate(
        			{opacity : "1"},500, function (){
						
					gplay("audiop"+letra);
					LETRAACTIVE=letra;
					INACTVITE=false;
					});
		}
		
		

	}
	
	
	//$("#"+letra+"letra").show();
	
	
}

ENTRADAACTIVE=0;
function togleagregarentrada()
{
	if(ENTRADAACTIVE)
	{
		
		$('#formentra').animate(
        	{opacity : "0",height: "0px"},1000);
			
		
		//$("#formentra").hide();
		ENTRADAACTIVE=0;
	}
	else
	{
		$('#formentra').animate(
        	{opacity : "1",height: "270px"},1000);
		//$("#formentra").show();
		ENTRADAACTIVE=1;
	}
}

PREGUNTAACTIVE=0;
function togleagregapregunta()
{
	if(PREGUNTAACTIVE)
	{
		
		$('#formpreguntadoc').animate(
        	{opacity : "0",height: "0px"},1000);
			
		
		//$("#formentra").hide();
		PREGUNTAACTIVE=0;
	}
	else
	{
		$('#formpreguntadoc').animate(
        	{opacity : "1",height: "230px"},1000);
		//$("#formentra").show();
		PREGUNTAACTIVE=1;
	}
}


function borrardiario(id)
{
	BorrarBdext(id,"deldiarioentrada","la entrada del diario",'deldiario');
}

function borrarpregunta(id)
{
	BorrarBdext(id,"delpreguntadoc","la pregunta",'deldiario');
}


function gplay(id)
{
	if($("#"+id).get(0) && CONAUDIO)
	{
	aud=$("#"+id).get(0);
	aud.play();
	}
}

function gpause(id)
{
	if($("#"+id).get(0))
	{
	aud=$("#"+id).get(0);
	aud.pause();
	}
}
function gstop(id)
{
	try
	{
	if($("#"+id).get(0))
	{
	aud=$("#"+id).get(0);
	aud.pause();
	aud.currentTime = 0;
	}
	}
	catch(ex)
	{}
}

function actdesactAudio(id,audiostop)
{
	if(!CONAUDIO)
	{
		//lo activo
		CONAUDIO=true;
		setstate('sound', 0);
		/*jQuery(id).each(function(idx, ele){
		  jQuery(this).removeClass("fa-microphone-slash").addClass("fa-microphone");
			
			});*/
			jQuery(id).removeClass("fa-microphone-slash").addClass("fa-microphone");
	}
	else
	{
		
		CONAUDIO=false;
		setstate('sound', 1);
		/*jQuery(id).each(function(idx, ele){
		  jQuery(this).addClass("fa-microphone-slash").removeClass("fa-microphone");
			});*/
			
		jQuery(id).addClass("fa-microphone-slash").removeClass("fa-microphone");
		gstop(audiostop);
	}
}

function setstate(name, value)
{
	param="?task=setState";
	param+="&state="+name;
	param+="&value="+value;
	
	AJAX.sendRequest(SITEURLCOMPLETA+INCLUDEAJAX+'extendinterface.php',param,function(resp){	
		},'html');
}




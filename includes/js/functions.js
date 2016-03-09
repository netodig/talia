// JavaScript Document
LOGINACTIVE=false;
function togleLogin()
{
	if(LOGINACTIVE)
	{
		//escondo
		$("#loginli").removeClass("loginactive");	
		$("#login").stop();
		$("#login").animate({ opacity : [ 0.0, "linear" ]}, 200);
		LOGINACTIVE=false;
	}
	else
	{
		$("#loginli").addClass("loginactive");	
		$("#login").stop();
		$("#login").animate({ opacity : [ 1, "linear" ]}, 200);
		LOGINACTIVE=true;
	}
}
function sel(id)
{
	rclass=$('#'+id).attr('class');
	aclass='check';
	if(rclass == 'check')
	{
		aclass='uncheck';
	}	
	$('#'+id).removeClass(rclass);
	$('#'+id).addClass(aclass);
}
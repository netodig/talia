
/*usando jquery*/

function BorrarBd(id,task,text,tabla)
{
	BorrarBdExt(id,task,text,tabla,'admininterface.php');
}

function BorrarBdExt(id,task,text,tabla,phpfile)
{
	if(confirm("Está seguro que desea eliminar "+text+"?"))
	{
            param="?task="+task;
            param+="&id="+id;
            AJAX.sendRequest(SITEURLCOMPLETA+INCLUDEAJAX+phpfile,param,function(resp){	
                    //elimino de la tabla

                    $('#'+tabla).fadeOut(300,function(){
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









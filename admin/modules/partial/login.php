<form id="frm_login" name="frm_login" class="formularionew" action="" method="POST" >
   <h1>Bienvenido a la Administración</h1>
  <h2>Introduzca sus datos para acceder</h2>
<?php 
		Msg::show("","h4","tc");
?>
  <fieldset class="w40p dvc">
    <legend></legend>
   
    <label for="usuario" class="w100p">
     <i class="fa fa-user"></i>  <input type="text" class="w100p " placeholder="Nombre de usuario" value="" id="usuario" name="usuario"></input>
    </label>
    <label for="pass" class="cb w100p">
      <i class="fa fa-key"></i>  <input type="password" class="w100p" placeholder="Contraseña" value="" id="pass" name="pass"/>
    </label>
    <div class="w100p tc fl">
     <button type="submit"><i class="fa fa-unlock-alt"></i> Entrar</button>
    </div>
    <input type="hidden" name="controller" value="general" />
    <input type="hidden" name="task" value="login" />
  </fieldset>
</form>
<script type="text/javascript">
	$("#frm_login").validate({
		rules: {
			usuario: {"required":true},
			pass: {"required":true},
		
			},
		messages: {
			usuario: {"required":'<i class="fa fa-exclamation-circle"></i>'},
			pass: {"required":'<i class="fa fa-exclamation-circle"></i>'},
		},
		debug: true,
		errorElement: 'div',		
		submitHandler: function(form){
		form.submit();
		}
	});

</script>
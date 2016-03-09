<div class="hide_desktop show_mobile mnu_movil"> <a href="/">Hola <?php echo $_SESSION['name'] ?></a>
  <button type="button" class="btn btn-navbar btnshmenu"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
  <div class="cb"></div>
</div>
<div class="loginbox hide_mobile">
  <ul class="submenu">
    <li>
      <h3>Hola <?php echo $_SESSION['name'] ?></h3>
    </li>
    <li><span class="separator">|</span></li>
    <li><a class="out" href="<?php echo Url::adminlink("", "controller=general&task=logout") ?>">Salir <i class="fa fa-sign-out"></i></a></li>
  </ul>
</div>
<div class="menu hide_mobile">
  <ul>
  	<li class="subm"><a href="<?php echo Url::adminlink("", "") ?>"><i class="fa fa-home"></i> Inicio</a>
   
    <li class="subm"><a><i class="fa fa-user"></i> Usuario</a>
      <ul>
       <!-- <li><a href="<?php echo Url::adminlink("perfiles/modulos/listado") ?>"><i class="fa fa-cog"></i> Modulos</a></li>-->
        <li><a href="<?php echo Url::adminlink("perfiles/perfiles/listado") ?>"><i class="fa fa-user"></i> Perfiles</a></li>
        <li><a href="<?php echo Url::adminlink("perfiles/usuarios/listado") ?>"><i class="fa fa-users"></i> Usuarios</a></li>
      </ul>
    </li>
     <li><a href="<?php echo Url::adminlink("traduccion/idioma/listado") ?>"><i class="fa fa-language "></i> Idiomas</a></li>
  <!--  <li class="subm"><a><i class="fa fa-language "></i> Gestion Idioma</a>
      <ul>
        <li><a href="<?php echo Url::adminlink("traduccion/traduce/tablas") ?>"><i class="fa fa-cog "></i> Configuración</a></li>
        <li><a href="<?php echo Url::adminlink("traduccion/idioma/listado") ?>"><i class="fa fa-language "></i> Idiomas</a></li>
       <li><a href="<?php echo Url::adminlink("traduccion/traduce/traduce") ?>"><i class="fa fa-flag-checkered "></i> Traducir</a></li>
      </ul>
    </li>-->
    <!--<li class="subm"><a><i class="fa fa-google "></i> Gestion SEO</a>
      <ul>
        <li><a href="<?php echo Url::adminlink("seo/seoconfig") ?>"><i class="fa fa-cog "></i> Configuracion</a></li>
        <li><a href="<?php echo Url::adminlink("seo/listadopaginas") ?>"><i class="fa fa-list-alt"></i> Titulos y Descripciones</a></li>
      </ul>
    </li>-->
    <!--<li class="subm"><a><i class="fa fa-envelope-o"></i> Gestion Email</a>
      <ul>
        <li><a href="<?php echo Url::adminlink("emails/emailsconfig") ?>"><i class="fa fa-cog"></i> Configuracion</a></li>
        <li><a href="<?php echo Url::adminlink("emails/listadoemails") ?>"><i class="fa fa-envelope-o"></i> Emails del Sistema</a></li>
      </ul>
    </li>-->
    <li class="hide_desktop"><a class="out" href="<?php echo Url::adminlink("", "controller=general&task=logout") ?>">Salir</a></li>
  </ul>
</div>
<script type="text/javascript">

    function PositionSubmenu(parentSubmenu)
    {
        var liparent = jQuery(parentSubmenu);
        var submenu = liparent.find('.subm').get(0);
        if (typeof submenu != "undefined")
        {
            var objSubmenu = jQuery(submenu);
            var ulparent = objSubmenu.parent().parent();//obtengo el ul contenedor                           
            objSubmenu.width(ulparent.width() - parseInt(objSubmenu.css('paddingLeft').replace('px', '')));
            var pos = ulparent.position().left - liparent.position().left;
            objSubmenu.css({left: pos});
        }
    }


    var isMobile = false;

    jQuery(document).ready(function() {

        jQuery('.subm').bind('click', function(e) {
            e.stopPropagation();
            if (jQuery(window).width() <= 768)
            {
                isMobile = true;
                var $this = jQuery(this);
                $this.find('ul:first').slideDown();
                $this.siblings().find('ul').slideUp().parent().removeClass('selected');
            }
            else
                isMobile = true;
        });

        jQuery('.menu li').on('hover', function() {
            if (!isMobile)
                PositionSubmenu(this);
        });

        jQuery('.btnshmenu').bind('click', function() {
            jQuery('.menu').slideToggle();
        });


    });

</script> 

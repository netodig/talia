<div class="w100p">
  <h1><i class="fa fa-home"></i> Panel principal</h1>
  <div class="panel">
    <h2> Usuarios </h2>
    <ul>
      <!--<li><a href="<?php echo Url::adminlink("perfiles/modulos/listado") ?>"><i class="fa fa-cog fa-3x"></i><br>
        Modulos</a></li>-->
      <li><a href="<?php echo Url::adminlink("perfiles/perfiles/listado") ?>"><i class="fa fa-user fa-3x"></i><br>
        Perfiles</a></li>
      <li><a href="<?php echo Url::adminlink("perfiles/usuarios/listado") ?>"><i class="fa fa-users fa-3x"></i><br>
        Usuarios</a></li>
    </ul>
  </div>
  
   <div class="panel">
    <h2>Categorias </h2>
    <ul>
   <li class="subm"><a href="<?php echo Url::adminlink("codificador/listado", "tipocod=1") ?>"><i class="fa fa-bookmark-o fa-3x"></i><br> Listado</a></li>
      <li><a href="<?php echo Url::adminlink("traduccion/idioma/listado") ?>"><i class="fa fa-plus-circle fa-3x"></i><br>
        Agregar nueva</a></li>
  
    </ul>
  </div>
  
  
  <div class="panel">
    <h2>Idiomas </h2>
    <ul>
    <!--  <li><a href="<?php echo Url::adminlink("traduccion/traduce/tablas") ?>"><i class="fa fa-cog fa-3x"></i><br>
        Configuración</a></li>-->
      <li><a href="<?php echo Url::adminlink("traduccion/idioma/listado") ?>"><i class="fa fa-language fa-3x"></i><br>
        Idiomas</a></li>
   <!--   <li><a href="<?php echo Url::adminlink("traduccion/traduce/traduce") ?>"><i class="fa fa-flag-checkered fa-3x"></i><br>
        Traducir</a></li>-->
    </ul>
  </div>
  <!--<div class="panel">
    <h2> SEO y posicionamiento </h2>
    <ul>
      <li><a href="<?php echo Url::adminlink("seo/seoconfig") ?>"><i class="fa fa-cog fa-3x"></i><br>
        Configuración</a></li>
      <li><a href="<?php echo Url::adminlink("seo/listadopaginas") ?>"><i class="fa fa-list-alt fa-3x"></i><br>
        Títulos y descripciones</a></li>
    </ul>
  </div>-->
  <!--<div class="panel">
    <h2> Emails </h2>
    <ul>
      <li><a href="<?php echo Url::adminlink("seo/seoconfig") ?>"><i class="fa fa-cog fa-3x"></i><br>
        Configuración</a></li>
      <li><a href="<?php echo Url::adminlink("seo/listadopaginas") ?>"><i class="fa fa-envelope-o fa-3x"></i><br>
        Emails del sistema</a></li>
    </ul>
  </div>-->
</div>

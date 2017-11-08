<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <title>CIRCULO ODONTOLOGICO CONCEPCION DEL URUGUAY</title>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />

    <?php use_stylesheet('jquery-ui-1.8.20.custom.css') ?>
    <?php use_stylesheet('menu.css') ?>
    <?php use_stylesheet('ui.jqgrid.css') ?>
    <?php use_stylesheet('jquery.ui.timepicker.css') ?>
    <?php use_stylesheet('jquery.tablescroll.css') ?>
    <?php use_stylesheet('superfish-verticalfish.css') ?>
    <?php use_stylesheet('superfish-vertical.css') ?>
    <?php use_stylesheet('superfish-navbar.css') ?>
    <?php use_stylesheet('ddaccordion.css') ?>
    <?php use_stylesheet('style.css') ?>
    <?php use_stylesheet('prettyCheckboxes.css') ?>

    <?php //use_stylesheet('styleodo.css') ?>
    <?php use_stylesheet('jquery-ui-1.8.17.custom.css') ?>
    <?php use_stylesheet('jquery.svg.css') ?>
    <?php use_stylesheet('odontograma.css') ?>

   
    <?php //use_javascript('webcam.js') ?>
    <?php use_javascript('hoverIntent.js') ?>
    <?php use_javascript('superfish.js') ?>
	<?php use_javascript('jquery.validator.js') ?>
    <?php use_javascript('grid.locale-es.js') ?>
    <?php use_javascript('jquery.jqGrid.min.js') ?>
    <?php use_javascript('tiny_mce/tiny_mce.js') ?>
    <?php use_javascript('jquery.ui.timepicker.js') ?>
    <?php use_javascript('jquery.tablescroll.js') ?>

    <?php use_javascript('jquery.jcarousel.js') ?>
    <?php use_javascript('DD_belatedPNG-min.js') ?>
    <?php use_javascript('functions.js') ?>
    <?php use_javascript('ddaccordion.js') ?>
    <?php use_javascript('prettyCheckboxes.js') ?>

    <?php use_javascript('jquery-1.7.min.js') ?>

    <?php use_javascript('plugins.js') ?>
    <?php use_javascript('jquery-ui-1.8.17.custom.min.js') ?>
    <?php use_javascript('jquery.tmpl.js') ?>
    <?php use_javascript('knockout-2.0.0.js') ?>
    <?php use_javascript('jquery.svg.min.js') ?>
    <?php use_javascript('jquery.svggraph.min.js') ?>
    <?php use_javascript('odontograma.js') ?>
    <?php use_javascript('modernizr-2.0.6.min.js') ?>
    <?php use_javascript('tratamientos.js') ?>

    
   

    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
</head>
<body>
<?php
	$autenticated =false;
	if ($sf_user->isAuthenticated()) {
	    $esalumno = false;
	    $autenticated =true;
	    $credencial = '';
		$arrCredenciales = array();
		foreach ($sf_user->getCredentials() as $credencial) {
			array_push($arrCredenciales, $credencial);
		}
		$sis=$sf_user->getGuardUser()->obtenerSistemas();
		$sf_user->setAttribute('idsede',$sf_user->getProfile()->getIdsede());
	}
?>

	<div class="shell">
		<!-- Header -->
		<div id="header">
			<div class="cl"></div>
			<!-- Logo -->
			<img alt="Smiley face" height="142" width="940" src="<?php echo $sf_request->getRelativeUrlRoot();?>/images/headerlogo2.png">

			<?php if ($autenticated){ ?>
			<p align="right"><?php echo '<b>Usuario:</b> '.$sf_user->getGuardUser()->getUsername().'&nbsp;&nbsp;'.link_to('>>', 'sf_guard_signout'); ; ?> </p>
    	<?php } else { ?>
            <div align="right">
			<form action="/login" name="login" id="formLogin" method="post">
				  <table border="0">
				    <tbody>
				    	<tr>
						  <th><label for="signin_username"><p align="right">Usuario</p></label></th>
						  <td><input type="text" name="signin[username]" id="signin_username" /></td>
						  <th><label for="signin_password"><p align="right">Contraseña</p></label></th>
						  <td><input type="password" name="signin[password]" id="signin_password" /></td>
						  <td><input type="submit" value="Ingresar"></td>
						</tr>
			</tbody>
			</table>
			</form>
			</div>

			<?php } ?>


			<!-- END Top Navigation -->
		</div>
		<!-- END Header -->
		<!-- Navigation -->
		<div id="navigation">
			<ul>
			    <li>
					<a title="Institucionales" href="#"><span class="sep-left"></span>Gestión<span class="sep-right"></span></a>
					<div class="dd">
						<ul>
							<li><a title="Inicio" href="<?php echo url_for('ingreso/index') ?>"><span class="sep-left"></span>Inicio</a></li>
							<?php if ($autenticated){ ?>
                                  <li><a title="Historia" href="<?php echo url_for('atenciones/index') ?>"><span class="sep-left"></span>Atenciones</a></li>

							<?php } ?>
						</ul>
					</div>
				</li>
				<li>
					<a title="Profesionales" href="<?php echo url_for('informes/profesionales') ?>"><span class="sep-left"></span>Profesionales<span class="sep-right"></span></a>
				</li>
				<li>
					<a title="Profesionales" href="<?php echo url_for('informes/obrassociales') ?>"><span class="sep-left"></span>Obras Sociales<span class="sep-right"></span></a>
				</li>
				<li>
					<a title="Institucionales" href="#"><span class="sep-left"></span>Institucionales<span class="sep-right"></span></a>
					<div class="dd">
						<ul>
							<li><a title="Autoridades" href="<?php echo url_for('informes/autoridades') ?>"><span class="sep-left"></span>Autoridades</a></li>
							<li><a title="Historia" href="<?php echo url_for('ingreso/historia') ?>"><span class="sep-left"></span>Historia</a></li>
							<li><a title="Saludent" href="<?php echo url_for('informes/saludent') ?>"><span class="sep-left"></span>Saludent</a></li>
							<?php if ($autenticated){ ?>
                                  <li><a title="Saludent" href="<?php echo url_for('informes/archivosprofesionales') ?>"><span class="sep-left"></span>Documentación</a></li>
							<?php } ?>
						</ul>
					</div>
				</li>
				<li>
					<a title="Contacto" href="#"><span class="sep-left"></span>Contacto<span class="sep-right"></span></a>
					<div class="dd">
						<ul>
							<li><a title="Ubicacion" href="<?php echo url_for('ingreso/ubicacion') ?>"><span class="sep-left"></span>Ubicación</a></li>
							<li><a title="Concacto" href="<?php echo url_for('contacto/new') ?>"><span class="sep-left"></span>Contacto</a></li>
						</ul>
					</div>
				</li>
			</ul>
			<div class="cl"></div>
		</div>
		<!-- END Navigation -->
		<!-- Main  -->
		<div id="main">
			<!-- Slider -->
			<!-- <div id="slider-holder">

			</div> -->
			<!-- END Slider -->

      <!-- Content -->
    <?php if ($autenticated && !$sf_user->getGuardUser()->getIsSuperAdmin()){ ?>
			<div id="content" style="width:930px" >
				 <?php echo $sf_content; ?>
			</div>
    <?php } else { ?>
      <div id="content">
				 <?php echo $sf_content; ?>
			</div>
    <?php } ?>
			<!-- ЕND Content  -->

			<!-- Sidebar -->
			<?php if ($autenticated && $sf_user->getGuardUser()->getIsSuperAdmin()){ ?>
					<div id="sidebar">
						<div class="box">
							<h2>Gestión General</h2>
							<ul>
							    <?php   if ($autenticated){
							                if ($sf_user->getGuardUser()->getIsSuperAdmin()) {
							    	            echo '<li>'.link_to('Usuarios', 'sf_guard_user').'</li>' ;
							    	        }
							    	    } ?>
								<?php echo '<li>'.link_to('Profesionales', 'personas/buscar').'</li>' ; ?>
								<?php echo '<li>'.link_to('Pacientes', 'pacientes/index').'</li>' ; ?>
								<?php echo '<li>'.link_to('Obras Sociales', 'obrassociales/index').'</li>' ; ?>
								<?php echo '<li>'.link_to('Autoridades', 'autoridades').'</li>' ; ?>
								<?php echo '<li>'.link_to('Entidades', 'cargoautoridades/index').'</li>' ; ?>
								<?php echo '<li>'.link_to('Gestión Tratamientos', 'tratamientos/index').'</li>' ; ?>
								<?php echo '<li>'.link_to('Gestión Atenciones', 'atenciones/index').'</li>' ; ?>
								<?php echo '<li>'.link_to('Gestión Contenido', 'noticia/index').'</li>' ; ?>
								<?php echo '<li>'.link_to('Gestión Contacto', 'contacto').'</li>' ; ?>
								<?php echo '<li>'.link_to('Gestión Saludent', 'practicas/index').'</li>' ; ?>
								<?php echo '<li>'.link_to('Archivos Profesionales', 'archivosprofesionales/index').'</li>' ; ?>
								<?php echo '<li>'.link_to('Banners del Menu', 'banners/index').'</li>' ; ?>
								<?php echo '<li>'.link_to('Salir', 'sf_guard_signout').'</li>' ; ?>
							</ul>
						</div>
					</div>
			<?php } else { ?>

               <?php

			         $banners = Doctrine_Core::getTable('Banners')
				      ->createQuery('a')
				      ->where('visible')
				      ->orderby(idorden)
				      ->execute();

   if (!$autenticated){ ?>
		<div id="sidebar">

			<div class="box" style="width=200px"><br></div>

      <?php foreach($banners as $banner){ ?>
					    <div class="box" style="background-color:#7dbf0d;width=200px">
								<p style="margin-left: 0em;text-align:center;color:#ffffff;font-weight:bold"><a target="_blank" style="text-align:left;color:#ffffff;font-weight:bold" href="<?php echo $banner->getUrl(); ?>"><?php echo $banner->getNombre(); ?></a></p>
			 			 </div>
            <?php if ($banner->getUrlsecundaria()=='') { ?>
                    <div class="box" style="width=200px">
                     <a target="_blank" href="<?php echo $banner->getUrl(); ?>">
                        <img alt="Smiley face" height="100" width="220"  src="<?php echo $sf_request->getRelativeUrlRoot();?>/banners/<?php echo $banner->getImagefile();?>">
                      </a>
                   </div>
           <?php  } else { ?>
                    <div class="box" onclick="window.open('<?php echo $banner->getUrl(); ?>')" style="width=200px">
                     <a target="_blank" onclick="window.open('<?php echo $banner->getUrlsecundaria(); ?>')">
                        <img alt="Smiley face" height="100" width="220"  src="<?php echo $sf_request->getRelativeUrlRoot();?>/banners/<?php echo $banner->getImagefile();?>">
                      </a>
                   </div>
          <?php  } ?>

            <br>
        <?php } ?>

                        <?php if ($autenticated && !$sf_user->getGuardUser()->getIsSuperAdmin()){ ?>
                        	<div class="box" style="background-color:#7dbf0d;width=200px">
								<p style="margin-left: 0em;text-align:center;color:#000000;font-weight:bold"><?php echo link_to('Salir', 'sf_guard_signout') ?></p>
						              </div>
                        <br>
                        <?php } ?>

		</div>

			<?php } // end if (!$autenticated){
      }  // end <?php if ($autenticated && $sf_user->getGuardUser()->getIsSuperAdmin()){
      ?>
			<!-- END Sidebar -->
			<div class="cl"></div>
			<!-- Feartured Products -->
			<div class="products featured">
			</div>
			<!-- END Featured Products -->
			<!-- Footer  -->
			<div id="footer">
				<!--<div id="footer-top"></div>
				<div id="footer-middle">
					<div class="col styles">
						<h3>Quienes somos?</h3>
						<ul>
							<li><a title="Acerca de" href="#"><span class="bullet"></span>Misión</a></li>
						</ul>
					</div>
					<div class="col info">
						<h3>Información</h3>
						<ul>
							<li><a title="Políticas de Privacidad" href="#"><span class="bullet"></span>Políticas Privacidad</a></li>
						</ul>
					</div>
					<div class="col newsletter">
						<h3>Newsletter</h3>
						 <form name="registrarse" method="post" action="<?php echo url_for('ingreso/index' ) ?>">
							<div class="field-holder"><input type="text" class="field" value="Ingrese su Email" title="Ingrese su Email" /></div>
							<div class="cl"></div>
							<input type="checkbox" name="check-box" value="" id="check-box" />
							<label for="check-box">Confirmo que deseo recibir correspondencia. </label>
							<input type="submit" value="Registrarse" class="submit-button" />
						</form>
					</div>
					<div class="cl"></div>
				</div> -->
				<div id="footer-bottom">
					<p style="color:#7dbf0d;font-size:12px;">&copy;Copyright&nbsp&nbsp&nbsp<b>Círculo Odontológico.</b></p>
				</div>
			</div>
			<!-- END Footer -->
		</div>
		<!-- END Main -->
	</div>
</body>
</html>

<!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!-- Consider adding an manifest.appcache: h5bp.com/d/Offline -->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8">

  <!-- Use the .htaccess and remove these lines to avoid edge case issues.
       More info: h5bp.com/b/378 -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

  <title></title>
  <meta name="description" content="">
  <meta name="author" content="">

  <!-- Mobile viewport optimized: j.mp/bplateviewport -->
  <meta name="viewport" content="width=device-width,initial-scale=1">

  <!-- Place favicon.ico and apple-touch-icon.png in the root directory: mathiasbynens.be/notes/touch-icons -->

  <!-- CSS: implied media=all -->
  <!-- CSS concatenated and minified via ant build script-->
 
  <!-- end CSS-->

  <!-- More ideas for your <head> here: h5bp.com/d/head-Tips -->

  <!-- All JavaScript at the bottom, except for Modernizr / Respond.
       Modernizr enables HTML5 elements & feature detects; Respond is a polyfill for min/max-width CSS3 Media Queries
       For optimal performance, use a custom Modernizr build: www.modernizr.com/download/ -->
</head>

<body>
  
  <form action="<?php echo url_for('atenciones/verhistorialfichas') ?>" method="post">
  <input type="hidden" name="selectedtab" id="selectedtab" value="<?php echo $selectedtab ?>">
  <input type="hidden" name="matricula" id="matricula" value="<?php echo $matricula ?>">
  <input type="hidden" name="idpaciente" id="idpaciente" value="<?php echo $idpaciente ?>">
  <input type="hidden" name="jsonatenciones" id="jsonatenciones" value="<?php echo $jsonatenciones ?>">

  <div id="container">
    <header>
      <h1>Clip Soluciones<h1>
    </header>
    <div id="main" role="main">      
      <div id="tratamiento">
        <h2>Tratamiento</h2>
        <select 
          data-bind=" options: tratamientosPosibles, 
                      value: tratamientoSeleccionado, 
                      optionsText: function(item){ return item.nombre; },
                      optionsCaption: 'Seleccione un tratamiento...'">
        </select>
        <ul data-bind="foreach: tratamientosAplicados">
          <li>
            P<span data-bind="text: diente.id"></span><span data-bind="text: cara"></span>
            -            
            <span data-bind="text: tratamiento.nombre"></span>
            | 
            <a href="#" data-bind="click: $parent.quitarTratamiento">Eliminar</a>
          </li>
        </ul>
      </div>
      <br>
      <div id="odontograma-wrapper">
        <h2>Odontograma</h2>
        <div id="odontograma"></div>
      </div>      
    </div>
    <footer>
      
    </footer>
  </div> <!--! end of #container -->  

  <!-- scripts concatenated and minified via ant build script-->

  <!-- end scripts-->



  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7 ]>
    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->

  </form>
  
</body>
</html>
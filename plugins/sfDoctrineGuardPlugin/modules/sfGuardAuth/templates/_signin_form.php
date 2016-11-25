<?php use_helper('I18N') ?>
<script>
$(document).ready(function(){
    $('#signin_password').keypress(function(e) {
        if(e.which == 13) {
            jQuery(this).blur();
            $('#formLogin').submit(); 
        }
    });             
});
</script>
      <style type="text/css">
         input { width: 140px; }
      </style>
<table border="0" width="100%">      
   <tr>
   <td width="50%"><img src="<?php echo $sf_request->getRelativeUrlRoot();?>/images/logo-sao.png" border="0"></td>
    <td width="50%"><p>Ingrese sus credenciales de acceso</p></td>
   <td width="50%"> 
	<!-- <form action="<?php echo url_for('@sf_guard_signin') ?>" name="login" id="formLogin" method="post">
	  <table border="0">
	    <tbody>	  
	    	<?php echo $form ?>  	
	    </tbody>
	    <tfoot>
	      <tr>
	        <td> 
	          &nbsp;
	        </td> 
	        <td align="center" >
	        <a href="javascript:document.login.submit()">
				<img src="<?php echo $sf_request->getRelativeUrlRoot();?>/images/botonIngresar.jpg" border="0" alt="Ingresar">
			</a> 
	        </td> 
	        </tr>
	          <?php $routes = $sf_context->getRouting()->getRoutes() ?>
	          <?php if (isset($routes['sf_guard_forgot_password'])): ?>
	            <tr>
	            <td colspan="2" >
	            <a href="<?php echo url_for('@sf_guard_forgot_password') ?>"><?php echo __('¿Olvidaste tu contraseña?', null, 'sf_guard') ?></a>
	            </td> 
	            </tr>  
	          <?php endif; ?>
	
	          <?php if (isset($routes['sf_guard_register'])): ?>
	            <tr>
	            <td colspan="2" >
	            &nbsp; <a href="<?php echo url_for('@sf_guard_register') ?>"><?php echo __('Buscas registrarte?', null, 'sf_guard') ?></a>
	            </td> 
	            </tr>  
	          <?php endif; ?>
	    </tfoot>
	  </table>
	</form>
	-->
	</td>
	</tr>
</table>	
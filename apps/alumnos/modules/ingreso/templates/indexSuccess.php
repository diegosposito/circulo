 <?php foreach ($noticiass as $noticias){ ?>
 	<div class="post">
						<h2><?php echo $noticias->getTitulo(); ?></h2>
						<p><?php echo html_entity_decode($noticias->getDescripcion()); ?></p>
						
	</div>
<?php } ?>
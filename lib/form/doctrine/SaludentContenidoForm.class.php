<?php

/**
 * SaludentContenido form.
 *
 * @package    sig
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class SaludentContenidoForm extends BaseSaludentContenidoForm
{
  public function configure()
  {
  	
    unset( $this['created_at'], $this['updated_at'], $this['created_by'], $this['updated_by'] );

  	$this->widgetSchema['descripcion'] = new sfWidgetFormTextareaTinyMCE(
		array(
			'config' => sfConfig::get('app_tiny_mce_simple')
		)
	);
  	
	$this->widgetSchema->setLabel('descripcion', '<p align="left">Contenido:</p>');
	
  }
}

<?php

/**
 * PlanesObras form.
 *
 * @package    sig
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class PlanesObrasForm extends BasePlanesObrasForm
{
  public function configure()
  { 

    unset( $this['created_at'], $this['updated_at'], $this['created_by'], $this['updated_by'] );
    $arrObras = array();

    $oss = Doctrine_Core::getTable('ObrasSociales')->findAll();
  	foreach ($oss as $os) {
  			$arrObras[$os->getIdObrasocial()] = $os->getAbreviada();
  	}
  	
  	asort($arrObras);
	
	// Se define el esquema del form
  	$this->widgetSchema['idobrasocial'] = new sfWidgetFormSelect(array('choices' => $arrObras));
	

	$this->widgetSchema->setLabel('idobrasocial', '<p align="left">Obra Social:</p>');
 	
  }
}

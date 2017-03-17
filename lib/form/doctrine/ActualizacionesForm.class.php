<?php

/**
 * Actualizaciones form.
 *
 * @package    sig
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ActualizacionesForm extends BaseActualizacionesForm
{
  public function configure()
  {

  	   unset( $this['created_at'], $this['updated_at'], $this['created_by'], $this['updated_by'] );
     
      // Se define los labels
	  $this->widgetSchema->setLabel('nombre', '<p align="left">Detalle del Archivo:</p>');
 	  $this->widgetSchema->setLabel('imagefile', '<p align="left">Imágen:</p>');
       $this->widgetSchema->setLabel('idorden', '<p align="left">Orden:</p>');

     
     // $arregloCategorias = array('1' => 'General', '2' => 'Para Profesional');

      $this->widgetSchema['imagefile'] = new sfWidgetFormInputFile(array(
                                               'label' => 'Archivo',
                                             ));

     
      $this->widgetSchema['nombre'] = new sfWidgetFormInputText(array(), array("style"=>'width: 200px;'));
    
     
     
      $this->widgetSchema->setLabel('imagefile', '<p align="left">Archivo:</p>');
        $this->widgetSchema->setLabel('nombre', '<p align="left">Detalle del Archivo:</p>');
        $this->widgetSchema->setLabel('idorden', '<p align="left">Orden:</p>');
    
      
      $this->setValidators(array(
        'nombre' => new sfValidatorString(array('required' => true), array('required' => 'El nombre es obligatorio.')),
        'idorden'    => new sfValidatorInteger(array('required' => false)),
        'imagefile' => new sfValidatorFile(array('required' => false)),
        ));

      $this->validatorSchema->setOption('allow_extra_fields',true); 
  }
}

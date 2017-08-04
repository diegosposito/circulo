<?php

/**
 * Actualizacionesaten form.
 *
 * @package    sig
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ActualizacionesatencerrForm extends BaseActualizacionesatenForm
{
  public function configure()
  {
  	    unset( $this['created_at'], $this['updated_at'], $this['created_by'], $this['updated_by'], $this['nombre'], $this['idorden'] );

      // Se define los labels
	  $this->widgetSchema->setLabel('imagefile', '<p align="left">Imágen:</p>');


     // $arregloCategorias = array('1' => 'General', '2' => 'Para Profesional');

      $this->widgetSchema['imagefile'] = new sfWidgetFormInputFile(array(
                                               'label' => 'Archivo',
                                             ));


      $this->widgetSchema->setLabel('imagefile', '<p align="left">Archivo:</p>');


      $this->setValidators(array(
        'imagefile' => new sfValidatorFile(array('required' => false)),
        ));

      $this->validatorSchema->setOption('allow_extra_fields',true);
  }
}

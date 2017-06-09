<?php

/**
 * Banners form.
 *
 * @package    sig
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class BannersForm extends BaseBannersForm
{
  public function configure()
  {
  	   unset( $this['created_at'], $this['updated_at'], $this['created_by'], $this['updated_by'] );

      // Se define los labels
	  $this->widgetSchema->setLabel('nombre', '<p align="left">Nombre de Archivo:</p>');
 	  $this->widgetSchema->setLabel('visible', '<p align="left">Visible:</p>');
 	  $this->widgetSchema->setLabel('url', '<p align="left">URL:</p>');
    $this->widgetSchema->setLabel('coordenada', '<p align="left">Coordenada:</p>');
    $this->widgetSchema->setLabel('urlsecundaria', '<p align="left">URL Secundaria:</p>');
    $this->widgetSchema->setLabel('coordenadasec', '<p align="left">Coord Secundaria:</p>');
      $this->widgetSchema->setLabel('imagefile', '<p align="left">Imágen:</p>');
       $this->widgetSchema->setLabel('idorden', '<p align="left">Orden:</p>');


     // $arregloCategorias = array('1' => 'General', '2' => 'Para Profesional');

      $this->widgetSchema['imagefile'] = new sfWidgetFormInputFile(array(
                                               'label' => 'Archivo',
                                             ));


      $this->widgetSchema['nombre'] = new sfWidgetFormInputText(array(), array("style"=>'width: 200px;'));
      $this->widgetSchema['url'] = new sfWidgetFormInputText(array(), array("style"=>'width: 400px;'));
      $this->widgetSchema['coordenada'] = new sfWidgetFormInputText(array(), array("style"=>'width: 400px;'));
      $this->widgetSchema['urlsecundaria'] = new sfWidgetFormInputText(array(), array("style"=>'width: 400px;'));
      $this->widgetSchema['coordenadasec'] = new sfWidgetFormInputText(array(), array("style"=>'width: 400px;'));

      $this->widgetSchema->setLabel('imagefile', '<p align="left">Archivo:</p>');
       $this->widgetSchema->setLabel('nombre', '<p align="left">Nombre de Archivo:</p>');
        $this->widgetSchema->setLabel('idorden', '<p align="left">Orden:</p>');
        $this->widgetSchema->setLabel('url', '<p align="left">URL:</p>');
        $this->widgetSchema->setLabel('coordenada', '<p align="left">Coordenada:</p>');
        $this->widgetSchema->setLabel('urlsecundaria', '<p align="left">URL Secundaria:</p>');
        $this->widgetSchema->setLabel('coordenadasec', '<p align="left">Coord Secundaria:</p>');



      $this->setValidators(array(
        'nombre' => new sfValidatorString(array('required' => true), array('required' => 'El nombre es obligatorio.')),
        'idorden'    => new sfValidatorInteger(array('required' => false)),
        'imagefile' => new sfValidatorFile(array('required' => false)),
        'url' => new sfValidatorString(array('required' => false, )),
        ));

      $this->validatorSchema->setOption('allow_extra_fields',true);
  }
}

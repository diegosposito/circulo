<?php

/**
 * ObrasSociales form.
 *
 * @package    sig
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ObrasSocialesForm extends BaseObrasSocialesForm
{
  public function configure()
  {

  	    unset( $this['created_at'], $this['updated_at'], $this['created_by'], $this['updated_by'] );
     
      // Se define los labels
	    $this->widgetSchema->setLabel('denominacion', '<p align="left">Obra Social:</p>');
 	    $this->widgetSchema->setLabel('abreviada', '<p align="left">Nombre Abreviado:</p>');
      $this->widgetSchema->setLabel('fechaaranceltexto', '<p align="left">Aranceles / Texto:</p>');
 	    $this->widgetSchema->setLabel('fechaultimoperiodotexto', '<p align="left">Ultimo Período / Texto:</p>');
      $this->widgetSchema->setLabel('ninterno', '<p align="left">Nro.Interno:</p>');
      $this->widgetSchema->setLabel('general', '<p align="left">General:</p>');
      $this->widgetSchema->setLabel('protesis', '<p align="left">Prótesis:</p>');
      $this->widgetSchema->setLabel('ortodoncia', '<p align="left">Ortodoncia:</p>');
      $this->widgetSchema->setLabel('implantes', '<p align="left">Implantes:</p>');
      $this->widgetSchema->setLabel('formato', '<p align="left">Formato:</p>');
      


 	    
      $this->widgetSchema['fechaarancel'] = new sfWidgetFormJQueryDate(array(
    'config' => '{}',
    'image'=> sfContext::getInstance()->getRequest()->getRelativeUrlRoot().'/images/calendar.gif',
    'culture' => substr(sfContext::getInstance()->getUser()->getCulture(), 0, 2),
    'config' => "{firstDay: 1, dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'], 
      monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre']}", 
            'date_widget' => new sfWidgetFormDate(array('format' => '%day%/%month%/%year%')) 
        ));

        $this->widgetSchema['fechaultimoperiodo'] = new sfWidgetFormJQueryDate(array(
    'config' => '{}',
    'image'=> sfContext::getInstance()->getRequest()->getRelativeUrlRoot().'/images/calendar.gif',
    'culture' => substr(sfContext::getInstance()->getUser()->getCulture(), 0, 2),
    'config' => "{firstDay: 1, dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'], 
      monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre']}", 
            'date_widget' => new sfWidgetFormDate(array('format' => '%day%/%month%/%year%')) 
        ));

      $this->widgetSchema->setLabel('fechaarancel', '<p align="left">Fecha Arancel:</p>');
      $this->widgetSchema->setLabel('fechaultimoperiodo', '<p align="left">Ultimo período abonado:</p>');

      $arregloEstados = array('1' => 'Habilitada', '0' => 'No Habilitada');
    
      $this->widgetSchema['estado'] = new sfWidgetFormSelect(array('label' => '<p align="left"><b>Estado:</b></p>', 'choices' => $arregloEstados));
  

      $this->setValidators(array(
        'denominacion' => new sfValidatorString(array('required' => true), array('required' => 'El nombre de la O.Social es obligatorio.')),
        'abreviada' => new sfValidatorString(array('max_length' => 200, 'required' => false)),
        'estado'    => new sfValidatorInteger(array('required' => false)),
        'fechaarancel' => new sfValidatorString(array('max_length' => 200, 'required' => false)),
        'fechaultimoperiodo' => new sfValidatorString(array('max_length' => 200, 'required' => false)),
        'fechaaranceltexto' => new sfValidatorString(array('max_length' => 200, 'required' => false)),
        'fechaultimoperiodotexto' => new sfValidatorString(array('max_length' => 200, 'required' => false)),
        'formato' => new sfValidatorString(array('max_length' => 200, 'required' => false)),
        ));

      $this->validatorSchema->setOption('allow_extra_fields',true); 

  }
}

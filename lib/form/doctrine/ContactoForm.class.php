<?php

/**
 * Contacto form.
 *
 * @package    sig
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ContactoForm extends BaseContactoForm
{
  public function configure()
  {

  	     unset($this['created_at'], $this['updated_at'], $this['created_by'], $this['updated_by']);
     
      // Se define los labels
  	    $this->widgetSchema->setLabel('nombre', '<p align="left">Nombres *</p>');
  	    $this->widgetSchema->setLabel('apellido', '<p align="left">Apellido *</p>');
  	    $this->widgetSchema->setLabel('telefono', '<p align="left">Teléfono *</p>');
  	    $this->widgetSchema->setLabel('email', '<p align="left">Email *</p>');
  	    $this->widgetSchema->setLabel('comentario', '<p align="left">Comentario *</p>');
	    $this->widgetSchema->setLabel('empresa', '<p align="left">Empresa o Profesión</p>');
	  
      $this->setValidators(array(
        'apellido' => new sfValidatorString(array('required' => true), array('required' => 'El apellido es obligatorio.')),
        'nombre' => new sfValidatorString(array('required' => true), array('required' => 'El nombre es obligatorio.')),
        'telefono' => new sfValidatorString(array('required' => true), array('required' => 'El teléfono es obligatorio.')),
        'email' => new sfValidatorString(array('required' => true), array('required' => 'El email es obligatorio.')),
        'comentario' => new sfValidatorString(array('required' => true), array('required' => 'El comentario es obligatorio.')),
        'empresa' => new sfValidatorString(array('max_length' => 200, 'required' => false)),
        'direccion' => new sfValidatorString(array('max_length' => 200, 'required' => false)),
        'localidad' => new sfValidatorString(array('max_length' => 200, 'required' => false)),
        'pais' => new sfValidatorString(array('max_length' => 200, 'required' => false)),
        ));

        $this->validatorSchema->setOption('allow_extra_fields',true); 
  }
}

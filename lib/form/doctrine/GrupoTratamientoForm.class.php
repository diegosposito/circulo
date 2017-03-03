<?php

/**
 * GrupoTratamiento form.
 *
 * @package    sig
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class GrupoTratamientoForm extends BaseGrupoTratamientoForm
{
  public function configure()
  {
  	    unset( $this['created_at'], $this['updated_at'], $this['created_by'], $this['updated_by'] );
        $this->widgetSchema->setLabel('nombre', '<p align="left">Descripción:</p>');

        $this->setValidators(array(
        'nombre' => new sfValidatorString(array('required' => true), array('required' => 'El nombre del nuevo grupo es obligatorio.')),
        'abreviacion' => new sfValidatorString(array('required' => false)),
        'abreviacion' => new sfValidatorString(array('required' => false)),
        'activo'      => new sfValidatorBoolean(array('required' => false)),
        ));

        $this->widgetSchema->setLabel('nombre', '<p align="left">Descripción:</p>');

        $this->widgetSchema->setLabel('abreviacion', '<p align="left">Abreviación:</p>');

        $this->widgetSchema->setLabel('activo', '<p align="left">Activo:</p>');

        $this->validatorSchema->setOption('allow_extra_fields',true); 
  }
}

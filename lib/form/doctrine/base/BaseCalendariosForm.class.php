<?php

/**
 * Calendarios form base class.
 *
 * @method Calendarios getObject() Returns the current form's model object
 *
 * @package    sig
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseCalendariosForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'idcalendario' => new sfWidgetFormInputHidden(),
      'idfacultad'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Facultades'), 'add_empty' => false)),
      'idsede'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Sedes'), 'add_empty' => false)),
      'descripcion'  => new sfWidgetFormInputText(),
      'anio'         => new sfWidgetFormInputText(),
      'resolucion'   => new sfWidgetFormInputText(),
      'activo'       => new sfWidgetFormInputCheckbox(),
      'created_at'   => new sfWidgetFormDateTime(),
      'updated_at'   => new sfWidgetFormDateTime(),
      'created_by'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CreatedBy'), 'add_empty' => true)),
      'updated_by'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UpdatedBy'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'idcalendario' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('idcalendario')), 'empty_value' => $this->getObject()->get('idcalendario'), 'required' => false)),
      'idfacultad'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Facultades'))),
      'idsede'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Sedes'))),
      'descripcion'  => new sfValidatorString(array('max_length' => 255)),
      'anio'         => new sfValidatorInteger(array('required' => false)),
      'resolucion'   => new sfValidatorString(array('max_length' => 255)),
      'activo'       => new sfValidatorBoolean(array('required' => false)),
      'created_at'   => new sfValidatorDateTime(),
      'updated_at'   => new sfValidatorDateTime(),
      'created_by'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CreatedBy'), 'required' => false)),
      'updated_by'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UpdatedBy'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('calendarios[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Calendarios';
  }

}

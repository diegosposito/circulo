<?php

/**
 * TiposTitulos form base class.
 *
 * @method TiposTitulos getObject() Returns the current form's model object
 *
 * @package    sig
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseTiposTitulosForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'idtipotitulo'       => new sfWidgetFormInputHidden(),
      'nombre'             => new sfWidgetFormInputText(),
      'descripcion'        => new sfWidgetFormInputText(),
      'tiempotrabajofinal' => new sfWidgetFormInputText(),
      'created_at'         => new sfWidgetFormDateTime(),
      'updated_at'         => new sfWidgetFormDateTime(),
      'created_by'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CreatedBy'), 'add_empty' => true)),
      'updated_by'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UpdatedBy'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'idtipotitulo'       => new sfValidatorChoice(array('choices' => array($this->getObject()->get('idtipotitulo')), 'empty_value' => $this->getObject()->get('idtipotitulo'), 'required' => false)),
      'nombre'             => new sfValidatorString(array('max_length' => 40, 'required' => false)),
      'descripcion'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'tiempotrabajofinal' => new sfValidatorInteger(array('required' => false)),
      'created_at'         => new sfValidatorDateTime(),
      'updated_at'         => new sfValidatorDateTime(),
      'created_by'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CreatedBy'), 'required' => false)),
      'updated_by'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UpdatedBy'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('tipos_titulos[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'TiposTitulos';
  }

}

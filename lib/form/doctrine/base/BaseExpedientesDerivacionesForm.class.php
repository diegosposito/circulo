<?php

/**
 * ExpedientesDerivaciones form base class.
 *
 * @method ExpedientesDerivaciones getObject() Returns the current form's model object
 *
 * @package    sig
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseExpedientesDerivacionesForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'idderivacion'  => new sfWidgetFormInputHidden(),
      'idexpediente'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ExpedientesEgresados'), 'add_empty' => false)),
      'idareaorigen'  => new sfWidgetFormInputText(),
      'idareadestino' => new sfWidgetFormInputText(),
      'observaciones' => new sfWidgetFormTextarea(),
      'activo'        => new sfWidgetFormInputCheckbox(),
      'leido'         => new sfWidgetFormInputCheckbox(),
      'created_at'    => new sfWidgetFormDateTime(),
      'updated_at'    => new sfWidgetFormDateTime(),
      'created_by'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CreatedBy'), 'add_empty' => true)),
      'updated_by'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UpdatedBy'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'idderivacion'  => new sfValidatorChoice(array('choices' => array($this->getObject()->get('idderivacion')), 'empty_value' => $this->getObject()->get('idderivacion'), 'required' => false)),
      'idexpediente'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ExpedientesEgresados'))),
      'idareaorigen'  => new sfValidatorInteger(),
      'idareadestino' => new sfValidatorInteger(),
      'observaciones' => new sfValidatorString(array('max_length' => 2000)),
      'activo'        => new sfValidatorBoolean(array('required' => false)),
      'leido'         => new sfValidatorBoolean(array('required' => false)),
      'created_at'    => new sfValidatorDateTime(),
      'updated_at'    => new sfValidatorDateTime(),
      'created_by'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CreatedBy'), 'required' => false)),
      'updated_by'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UpdatedBy'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('expedientes_derivaciones[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ExpedientesDerivaciones';
  }

}

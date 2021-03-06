<?php

/**
 * EquivalenciasAlumnos filter form base class.
 *
 * @package    sig
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseEquivalenciasAlumnosFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'idalumno'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Alumnos'), 'add_empty' => true)),
      'fecha'             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'fecharesolucion'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'nroresolucion'     => new sfWidgetFormFilterInput(),
      'observaciones'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'cantidadprogramas' => new sfWidgetFormFilterInput(),
      'nrorecibo1'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'nrorecibo2'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'created_at'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'created_by'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CreatedBy'), 'add_empty' => true)),
      'updated_by'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UpdatedBy'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'idalumno'          => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Alumnos'), 'column' => 'idalumno')),
      'fecha'             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'fecharesolucion'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'nroresolucion'     => new sfValidatorPass(array('required' => false)),
      'observaciones'     => new sfValidatorPass(array('required' => false)),
      'cantidadprogramas' => new sfValidatorPass(array('required' => false)),
      'nrorecibo1'        => new sfValidatorPass(array('required' => false)),
      'nrorecibo2'        => new sfValidatorPass(array('required' => false)),
      'created_at'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'created_by'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('CreatedBy'), 'column' => 'id')),
      'updated_by'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('UpdatedBy'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('equivalencias_alumnos_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'EquivalenciasAlumnos';
  }

  public function getFields()
  {
    return array(
      'idequivalencia'    => 'Number',
      'idalumno'          => 'ForeignKey',
      'fecha'             => 'Date',
      'fecharesolucion'   => 'Date',
      'nroresolucion'     => 'Text',
      'observaciones'     => 'Text',
      'cantidadprogramas' => 'Text',
      'nrorecibo1'        => 'Text',
      'nrorecibo2'        => 'Text',
      'created_at'        => 'Date',
      'updated_at'        => 'Date',
      'created_by'        => 'ForeignKey',
      'updated_by'        => 'ForeignKey',
    );
  }
}

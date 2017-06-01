<?php

/**
 * Tratamientos form.
 *
 * @package    sig
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class TratamientosForm extends BaseTratamientosForm
{
  public function configure()
  {

  	    unset( $this['created_at'], $this['updated_at'], $this['created_by'], $this['updated_by'] );

  	// Se define los labels
	$this->widgetSchema->setLabel('nombre', '<p align="left">Tratamiento:</p>');
 	$this->widgetSchema->setLabel('abreviacion', '<p align="left">Abreviación:</p>');
    $this->widgetSchema->setLabel('idobrasocial', '<p align="left">Obra Social:</p>');
 	$this->widgetSchema->setLabel('idontologia', '<p align="left">Odontología:</p>');
 	$this->widgetSchema->setLabel('idgrupotratamiento', '<p align="left">Código Común:</p>');
    $this->widgetSchema->setLabel('garantia', '<p align="left">Garantía:</p>');
    $this->widgetSchema->setLabel('importe', '<p align="left">Importe:</p>');
    $this->widgetSchema->setLabel('coseguro', '<p align="left">Coseguro:</p>');
    $this->widgetSchema->setLabel('bono', '<p align="left">Bono:</p>');
    $this->widgetSchema->setLabel('importeos', '<p align="left">Importe O. Social:</p>');
    $this->widgetSchema->setLabel('idautorizacion', '<p align="left">Autorización:</p>');
    $this->widgetSchema->setLabel('visible', '<p align="left">Visible:</p>');
    $this->widgetSchema->setLabel('descripcion', '<p align="left">Descripción:</p>');
 	$this->widgetSchema->setLabel('normas', '<p align="left">Normas de Trabajo:</p>');
 	$this->widgetSchema->setLabel('activo', '<p align="left">Activo?:</p>');
  $this->widgetSchema->setLabel('idplan', '<p align="left">Plan:</p>');

    $oss = Doctrine_Core::getTable('ObrasSociales')->obtenerTodas();
    foreach($oss as $os){
        $arregloOS[$os->getIdObrasocial()] = $os->getAbreviada();
    }

    $this->widgetSchema['idobrasocial'] = new sfWidgetFormSelect(array('choices' => $arregloOS));
    $this->widgetSchema->setLabel('idobrasocial', '<p align="left">Obra Social:</p>');

    $oss = Doctrine_Core::getTable('GrupoTratamiento')->obtenerTodos();
    foreach($oss as $os){
        $arregloGT[$os->getId()] = $os->getNombre()."(".$os->getAbreviacion().")";
    }

    $this->widgetSchema['idgrupotratamiento'] = new sfWidgetFormSelect(array('choices' => $arregloGT));
    $this->widgetSchema->setLabel('idgrupotratamiento', '<p align="left">Grupo Tratamiento:</p>');


    // arreglos estaticos
    $arregloAutorizacion = array('1' => 'No Autoriza', '2' => 'Autorización Previa','3' => 'Con Presentación de Orden', '4' => 'Con Bono de COCU');
    $arregloVisible = array('1' => 'Si', '2' => 'No');
    $arregloOdontologia = array('1' => 'General', '2' => 'Prótesis','3' => 'Implante', '4' => 'Ortodoncia');

    $this->widgetSchema['idautorizacion'] = new sfWidgetFormSelect(array('choices' => $arregloAutorizacion));
    $this->widgetSchema->setLabel('idautorizacion', '<p align="left">Autorización:</p>');

    $this->widgetSchema['visible'] = new sfWidgetFormSelect(array('choices' => $arregloVisible));
    $this->widgetSchema->setLabel('visible', '<p align="left">Visible:</p>');

    $this->widgetSchema['idontologia'] = new sfWidgetFormSelect(array('choices' => $arregloOdontologia));
    $this->widgetSchema->setLabel('idontologia', '<p align="left">Odontología:</p>');

    $this->widgetSchema['nombre'] = new sfWidgetFormInputText(array(), array("style"=>'width: 250px;'));
    $this->widgetSchema->setLabel('nombre', '<p align="left">Tratamiento:</p>');

    $this->setValidators(array(
      'id'                 => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'nombre' => new sfValidatorString(array('required' => true), array('required' => 'El tratamiento es obligatorio.')),
      'abreviacion'        => new sfValidatorString(array('max_length' => 200, 'required' => false)),
      'idgrupotratamiento'  => new sfValidatorInteger(array('required' => false)),
      'idobrasocial'        => new sfValidatorInteger(array('required' => false)),
      'idplan'        => new sfValidatorInteger(array('required' => false)),
      'idontologia'        => new sfValidatorInteger(array('required' => false)),
      'garantia'           => new sfValidatorInteger(array('required' => false)),
      'importe'            => new sfValidatorNumber(array('required' => false)),
      'coseguro'           => new sfValidatorNumber(array('required' => false)),
      'bono'               => new sfValidatorNumber(array('required' => false)),
      'importeos'          => new sfValidatorNumber(array('required' => false)),
      'idautorizacion'     => new sfValidatorInteger(array('required' => false)),
      'visible'            => new sfValidatorInteger(array('required' => false)),
      'descripcion'        => new sfValidatorString(array('max_length' => 400, 'required' => false)),
      'normas'             => new sfValidatorString(array('max_length' => 2000, 'required' => false)),
      'activo'             => new sfValidatorBoolean(array('required' => false)),
    ));

    $this->validatorSchema->setOption('allow_extra_fields',true);


  }
}

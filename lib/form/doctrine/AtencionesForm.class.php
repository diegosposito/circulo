<?php

/**
 * Atenciones form.
 *
 * @package    sig
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class AtencionesForm extends BaseAtencionesForm
{
  public function configure()
  {

  	unset( $this['created_at'], $this['updated_at'], $this['created_by'], $this['updated_by'], $this['tratamiento'] );

  	$arr_tratamientos = array();

  	// Se define los labels
	$this->widgetSchema->setLabel('nrodoc', '<p align="left">Paciente:</p>');
 	$this->widgetSchema->setLabel('mes', '<p align="left">Mes:</p>');
    $this->widgetSchema->setLabel('anio', '<p align="left">Año:</p>');
 	$this->widgetSchema->setLabel('idobrasocial', '<p align="left">Obra Social:</p>');
    $this->widgetSchema->setLabel('matricula', '<p align="left">Matrícula:</p>');
    $this->widgetSchema->setLabel('pieza', '<p align="left">Pieza:</p>');
    $this->widgetSchema->setLabel('fecha', '<p align="left">Fecha:</p>');
    $this->widgetSchema->setLabel('caras', '<p align="left">Caras:</p>');
    $this->widgetSchema->setLabel('importe', '<p align="left">Importe:</p>');
    $this->widgetSchema->setLabel('coseguro', '<p align="left">Coseguro:</p>');
    $this->widgetSchema->setLabel('bono', '<p align="left">Bono:</p>');
    $this->widgetSchema->setLabel('importeos', '<p align="left">Importe O. Social:</p>');

    $oss = Doctrine_Core::getTable('ObrasSociales')->obtenerTodas();
    foreach($oss as $os){
        $arregloOS[$os->getIdObrasocial()] = $os->getAbreviada();
    }

    $arregloAnio = array();

    $this->widgetSchema['idobrasocial'] = new sfWidgetFormSelect(array('choices' => $arregloOS));
    $this->widgetSchema->setLabel('idobrasocial', '<p align="left">Obra Social:</p>');
    $this->widgetSchema['idtratamiento'] = new sfWidgetFormSelect(array('choices' => $arr_tratamientos));
    $this->widgetSchema->setLabel('idtratamiento', '<p align="left">Tratamiento:</p>');

    $arregloMeses = array('1' => 'Enero', '2' => 'Febrero','3' => 'Marzo', '4' => 'Abril','5' => 'Mayo', '6' => 'Junio','7' => 'Julio', '8' => 'Agosto','9' => 'Setiembre', '10' => 'Octubre','11' => 'Noviembre', '12' => 'Diciembre');
    $this->widgetSchema['mes'] = new sfWidgetFormSelect(array('choices' => $arregloMeses));
    $this->widgetSchema->setLabel('mes', '<p align="left">Mes:</p>');

    for ($anio = date("Y"); $anio > date("Y")-10; $anio=$anio-1) {
        $arregloAnio[$anio]=$anio;
    }
    $this->widgetSchema['mes'] = new sfWidgetFormSelect(array('choices' => $arregloMeses));
    $this->widgetSchema->setLabel('mes', '<p align="left">Mes:</p>');

    $this->widgetSchema['anio'] = new sfWidgetFormSelect(array('choices' => $arregloAnio));
    $this->widgetSchema->setLabel('anio', '<p align="left">Año:</p>');


   $this->setValidators(array(
      'id'           => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'nrodoc'       => new sfValidatorString(array('max_length' => 80, 'required' => false)),
      'mes'          => new sfValidatorInteger(array('required' => false)),
      'anio'         => new sfValidatorInteger(array('required' => false)),
      'idobrasocial' => new sfValidatorInteger(array('required' => false)),
      'idtratamiento' => new sfValidatorInteger(array('required' => false)),
      'matricula'    => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'fecha'        => new sfValidatorDate(array('required' => false)),
      'pieza'        => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'caras'        => new sfValidatorString(array('max_length' => 10, 'required' => false)),
     // 'tratamiento'  => new sfValidatorString(array('max_length' => 200, 'required' => false)),
      'importe'      => new sfValidatorNumber(array('required' => false)),
      'coseguro'     => new sfValidatorNumber(array('required' => false)),
      'bono'         => new sfValidatorNumber(array('required' => false)),
      'importeos'    => new sfValidatorNumber(array('required' => false)),
    ));


    $this->validatorSchema->setOption('allow_extra_fields',true);


  }
}
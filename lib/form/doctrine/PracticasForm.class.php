<?php

/**
 * Practicas form.
 *
 * @package    sig
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class PracticasForm extends BasePracticasForm
{
  public function configure()
  {
  	unset( $this['created_at'], $this['updated_at'], $this['created_by'], $this['updated_by'] );

  	$this->setValidators(array(
      'idpractica'      => new sfValidatorChoice(array('choices' => array($this->getObject()->get('idpractica')), 'empty_value' => $this->getObject()->get('idpractica'), 'required' => false)),
      'nombre' => new sfValidatorString(array('required' => true), array('required' => 'El nombre es obligatorio.')),
      'idtipopractica' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TipoPracticas'), 'required' => true)),
    ));

    $this->widgetSchema->setLabel('idtipopractica', '<p align="left">Tipo Práctica:</p>');

     
     

      $this->validatorSchema->setOption('allow_extra_fields',true); 
  }
}

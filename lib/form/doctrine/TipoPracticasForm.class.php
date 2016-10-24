<?php

/**
 * TipoPracticas form.
 *
 * @package    sig
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class TipoPracticasForm extends BaseTipoPracticasForm
{
  public function configure()
  {
  	    unset( $this['created_at'], $this['updated_at'], $this['created_by'], $this['updated_by'] );
        $this->widgetSchema->setLabel('nombre', '<p align="left">Tipo Práctica:</p>');

        $this->setValidators(array(
         'idtipopractica' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('idtipopractica')), 'empty_value' => $this->getObject()->get('idtipopractica'), 'required' => false)),
        'nombre' => new sfValidatorString(array('required' => true), array('required' => 'El nombre es obligatorio.')),
        'orden'            => new sfValidatorInteger(array('required' => false)),
        ));
  }
}

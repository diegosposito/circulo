<?php

/**
 * Pacientes form.
 *
 * @package    sig
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class PacientesForm extends BasePacientesForm
{
  public function configure()
  {

  	     unset( $this['created_at'], $this['updated_at'], $this['created_by'], $this['updated_by'] );

  	     // Se define los labels
	    $this->widgetSchema->setLabel('nombre', '<p align="left">Nombre:</p>');
 	    $this->widgetSchema->setLabel('apellido', '<p align="left">Apellido:</p>');
      $this->widgetSchema->setLabel('nroafiliado', '<p align="left">Nro. Afiliado:</p>');
 	    $this->widgetSchema->setLabel('nrodoc', '<p align="left">Documento:</p>');
      $this->widgetSchema->setLabel('idsexo', '<p align="left">Sexo:</p>');
      $this->widgetSchema->setLabel('estadocivil', '<p align="left">E. Civil:</p>');
      $this->widgetSchema->setLabel('fechanac', '<p align="left">Fec. Nacimiento:</p>');
      $this->widgetSchema->setLabel('fechaingreso', '<p align="left">Fec. Ingreso:</p>');
      $this->widgetSchema->setLabel('direccion', '<p align="left">Dirección:</p>');

      $this->widgetSchema->setLabel('idprovincia', '<p align="left">Provincia:</p>');
      $this->widgetSchema->setLabel('idobrasocial', '<p align="left">O. Social:</p>');
      $this->widgetSchema->setLabel('idciudadnac', '<p align="left">Ciudad:</p>');
 	    $this->widgetSchema->setLabel('email', '<p align="left">Email:</p>');
      $this->widgetSchema->setLabel('celular', '<p align="left">Celular:</p>');
 	    $this->widgetSchema->setLabel('telefono', '<p align="left">Teléfono:</p>');
      $this->widgetSchema->setLabel('titular', '<p align="left">Titular:</p>');
      $this->widgetSchema->setLabel('parentesco', '<p align="left">Parentesco:</p>');
      $this->widgetSchema->setLabel('ocupacion', '<p align="left">Ocupación:</p>');
      $this->widgetSchema->setLabel('siglas', '<p align="left">Siglas:</p>');
      $this->widgetSchema->setLabel('plan', '<p align="left">Plan:</p>');
      $this->widgetSchema->setLabel('trabajo', '<p align="left">Trabajo:</p>');
      $this->widgetSchema->setLabel('jerarquia', '<p align="left">Jerarquía:</p>');
      $this->widgetSchema->setLabel('credencial', '<p align="left">Credencial:</p>');
      $this->widgetSchema->setLabel('anotaciones', '<p align="left">Anotaciones:</p>');
      $this->widgetSchema->setLabel('activo', '<p align="left">Activo:</p>');
      $this->widgetSchema->setLabel('historial', '<p align="left">Historial:</p>');

      $this->widgetSchema['imagefile'] = new sfWidgetFormInputFile(array(
                                               'label' => 'Archivo',
                                             ));
      $this->widgetSchema->setLabel('imagefile', '<p align="left">Foto:</p>');
         
      $range  = range(date('Y')-80, date('Y')+1);
		  $years = array_combine($range,$range);

      $this->widgetSchema['direccion'] = new sfWidgetFormInputText(array(), array("style"=>'width: 250px;'));
      $this->widgetSchema->setLabel('direccion', '<p align="left">Dirección:</p>');
      $this->widgetSchema['plan'] = new sfWidgetFormInputText(array(), array("style"=>'width: 250px;'));
      $this->widgetSchema->setLabel('plan', '<p align="left">Plan:</p>');
      $this->widgetSchema['titular'] = new sfWidgetFormInputText(array(), array("style"=>'width: 250px;'));
      $this->widgetSchema->setLabel('titular', '<p align="left">Titular:</p>');
      $this->widgetSchema['parentesco'] = new sfWidgetFormInputText(array(), array("style"=>'width: 250px;'));
      $this->widgetSchema->setLabel('parentesco', '<p align="left">Parentesco:</p>');
      $this->widgetSchema['ocupacion'] = new sfWidgetFormInputText(array(), array("style"=>'width: 250px;'));
      $this->widgetSchema->setLabel('ocupacion', '<p align="left">Ocupación:</p>');

		  $this->widgetSchema['fechanac'] =
		  new sfWidgetFormDate(array('format' => '%day%/%month%/%year%','years' => $years));
		  $this->widgetSchema['fechaingreso'] =
		  new sfWidgetFormDate(array('format' => '%day%/%month%/%year%','years' => $years));     

		  $this->widgetSchema->setLabel('fechanac', '<p align="left">Fec. Nac.:</p>');
      $this->widgetSchema->setLabel('fechaingreso', '<p align="left">Fec. Ingreso:</p>');
            
      
  }
}

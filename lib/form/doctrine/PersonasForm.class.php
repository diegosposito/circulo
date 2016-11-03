<?php

/**
 * Personas form.
 *
 * @package    sig
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class PersonasForm extends BasePersonasForm
{
  public function configure()
  {

        unset( $this['cantgrupofamiliar'],$this['titulo'],$this['monto'],$this['idcobrador'], $this['activo'], $this['idprofesion'],$this['vive'],$this['created_at'], $this['updated_at'], $this['tienefoto'], $this['created_by'], $this['updated_by'] ,$this['nrodoc'] ,$this['fechanac'],$this['socio'],$this['fechaingreso'] ,$this['idciudadnac'],$this['idnacionalidad'],$this['estadocivil']         );
     
      // Se define los labels
	    $this->widgetSchema->setLabel('nombre', '<p align="left">Nombre:</p>');
 	    $this->widgetSchema->setLabel('apellido', '<p align="left">Apellido:</p>');
      $this->widgetSchema->setLabel('idsexo', '<p align="left">Sexo:</p>');
 	    $this->widgetSchema->setLabel('idtipodoc', '<p align="left">Tipo Documento:</p>');
      $this->widgetSchema->setLabel('idusuario', '<p align="left">Usuario:</p>');
      $this->widgetSchema->setLabel('numerodoc', '<p align="left">Numero Doc:</p>');
      $this->widgetSchema->setLabel('direccion', '<p align="left">Dirección:</p>');
      $this->widgetSchema->setLabel('ciudad', '<p align="left">Ciudad:</p>');
      $this->widgetSchema->setLabel('email', '<p align="left">Email:</p>');
      $this->widgetSchema->setLabel('celular', '<p align="left">Celular:</p>');
      $this->widgetSchema->setLabel('telefono', '<p align="left">Teléfono:</p>');
      
      $this->widgetSchema->setLabel('nrolector', '<p align="left">Matrícula Nro.:</p>');
     /* $this->widgetSchema['idcobrador'] = new sfWidgetFormSelect(array('choices' => $arregloCobradores));
      $this->widgetSchema->setLabel('idcobrador', '<p align="left">Cobrador:</p>'); */
      $this->widgetSchema->setLabel('horarios', '<p align="left">Horarios:</p>');
      $this->widgetSchema->setLabel('otrainformacionrelevante', '<p align="left">Observaciones:</p>');
      $this->widgetSchema->setLabel('mostrarinfoemail', '<p align="left">Muestra Info Email?:</p>');
      $this->widgetSchema->setLabel('mostrarinfocelular', '<p align="left">Muestra Info Celular?:</p>');
      $this->widgetSchema->setLabel('imagefile', '<p align="left">Foto Personal:</p>');

      $this->widgetSchema['imagefile'] = new sfWidgetFormInputFile(array(
                                          'label' => 'Foto Personal',
                                        ));

      $this->widgetSchema['horarios'] = new sfWidgetFormTextareaTinyMCE(
             array(
              'config' => sfConfig::get('app_tiny_mce_simple')
             )
      );

      $this->widgetSchema->setLabel('imagefile', '<p align="left">Foto Personal:</p>');


      $this->setValidators(array(
        'apellido' => new sfValidatorString(array('required' => true), array('required' => 'El apellido es obligatorio.')),
        'nombre' => new sfValidatorString(array('required' => true), array('required' => 'El nombre es obligatorio.')),
        'numerodoc' => new sfValidatorString(array('required' => true), array('required' => 'El documento es obligatorio.')),
        'celular' => new sfValidatorString(array('max_length' => 200, 'required' => false)),
        'nrolector' => new sfValidatorString(array('max_length' => 200, 'required' => false)),
        'direccion' => new sfValidatorString(array('max_length' => 200, 'required' => false)),
        'ciudad' => new sfValidatorString(array('max_length' => 200, 'required' => false)),
        'email' => new sfValidatorString(array('max_length' => 200, 'required' => false)),
        'telefono' => new sfValidatorString(array('max_length' => 200, 'required' => false)),
        'mostrarinfocontacto' => new sfValidatorString(array('required' => false)),
        'horarios' => new sfValidatorString(array('required' => false)),
        'otrainformacionrelevante' => new sfValidatorString(array('max_length' => 2000, 'required' => false)),
        'imagefile' => new sfValidatorFile(array('required' => false)),
        ));

      $this->validatorSchema->setOption('allow_extra_fields',true); 
      

   
	 }

 

    public function checkDni($validator, $values)
    {
      // no debe estar vacio el campo numerodoc
      if(empty($values['numerodoc']) )
      {
        // nrodoc incorrecto
        throw new sfValidatorError($validator, 'Numero de documento invalido');
      } else {

		$nrodoc = preg_replace("/[^\d]/", "", $values['numerodoc']);
		//$values['idtipodoc']
		$oTipoDocumento = Doctrine_Core::getTable('TiposDocumentos')->find(1);        
		$this->formato = $oTipoDocumento->getFormato();  

   		if (preg_match($this->formato, $values['numerodoc'])) {

		    // CONTROLAR QUE EL NRODOC NO EXISTA PREVIAMENTE
		    //===================================================
		    $oPersona = Doctrine_Core::getTable('Personas')->buscarPersona($values['idtipodoc'],$nrodoc);
			if($oPersona) throw new sfValidatorError($validator, 'La persona ya esta en la base , se encontro el DNI.');

		} else {
			throw new sfValidatorError($validator, 'Formato de documento incorrecto');
		}

	}
 
      // nrodocincorrecto
      return $values;
    }

}

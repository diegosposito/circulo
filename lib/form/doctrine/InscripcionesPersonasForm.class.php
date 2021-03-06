<?php
class InscripcionesPersonasForm extends sfForm
{
	        
  public function configure()
  {         
	$arregloSexo = array(1 => 'Masculino', 2 => 'Femenino');
	$arregloEstadosCiviles = array(1 => 'Soltero', 2 =>'Casado', 3 =>'Otros');
	$arregloSiNo = array(1 => 'No', 2 => 'Si');
	$arregloDocumentacion = array(1 => '4 Fotografias 3x3', 2 =>'Fotocopia DNI (1ra. y 2da. hoja y hoja de domicilio actualizado)', 3 =>'Certificado alumno regular (CAR)', 4 =>'Certificado de título en tramite (CTT)',5 =>'Fotocopia autenticada de título de nivel medio',6 =>'Fotocopia autenticada de título de grado',7 =>'Fotocopia autenticada de partida de nacimiento');
	$arregloDocumentacionExtranjero = array( 1 => 'Titulo revalidado ante Ministerio de Educación', 2 => 'Certificado o constancia de iniciación de trámite de residencia estudiantil');
	$arregloDocumentacionAdicional = array(1 => 'Radiografia de torax', 2 => 'Electrocardiograma', 3 => 'Ergometría - mayores de 32 año', 4 =>'Planilla médica', 5 =>'Planilla bucodental', 6 =>'Hemograma', 7 =>'Glucemia', 8 =>'Estudio VDRL');
  	$ciclos = Doctrine_Core::getTable('CiclosLectivos')->obtenerCiclosLectivosActivos();
	foreach($ciclos as $ciclo){
		$arregloCiclos[$ciclo->getId()] = $ciclo->getCiclo(); 
	}	

	$niveles_estudios = Doctrine_Core::getTable('NivelesEstudios')->obtenerNivelesEstudios(false);
	foreach($niveles_estudios as $ne){
		$arregloNe[$ne->getIdNivelEstudio()] = $ne->getDescripcion(); 
	}	
	// Se define el esquema del form
  	
	// INFORMACION PERSONAL
	$this->widgetSchema['idpersona'] = new sfWidgetFormInputHidden();
	$this->widgetSchema['idtipodocumento'] = new sfWidgetFormInputHidden();
	$this->widgetSchema['idalumno'] = new sfWidgetFormInputHidden();
	$this->widgetSchema['idciclolectivo'] = new sfWidgetFormSelect(array('label' => '<p align="left">Ciclo Lectivo:</p>', 'choices' => $arregloCiclos));
	$this->widgetSchema['nombre'] = new sfWidgetFormInput(array('label' => '<p align="left">Nombre:</p>'), array('size' => '20'));
	$this->widgetSchema['apellido'] = new sfWidgetFormInput(array('label' => '<p align="left">Apellido:</p>'), array('size' => '20'));	
	$this->widgetSchema['idsexo'] = new sfWidgetFormChoice(array('label' => '<p align="left">Sexo:</p>', 'choices' => $arregloSexo, 'expanded' => true, 'default' => 1));
	$this->widgetSchema['internacional'] = new sfWidgetFormInputCheckbox(array('label' => '<p align="left">Internacional?:</p>'));
  	$this->widgetSchema['estadocivil'] = new sfWidgetFormSelect(array('label' => '<p align="left">Estado Civil:</p>', 'choices' => $arregloEstadosCiviles));
	$this->widgetSchema['paisnacimiento'] = new sfWidgetFormDoctrineChoice(array(
		'label' => '<p align="left">País:</p>', 
		'expanded' => false,
		'multiple' => false,
		'model' => 'Paises',
		'add_empty' => false
	));
	
	$this->widgetSchema['provincianacimiento'] = new sfWidgetFormSelect(array('label' => '<p align="left">Provincia:</p>', 'choices' => array(0 => '----Seleccione----')));
	$this->widgetSchema['ciudadnacimiento'] = new sfWidgetFormSelect(array('label' => '<p align="left">Ciudad:</p>', 'choices' => array(0 => '----Seleccione----')));
	$this->widgetSchema['fechanacimiento'] = new sfWidgetFormInput(array('label' => '<p align="left">Fecha de Nacimiento:</p>'), array('size' =>'10'));	
		
	$this->widgetSchema['tipodocumento'] = new sfWidgetFormInput(array('label' => '<p align="left">Tipo Documento:</p>'), array('size' =>'7'));
	$this->widgetSchema['nrodocumento'] = new sfWidgetFormInput(array('label' => '<p align="left">Nro. Documento:</p>'), array('size' =>'10'));
	
	// RESIDENCIA ESTABLE
	$this->widgetSchema['nombrecalle'] = new sfWidgetFormInput(array('label' => '<p align="left">Calle:</p>'), array('size' =>'30'));
	$this->widgetSchema['nrocalle'] = new sfWidgetFormInput(array('label' => '<p align="left">Nro.:</p>'), array('size' =>'5'));
	$this->widgetSchema['barrio'] = new sfWidgetFormInput(array('label' => '<p align="left">Barrio:</p>'), array('size' =>'10'));
	$this->widgetSchema['manzana'] = new sfWidgetFormInput(array('label' => '<p align="left">Manzana:</p>'), array('size' =>'5'));
	$this->widgetSchema['casa'] = new sfWidgetFormInput(array('label' => '<p align="left">Casa:</p>'), array('size' =>'5'));
	$this->widgetSchema['edificio'] = new sfWidgetFormInput(array('label' => '<p align="left">Edificio:</p>'), array('size' =>'10'));
	$this->widgetSchema['piso'] = new sfWidgetFormInput(array('label' => '<p align="left">Piso:</p>'), array('size' =>'5'));
	$this->widgetSchema['depto'] = new sfWidgetFormInput(array('label' => '<p align="left">Depto.:</p>'), array('size' =>'5'));
	
	$this->widgetSchema['paisresidencia'] = new sfWidgetFormDoctrineChoice(array(
		'label' => '<p align="left">País:</p>', 	
		'expanded' => false,
		'multiple' => false,
		'model' => 'Paises',
		'add_empty' => false
	));
	$this->widgetSchema['provinciaresidencia'] = new sfWidgetFormSelect(array('label' => '<p align="left">Provincia:</p>', 'choices' => array(0 => '----Seleccione----')));
	$this->widgetSchema['ciudadresidencia'] = new sfWidgetFormSelect(array('label' => '<p align="left">Ciudad:</p>', 'choices' => array(0 => '----Seleccione----')));
	$this->widgetSchema['areatelefonofijo'] = new sfWidgetFormInput(array('label' => '<p align="left">Teléfono:</p>'), array('size' =>'5'));
	$this->widgetSchema['nrotelefonofijo'] = new sfWidgetFormInput(array('label' => '<p align="left">Teléfono:</p>'), array('size' =>'10'));
	$this->widgetSchema['areatelefonomovil'] = new sfWidgetFormInput(array('label' => '<p align="left">Teléfono:</p>'), array('size' =>'5'));
	$this->widgetSchema['nrotelefonomovil'] = new sfWidgetFormInput(array('label' => '<p align="left">Celular:</p>'), array('size' =>'10'));
	$this->widgetSchema['email'] = new sfWidgetFormInput(array('label' => '<p align="left">E-mail:</p>'), array('size' =>'40'));
	$this->widgetSchema['email1'] = new sfWidgetFormInput(array('label' => '<p align="left">E-mail UCU:</p>'), array('size' =>'40'));
	
	// DOCUMENTACION
	$this->widgetSchema['documentacion'] = new sfWidgetFormChoice(array('label' => '<p align="left">Documentación:</p>', 'choices' => $arregloDocumentacion, 'expanded' => true, 'multiple' => true));
	$this->widgetSchema['documentacionextranjero'] = new sfWidgetFormChoice(array('label' => '<p align="left">Documentación para alumnos extranjero:</p>', 'choices' => $arregloDocumentacionExtranjero, 'expanded' => true, 'multiple' => true));
	$this->widgetSchema['legajo'] = new sfWidgetFormInput(array('label' => '<p align="left">Legajo:</p>'), array('size' =>'10'));
	$this->widgetSchema['observaciones'] = new sfWidgetFormTextArea(array('label' => '<p align="left">Observaciones:</p>'), array('rows' => '5', 'cols' => '70'));
	$this->widgetSchema['fechacerttittramite'] = new sfWidgetFormInput(array('label' => '<p align="left">Fecha de CTT:</p>'), array('size' =>'10'));
	
	// DOCUMENTACION ADICIONAL
	$this->widgetSchema['documentacionadicional'] = new sfWidgetFormChoice(array('label' => '<p align="left">Documentación:</p>', 'choices' => $arregloDocumentacionAdicional, 'expanded' => true, 'multiple' => true));

	// ESTUDIOS PREVIOS
	$this->widgetSchema['idestudio'] = new sfWidgetFormInputHidden();
	$this->widgetSchema['titulo'] = new sfWidgetFormInput(array('label' => '<p align="left">Título:</p>'), array('size' =>'30'));
	/*$this->widgetSchema['nivel'] = new sfWidgetFormDoctrineChoice(array(
		'label' => '<p align="left">Nivel del Estudio:</p>', 	
		'expanded' => false,
		'multiple' => false,
		'model' => 'NivelesEstudios',
		'add_empty' => false
	));*/

    $this->widgetSchema['nivel'] = new sfWidgetFormSelect(array('label' => '<p align="left">Nivel del Estudio:</p>', 'choices' => $arregloNe));

	$this->widgetSchema['categoria'] = new sfWidgetFormDoctrineChoice(array(
		'label' => '<p align="left">Categoria Titulo:</p>', 	
		'expanded' => false,
		'multiple' => false,
		'model' => 'CategoriasTitulos',
		'add_empty' => false
	));			
	$this->widgetSchema['establecimiento'] = new sfWidgetFormInput(array('label' => '<p align="left">Establecimiento:</p>'), array('size' =>'30'));
	$this->widgetSchema['paisestablecimiento'] = new sfWidgetFormDoctrineChoice(array(
		'label' => '<p align="left">País:</p>', 	
		'expanded' => false,
		'multiple' => false,
		'model' => 'Paises',
		'add_empty' => false
	));
	$this->widgetSchema['provinciaestablecimiento'] = new sfWidgetFormSelect(array('label' => '<p align="left">Provincia:</p>', 'choices' => array(0 => '----Seleccione----')));
	$this->widgetSchema['ciudadestablecimiento'] = new sfWidgetFormSelect(array('label' => '<p align="left">Ciudad:</p>', 'choices' => array(0 => '----Seleccione----')));
	$this->widgetSchema['fechaemision'] = new sfWidgetFormInput(array('label' => '<p align="left">Fecha de Emisión:</p>'), array('size' =>'10'));
	$this->widgetSchema['duracion'] = new sfWidgetFormInput(array('label' => '<p align="left">Duración:</p>'), array('size' =>'8'));
	$this->widgetSchema['unidadtiempo'] = new sfWidgetFormDoctrineChoice(array(
		'label' => '<p align="left">Unidad de tiempo:</p>', 	
		'expanded' => false,
		'multiple' => false,
		'model' => 'UnidadesDeTiempo',
		'add_empty' => false
	));	

	$this->widgetSchema['formaciondocente'] =  new sfWidgetFormInputCheckbox(array('label' => '<p align="left">Formación Docente:</p>'));
	$this->widgetSchema['concluyo'] =  new sfWidgetFormInputCheckbox(array('label' => '<p align="left">Concluyo?</p>'));
	$this->widgetSchema['continua'] =  new sfWidgetFormInputCheckbox(array('label' => '<p align="left">Continúa?</p>'));
	
	//$this->widgetSchema['concluyo'] = new sfWidgetFormChoice(array('label' => '<p align="left">¿Concluyo?:</p>', 'choices' => $arregloSiNo, 'expanded' => true, 'default' => 1));	
	//$this->widgetSchema['continua'] = new sfWidgetFormChoice(array('label' => '<p align="left">¿Continua?:</p>', 'choices' => $arregloSiNo, 'expanded' => true, 'default' => 1));
  	$this->widgetSchema['numerototal'] = new sfWidgetFormInput(array('label' => '<p align="left">Nro. de materias:</p>'), array('size' =>'2'));
	$this->widgetSchema['numeroaprobadas'] = new sfWidgetFormInput(array('label' => '<p align="left">Nro. de materias aprobadas:</p>'), array('size' =>'2'));
	$this->widgetSchema['anioingreso'] = new sfWidgetFormInput(array('label' => '<p align="left">Año de Ingreso:</p>'), array('size' =>'4'));
	$this->widgetSchema['anioegreso'] = new sfWidgetFormInput(array('label' => '<p align="left">Año de Egreso:</p>'), array('size' =>'4'));
	$this->widgetSchema['promedio'] = new sfWidgetFormInput(array('label' => '<p align="left">Promedio:</p>'), array('size' =>'4'));
	$this->widgetSchema['otros'] = new sfWidgetFormInput(array('label' => '<p align="left">Otros:</p>'), array('size' =>'50'));
	$this->widgetSchema['informacionrelevante'] = new sfWidgetFormTextArea(array('label' => '<p align="left"><b>Informacion relevante:</b></p>')); 	 
  }
}

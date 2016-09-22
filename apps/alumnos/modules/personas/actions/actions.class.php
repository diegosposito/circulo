<?php

/**
 * personas actions.
 *
 * @package    sig
 * @subpackage personas
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class personasActions extends sfActions
{
	public function executeGuardarnombre(sfWebRequest $request) {
		$oPersona = Doctrine_Core::getTable('Personas')->find($request->getParameter('idpersona'));
		$nombreAnterior = $oPersona->getApellido().", ". $oPersona->getNombre();
		
		$oPersona->setApellido(strtoupper($request->getParameter('apellido')));
		$oPersona->setNombre(ucwords(strtolower($request->getParameter('nombre'))));
		$oPersona->save();
		
		$destinatario = array('auditoriaacademica@correo.edu.ar' => 'UCU - Auditoria Academica','informatica@correo.edu.ar' => 'Dpto Informatica');

		$remitente = $this->getUser()->getGuardUser()->getEmailAddress();
		$oArea = Doctrine_Core::getTable('Areas')->find($this->getUser()->getProfile()->getIdarea());
		$oSede = Doctrine_Core::getTable('Sedes')->find($this->getUser()->getProfile()->getIdsede());
		
		$mensajeEmail = '
**************************************************************************************
**************************************************************************************
Se modificó el nombre del alumno '.$oPersona.', '.$oPersona->getTiposDocumentos().': '.$oPersona->getNrodoc().'.
El nombre que se modificó fue: '.$nombreAnterior.' 	
E-mail remitente: '.$remitente.'	
Area: '.$oArea.'
Sede: '.$oSede.'
**************************************************************************************
**************************************************************************************';
		
		$resultado = $this->getMailer()->composeAndSend(
				$remitente,
				$destinatario,
				'SAO- Modificacion de nombre de alumno: '. $oPersona,
				$mensajeEmail
		);		
		
		echo "Se ha guardado correctamente la persona.";
		
		return sfView::NONE;		
	}
	
	public function executeBuscarpersonas(sfWebRequest $request) {
	
	}	

	// Guarda la documentacion laboral seleccionada de la persona
  public function executeGuardarestudioprevio(sfWebRequest $request) {
	  	if($request->getParameter('idestudio')) {
  			$oEstudio = Doctrine_Core::getTable('Estudios')->find($request->getParameter('idestudio'));
  		} else {
  			$oEstudio = new Estudios();
  		}
  		$oEstudio->setIdpersona($request->getParameter('idpersona'));
  		$oEstudio->setIdnivelestudio($request->getParameter('nivel'));
  		$oEstudio->setDescripcion($request->getParameter('titulo'));
  		$oEstudio->setIdcategoriatitulo($request->getParameter('categoria'));
  		$oEstudio->setEstablecimiento($request->getParameter('establecimiento'));
  		$oEstudio->setIdciudad($request->getParameter('ciudadestablecimiento'));
  		$arr = explode('-', $request->getParameter('fechaemision'));
  		$oEstudio->setFecha($arr[2]."-".$arr[1]."-".$arr[0]);
		$fechaegreso=($arr[2]."-".$arr[1]."-".$arr[0]);
  		$oEstudio->setDuracion($request->getParameter('duracion'));
  		$oEstudio->setIdunidadtiempo($request->getParameter('unidadtiempo'));
		$oEstudio->setContinua($request->getParameter('continua') == 'on' ? 1 : 0);
  		$oEstudio->setCantmaterias($request->getParameter('numerototal'));
  		$oEstudio->setCantmatapro($request->getParameter('numeroaprobadas'));
  		$oEstudio->setPromedio($request->getParameter('promedio'));
  		
  		if ($request->getParameter('concluyo') == 'on'){
          $oEstudio->setConcluyo(1);
          $oEstudio->setAnioegreso($request->getParameter('anioegreso'));
  		}
        else{
          $oEstudio->setConcluyo(0);
          $oEstudio->setAnioingreso($request->getParameter('anioingreso'));
        }

        if($request->getParameter('nivel')==14) {
        	$oEstudio->setOtrotitulo($request->getParameter('otros'));
        }
        if ($request->getParameter('formaciondocente') == 'on') {
			$oEstudio->setFormaciondocente(1);
        } else {
			$oEstudio->setFormaciondocente(0);
        }
  		$oEstudio->save();

  		echo "El estudio previo ha sido guardado correctamente.";

  		return sfView::NONE;  	
	}

	public function executeMesescobro(sfWebRequest $request)
    {
     
      $this->persona = Doctrine::getTable('Personas')->find($request->getParameter('idpersona'));

      //$this->resultado = Doctrine_Core::getTable('MesesCobro')->obtenerMesesCobro($request->getParameter('idpersona'));
      $this->resultado = Doctrine_Core::getTable('MesesCobro')->obtenerSoloMesesCobro($request->getParameter('idpersona'));
     
    }

    public function executeRegistrarcobro(sfWebRequest $request)
    {
        
        if ($request->getParameter('idpersona')>0){
       
       		$this->resultado = Doctrine_Core::getTable('MesesCobro')->borrarMesesCobro($request->getParameter('idpersona'));
      
	        foreach($request->getParameter('meses') as $mes){
	          
	        	$oMesesCobro = new MesesCobro();
	  		
				$oMesesCobro->setIdpersona($request->getParameter('idpersona'));
				$oMesesCobro->setMes($mes);
			  		
			  	$oMesesCobro->save();
	        }
        }

        $this->redirect('personas/mesescobro?idpersona='.$request->getParameter('idpersona'));
     
    }

	public function executeRegistrar(sfWebRequest $request) {
       $this->mensaje = ""; $this->isPost = false; 
       $documento=$request->getParameter('nrodocumento');

       if ($request->isMethod('post')){
       	   $pos = strpos($request->getParameter('nrodocumento'), '.');
           if ($pos === false) 
           	   $documento = '';
       }

       if ($request->isMethod('post') && $documento<>'') {
			$this->isPost= true;
		    $this->idtipodocumento =$request->getParameter('idtipodocumento');
		    $this->nrodoc =preg_replace("/[^\d]/", "", $request->getParameter('nrodocumento'));	
		    $this->numerodoc = $request->getParameter('nrodocumento');
		    $this->resultado = Doctrine_Core::getTable('Personas')->obtenerPersonas(2, $this->nrodoc,$request->getParameter('idtipodocumento'));			
		} else {
			$this->resultado = array();
		}

        $this->form = new BuscarPersonasForm();
    }

    public function executeGenerarrecibos(sfWebRequest $request)
    {
	    $this->msgSuccess = $request->getParameter('msgSuccess', '');
	    $this->msgError = $request->getParameter('msgError', '');
	     
	    // solo usuarios de sede central pueden asignar resoluciones
	    if(sfContext::getInstance()->getUser()->getAttribute('id_sede','')<>'1'){
	        $this->msgError = 'El usuario actual no está habilitado para asignar resoluciones!!';
	        $this->resultado ='';
	    }

	    if ($idsede=='')
	        $this->idsede = sfContext::getInstance()->getUser()->getAttribute('id_sede','');
	     
	    // Obtener Sedes
	    $this->sedes = Doctrine_Core::getTable('Sedes')->findAll();
	      
	    $this->idsede = $idsede;
     
    }

    public function executeGestionrecibosgenerados(sfWebRequest $request)
    {
	    $this->msgSuccess = $request->getParameter('msgSuccess', '');
	    $this->msgError = $request->getParameter('msgError', '');

	    $this->cobradores = Doctrine_Core::getTable('Personas')->obtenerCobradores();

	    $this->estados = array(1=>'Generados',2=>'Cancelados',3=>'Cobrados');	 
	     
	}

    public function executeGrabarrecibosgenerados(sfWebRequest $request)
    {
        $this->msgSuccess = $request->getParameter('msgSuccess', '');
        $this->msgError = $request->getParameter('msgError', '');

        $arr_personas = array();
           
        // Obtiene designaciones seleccionadas en la vista en un array
        $idcase = $request->getParameter('idcase', '');

        foreach($idcase as $seleccionados){
            if(is_numeric($seleccionados)) 
                $arr_personas[] = $seleccionados;
        }

            // Si existen para generar recibos
            if ( count($arr_personas)>0 ){
                $resultado = Doctrine_Core::getTable('Personas')->crearRecibos($arr_personas);
                $estado = 'Los recibos fueron generados para los socios seleccionados.';
                $this->redirect($this->generateUrl('default', array('module' => 'personas',
                'action' => 'generarrecibos', 'msgSuccess' => $estado )));
            } else {
               $estado='No hay socios seleccionados para generar recibos';
               $this->redirect($this->generateUrl('default', array('module' => 'personas',
                'action' => 'generarrecibos', 'msgError' => $estado )));
            }

   }

   public function executeImprimirrecibosseleccionados(sfWebRequest $request)
    {
        $this->msgSuccess = $request->getParameter('msgSuccess', '');
        $this->msgError = $request->getParameter('msgError', '');

        $arr_idrecibosgenerados = array();
           
        // Obtiene designaciones seleccionadas en la vista en un array
        $idcase = $request->getParameter('idcase', '');

        foreach($idcase as $seleccionados){
            if(is_numeric($seleccionados)) 
                $arr_idrecibosgenerados[] = $seleccionados;
        }

        // Si existen para generar recibos
         if ( count($arr_idrecibosgenerados)>0 ){
                $resultado = Doctrine_Core::getTable('Personas')->obtenerRecibosGeneradosPorIds($arr_idrecibosgenerados);
        } else {
               $estado='No hay recibos generados seleccionados';
               $this->redirect($this->generateUrl('default', array('module' => 'personas',
                'action' => 'generarrecibos', 'msgError' => $estado )));
        }

        // COMIENZA LA IMPRESION DE RECIBOS

		$pdf = new PDF();

		$pdf->SetFont("Times", "", 9);
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false); 
 
		$pdf->AddPage();
		$current_date = date("Y");
		$encabezado = '
			<div style="text-align: center; font-family: Times New Roman,Times,serif;"><span
			style="font-size: 12;"><img src="'.$request->getRelativeUrlRoot().'/images/alcec3.jpg" width="550px">
			Generar recibos: '.$current_date.'</div>';        

		$pdf->writeHTML($encabezado, true, false, true, false, '');   
		
		$y = 60;
		$pdf->SetXY(10,$y);
		$pdf->Cell(10,5,'Nro Recibo',0,0,'C');    
		$pdf->SetXY(20,$y);
		$pdf->Cell(80,5,'Nombre',0,0,'C');    
		$pdf->SetXY(20,$y);
		$pdf->Cell(225,5,'Mes',0,0,'C'); 
		$pdf->SetXY(20,$y);
		$pdf->Cell(280,5,'Monto',0,0,'C'); 
		$pdf->SetXY(20,$y);
		$y = $y + 5;		
		$contador = 1;
		
		$pdf->Line(10,$y,199,$y);
		
	    foreach ($resultado as $socio){	
		    			    		
		   	$pdf->SetXY(0,$y-5);
            $pdf->SetXY(10,$y);
		    $pdf->Cell(10,5,$socio['id'],0,0,'L');
		    $pdf->SetXY(20,$y);        
		    $pdf->Cell(80,5,$socio['socio'],0,0,'L');        
		    $pdf->SetXY(120,$y); 
		    $pdf->Cell(10,5,$socio['mesanio'],0,0,'L'); 
		    $pdf->SetXY(160,$y); 
		    $pdf->Cell(10,5,$socio['monto'],0,0,'L'); 
		    
		
 			$y = $y + 5;  
		 	// add a page
			if($y>=265) {
				$pdf->AddPage();

				$encabezado = '
			<div style="text-align: center; font-family: Times New Roman,Times,serif;"><span
			style="font-size: 12;"><img src="'.$request->getRelativeUrlRoot().'/images/alcec3.jpg" width="550px">
			Generar Recibos: '.$current_date.'</div>';        
	
				$pdf->writeHTML($encabezado, true, false, true, false, '');   
				$y=60;

			}
	
		    } // fin (foreach)	

			 
		$pdf->Output('recibos.pdf', 'I');
 
		// stop symfony process
		throw new sfStopException();
				
		return sfView::NONE;

   }

    public function executeObtenerrecibosgenerados(sfWebRequest $request)
  {
      

      $this->msgSuccess = $request->getParameter('msgSuccess', '');
      $this->msgError = $request->getParameter('msgError', '');
      
      $this->resultado = Doctrine_Core::getTable('Personas')->obtenerRecibosAGenerar();
  
      $this->permite_seleccionar = $request->getParameter('permite_seleccionar');

  }

   public function executeObtenerrecibosporestado(sfWebRequest $request)
  {
    
    if($request->getParameter('inicio')){
    	$fechaa = explode("/", $request->getParameter('inicio'));
        $fechadesde = $fechaa[2]."-".$fechaa[0]."-".$fechaa[1]; 
    }
    
    if($request->getParameter('fin')){
    	 $fechab = explode("/", $request->getParameter('fin'));
         $fechahasta = $fechab[2]."-".$fechab[0]."-".$fechab[1]; 
    }
   


      $this->msgSuccess = $request->getParameter('msgSuccess', '');
      $this->msgError = $request->getParameter('msgError', '');
      if ($request->getParameter('seleccionar')==1)
          $this->permite_seleccionar = '1';
      else
          $this->permite_seleccionar = '0';

      $this->resultado = Doctrine_Core::getTable('Personas')->obtenerRecibosPorEstado($request->getParameter('seleccionar'), $request->getParameter('seleccionar2'),$fechadesde, $fechahasta);
  
     
  }

    public function executeModificarregistro(sfWebRequest $request)	{	

    	// Busca si existe la persona
		if($request->getParameter('idpersona')>1){
		        $oPersona = Doctrine_Core::getTable('Personas')->find($request->getParameter('idpersona'));
		    } else {
		        $oPersona = new Personas(); 
		        $oPersona->setIdtipodoc($request->getParameter('idtipodocumento'));
		        $oPersona->setNumerodoc($request->getParameter('nrodocumento'));
        }

		$this->form = new InscripcionesPersonasForm();
		$this->email = 0;
		$this->emailucu = 0;
		$this->activo = 0;
		$this->idpersona = $oPersona->getIdpersona();
		
		// Si existe obtiene todos los datos personales y los muestra en pantalla
		$this->form->setDefault('idpersona', $oPersona->getIdpersona());
		$this->form->setDefault('idtipodocumento', $oPersona->getIdtipodoc());		
		$oTipoDocumento = Doctrine_Core::getTable('TiposDocumentos')->find($oPersona->getIdtipodoc());
		$this->form->setDefault('tipodocumento', $oTipoDocumento->getDescripcion()."(".$oTipoDocumento->getPaises()->getAbreviacion().")");	
		if($oPersona->getNumerodoc()) {
			$this->form->setDefault('nrodocumento', $oPersona->getNumerodoc());
		} else {
			$this->form->setDefault('nrodocumento', $oPersona->getNrodoc());		
		}
		
		$this->form->setDefault('nombre', $oPersona->getNombre());
		$this->form->setDefault('apellido', $oPersona->getApellido());
		$this->form->setDefault('idsexo', $oPersona->getIdsexo());
		$this->form->setDefault('estadocivil', $oPersona->getEstadocivil());
		$this->idciudadnac = $oPersona->getIdciudadnac();
		$oCiudadNacimiento = Doctrine_Core::getTable('Ciudades')->find($this->idciudadnac);
		$oProvinciaNacimiento = Doctrine_Core::getTable('Provincias')->find($oCiudadNacimiento->getIdprovincia());
		$this->idprovincianac = $oProvinciaNacimiento->getIdprovincia();
		$oPaisNacimiento = Doctrine_Core::getTable('Paises')->find($oProvinciaNacimiento->getIdpais());
		$this->idpaisnac = $oPaisNacimiento->getIdpais();
		$arr = explode('-', $oPersona->getFechanac());
		$this->form->setDefault('fechanacimiento', $arr[2]."-".$arr[1]."-".$arr[0]);

		// Obtiene el contecto de la persona
		$oContacto = $oPersona->getContacto();
		if($oContacto){
			$this->form->setDefault('nombrecalle', $oContacto->getCallee());
			$this->form->setDefault('nrocalle', $oContacto->getNumeroe());
			$this->form->setDefault('barrio', $oContacto->getBarrioe());
			$this->form->setDefault('edificio', $oContacto->getEdificioe());
			$this->form->setDefault('piso', $oContacto->getPisoe());
			$this->form->setDefault('depto', $oContacto->getDeptoe());
			$this->idciudadres = $oContacto->getIdciudade();
			if(($this->idciudadres != 0) && ($this->idciudadres != NULL)) {
				$oCiudadResidencia = Doctrine_Core::getTable('Ciudades')->find($this->idciudadres);
				$oProvinciaResidencia = Doctrine_Core::getTable('Provincias')->find($oCiudadResidencia->getIdprovincia());
				$this->idprovinciares = $oProvinciaResidencia->getIdprovincia();
				$oPaisResidencia = Doctrine_Core::getTable('Paises')->find($oProvinciaResidencia->getIdpais());
				$this->idpaisres = $oPaisResidencia->getIdpais();
			} else {
				$this->idciudadres = 0;
			}
  			$this->form->setDefault('areatelefonofijo', $oContacto->getTelefonofijocar());
			$this->form->setDefault('nrotelefonofijo', $oContacto->getTelefonofijonum());
			$this->form->setDefault('areatelefonomovil', $oContacto->getCelularcar());
			$this->form->setDefault('nrotelefonomovil', $oContacto->getCelularnum());
			$this->form->setDefault('email', $oContacto->getEmail());
			$this->form->setDefault('email1', $oContacto->getEmail1());
			if ($oContacto->getEmail() != NULL) {
				$this->email = 1;
			}	 
			if ($oContacto->getEmail1() != NULL) {
				$this->emailucu = 1;
			} 

		} else {
			//$this->idciudadnac = 0;
			$this->idciudadres = 0;
		}

		// Obtiene otra informacion relevante de persona
		$this->form->setDefault('informacionrelevante', $oPersona->getOtrainformacionrelevante());
		
		$this->setTemplate('inscribir');
	}	
	
	public function executeModificarnombre(sfWebRequest $request)	{
		// Busca si existe la persona
		$this->idpersona = $request->getParameter('idpersona');
		$oPersona = Doctrine_Core::getTable('Personas')->find($this->idpersona);
	
		$this->form = new InscripcionesAspiranteForm();
		$this->email = 0;
		$this->activo = 0;
	
		// Si existe obtiene todos los datos personales y los muestra en pantalla
		$this->form->setDefault('idpersona', $this->idpersona);
		$this->form->setDefault('idtipodocumento', $oPersona->getIdtipodoc());
		$oTipoDocumento = Doctrine_Core::getTable('TiposDocumentos')->find($oPersona->getIdtipodoc());
		$this->form->setDefault('tipodocumento', $oTipoDocumento->getDescripcion()."(".$oTipoDocumento->getPaises()->getAbreviacion().")");
		if($oPersona->getNumerodoc()) {
			$this->form->setDefault('nrodocumento', $oPersona->getNumerodoc());
		} else {
			$this->form->setDefault('nrodocumento', $oPersona->getNrodoc());
		}
	
		$this->form->setDefault('nombre', $oPersona->getNombre());
		$this->form->setDefault('apellido', $oPersona->getApellido());
		$this->form->setDefault('idsexo', $oPersona->getIdsexo());
		$this->form->setDefault('estadocivil', $oPersona->getEstadocivil());
		$this->idciudadnac = $oPersona->getIdciudadnac();
		$oCiudadNacimiento = Doctrine_Core::getTable('Ciudades')->find($this->idciudadnac);
		$oProvinciaNacimiento = Doctrine_Core::getTable('Provincias')->find($oCiudadNacimiento->getIdprovincia());
		$this->idprovincianac = $oProvinciaNacimiento->getIdprovincia();
		$oPaisNacimiento = Doctrine_Core::getTable('Paises')->find($oProvinciaNacimiento->getIdpais());
		$this->idpaisnac = $oPaisNacimiento->getIdpais();
		$arr = explode('-', $oPersona->getFechanac());
		$this->form->setDefault('fechanacimiento', $arr[2]."-".$arr[1]."-".$arr[0]);
	
	}
		
	public function executeGuardarinformacionpersonal(sfWebRequest $request) {
		$numerodoc = $request->getParameter('nrodocumento');
		$nrodoc = preg_replace("/[^\d]/", "", $numerodoc);
		$fechaingreso = date('Y-m-d');
	
		$arr = explode('-', $request->getParameter('fechanacimiento'));
		$fechanacimiento = $arr[2]."-".$arr[1]."-".$arr[0];
		if ($request->getParameter('internacional')=="on") {
			$internacional = 1;
		} else {
			$internacional = 0;
		}
	
		if($request->getParameter('idpersona')){
			$oPersona = Doctrine::getTable('Personas')->find($request->getParameter('idpersona'));
		} else {
			$oPersona = new Personas();
			$oPersona->setIdtipodoc($request->getParameter('idtipodocumento'));
			$oPersona->setFechaingreso($fechaingreso);
			$oPersona->setNrodoc($nrodoc);
		}
		// Guarda los datos personales
		$oPersona->setNumerodoc($numerodoc);
		$oPersona->setNombre(ucwords(strtolower($request->getParameter('nombre'))));
		$oPersona->setApellido(strtoupper($request->getParameter('apellido')));
		$oPersona->setIdsexo($request->getParameter('idsexo'));
		$oPersona->setEstadocivil($request->getParameter('estadocivil'));
		$oPersona->setIdciudadnac($request->getParameter('ciudadnacimiento'));
		$oPersona->setFechanac($fechanacimiento);
		$oPersona->save();
		
		echo json_encode(array("idpersona"=>$oPersona->getIdpersona(),"mensaje"=>"La persona ha sido guardado correctamente."));
	
		return sfView::NONE;
	}

	public function executeGuardarinformacionrelevante(sfWebRequest $request) {
		
		if($request->getParameter('idpersona')){
			$oPersona = Doctrine::getTable('Personas')->find($request->getParameter('idpersona'));
			$oPersona->setOtrainformacionrelevante($request->getParameter('informacionrelevante'));
		    $oPersona->save();
		    echo json_encode(array("idpersona"=>$request->getParameter('idpersona'),"mensaje"=>"La información ha sido guardado correctamente."));
		} else {
			echo json_encode(array("idpersona"=>"","mensaje"=>"La información no pudo ser guardada."));
	
		}
		
		return sfView::NONE;
	}
	
	public function executeModificar(sfWebRequest $request)	{
		// Busca si existe la persona
		$this->idpersona = $request->getParameter('idpersona');
		$oPersona = Doctrine_Core::getTable('Personas')->find($this->idpersona);
	
		$this->form = new InscripcionesAspiranteForm();
		$this->email = 0;
		$this->activo = 0;
	
		// Si existe obtiene todos los datos personales y los muestra en pantalla
		$this->form->setDefault('idpersona', $this->idpersona);
		$this->form->setDefault('idtipodocumento', $oPersona->getIdtipodoc());
		$oTipoDocumento = Doctrine_Core::getTable('TiposDocumentos')->find($oPersona->getIdtipodoc());
		$this->form->setDefault('tipodocumento', $oTipoDocumento->getDescripcion()."(".$oTipoDocumento->getPaises()->getAbreviacion().")");
		if($oPersona->getNumerodoc()) {
			$this->form->setDefault('nrodocumento', $oPersona->getNumerodoc());
		} else {
			$this->form->setDefault('nrodocumento', $oPersona->getNrodoc());
		}
	
		$this->form->setDefault('nombre', $oPersona->getNombre());
		$this->form->setDefault('apellido', $oPersona->getApellido());
		$this->form->setDefault('idsexo', $oPersona->getIdsexo());
		$this->form->setDefault('estadocivil', $oPersona->getEstadocivil());
		$this->idciudadnac = $oPersona->getIdciudadnac();
		$oCiudadNacimiento = Doctrine_Core::getTable('Ciudades')->find($this->idciudadnac);
		$oProvinciaNacimiento = Doctrine_Core::getTable('Provincias')->find($oCiudadNacimiento->getIdprovincia());
		$this->idprovincianac = $oProvinciaNacimiento->getIdprovincia();
		$oPaisNacimiento = Doctrine_Core::getTable('Paises')->find($oProvinciaNacimiento->getIdpais());
		$this->idpaisnac = $oPaisNacimiento->getIdpais();
		$arr = explode('-', $oPersona->getFechanac());
		$this->form->setDefault('fechanacimiento', $arr[2]."-".$arr[1]."-".$arr[0]);
	
		// Obtiene el contecto de la persona
		$oContacto = $oPersona->getContacto();
		if($oContacto){
			$this->form->setDefault('nombrecalle', $oContacto->getCallee());
			$this->form->setDefault('nrocalle', $oContacto->getNumeroe());
			$this->form->setDefault('barrio', $oContacto->getBarrioe());
			$this->form->setDefault('edificio', $oContacto->getEdificioe());
			$this->form->setDefault('piso', $oContacto->getPisoe());
			$this->form->setDefault('depto', $oContacto->getDeptoe());
			$this->idciudadres = $oContacto->getIdciudade();
			if(($this->idciudadres != 0) && ($this->idciudadres != NULL)) {
				$oCiudadResidencia = Doctrine_Core::getTable('Ciudades')->find($this->idciudadres);
				$oProvinciaResidencia = Doctrine_Core::getTable('Provincias')->find($oCiudadResidencia->getIdprovincia());
				$this->idprovinciares = $oProvinciaResidencia->getIdprovincia();
				$oPaisResidencia = Doctrine_Core::getTable('Paises')->find($oProvinciaResidencia->getIdpais());
				$this->idpaisres = $oPaisResidencia->getIdpais();
			} else {
				$this->idciudadres = 0;
			}
			$this->form->setDefault('areatelefonofijo', $oContacto->getTelefonofijocar());
			$this->form->setDefault('nrotelefonofijo', $oContacto->getTelefonofijonum());
			$this->form->setDefault('areatelefonomovil', $oContacto->getCelularcar());
			$this->form->setDefault('nrotelefonomovil', $oContacto->getCelularnum());
			$this->form->setDefault('email', $oContacto->getEmail());
			$this->form->setDefault('email1', $oContacto->getEmail1());
			if ($oContacto->getEmail1() != NULL) {
				$this->email = 1;
			}
		} else {
			$this->idciudadres = 0;
		}
	}
		
	// Obtiene los estudios previos de la persona
	public function executeObtenerestudiosprevios(sfWebRequest $request)	{
		$persona = Doctrine_Core::getTable('Personas')->find($request->getParameter('idpersona'));
		$this->alumno = Doctrine_Core::getTable('Alumnos')->find($request->getParameter('idalumno'));
		// Obtiene los estudios previos de la persona					
		$this->estudiosprevios = $persona->getEstudiosPrevios();			
	}

	// Obtiene los estudios previos de la persona
	public function executeGetallestudiosprevios(sfWebRequest $request)	{
		$persona = Doctrine_Core::getTable('Personas')->find($request->getParameter('idpersona'));
		//$persona = Doctrine_Core::getTable('Personas')->find(18133);
		//$this->alumno = Doctrine_Core::getTable('Alumnos')->find($request->getParameter('idalumno'));
		// Obtiene los estudios previos de la persona					
		$this->estudiosprevios = $persona->getEstudiosPrevios();			
	}
	
	public function executeBuscar(sfWebRequest $request)
	{
		$this->form = new BuscarAlumnosForm(array(
			'url' => $this->url,
		    'titulo' => $this->titulo,
			'tipo' => $this->tipo,				
			'referer' => $request->getGetParameter('referer', str_replace($request->getUriPrefix(), '', $request->getUri()))
		));	

		if ($request->isMethod('post')) {
			$this->form->bind($request->getParameter($this->form->getName()));

			if ($this->form->isValid())	{
				$arreglo = $request->getParameter($this->form->getName());
				
        		$this->idplanestudio = $arreglo['idplanestudio'];
        		$this->tipocriterio = $arreglo['tipocriterio'];
        		$this->criterio = $arreglo['criterio'];
        		$this->titulo = $arreglo['titulo'];
        		$this->tipo = $arreglo['tipo'];
        	
  				$this->resultado = Doctrine_Core::getTable('Alumnos')->buscarPersonas($this->tipocriterio, $this->criterio, $this->idplanestudio, $this->getUser()->getProfile()->getIdsede(), $this->tipo);			
			}
		} else {
			$this->resultado = array();
		}
	}

	public function executeBuscarcobrador(sfWebRequest $request)
	{
		$this->form = new BuscarAlumnosForm(array(
			'url' => $this->url,
		    'titulo' => $this->titulo,
			'tipo' => $this->tipo,				
			'referer' => $request->getGetParameter('referer', str_replace($request->getUriPrefix(), '', $request->getUri()))
		));	

		if ($request->isMethod('post')) {
			$this->form->bind($request->getParameter($this->form->getName()));

			if ($this->form->isValid())	{
				$arreglo = $request->getParameter($this->form->getName());
				
        		$this->idplanestudio = $arreglo['idplanestudio'];
        		$this->tipocriterio = $arreglo['tipocriterio'];
        		$this->criterio = $arreglo['criterio'];
        		$this->titulo = $arreglo['titulo'];
        		$this->tipo = $arreglo['tipo'];
        	
  				$this->resultado = Doctrine_Core::getTable('Alumnos')->buscarCobrador($this->tipocriterio, $this->criterio, $this->idplanestudio, $this->getUser()->getProfile()->getIdsede(), $this->tipo);			
			}
		} else {
			$this->resultado = array();
		}
	}

	
	public function executeBuscarcertificado(sfWebRequest $request)
	{
		$this->form = new BuscarAlumnosForm(array(
			'url' => $this->url,
		    'titulo' => $this->titulo,
			'tipo' => $this->tipo,				
			'referer' => $request->getGetParameter('referer', str_replace($request->getUriPrefix(), '', $request->getUri()))
		));	

		if ($request->isMethod('post')) {
			$this->form->bind($request->getParameter($this->form->getName()));

			if ($this->form->isValid())	{
				$arreglo = $request->getParameter($this->form->getName());
				
        		$this->idplanestudio = $arreglo['idplanestudio'];
        		$this->tipocriterio = $arreglo['tipocriterio'];
        		$this->criterio = $arreglo['criterio'];
        		$this->titulo = $arreglo['titulo'];
        		$this->tipo = $arreglo['tipo'];
        	
  				$this->resultado = Doctrine_Core::getTable('Alumnos')->buscarAlumnos($this->tipocriterio, $this->criterio, $this->idplanestudio, $this->getUser()->getProfile()->getIdsede(), $this->tipo);			
			}
		} else {
			$this->resultado = array();
		}
	}

  
  public function executeUpdatecobrador(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($personas = Doctrine_Core::getTable('Personas')->find(array($request->getParameter('idpersona'))), sprintf('Object personas does not exist (%s).', $request->getParameter('idpersona')));
    $this->form = new CobradoresForm($personas);

    $this->processcobradorForm($request, $this->form);

    $this->setTemplate('editcobrador');

  }

  public function executeCreatecobrador(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new CobradoresForm();

    $this->processcobradorForm($request, $this->form);

    $this->setTemplate('newcobrador');
  }


  public function executeIndex(sfWebRequest $request)
  {
    $this->personass = Doctrine_Core::getTable('Personas')
      ->createQuery('a')
      ->execute();
  }

  public function executeNew(sfWebRequest $request)
  {
     // Redirige al inicio si no tiene acceso
     if (!$this->getUser()->getGuardUser()->getIsSuperAdmin())
     	$this->redirect('ingreso');
     

     $this->form = new PersonasForm();
    
  }

  public function executeNewcobrador(sfWebRequest $request)
  {
    $this->form = new CobradoresForm();
    $this->form->setDefault('socio', 0);  
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new PersonasForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    
    // Redirige al inicio si no tiene acceso
    if (!$this->getUser()->getGuardUser()->getIsSuperAdmin())
     	$this->redirect('ingreso');
 
    
    $this->forward404Unless($personas = Doctrine_Core::getTable('Personas')->find(array($request->getParameter('idpersona'))), sprintf('Object personas does not exist (%s).', $request->getParameter('idpersona')));
    $this->form = new PersonasForm($personas);
  }

  public function executeEditcobrador(sfWebRequest $request)
  {
    $this->forward404Unless($personas = Doctrine_Core::getTable('Personas')->find(array($request->getParameter('idpersona'))), sprintf('Object personas does not exist (%s).', $request->getParameter('idpersona')));
    $this->form = new CobradoresForm($personas);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($personas = Doctrine_Core::getTable('Personas')->find(array($request->getParameter('idpersona'))), sprintf('Object personas does not exist (%s).', $request->getParameter('idpersona')));
    $this->form = new PersonasForm($personas);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
     
    // Redirige al inicio si no tiene acceso
    if (!$this->getUser()->getGuardUser()->getIsSuperAdmin())
     	$this->redirect('ingreso');
 

    $request->checkCSRFProtection();

    $this->forward404Unless($personas = Doctrine_Core::getTable('Personas')->find(array($request->getParameter('idpersona'))), sprintf('Object personas does not exist (%s).', $request->getParameter('idpersona')));
    $personas->delete();

    $this->redirect('personas/index');
  }

  public function executeGetanalitico(sfWebRequest $request) {

    // **********************************
    // Obtener Analitico Final
    //***********************************
    
    $soapclient = new nusoap_client("http://prueba.com");
  
    //llamamos la función implementada en el server.php de la siguiente manera
    $resultado = $soapclient->call('getpersona',array( 'value'=> $request->getParameter('idp')));
    $this->persona = unserialize(base64_decode($resultado));
         
    $this->analitico = ""; 
  
    if ($request->getParameter('idc')){
      $analitico = $soapclient->call('obteneranalitico',array( 'idp'=> $request->getParameter('idp'),  'idc'=> $request->getParameter('idc')));
      $analitico_final = unserialize(base64_decode($analitico));
    }

    //***********************************  
    $config = sfTCPDFPluginConfigHandler::loadConfig();
 
    // pdf object
    $pdf = new sfTCPDF("P", "mm", "A4", true, 'UTF-8', false);  
   // $pdf = new sfTCPDF();
        
    // settings
    $pdf->SetFont("Times", "", 9);

    //$pdf->AddFont('SerifaBT','','serifabt.php');
    // set header and footer fonts  
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
      
    // set default monospaced font  
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);  
      
    //set margins  
    $pdf->SetMargins(PDF_MARGIN_LEFT-5, PDF_MARGIN_TOP-17, PDF_MARGIN_RIGHT + 10);  
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER-20);  
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER-35);  
      
    //set auto page breaks  
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM-25);  

    // sentencias para retirar encabezados y pie por defecto
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);  
        
    // add a page
    $pdf->AddPage();
                
    $encabezado = '<br><div style="text-align: center; width: 850px; font-family: Times New Roman,Times,serif;"><span
      style="font-size: 12;"><img src="'.$request->getRelativeUrlRoot().'/images/CabeceraSIG-UCU.jpg" width="850px">
      CERTIFICADO ANALITICO PARCIAL '.'</div>'; 

    $conste = '
      <div style="text-align: left; font-family: Times New Roman,Times,serif;"><span
      style="font-size: 10;"> CONSTE que APELLIDO, Nombre, DNI Nº 18123123 alumno de la carrera CARRERA, que se dicta en la FACULTAD perteneciente a la Universidad de Concepción del Uruguay, ha aprobado las asignaturas que a continuación se detallan: '.'</div>';          
  
    $pdf->writeHTML($encabezado, true, false, true, false, '');

    $pdf->SetXY(180,0);
    $pdf->SetFont("Times", "", 14);
    $pdf->Cell(10,50,'Facultad Ciencias Juridicas',0,0,'R');
    $pdf->SetXY(180,5);
    $pdf->Cell(10,52,'Abogacia',0,0,'R');
    $pdf->SetFont("Times", "", 9); 

    $pdf->SetXY(10,45);
    $pdf->writeHTML($conste, true, false, true, false, '');
    $pdf->SetXY(10,57); 
    $pdf->Cell(20,10,'FECHA',0,0,'L');    
    $pdf->SetXY(25,57);
    $pdf->Cell(20,10,'ASIGNATURA',0,0,'L');    
    $pdf->SetXY(130,57);
    $pdf->Cell(20,10,'CALIFICACION',0,0,'L');    
    $pdf->SetXY(160,57);
    $pdf->Cell(20,10,'LIBRO',0,0,'L');    
    $pdf->SetXY(176,57);
    $pdf->Cell(20,10,'FOLIO',0,0,'L');    

    $oAreas = new Areas();
    $oAlumnos=$oAreas->obtenerAspirantesCicloArea($this->getUser()->getAttribute('cohorte'),$this->getUser()->getProfile()->getIdarea(),$this->getUser()->getProfile()->getIdsede());
    
    $y=60;
    $arrYears = array (1 => "Primer año", 2 => "Segundo año", 3 => "Tercer año", 4 => "Cuarto año",  5 => "Quinto año", 6 => "Sexto año");
    $anioactual = 0; $sumanotas = 0; $cantidad = 0; $canti = 0; $contador = 0;
     

    // SI existen registros de materias asociados al Alumno
    if($analitico_final){
        foreach ($analitico_final as $notas){  

             // Determinar año actual
             if ($anioactual != $notas['curso']) {
                $anioactual = $notas['curso'];  
                $pdf->SetLineWidth(0.7);
                $pdf->SetFont('', 'B');
                $pdf->Line(9,$y+6,199,$y+6);
                $pdf->Line(9,$y+12,199,$y+12); 
                $y=$y+5;
                $pdf->SetXY(0,$y-2);
                //Se muestra una etiqueta con el año
                $pdf->Cell(200,10,$arrYears[$anioactual],0,0,'C');
                $pdf->SetFont('');      
             }
           
                                   
            $y=$y+4;
            $pdf->SetXY(0,$y-4);
                  
            $pdf->SetXY(10,$y);        
            $pdf->Cell(10,10, $notas['fecha']); 
            $pdf->SetXY(30,$y);        
            $pdf->Cell(10,10, $notas['nombre']);  
            $pdf->SetXY(140,$y);        
            $pdf->Cell(10,10, $notas['calificacion']." ".$notas['nota']);  
            $pdf->SetXY(160,$y);        
            $pdf->Cell(10,10, $notas['Libro']);  
            $pdf->SetXY(180,$y);        
            $pdf->Cell(10,10, $notas['folio']);  
            $pdf->Line(9,$y+10,199,$y+10); 
                     
            $y=$y+4; 
            $contador++; $contadortotal++;
            $sumanotas+=$notas['calificacion'];

          // chequeo que la cantidad de registros por pagina sea 50 (if*3)
              if ($contador==23){

                 $contador=1;
 
                 $this->Pie($pdf, 1);

                // add a page
                 $pdf->AddPage();

                 $pdf->SetFont("Times", "", 9);
                              
                 $pdf->writeHTML($encabezado, true, false, true, false, '');
    
                 $pdf->SetXY(170,0);
                 $pdf->SetFont("Times", "", 12);
                 $pdf->Cell(10,50,'Facultad Ciencias Juridicas',0,0,'R');
                 $pdf->SetXY(170,5);
                 $pdf->Cell(10,50,'Abogacia',0,0,'R');
                 $pdf->SetFont("Times", "", 9);


                 $pdf->SetXY(10,45);
                 $pdf->writeHTML($conste, true, false, true, false, '');
                 $pdf->SetXY(10,57); 
                 $pdf->Cell(20,10,'FECHA',0,0,'L');    
                 $pdf->SetXY(25,57);
                 $pdf->Cell(20,10,'ASIGNATURA',0,0,'L');    
                 $pdf->SetXY(130,57);
                 $pdf->Cell(20,10,'CALIFICACION',0,0,'L');    
                 $pdf->SetXY(160,57);
                 $pdf->Cell(20,10,'LIBRO',0,0,'L');    
                 $pdf->SetXY(176,57);
                 $pdf->Cell(20,10,'FOLIO',0,0,'L');   

                 $y=60;   
              }                 
  
    
        } // end foreach
        $pdf->SetXY(160,$y+10);
        $promedio=number_format($sumanotas / $contadortotal, 2);
        $pdf->Cell(50,10,'CANTIDAD TOTAL:'.$contadortotal,0,0,'L'); 
        $pdf->SetXY(160,$y+16);
        $pdf->Cell(50,10,'PROMEDIO:'.$promedio,0,0,'L'); 
    
    } // fin (if*1)
      
    $this->Pie($pdf, 1);

    $pdf->Output('planilla.pdf', 'I');
 
    // stop symfony process
    throw new sfStopException();
    
      return sfView::NONE;        
    
    
               
  }   

  function Pie($_pdf, $idArea)
  {
      
    // Rectangulo Página completa
    $_pdf->Rect(9,15,190,281);
    
    //Asigna el ancho de la linea
    $_pdf->SetLineWidth(0);
    // Linea horizontal que separa el pie y el documento
    $_pdf->Line(9,284,199,284);
    $_pdf->SetY(-14);
    
    // Muestra la imagen del Logo de la UCU con direccion dependientdo de parametro 
    if (($idArea==25) or ($idArea==21) or ($idArea==20) or ($idArea==18) or ($idArea==4)) {
        $_pdf->Image('images/PieSIG-UCU-GCHU.jpg',11,285,188);
    } elseif ($idArea==17) {
        $_pdf->Image('images/PieSIG-UCU-VGUAY.jpg',11,285,188);
    } else {
       $_pdf->Image('images/PieSIG-UCU.jpg' , 10, 285, 180, 8, '', '', '', true, 100);
    }
    
      // Set font
    $_pdf->SetFont('helvetica', 'I', 8);
    // Page number
    $_pdf->Cell(0, 10, 'Página '.$_pdf->PageNo().'/{nb}', 0, false, 'L', 0, '', 0, false, 'T', 'M');
  

}

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
   // var_dump($request->getParameterHolder()->getAll());
    //echo "ver".$request->getPostParameter('personas[apellido]');
   
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $personas = $form->save();
      $nrodoc = preg_replace("/[^\d]/", "", $personas->getNumeroDoc());
      $personas->setNroDoc($nrodoc);
      $personas->setIdtipodoc($request->getPostParameter('personas[idtipodoc]'));
      $personas->setIdusuario($request->getPostParameter('personas[idusuario]'));
      if ($request->getPostParameter('personas[mostrarinfoemail]') == 'on') {
   			$personas->setMostrarinfoemail(1);
      } else {
   			$personas->setMostrarinfoemail(0);
      }
      if ($request->getPostParameter('personas[mostrarinfocelular]') == 'on') {
   			$personas->setMostrarinfocelular(1);
      } else {
   			$personas->setMostrarinfocelular(0);
      }
      $personas->setIdsexo($request->getPostParameter('personas[idsexo]'));
      $personas->save();
      

      $folder_path_name = sfConfig::get('app_pathfiles_folder')."/profesionales/".$personas->getIdpersona();
      
      if (!is_dir($folder_path_name) && !mkdir($folder_path_name)){
          die("Error creando carpeta $uploaddir");
      }

      foreach ($request->getFiles() as $fileName) {
      	   $targetFolder = sfConfig::get('app_pathfiles_folder')."/profesionales/".$personas->getIdpersona().'/'.$fileName['imagefile']['name'];
      	  // echo $targetFolder;
      	   //$fileSize = $fileName['imagefile']['size'];
		   //$fileType = $fileName['imagefile']['type'];
		   //$theFileName = $fileName['imagefile']['name'];
		   move_uploaded_file($fileName['imagefile']['tmp_name'], $targetFolder);
		 
		}
		$personas->setImagefile($fileName['imagefile']['name']);
		$personas->save();
		
        $this->redirect('personas/edit?idpersona='.$personas->getIdpersona());
    }
  }

  protected function processcobradorForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $personas = $form->save();
      $nrodoc = preg_replace("/[^\d]/", "", $personas->getNumeroDoc());
      $personas->setNroDoc($nrodoc);
      $personas->setSocio(false);
      $personas->save();

      $this->redirect('personas/editcobrador?idpersona='.$personas->getIdpersona());
    }
  }
}

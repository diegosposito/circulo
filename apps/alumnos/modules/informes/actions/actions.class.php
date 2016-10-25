<?php

/**
 * aspirante actions.
 *
 * @package    sig
 * @subpackage aspirante
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class informesActions extends sfActions
{
	public function executeObtenerofertaacademica(sfWebRequest $request)
	{
		$this->carreras = Doctrine_Core::getTable('Carreras')->obtenerOfertaAcademica();
	}

	public function executeAutoridades(sfWebRequest $request)
	{
	    $this->autoridadess = Doctrine_Core::getTable('Autoridades')
	      ->createQuery('a')
	      ->innerJoin('a.CargoAutoridades ca')
	      ->orderBy('ca.orden')
	      ->execute();
	}

	public function executeAutoridadespdf(sfWebRequest $request){

		$oAutoridades = Doctrine_Core::getTable('Autoridades')->obtenerAutoridades();

		// pdf object
		$pdf = new PDF('P');

    	// settings
		$pdf->SetFont("Times", "", 9);
		// sentencias para retirar encabezados y pie por defecto
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false); 

		$entidad='NULL';
 
        // add a page
		$pdf->AddPage();
		$current_date = date("Y");
		$encabezado = '
			<div style="text-align: center; font-family: Times New Roman,Times,serif;"><span
			style="font-size: 12;"><img src="'.$request->getRelativeUrlRoot().'/images/headerlogo2.png" height="70px" width="550px">
			<b>Autoridades:</b> '.$current_date.'</div>';        

		$pdf->writeHTML($encabezado, true, false, true, false, '');   
		
		$y = 45;
		
		foreach ($oAutoridades as $oautoridad){	

	    	if($entidad<>$oautoridad['entidad']){
                $entidad=$oautoridad['entidad'];
	    		$pdf->SetXY(10,$y);
	    		$pdf->SetFont('Times','B',10);
	    		$pdf->Cell(56,10,$oautoridad['entidad'],0,0,'L'); 
	    		$pdf->SetFont('Times','',10);   
				$y = $y + 9;
				$pdf->Line(10,$y,190,$y);
				$contador = 1;
	    	}
		    			    		
		   	$pdf->SetXY(0,$y-5);
            $pdf->SetXY(10,$y);
		    $pdf->Cell(15,5,$oautoridad['autoridad'],0,0,'L');
		   
 			$y = $y + 5;  
		 	// add a page
			if($y>=265) {
				$pdf->AddPage();
 
				$pdf->writeHTML($encabezado, true, false, true, false, '');   
				$y=60;

			}
	
		    } // fin (foreach)	

			 
		$pdf->Output('planilla.pdf', 'I');
 
		// stop symfony process
		throw new sfStopException();
				
		return sfView::NONE;
  } 
  
  public function executeSaludent(sfWebRequest $request)
	{
	    $this->practicass = Doctrine_Core::getTable('Practicas')
	      ->createQuery('p')
	      ->innerJoin('p.TipoPracticas tp')
	      ->orderBy('tp.orden, p.codigo')
	      ->execute();
	}

	public function executeObtenerpersonalnodocente(sfWebRequest $request)
	{
		$this->autoridades = Doctrine_Core::getTable('DesignacionesEmpleados')->obtenerAutoridades();
	}	
	
	public function executeBuscarciclolectivo(sfWebRequest $request)	
	{
		$this->mensaje = "";
		$this->form = new BuscarCiclosLectivosForm();
	}

	public function executeMostrararchivos(sfWebRequest $request)
   {
    
    $currentUser = sfContext::getInstance()->getUser();

    if (!$currentUser->isAuthenticated()) {
   		$this->redirect('guard/login');
   	}
  
    $this->obras_sociales = Doctrine_Core::getTable('ObrasSociales')->find(array($request->getParameter('idobrasocial')));
   // $this->obras_sociales = Doctrine_Core::getTable('ObrasSociales')->find(array(1));
    $this->forward404Unless($this->obras_sociales);

    if(count($_FILES['upload']['name']) > 0){
        //Loop through each file
        for($i=0; $i<count($_FILES['upload']['name']); $i++) {
          //Get the temp file path
            $tmpFilePath = $_FILES['upload']['tmp_name'][$i];
            
            

            //Make sure we have a filepath
            if($tmpFilePath != ""){
            
                //save the filename
                $shortname = $_FILES['upload']['name'][$i];

                //save the url and the file
                //$filePath = "/tmp/uploaded/" . date('d-m-Y-H-i-s').'-'.$_FILES['upload']['name'][$i];
               // $filePath = sfConfig::get('app_pathfiles_folder')."/".$obras_sociales->getIdobrasocial();
                $filePath = sfConfig::get('app_pathfiles_folder')."/".$this->obras_sociales->getIdObrasocial()."/".$shortname;

                //Upload the file into the temp dir
                if(move_uploaded_file($tmpFilePath, $filePath)) {

                    $files[] = $shortname;
                    //insert into db 
                    //use $shortname for the filename
                    //use $filePath for the relative url to the file

                }
            }// endif
        } // endfor
    } // end if

    // listar archivos de la carpeta
    $directorio = sfConfig::get('app_pathfiles_folder')."/".$this->obras_sociales->getIdObrasocial();
    $gestor_dir = opendir($directorio);
    $this->ficheros = array();
    while (false !== ($nombre_fichero = readdir($gestor_dir))) {
      
      $image_file = 'image.png';
      switch (pathinfo($nombre_fichero, PATHINFO_EXTENSION)) {
          case 'pdf':
              $image_file = 'pdf.png';
              break;
          case 'doc':
              $image_file = 'word.png';
              break;
          case 'docx':
              $image_file = 'word.png';
              break;
          case 'xls':
              $image_file = 'excel.png';
              break;        
          case 'xlsx':
              $image_file = 'excel.png';
              break;
          case 'txt':
              $image_file = 'wordpad.png';
              break;    
      }

      $this->ficheros[] = array($nombre_fichero, $this->obras_sociales->getIdObrasocial()."/".$nombre_fichero, $image_file);
    }
    sort($this->ficheros);

  } // end function

	public function executeObrassociales(sfWebRequest $request)
	{
	    $this->obras_socialess = Doctrine_Core::getTable('ObrasSociales')
	      ->createQuery('a')
	      ->orderBy('a.ninterno')
	      ->execute();
	}

	public function executeProfesionales(sfWebRequest $request)
	{
	    $this->profesionaless = Doctrine_Core::getTable('Personas')
	      ->createQuery('a')
	      ->orderBy('a.ciudad, a.apellido, a.nombre')
	      ->execute();
	}
	
	public function executeBuscarciclolectivoacad(sfWebRequest $request)	
	{
		$this->mensaje = "";
		$this->form = new BuscarCiclosLectivosAcadForm();
	}
	
	public function executeBuscaralumnosestados(sfWebRequest $request)	
	{
		$this->mensaje = "";
		$this->form = new BuscarEstadosCiclosLectivosForm();
	}
	
	public function executeBuscaraspirantes(sfWebRequest $request)	
	{
		$this->mensaje = "";
		$this->form = new BuscarAspirantesForm();
	}     

	public function executeBuscaraspirantespreuniversitario(sfWebRequest $request)	
	{
		$this->mensaje = "";
		$this->form = new BuscarAspirantesForm();
	}   

	public function executeBuscar(sfWebRequest $request)
	{
		$this->form = new BuscarCarrerasForm();
	}

	public function executeBuscaralu(sfWebRequest $request)
	{
		$this->form = new BuscarCarrerasForm();
	}
	
	public function executeBuscarplancorrelatividades(sfWebRequest $request)
	{
		$this->form = new BuscarCarrerasForm();
	}
	
	public function executeBuscarplanes(sfWebRequest $request)
	{
		$this->form = new BuscarCarrerasForm();
	}		
	
	public function executeControlgeneral(sfWebRequest $request)
	{
		$this->form = new BuscarCarrerasForm();
	}

	public function executeControlautogestion(sfWebRequest $request)
	{
		$this->form = new BuscarCarrerasForm();
	}

	public function executeAlumnossincuenta(sfWebRequest $request)
	{
		$this->form = new BuscarCarrerasForm();
	}

	public function executeObteneralumnos(sfWebRequest $request) 
	{
		$this->planestudio = Doctrine_Core::getTable('PlanesEstudios')->find($request->getParameter('idplanestudio'));
		$this->alumnos = $this->planestudio->obtenerAlumnosUltimoAnioAprobado();
	}	

	public function executeObtenerMateriasAprobadasPorPlanEstudio(sfWebRequest $request) 
	{
		$this->planestudio = Doctrine_Core::getTable('PlanesEstudios')->find($request->getParameter('idplanestudio'));
		$this->alumnos = $this->planestudio->obtenerCantidadesMateriasAprobadasPorPlanEstudio();
	}
	
	public function executeObteneraspirantes(sfWebRequest $request) 
	{
		$oAreas = new Areas();
		$this->alumnosinscriptospre = array();
        if ($request->getParameter('idciclo')) { 
        	$this->idciclo = $request->getParameter('idciclo');
        	$oCicloLectivo = Doctrine_Core::getTable('CiclosLectivos')->find($this->idciclo);
			$this->ciclo = $oCicloLectivo->getCiclo(); 
			//$this->alumnos = $oAreas->obtenerAspirantesCicloArea($this->idciclo,$this->getUser()->getProfile()->getIdarea(),$this->getUser()->getProfile()->getIdsede());
			$this->alumnos = $oAreas->obtenerAlumnosCicloActivos($this->idciclo,$this->getUser()->getProfile()->getIdarea(),$this->getUser()->getProfile()->getIdsede());		
		}	
      } 
		
	public function executeInformeaspirantesciclo(sfWebRequest $request) 
	{
		$this->getUser()->setAttribute('idciclo',$request->getParameter('idciclo'));
  	
		switch ($request->getParameter('listado')) {
		    case 1:
		    	// 1 Listado de Aspirantes por Carrera
				$this->executeAspirantescarrerapdf($request);			        
		        break;
		    case 2:
		    	// 2 Listado de Aspirantes por Comision
		        $this->executeAspirantescomisionpdf($request);
		        break;		
		    case 3:
		    	// 3 Listado de Aspirantes por Sede
		        $this->executeAspirantessedepdf($request);
		        break;			        
		    case 4:
		    	// 4 Listado de Aspirantes para Seguro
   		        $this->executeListadoparaseguropdf($request);			    	
		        break; 
		    case 5:
		    	// 5 Planilla de Asistencia PreUniversitario
   		        $this->executeAsistenciapreuniversitariopdf($request);		        
		        break; 		
		    case 6:
		    	// 6 Planilla de TP PreUniversitario
		        $this->executeTppreuniversitariopdf($request);
		        break; 
		    case 7:
		    	// 7 Planilla de Evaluacion PreUniversitario por Fecha
		        $this->executeEvaluacionpreuniversitarioporfechapdf($request);		        
		        break; 		
		    case 8:
		    	// 8 Planilla de Evaluacion PreUniversitario por Carrera
		        $this->executeEvaluacionpreuniversitarioporcarrerapdf($request);
		        break; 	
		    case 9:
		    	// 9 Planilla de Aspirantes (Excel)
		        $this->executeListadoparasegurocsv($request);
		        break; 	  
		    case 10:
				// 10 Listado de Inscriptos a Pre-Universitario
				$this->executeInscriptosCursoAnticipadopdf($request);
				break;		 
		    case 11:
				// 10 Listado Usuarios SAO Autogestion
				$this->executeSaoAutogestionpdf($request);
				break;	
		    case 12:
				// 10 Listado de Inscriptos a Pre-Universitario
				$this->executeInscriptosPreuniversitariopdf($request);
				break;	             
		}       
	}	  

	public function executeInformeaspirantescicloacad(sfWebRequest $request) 
	{
		$this->getUser()->setAttribute('idciclo',$request->getParameter('idciclo'));
  	
		switch ($request->getParameter('listado')) {
		    case 1:
		    	// 1 Listado de Aspirantes por Carrera
				$this->executeAspirantescarreraacadpdf($request);			        
		        break;            
		}       
	}	

	public function executeInformealumnosestadociclo(sfWebRequest $request) 
	{
		$this->getUser()->setAttribute('idciclo',$request->getParameter('idciclo'));
		$this->getUser()->setAttribute('idestado',$request->getParameter('idestado'));
  	
		switch ($request->getParameter('listado')) {
		    case 1:
		    	// 1 Listado por Carrera
				$this->executeRegistrosEstadosPorCiclopdf($request);			        
		        break;
		}       
	}	

	public function executeObrassocialespdf(sfWebRequest $request){

		$oObrasSociales = Doctrine_Core::getTable('ObrasSociales')->obtenerObrasSociales();

		// pdf object
		$pdf = new PDF();

    	// settings
		$pdf->SetFont("Times", "", 10);
		// sentencias para retirar encabezados y pie por defecto
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false); 
 
        // add a page
		$pdf->AddPage();
		$current_date = date("Y");
		$encabezado = '
			<div style="text-align: center; font-family: Times New Roman,Times,serif;"><span
			style="font-size: 12;"><img src="'.$request->getRelativeUrlRoot().'/images/headerlogo2.png" height="70px" width="850px">
			<b>Obras Sociales:</b> '.$current_date.'</div>';        

		$pdf->writeHTML($encabezado, true, false, true, false, '');   
		
		$y = 45;
		$pdf->SetXY(10,$y);
		$pdf->Cell(15,5,'Obra Social',0,0,'C');    
		$pdf->SetXY(68,$y);
		$pdf->Cell(120,5,'Abrev.',0,0,'C');    
		$pdf->SetXY(66,$y);
		$pdf->Cell(200,5,'General',0,0,'C'); 
		$pdf->SetXY(62,$y);
		$pdf->Cell(268,5,'Prótesis',0,0,'C'); 
		$pdf->SetXY(80,$y);
		$pdf->Cell(299,5,'Ortodoncia',0,0,'C'); 
		$pdf->SetXY(85,$y);
		$pdf->Cell(350,5,'Implantes',0,0,'C'); 
		$pdf->SetXY(20,$y);
		$y = $y + 5;		
		$contador = 1;
		
		$pdf->Line(10,$y,280,$y);
		
	    foreach ($oObrasSociales as $osocial){	
		    			    		
		   	$pdf->SetXY(0,$y-5);
            $pdf->SetXY(10,$y);
		    $pdf->Cell(15,5,$osocial['denominacion'],0,0,'L');
		    $pdf->SetXY(123,$y);        
		    $pdf->Cell(100,5,$osocial['abreviada'],0,0,'L');        
		    $pdf->SetXY(160,$y); 
		    $pdf->Cell(10,5,$osocial['general']==1 ? 'Habilitada' : 'No Habilitada',0,0,'L'); 
		    $pdf->SetXY(190,$y); 
		    $pdf->Cell(10,5,$osocial['protesis']==1 ? 'Habilitada' : 'No Habilitada',0,0,'L'); 
		    $pdf->SetXY(220,$y); 
		    $pdf->Cell(10,5,$osocial['ortodoncia']==1 ? 'Habilitada' : 'No Habilitada',0,0,'L'); 
		    $pdf->SetXY(250,$y); 
		    $pdf->Cell(10,5,$osocial['implantes']==1 ? 'Habilitada' : 'No Habilitada',0,0,'L'); 
		    
		
 			$y = $y + 5;  
		 	// add a page
			if($y>=180) {
				$pdf->AddPage();
	
				$pdf->writeHTML($encabezado, true, false, true, false, '');   
				$y=45;

				$pdf->SetXY(10,$y);
				$pdf->Cell(15,5,'Obra Social',0,0,'C');    
				$pdf->SetXY(68,$y);
				$pdf->Cell(120,5,'Abrev.',0,0,'C');    
				$pdf->SetXY(66,$y);
				$pdf->Cell(200,5,'General',0,0,'C'); 
				$pdf->SetXY(62,$y);
				$pdf->Cell(268,5,'Prótesis',0,0,'C'); 
				$pdf->SetXY(80,$y);
				$pdf->Cell(299,5,'Ortodoncia',0,0,'C'); 
				$pdf->SetXY(85,$y);
				$pdf->Cell(350,5,'Implantes',0,0,'C'); 
				$pdf->SetXY(20,$y);
				$y = $y + 5;		
				$contador = 1;
				$pdf->Line(10,$y,280,$y);

			}
	
		    } // fin (foreach)	

			 
		$pdf->Output('planilla.pdf', 'I');
 
		// stop symfony process
		throw new sfStopException();
				
		return sfView::NONE;
  } 

  public function executeProfesionalespdf(sfWebRequest $request){

  	  	$oPersonas = Doctrine_Core::getTable('Personas')->obtenerProfesionales(1);

		// pdf object
		$pdf = new PDF();

    	// settings
		$pdf->SetFont("Times", "", 11);
		// sentencias para retirar encabezados y pie por defecto
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false); 
 
        // add a page
		$pdf->AddPage();
		$current_date = date("Y");
		$encabezado = '
			<div style="text-align: center; font-family: Times New Roman,Times,serif;"><span
			style="font-size: 12;"><img src="'.$request->getRelativeUrlRoot().'/images/headerlogo2.png" height="70px" width="850px">
			<b>Profesionales:</b> '.$current_date.'</div>';        

		$pdf->writeHTML($encabezado, true, false, true, false, '');   
		
		$y = 45;
		$pdf->SetXY(10,$y);
		$pdf->Cell(15,5,'Matrícula',0,0,'C');    
		$pdf->SetXY(15,$y);
		$pdf->Cell(60,5,'Nombre',0,0,'C');    
		$pdf->SetXY(20,$y);
		$pdf->Cell(150,5,'Domicilio',0,0,'C'); 
		$pdf->SetXY(45,$y);
		$pdf->Cell(260,5,'Teléfono',0,0,'C'); 
		$pdf->SetXY(50,$y);
		$pdf->Cell(292,5,'Celular',0,0,'C'); 
		$pdf->SetXY(45,$y);
		$pdf->Cell(360,5,'Email',0,0,'C'); 
		$pdf->SetXY(20,$y);
		$y = $y + 5;		
		$contador = 1;
		
		$pdf->Line(10,$y,280,$y);
		$ciudad = "|";

	    foreach ($oPersonas as $opersona){	

	    	if($ciudad<>$opersona['ciudad']){
	    		$pdf->SetFont('Times','B',12); 
	    		$y = $y + 5;  
	    		$pdf->SetXY(0,$y-5);
                $pdf->SetXY(10,$y);
                $pdf->Cell(60,5,$opersona['ciudad'],0,0,'L'); 
                $ciudad=$opersona['ciudad'];  
                $y = $y + 5;  
                $pdf->SetFont('Times','',11); 
	    	}
		    			    		
		   	$pdf->SetXY(0,$y-5);
            $pdf->SetXY(10,$y);
            $pdf->Cell(60,5,$opersona['matricula'],0,0,'L');    
		    $pdf->SetXY(25,$y);        
		    $pdf->Cell(25,5,$opersona['apellido'].", ".$opersona['nombre'],0,0,'L'); 
		    $pdf->SetXY(85,$y); 
		    $pdf->Cell(10,5, $opersona['direccion'], 0,0,'L'); 
		    $pdf->SetXY(165,$y); 
		    $pdf->Cell(60,5,$opersona['telefono'],0,0,'L');   
		    $pdf->SetXY(190,$y);  
		    $pdf->Cell(10,5,$opersona['mostrarinfocelular'] ? $opersona['celular'] : ' - ',0,0,'L'); 
		    $pdf->SetXY(218,$y); 
		    $pdf->Cell(10,5,$opersona['mostrarinfoemail'] ? $opersona['email'] : ' - ',0,0,'L'); 
		    
		
 			$y = $y + 5;  
		 	// add a page
			if($y>=180) {
				$pdf->AddPage();

				$pdf->writeHTML($encabezado, true, false, true, false, '');   
		
				$y = 45;
				$pdf->SetXY(10,$y);
				$pdf->Cell(15,5,'Matrícula',0,0,'C');    
				$pdf->SetXY(15,$y);
				$pdf->Cell(60,5,'Nombre',0,0,'C');    
				$pdf->SetXY(20,$y);
				$pdf->Cell(150,5,'Domicilio',0,0,'C'); 
				$pdf->SetXY(45,$y);
				$pdf->Cell(260,5,'Teléfono',0,0,'C'); 
				$pdf->SetXY(50,$y);
				$pdf->Cell(292,5,'Celular',0,0,'C'); 
				$pdf->SetXY(45,$y);
				$pdf->Cell(360,5,'Email',0,0,'C'); 
				$pdf->SetXY(20,$y);
				$y = $y + 5;		
				$contador = 1;
				
				$pdf->Line(10,$y,280,$y);

			}
	
		    } // fin (foreach)	

			 
		$pdf->Output('profesionales.pdf', 'I');
 
		// stop symfony process
		throw new sfStopException();
				
		return sfView::NONE;
  } 


	// 1 Listado de Aspirantes por Carrera
	public function executeAspirantescarrerapdf(sfWebRequest $request) 
	{
		$config = sfTCPDFPluginConfigHandler::loadConfig();
 		$oCicloLectivo = Doctrine_Core::getTable('CiclosLectivos')->find($request->getParameter('idciclo'));

		$lineas_hoja = $request->getParameter('formatos');

		// pdf object
		$pdf = new PDF();
		// settings
		$pdf->SetFont("Times", "", 9);
		// sentencias para retirar encabezados y pie por defecto
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);  
		// add a page
		$pdf->AddPage();
//$pdf->AddPage($orientation='', $format='Legal', $keepmargins=false, $tocpage=false);
                
		$encabezado = '
			<div style="text-align: center; font-family: Times New Roman,Times,serif;"><span
			style="font-size: 12;"><img src="'.$request->getRelativeUrlRoot().'/images/CabeceraSIG-UCU.jpg" width="550px">
			INFORME DE ASPIRANTES - CICLO LECTIVO '.$oCicloLectivo->getCiclo().'</div>';        
        
		$pdf->writeHTML($encabezado, true, false, true, false, '');
		
		$y = 40;
		$pdf->SetXY(10,$y);
		$pdf->Cell(5,10,'Nº',0,0,'C');    
		$pdf->SetXY(15,$y);
		$pdf->Cell(40,10,'APELLIDO',0,0,'C');    
		$pdf->SetXY(55,$y);
		$pdf->Cell(40,10,'NOMBRE',0,0,'C');    
		$pdf->SetXY(95,$y);
		$pdf->Cell(20,10,'DOC.',0,0,'C');    
		$pdf->SetXY(115,$y);		
		$pdf->Cell(10,10,'BAJA',0,0,'C');    
		$pdf->SetXY(125,$y);
		$pdf->Cell(20,10,'COM',0,0,'C');    
		$pdf->SetXY(145,$y);
  		$pdf->Cell(10,10,'USU',0,0,'C');       
		$pdf->SetXY(155,$y);
        $pdf->Cell(30,10,'EMAIL',0,0,'C');   		      

		$oAreas = new Areas();
		$oAlumnos = $oAreas->obtenerAspirantesCicloArea($request->getParameter('idciclo'),$this->getUser()->getProfile()->getIdarea(),$this->getUser()->getProfile()->getIdsede());
        
		$y = $y + 5;
		$contador = 1;
		$contadorcar = 0;
		$contadoralu = 1;
		$contadortotal = 0;
		// verificacion de existencia del objeto alumnos  (if*1)
		if($oAlumnos){
		    $idPlanAnterior = 0;
		    $idPlan = 0;
		    foreach ($oAlumnos as $alumno){		
				$idPlan = $alumno['idplanestudio'];
				// cuando cambia de carrera se deba agregar un rotulo (if*2)
				if( $idPlanAnterior!=$idPlan)   {
					//lineas del rotulo
					$pdf->Line(10,$y+3,199,$y+3);
			        $pdf->Line(10,$y+7,199,$y+7);   
			                             
					$y = $y+5;
				    $contadoralu = 1;    // por cada carrera tengo el contador de alumnos
	                $pdf->SetXY(0,$y-5);
	                //Se muestra una etiqueta del grupo
	                $pdf->Cell(200,10,$alumno['nomcar'],0,0,'C'); 
	                $contadorcar++;     
				} // fin (if*2)
					
		        $pdf->SetXY(10,$y);
		        $pdf->Cell(5,10,$contadoralu,0,0,'L');
		        $pdf->SetXY(15,$y);        
		        $pdf->Cell(40,10,$alumno['ape'],0,0,'L');        
		        $pdf->SetXY(55,$y);        
		        $pdf->Cell(40,10,$alumno['nom'],0,0,'L');              
		        $pdf->SetXY(95,$y);        
		        $pdf->Cell(20,10,$alumno['tipodoc'].' '.$alumno['documento'],0,0,'C'); 
		  		$activo = $alumno['activo'];
				$estado = "";
				if ($alumno['idestado']==2) {$estado = "BAJA";};
		        $pdf->SetXY(115,$y);        
				$pdf->Cell(10,10,$estado,0,0,'C');  
	
				$idmateria = 104;
				$oAlumno = Doctrine_Core::getTable('Alumnos')->find($alumno['idalumno']);
		        $alumat = $oAlumno->obtenerComision($idmateria);
		        $pdf->SetXY(125,$y);        
		        $pdf->Cell(20,10,$alumat['idcomision'],0,0,'L'); 		
		        $profile = $oAlumno->getPersonas()->existeUsuario();
				// verifico que exista registro en profile 
				if($profile) $usuario = 'X'; else $usuario = '';
		        $pdf->SetXY(145,$y);        
		        $pdf->Cell(10,10,$usuario,0,0,'C'); 
				$contacto = $oAlumno->getPersonas()->getContacto();	
		        $pdf->SetXY(155,$y);
		        $pdf->Cell(30,10,$contacto['email'],0,0,'L'); 
	
		        $y=$y+4; $contador++; $contadortotal++; $contadoralu++;  $idPlanAnterior=$idPlan;
				// chequeo que la cantidad de registros por pagina sea 55 (if*3)
		        if ($contador+$contadorcar==$lineas_hoja){
		        	$pdf->Line(10,$y+3,199,$y+3);
		            $contador = 1;
		            $contadorcar = 0;
		            // add a page
			    	$pdf->AddPage();
				    	
					$encabezado = '
						<div style="text-align: center; font-family: Times New Roman,Times,serif;"><span
						style="font-size: 12;"><img src="'.$request->getRelativeUrlRoot().'/images/CabeceraSIG-UCU.jpg" width="550px">
						INFORME DE ASPIRANTES - CICLO LECTIVO '.$oCicloLectivo->getCiclo().'</div>';        
					        
					$pdf->writeHTML($encabezado, true, false, true, false, '');	
							
					$y = 40;
					$pdf->SetXY(10,$y);
					$pdf->Cell(5,10,'Nº',0,0,'C');    
					$pdf->SetXY(15,$y);
					$pdf->Cell(40,10,'APELLIDO',0,0,'C');    
					$pdf->SetXY(55,$y);
					$pdf->Cell(40,10,'NOMBRE',0,0,'C');    
					$pdf->SetXY(95,$y);
					$pdf->Cell(20,10,'DOC.',0,0,'C');    
					$pdf->SetXY(115,$y);		
					$pdf->Cell(10,10,'BAJA',0,0,'C');    
					$pdf->SetXY(125,$y);
					$pdf->Cell(20,10,'COM',0,0,'C');    
					$pdf->SetXY(145,$y);
			  		$pdf->Cell(10,10,'USU',0,0,'C');       
					$pdf->SetXY(155,$y);
			        $pdf->Cell(30,10,'EMAIL',0,0,'C');
			        
			        $y = $y + 5;
		        }    // fin (if*3)           
				$pdf->Line(10,$y+3,199,$y+3);       
		    }
		    $pdf->SetXY(10,$y+10);
			$pdf->Cell(50,10,'CANTIDAD TOTAL:'.$contadortotal,0,0,'L');	
		} // fin (if*1)
		
		$pdf->Output('planilla-asistencia.pdf', 'I');
 
		// stop symfony process
		throw new sfStopException();
  	
    	return sfView::NONE;    		 
	}	
	
	// 2 Listado de Aspirantes por Comision
	public function executeAspirantescomisionpdf(sfWebRequest $request) 
	{
		$config = sfTCPDFPluginConfigHandler::loadConfig();
 		$oCicloLectivo = Doctrine_Core::getTable('CiclosLectivos')->find($request->getParameter('idciclo'));
		// pdf object
		$pdf = new PDF();
		// settings
		$pdf->SetFont("Times", "", 9);
		// sentencias para retirar encabezados y pie por defecto
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);  
		// add a page
		$pdf->AddPage();
		
		$encabezado = '
			<div style="text-align: center; font-family: Times New Roman,Times,serif;"><span
			style="font-size: 12;"><img src="'.$request->getRelativeUrlRoot().'/images/CabeceraSIG-UCU.jpg" width="550px">
			INFORME DE ASPIRANTES - CICLO LECTIVO '.$oCicloLectivo->getCiclo().'</div>';        

		$pdf->writeHTML($encabezado, true, false, true, false, '');   
	
		$y = 40;
		$pdf->SetXY(10,$y);
		$pdf->Cell(5,10,'Nº',0,0,'C');    
		$pdf->SetXY(15,$y);
		$pdf->Cell(40,10,'APELLIDO',0,0,'C');    
		$pdf->SetXY(55,$y);
		$pdf->Cell(40,10,'NOMBRE',0,0,'C');    
		$pdf->SetXY(95,$y);
		$pdf->Cell(20,10,'DOC.',0,0,'C');    
		$pdf->SetXY(115,$y);		
		$pdf->Cell(20,10,'BAJA',0,0,'C');    
		$pdf->SetXY(135,$y);
		$pdf->Cell(50,10,'CARRERA',0,0,'C');    
		
		$oAreas = new Areas();
		$idmateria = 104;
		$oAlumnos =$oAreas->obtenerAspirantesCicloComisionArea($request->getParameter('idciclo'),$this->getUser()->getProfile()->getIdarea(),$idmateria);							
		        
		$y = $y + 5;
		$contador = 1;      
		$contadoralu = 1;
		$contadortotal = 0;
		// verificacion de existencia del objeto alumnos (if*1)
		if($oAlumnos){
		    $idComisionAnterior = 0;
		    $idComision = 0;
		    foreach ($oAlumnos as $alumat){	
				$alumno = Doctrine_Core::getTable('Alumnos')->find($alumat['idalumno']);
		    	$idComision = $alumat['idcomision'];		    			
				// verifico si cambia la comision  (if*2)
		    	if ($idComisionAnterior!=$idComision) {
					//lineas del rotulo
					$pdf->Line(10,$y+3,199,$y+3);
			        $pdf->Line(10,$y+7,199,$y+7);   
			                             
					$y = $y+5;
				    $contadoralu = 1;    // por cada carrera tengo el contador de alumnos
	                $pdf->SetXY(0,$y-5);
                   	//Se muestra una etiqueta del grupo
                   	if($idComision!=0) {
                   		$oComision = Doctrine_Core::getTable('Comisiones')->find($idComision);
                   		$pdf->Cell(200,10,'Comision '.$oComision->getNombre(),0,0,'C');
                   	}    												
	                $contador++;     
				} // fin (if*2)	
		        $pdf->SetXY(10,$y);
		        $pdf->Cell(5,10,$contadoralu,0,0,'L');
		        $pdf->SetXY(15,$y);        
		        $pdf->Cell(40,10,$alumno->getPersonas()->getApellido(),0,0,'L');        
		        $pdf->SetXY(55,$y);        
		        $pdf->Cell(40,10,$alumno->getPersonas()->getNombre(),0,0,'L');              
		        $pdf->SetXY(95,$y);        
		        $pdf->Cell(20,10,$alumno->getPersonas()->getTiposDocumentos().' '.$alumno->getPersonas()->getNroDoc(),0,0,'C'); 

		        $profile = $alumno->getPersonas()->existeUsuario();
				if($profile) $usuario='X'; else $usuario='';

				$idmateria = 104;
				$contacto = $alumno->getPersonas()->getContacto();
				$activo = $alumno->getActivo();
				$estado = "_";
				if (!$activo) {$estado="BAJA";};
		        $pdf->SetXY(115,$y);        
		        $pdf->Cell(20,10,$estado,0,0,'C'); 
				$pdf->SetXY(135,$y);
		        $pdf->Cell(50,10,$alumno->getPlanesEstudios()->getCarreras()->getNombre(),0,0,'L'); 
			        				
	    	    $y=$y+4; $contador++; $contadortotal++; $contadoralu++; $idComisionAnterior=$idComision;
				// chequeo que la cantidad de registros por pagina sea 55 (if*3)
	    	    if ($contador==56){
		            $pdf->Line(10,$y+3,199,$y+3);
	    	    	$contador = 1;
		            // add a page
			    	$pdf->AddPage();
				    	
					$encabezado = '
						<div style="text-align: center; font-family: Times New Roman,Times,serif;"><span
						style="font-size: 12;"><img src="'.$request->getRelativeUrlRoot().'/images/CabeceraSIG-UCU.jpg" width="550px">
						INFORME DE ASPIRANTES - CICLO LECTIVO '.$oCicloLectivo->getCiclo().'</div>';       
					        
					$pdf->writeHTML($encabezado, true, false, true, false, '');	
							
					$y = 40;
					$pdf->SetXY(10,$y);
					$pdf->Cell(5,10,'Nº',0,0,'C');    
					$pdf->SetXY(15,$y);
					$pdf->Cell(40,10,'APELLIDO',0,0,'C');    
					$pdf->SetXY(55,$y);
					$pdf->Cell(40,10,'NOMBRE',0,0,'C');    
					$pdf->SetXY(95,$y);
				  	$pdf->Cell(20,10,'DOC.',0,0,'C');    
					$pdf->SetXY(115,$y);		
					$pdf->Cell(20,10,'BAJA',0,0,'C');    
				 	$pdf->SetXY(135,$y);
					$pdf->Cell(50,10,'CARRERA',0,0,'C');  
			        
			        $y = $y + 5;	    	    	
				}    
				$pdf->Line(10,$y+3,199,$y+3); 				    
	    	} // fin (foreach)
		    $pdf->SetXY(10,$y+10);
			$pdf->Cell(50,10,'CANTIDAD TOTAL:'.$contadortotal,0,0,'L');		    	
		} // fin (if*1)
			
		$pdf->Output('planilla.pdf', 'I');
 
		// stop symfony process
		throw new sfStopException();
  	
    	return sfView::NONE;    		       
	}

	// 3 Listado de Aspirantes por Sede
	public function executeAspirantessedepdf(sfWebRequest $request) 
	{
		$config = sfTCPDFPluginConfigHandler::loadConfig();
 		$oCicloLectivo = Doctrine_Core::getTable('CiclosLectivos')->find($request->getParameter('idciclo'));
		// pdf object
		$pdf = new PDF();
		// settings
		$pdf->SetFont("Times", "", 9);
		// sentencias para retirar encabezados y pie por defecto
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);  
		// add a page
		$pdf->AddPage();
		
		$encabezado = '
			<div style="text-align: center; font-family: Times New Roman,Times,serif;"><span
			style="font-size: 12;"><img src="'.$request->getRelativeUrlRoot().'/images/CabeceraSIG-UCU.jpg" width="550px">
			INFORME DE ASPIRANTES - CICLO LECTIVO '.$oCicloLectivo->getCiclo().'</div>';        

		$pdf->writeHTML($encabezado, true, false, true, false, '');   

		$y = 40;
		$pdf->SetXY(10,$y);
		$pdf->Cell(5,10,'Nº',0,0,'C');    
		$pdf->SetXY(15,$y);
		$pdf->Cell(40,10,'APELLIDO',0,0,'C');    
		$pdf->SetXY(55,$y);
		$pdf->Cell(40,10,'NOMBRE',0,0,'C');    
		$pdf->SetXY(95,$y);
		$pdf->Cell(20,10,'DOC.',0,0,'C');    
		$pdf->SetXY(115,$y);		
		$pdf->Cell(20,10,'BAJA',0,0,'C');    
		$pdf->SetXY(135,$y);
		$pdf->Cell(50,10,'CARRERA',0,0,'C');    
							
		$oAreas = new Areas();
		$idmateria = 104; 
		$oAlumnos =$oAreas->obtenerAspirantesCicloSedeArea($request->getParameter('idciclo'),$this->getUser()->getProfile()->getIdarea(),$idmateria);
		        
		$y = $y + 5;
		$contador = 1;     
		$contadoralu = 1;
		$contadortotal = 0;
		// verificacion de existencia del objeto alumnos (if*1)
		if($oAlumnos){
		    $idSedeAnterior = 0;
		    $idSede = 0;
		    foreach ($oAlumnos as $alumat){	
		    	$alumno = Doctrine_Core::getTable('Alumnos')->find($alumat['idalumno']);	
		    	$idSede = $alumat['idsede'];		    			
				// verifico si cambia la comision  (if*2)
		    	if ($idSedeAnterior!=$idSede) {
					//lineas del rotulo
					$pdf->Line(10,$y+3,199,$y+3);
			        $pdf->Line(10,$y+7,199,$y+7);   
			                             
					$y = $y+5;
				    $contadoralu = 1;    // por cada carrera tengo el contador de alumnos
	                $pdf->SetXY(0,$y-5);
                   	//Se muestra una etiqueta del grupo
                   	if($idSede!=0) {
                   		$oSede = Doctrine_Core::getTable('Sedes')->find($idSede);
                   		$pdf->Cell(200,10,$oSede->getNombre(),0,0,'C');
                   	}    												
	                $contador++;     
				} // fin (if*2)	
		        $pdf->SetXY(10,$y);
		        $pdf->Cell(5,10,$contadoralu,0,0,'L');
		        $pdf->SetXY(15,$y);        
		        $pdf->Cell(40,10,$alumno->getPersonas()->getApellido(),0,0,'L');        
		        $pdf->SetXY(55,$y);        
		        $pdf->Cell(40,10,$alumno->getPersonas()->getNombre(),0,0,'L');              
		        $pdf->SetXY(95,$y);        
		        $pdf->Cell(20,10,$alumno->getPersonas()->getTiposDocumentos().' '.$alumno->getPersonas()->getNroDoc(),0,0,'C'); 

		        $profile = $alumno->getPersonas()->existeUsuario();
				if($profile) $usuario='X'; else $usuario='';

				$idmateria = 104;
				$contacto = $alumno->getPersonas()->getContacto();
				$activo = $alumno->getActivo();
				$estado = "_";
				if (!$activo) {$estado="BAJA";};
		        $pdf->SetXY(115,$y);        
		        $pdf->Cell(20,10,$estado,0,0,'C'); 
				$pdf->SetXY(135,$y);
		        $pdf->Cell(50,10,$alumno->getPlanesEstudios()->getCarreras()->getNombre(),0,0,'L'); 
			        				
	    	    $y=$y+4; $contador++; $contadortotal++; $contadoralu++; $idSedeAnterior=$idSede;
				// chequeo que la cantidad de registros por pagina sea 55 (if*3)
	    	    if ($contador==56){
		            $pdf->Line(10,$y+3,199,$y+3);
	    	    	$contador = 1;
		            // add a page
			    	$pdf->AddPage();
				    	
					$encabezado = '
						<div style="text-align: center; font-family: Times New Roman,Times,serif;"><span
						style="font-size: 12;"><img src="'.$request->getRelativeUrlRoot().'/images/CabeceraSIG-UCU.jpg" width="550px">
						INFORME DE ASPIRANTES - CICLO LECTIVO '.$oCicloLectivo->getCiclo().'</div>';       
					        
					$pdf->writeHTML($encabezado, true, false, true, false, '');	
							
					$y = 40;
					$pdf->SetXY(10,$y);
					$pdf->Cell(5,10,'Nº',0,0,'C');    
					$pdf->SetXY(15,$y);
					$pdf->Cell(40,10,'APELLIDO',0,0,'C');    
					$pdf->SetXY(55,$y);
					$pdf->Cell(40,10,'NOMBRE',0,0,'C');    
					$pdf->SetXY(95,$y);
				  	$pdf->Cell(20,10,'DOC.',0,0,'C');    
					$pdf->SetXY(115,$y);		
					$pdf->Cell(20,10,'BAJA',0,0,'C');    
				 	$pdf->SetXY(135,$y);
					$pdf->Cell(50,10,'CARRERA',0,0,'C');  
			        
			        $y = $y + 5;	    	    	
				}    
				$pdf->Line(10,$y+3,199,$y+3); 				    
	    	} // fin (foreach)
		    $pdf->SetXY(10,$y+10);
			$pdf->Cell(50,10,'CANTIDAD TOTAL:'.$contadortotal,0,0,'L');		    	
		} // fin (if*1)
			
		$pdf->Output('planilla.pdf', 'I');
 
		// stop symfony process
		throw new sfStopException();
  	
    	return sfView::NONE;    		       
	}
		
   	// 4 Listado de Aspirantes para Seguro
	public function executeListadoparaseguropdf(sfWebRequest $request) 
	{
		$config = sfTCPDFPluginConfigHandler::loadConfig();
 		$oCicloLectivo = Doctrine_Core::getTable('CiclosLectivos')->find($request->getParameter('idciclo'));
		// pdf object
		$pdf = new PDF('L');
		// settings
		$pdf->SetFont("Times", "", 9);  
		// sentencias para retirar encabezados y pie por defecto
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);  		      
		// add a page
		$pdf->AddPage();
               
		$encabezado = '
			<div style="text-align: center; font-family: Times New Roman,Times,serif;"><span
			style="font-size: 12;"><img src="'.$request->getRelativeUrlRoot().'/images/CabeceraSIG-UCU.jpg" width="950px">
			INFORME DE ASPIRANTES - CICLO LECTIVO '.$oCicloLectivo->getCiclo().'</div>';         
        
		$pdf->writeHTML($encabezado, true, false, true, false, '');
 		       		
		$y = 50;     
		$pdf->SetXY(10,$y);
		$pdf->Cell(5,10,'Nº',0,0,'C');    
		$pdf->SetXY(15,$y);
		$pdf->Cell(40,10,'APELLIDO',0,0,'C');    
		$pdf->SetXY(55,$y);
		$pdf->Cell(40,10,'NOMBRE',0,0,'C');    
		$pdf->SetXY(95,$y);
		$pdf->Cell(35,10,'DOC.',0,0,'C');    
		$pdf->SetXY(130,$y);		
		$pdf->Cell(20,10,'FEC. NAC.',0,0,'C');    	
		$pdf->SetXY(150,$y);
		$pdf->Cell(25,10,'TEL',0,0,'C');    
		$pdf->SetXY(175,$y);
		$pdf->Cell(25,10,'CEL',0,0,'C');    
		$pdf->SetXY(200,$y);
		$pdf->Cell(50,10,'EMAIL',0,0,'C');    				    				    	
		$pdf->SetXY(250,$y);   
		$pdf->Cell(40,10,'ORIGEN',0,0,'C');    

		$oAreas = new Areas();
		$oAlumnos = $oAreas->obtenerAspirantesSeguroAlfabetico($request->getParameter('idciclo'),$this->getUser()->getProfile()->getIdarea(),$this->getUser()->getProfile()->getIdsede());

		$y = $y + 5;
		$contador = 1;
		$cantidad = 0;
		$contadorcar = 0;		
		$contadoralu = 1;
		$contadortotal = 0;
		
		// verificacion de existencia del objeto alumnos  (if*1)
		if($oAlumnos){
		    $idPlanAnterior = 0;
		    $idPlan = 0;
		    foreach ($oAlumnos as $alumat) {	
		    	$alumno = Doctrine_Core::getTable('Alumnos')->find($alumat['idalumno']);	
				$idPlan = $alumno->getIdplanestudio();		    	
				// cuando cambia de carrera se deba agregar un rotulo (if*2)
				if( $idPlanAnterior!=$idPlan) {
 					//lineas del rotulo
					$pdf->Line(10,$y+3,290,$y+3);
			        $pdf->Line(10,$y+7,290,$y+7);   
					
					$y = $y+5;
				    $contadoralu = 1;    // por cada carrera tengo el contador de alumnos
	                $pdf->SetXY(0,$y-5);
	                //Se muestra una etiqueta del grupo
	                $pdf->Cell(290,10,$alumno->getPlanesEstudios().'('.$alumno->getIdplanestudio().')',0,0,'C'); 
                   				                              
	                $contadorcar++;
				} // fin (if*2)
					
		        $pdf->SetXY(10,$y);
		        $pdf->Cell(5,10,$contadoralu,0,0,'C');
		        $pdf->SetXY(15,$y);        
		        $pdf->Cell(40,10,$alumno->getPersonas()->getApellido(),0,0,'L');        
		        $pdf->SetXY(55,$y);        
		        $pdf->Cell(40,10,$alumno->getPersonas()->getNombre(),0,0,'L');              
		        $pdf->SetXY(95,$y);        
		        $pdf->Cell(35,10,$alumno->getPersonas()->getTiposDocumentos().' '.$alumno->getPersonas()->getNroDoc(),0,0,'C'); 
				
		        // dar formato a campo fecha
		  		$arr = explode('-', $alumno->getPersonas()->getFechaNac());
		  		$fechanac = $arr[2]."-".$arr[1]."-".$arr[0];
		        $pdf->SetXY(130,$y);        
		        $pdf->Cell(20,10,$fechanac,0,0,'C'); 
				$pdf->SetXY(150,$y);
				$contacto = $alumno->getPersonas()->getContacto();
				if($contacto['telefonofijocar']) $area='('.$contacto['telefonofijocar'].') '; else $area='';
		        $pdf->Cell(25,10,$area.substr($contacto['telefonofijonum'],0,10),0,0,'L'); 			        
		        $pdf->SetXY(175,$y);
		        if($contacto['celularcar']) $area='('.$contacto['celularcar'].') '; else $area='';
		        $pdf->Cell(25,10,$area.$contacto['celularnum'],0,0,'L'); 				        			        
		        $pdf->SetXY(200,$y);
		        $pdf->Cell(50,10,$contacto['email'],0,0,'L'); 
		        $pdf->SetXY(250,$y);		

		    	$contactos = Doctrine_Core::getTable('Contactos')->findByIdpersona($alumno->getPersonas()->getIdpersona());
				$idciudade='';
				if(isset($contactos)) {
					foreach($contactos as $c){
						$idciudade = $c['idciudade'];
			    		$ciudad = Doctrine_Core::getTable('Ciudades')->findByIdciudad($idciudade);
						$nombre='';
						if(isset($ciudad)) {
							foreach($ciudad as $ciu){
								$nombreciudad = $ciu['descripcion'];
							}
						}
					}		    	
				}
				// cuando cambia de carrera se deba agregar un rotulo (if*2)
	        
		        $pdf->Cell(40,10,$nombreciudad,0,0,'C'); 
		        //$pdf->Cell(40,10,$alumno->getPersonas()->getPaises(),0,0,'C'); 
	
		        $y=$y+4; $contador++; $cantidad++; $contadortotal++; $contadoralu++;  $idPlanAnterior=$idPlan; 
				// chequeo que la cantidad de registros por pagina sea 55 (if*3)
		        if ($contador+$contadorcar>=30){
		        	$pdf->Line(10,$y+3,290,$y+3);
		            $contador = 1;
		            $contadorcar = 0;
		            // add a page
			    	$pdf->AddPage();
				    	
					$encabezado = '
						<div style="text-align: center; font-family: Times New Roman,Times,serif;"><span
						style="font-size: 12;"><img src="'.$request->getRelativeUrlRoot().'/images/CabeceraSIG-UCU.jpg" width="950px">
						INFORME DE ASPIRANTES - CICLO LECTIVO '.$oCicloLectivo->getCiclo().'</div>';           
					        
					$pdf->writeHTML($encabezado, true, false, true, false, '');	
							
			 		$y = 50;
					$pdf->SetXY(10,$y);
					$pdf->Cell(5,10,'Nº',0,0,'C');    
					$pdf->SetXY(15,$y);
					$pdf->Cell(40,10,'APELLIDO',0,0,'C');    
					$pdf->SetXY(55,$y);
					$pdf->Cell(40,10,'NOMBRE',0,0,'C');    
					$pdf->SetXY(95,$y);
					$pdf->Cell(35,10,'DOC.',0,0,'C');    
					$pdf->SetXY(130,$y);		
					$pdf->Cell(20,10,'FEC. NAC.',0,0,'C');    	
					$pdf->SetXY(150,$y);
					$pdf->Cell(25,10,'TEL',0,0,'C');    
					$pdf->SetXY(175,$y);
					$pdf->Cell(25,10,'CEL',0,0,'C');    
					$pdf->SetXY(200,$y);
					$pdf->Cell(50,10,'EMAIL',0,0,'C');    				    				    	
					$pdf->SetXY(250,$y);   
					$pdf->Cell(40,10,'ORIGEN',0,0,'C');    
		            $y = $y+5;					
		        }    // fin (if*3)           
				$pdf->Line(10,$y+3,290,$y+3);		        
		    }
		    $pdf->SetXY(10,$y+10);
			$pdf->Cell(50,10,'CANTIDAD TOTAL:'.$contadortotal,0,0,'L');	
		} // fin (if*1)
		
		$pdf->Output('planilla.pdf', 'I');
 
		// stop symfony process
		throw new sfStopException();
  	
    	return sfView::NONE;    		 
	}	 
	   	
   	// 5 Planilla de Asistencia PreUniversitario
	public function executeAsistenciapreuniversitariopdf(sfWebRequest $request) 
	{
		$config = sfTCPDFPluginConfigHandler::loadConfig();
		$oCicloLectivo = Doctrine_Core::getTable('CiclosLectivos')->find($request->getParameter('idciclo')); 
		// pdf object
		$pdf = new PDF();
		// settings
		$pdf->SetFont("Times", "", 10);
		// sentencias para retirar encabezados y pie por defecto
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);  
        // add a page
		$pdf->AddPage();		
					
		$encabezado = '
			<div style="text-align: center; font-family: Times New Roman,Times,serif;"><span
			style="font-size: 12;"><img src="'.$request->getRelativeUrlRoot().'/images/CabeceraSIG-UCU.jpg" width="550px">
			INFORME DE ASPIRANTES - CICLO LECTIVO '.$oCicloLectivo->getCiclo().'</div>';        

		$pdf->writeHTML($encabezado, true, false, true, false, '');   
		
		$y = 40;
		$pdf->SetXY(10,$y);
		$pdf->Cell(5,7,'Nº',0,0,'C');    
		$pdf->SetXY(15,$y);
		$pdf->Cell(40,7,'APELLIDO',0,0,'C');    
		$pdf->SetXY(55,$y);
		$pdf->Cell(60,7,'NOMBRE',0,0,'C');    
   		$pdf->SetXY(105,$y);
		$pdf->Cell(25,7,'ASISTENCIA',0,0,'C');
		$pdf->SetXY(130,$y);
		$pdf->Cell(60,7,'CARRERA',0,0,'C');
		$y = $y + 7;
		$pdf->Line(10,$y,199,$y);
				
		$pdf->SetXY(105,$y);
		$pdf->Cell(20,6,' 1    2   3    4   5',0,0,'L');    
			
		$y = $y + 6;
		$pdf->Line(10,$y,199,$y);

		// esta planilla unicamente se usa para la materia introduccion a la vida universitaria, en el ciclo lectivo 2013 
		// no debe seguir este modulo
		$oAreas = new Areas();		
		$idmateria = 104; 
		$oAlumnos = $oAreas->obtenerAspirantesCicloAlfabetico($request->getParameter('idciclo'),$this->getUser()->getProfile()->getIdarea(),$this->getUser()->getProfile()->getIdsede());
	
		$contador = 1;
		$contadoralu = 1;
		$contadortotal = 0;
		
		// verificacion de existencia del objeto alumnos  (if*1)
		if($oAlumnos){
		    $idComisionAnterior = 0;
		    $idComision = 0;
		    foreach ($oAlumnos as $alumat){	
		    	$alumno = Doctrine_Core::getTable('Alumnos')->find($alumat['idalumno']);
				$idComision = 115;//$alumat['idcomision']; 
	    		if ($this->getUser()->getProfile()->getIdarea() <> 1 and $idComisionAnterior > 0) { 
					$idComisionAnterior = $idComision;
				}		    		
		    		
				// verifico si cambia la comision  (if*2)
				if ($idComisionAnterior!=$idComision) {					
					$contadoralu = 1;		
  
                   	$pdf->SetXY(0,$y);
                   	//Se muestra una etiqueta del grupo
                   	if($idComision!=0) {
                   		$oComision = Doctrine_Core::getTable('Comisiones')->find($idComision);
                   		$pdf->Cell(105,7,$oComision->getNombre(),0,0,'C');	
                   		$y = $y + 7;

                   		$pdf->Line(10,$y,199,$y);
                   		
                   		$contador++;
                   	}    																			
	    	    } // fin (if*2)
		    	    	    	       	    
		        $pdf->SetXY(10,$y);
		        $pdf->Cell(5,6,$contadoralu,0,0,'L');
		        $pdf->SetXY(15,$y);        
		        $pdf->Cell(40,6,$alumno->getPersonas()->getApellido(),0,0,'L');        
		        $pdf->SetXY(55,$y);        
		        $pdf->Cell(60,6,$alumno->getPersonas()->getNombre(),0,0,'L');              
				$pdf->SetXY(130,$y);
				$pdf->SetFont("Times", "", 9);
				$pdf->Cell(60,6,$alumno->getPlanesEstudios()->getCarreras()->getNombre(),0,0,'L'); 
				$pdf->SetFont("Times", "", 10);
				
				$y=$y+6; $contador++; $contadortotal++; $contadoralu++; $idComisionAnterior=$idComision;
				if ($contador == 37){
		            $pdf->Line(10,$y,199,$y);	
					//lineas verticales             
					$pdf->Line(105,47,105,$y);
					$pdf->Line(110,47,110,$y);
					$pdf->Line(115,47,115,$y);
					$pdf->Line(120,47,120,$y);
					$pdf->Line(125,47,125,$y);
					$pdf->Line(130,47,130,$y);
				            
					$contador = 1;		
					// add a page
			    	$pdf->AddPage();
			    	
					$encabezado = '
						<div style="text-align: center; font-family: Times New Roman,Times,serif;"><span
						style="font-size: 12;"><img src="'.$request->getRelativeUrlRoot().'/images/CabeceraSIG-UCU.jpg" width="550px">
						INFORME DE ASPIRANTES - CICLO LECTIVO '.$oCicloLectivo->getCiclo().'</div>';        

					$pdf->writeHTML($encabezado, true, false, true, false, '');   
		
					$y = 40;
					$pdf->SetXY(10,$y);
					$pdf->Cell(5,7,'Nº',0,0,'C');
					$pdf->SetXY(15,$y);
					$pdf->Cell(40,7,'APELLIDO',0,0,'C');
					$pdf->SetXY(55,$y);
					$pdf->Cell(60,7,'NOMBRE',0,0,'C');
					$pdf->SetXY(105,$y);
					$pdf->Cell(25,7,'ASISTENCIA',0,0,'C');
					$pdf->SetXY(130,$y);
					$pdf->Cell(60,7,'CARRERA',0,0,'C');
					$y = $y + 7;
					$pdf->Line(10,$y,199,$y);
					
					$pdf->SetXY(105,$y);
					$pdf->Cell(20,6,' 1    2   3    4   5',0,0,'L');
					$y = $y + 6;
					$pdf->Line(10,$y,199,$y);
				}		
				$pdf->Line(10,$y,199,$y);	
		    } // fin (foreach)
			//lineas verticales             
			$pdf->Line(105,47,105,$y);
			$pdf->Line(110,47,110,$y);
			$pdf->Line(115,47,115,$y);
			$pdf->Line(120,47,120,$y);
			$pdf->Line(125,47,125,$y);
			$pdf->Line(130,47,130,$y);		    
		} // fin (if*1)
		
		$pdf->Output('planilla.pdf', 'I');
 
		// stop symfony process
		throw new sfStopException();
  	
    	return sfView::NONE;    		
	}   	
	
   	// 6 Planilla de TP PreUniversitario
	public function executeTppreuniversitariopdf(sfWebRequest $request) 
	{	
		$config = sfTCPDFPluginConfigHandler::loadConfig();
 		$oCicloLectivo = Doctrine_Core::getTable('CiclosLectivos')->find($request->getParameter('idciclo'));
		// pdf object
		$pdf = new PDF();
		// settings
		$pdf->SetFont("Times", "", 10);
		// sentencias para retirar encabezados y pie por defecto
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);  
		// add a page
		$pdf->AddPage();
    			
		$encabezado = '
			<div style="text-align: center; font-family: Times New Roman,Times,serif;"><span
			style="font-size: 12;"><img src="'.$request->getRelativeUrlRoot().'/images/CabeceraSIG-UCU.jpg" width="550px">
			PLANILLA DE EVALUACION PREUNIVERSITARIO - CICLO LECTIVO '.$oCicloLectivo->getCiclo().'</div>';        

		$pdf->writeHTML($encabezado, true, false, true, false, '');   		

		$y = 40;
		$pdf->SetXY(10,$y);
		$pdf->Cell(5,7,'Nº',0,0,'C');    
		$pdf->SetXY(15,$y);
		$pdf->Cell(40,7,'APELLIDO',0,0,'C');    
		$pdf->SetXY(55,$y);
		$pdf->Cell(35,7,'NOMBRE',0,0,'C');    
		$pdf->SetXY(90,$y);
		$pdf->Cell(50,7,'EVALUACION',0,0,'C');
	 	$pdf->SetXY(140,$y);
		$pdf->Cell(50,7,'CARRERA',0,0,'C');    
		
		$y = $y + 7;
		$pdf->Line(10,$y,199,$y);
				
		$pdf->SetXY(90,$y);
		$pdf->Cell(10,6,'1',0,0,'C');    
		$pdf->SetXY(100,$y);
		$pdf->Cell(10,6,'2',0,0,'C');    
		$pdf->SetXY(110,$y);
		$pdf->Cell(10,6,'3',0,0,'C');    
		$pdf->SetXY(120,$y);
		$pdf->Cell(10,6,'4',0,0,'C');    
		$pdf->SetXY(130,$y);
		$pdf->Cell(10,6,'5',0,0,'C');    
		
		$y = $y + 6;
		$pdf->Line(10,$y,199,$y);
				
		$oAreas = new Areas();
		$oAlumnos=$oAreas->obtenerAspirantesCicloAlfabetico($request->getParameter('idciclo'),$this->getUser()->getProfile()->getIdarea(),$this->getUser()->getProfile()->getIdsede());        
		
		$contador = 1;     
		$contadoralu = 1;
		$contadortotal = 0;
		// verificacion de existencia del objeto alumnos  (if*1)
		if($oAlumnos) {
		    foreach ($oAlumnos as $alumat) {		
	    		$alumno = Doctrine_Core::getTable('Alumnos')->find($alumat['idalumno']);
						    		
		        $pdf->SetXY(10,$y);
		        $pdf->Cell(5,6,$contadoralu,0,0,'L');
		        $pdf->SetXY(15,$y);        
		        $pdf->Cell(40,6,$alumno->getPersonas()->getApellido(),0,0,'L');        
		        $pdf->SetXY(55,$y);        
		        $pdf->Cell(35,6,$alumno->getPersonas()->getNombre(),0,0,'L');              
				$pdf->SetXY(140,$y);
				$pdf->SetFont("Times", "", 9);
		        $pdf->Cell(50,6,$alumno->getPlanesEstudios()->getCarreras()->getNombre(),0,0,'L'); 	        				
		        $pdf->SetFont("Times", "", 10);
		        
		        $y=$y+6; $contador++; $contadortotal++; $contadoralu++;
				if ($contador==37) {
		            $pdf->Line(10,$y,199,$y);	
					//lineas verticales             
					$pdf->Line(90,47,90,$y);
					$pdf->Line(95,53,95,$y);					
					$pdf->Line(100,47,100,$y);
					$pdf->Line(105,53,105,$y);					
					$pdf->Line(110,47,110,$y);
					$pdf->Line(115,53,115,$y);					
					$pdf->Line(120,47,120,$y);
					$pdf->Line(130,47,130,$y);
					$pdf->Line(140,47,140,$y);	

					$contador = 1;		
					// add a page
			    	$pdf->AddPage();
										
					$encabezado = '
						<div style="text-align: center; font-family: Times New Roman,Times,serif;"><span
						style="font-size: 12;"><img src="'.$request->getRelativeUrlRoot().'/images/CabeceraSIG-UCU.jpg" width="550px">
						PLANILLA DE EVALUACION PREUNIVERSITARIO - CICLO LECTIVO '.$oCicloLectivo->getCiclo().'</div>';        
					
					$pdf->writeHTML($encabezado, true, false, true, false, '');   

					$y = 40;
					$pdf->SetXY(10,$y);
					$pdf->Cell(5,7,'Nº',0,0,'C');    
					$pdf->SetXY(15,$y);
					$pdf->Cell(40,7,'APELLIDO',0,0,'C');    
					$pdf->SetXY(55,$y);
					$pdf->Cell(35,7,'NOMBRE',0,0,'C');    
					$pdf->SetXY(90,$y);
					$pdf->Cell(50,7,'EVALUACION',0,0,'C');
				 	$pdf->SetXY(140,$y);
					$pdf->Cell(50,7,'CARRERA',0,0,'C');    
					
					$y = $y + 7;
					$pdf->Line(10,$y,199,$y);
							
					$pdf->SetXY(90,$y);
					$pdf->Cell(10,6,'1',0,0,'C');    
					$pdf->SetXY(100,$y);
					$pdf->Cell(10,6,'2',0,0,'C');    
					$pdf->SetXY(110,$y);
					$pdf->Cell(10,6,'3',0,0,'C');    
					$pdf->SetXY(120,$y);
					$pdf->Cell(10,6,'4',0,0,'C');    
					$pdf->SetXY(130,$y);
					$pdf->Cell(10,6,'5',0,0,'C');    
					$y = $y + 6;
							
					$pdf->Line(10,$y,199,$y);
				}
		        $pdf->Line(10,$y,199,$y);	
		    } // fin (foreach)*/
			//lineas verticales             
			$pdf->Line(90,47,90,$y);
			$pdf->Line(95,53,95,$y);					
			$pdf->Line(100,47,100,$y);
			$pdf->Line(105,53,105,$y);					
			$pdf->Line(110,47,110,$y);
			$pdf->Line(115,53,115,$y);					
			$pdf->Line(120,47,120,$y);
			$pdf->Line(130,47,130,$y);
			$pdf->Line(140,47,140,$y);		    					    
		} // fin (if*1)
			
		$pdf->Output('planilla.pdf', 'I');
 
		// stop symfony process
		throw new sfStopException();
  	
    	return sfView::NONE;    		       
	}   	

  	// 7 Planilla de Evaluacion PreUniversitario por Fecha
	public function executeEvaluacionpreuniversitarioporfechapdf(sfWebRequest $request) 
	{
		$config = sfTCPDFPluginConfigHandler::loadConfig();
		$oCicloLectivo = Doctrine_Core::getTable('CiclosLectivos')->find($request->getParameter('idciclo')); 
		// pdf object
		$pdf = new PDF();
		// settings
		$pdf->SetFont("Times", "", 10);
		// sentencias para retirar encabezados y pie por defecto
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);  
		// add a page
		$pdf->AddPage();
				    			
		$encabezado = '
			<div style="text-align: center; font-family: Times New Roman,Times,serif;"><span
			style="font-size: 12;"><img src="'.$request->getRelativeUrlRoot().'/images/CabeceraSIG-UCU.jpg" width="550px">
			PLANILLA DE EVALUACION PREUNIVERSITARIO - CICLO LECTIVO '.$oCicloLectivo->getCiclo().'</div>';        

		$pdf->writeHTML($encabezado, true, false, true, false, '');   

		$y = 40;
		$pdf->SetXY(10,$y);
		$pdf->Cell(5,7,'Nº',0,0,'C');    
		$pdf->SetXY(15,$y);
		$pdf->Cell(40,7,'APELLIDO',0,0,'C');    
		$pdf->SetXY(55,$y);
		$pdf->Cell(35,7,'NOMBRE',0,0,'C');    
		$pdf->SetXY(90,$y);
		$pdf->Cell(50,7,'EVALUACION',0,0,'C');
	 	$pdf->SetXY(140,$y);
		$pdf->Cell(50,7,'CARRERA',0,0,'C');    
		
		$y = $y + 7;
		$pdf->Line(10,$y,199,$y);
		
		$pdf->SetXY(90,$y);
		$pdf->Cell(10,6,'1',0,0,'C');
		$pdf->SetXY(100,$y);
		$pdf->Cell(10,6,'2',0,0,'C');
		$pdf->SetXY(110,$y);
		$pdf->Cell(10,6,'3',0,0,'C');
		$pdf->SetXY(120,$y);
		$pdf->Cell(10,6,'4',0,0,'C');
		$pdf->SetXY(130,$y);
		$pdf->Cell(10,6,'5',0,0,'C');
		
		$y = $y + 6;
		$pdf->Line(10,$y,199,$y);
		
		$oAreas = new Areas();
		$idmateria = 104; // esto se dejo fijo por que este modulo no debe estar para el ciclo 2013
		$oAlumnos = $oAreas->obtenerAspirantesCicloAlfabetico($request->getParameter('idciclo'),$this->getUser()->getProfile()->getIdarea(),$this->getUser()->getProfile()->getIdsede());        
				
		$contador = 1;  
		$contadoralu = 1;
		$contadortotal = 0;
		// verificacion de existencia del objeto alumnos  (if*1)
		if($oAlumnos) {
		    foreach ($oAlumnos as $alumat){		
				$alumno = Doctrine_Core::getTable('Alumnos')->find($alumat['idalumno']);   
		    	   
			    $pdf->SetXY(10,$y);
				$pdf->Cell(5,6,$contadoralu,0,0,'L');
				$pdf->SetXY(15,$y);        
				$pdf->Cell(40,6,$alumno->getPersonas()->getApellido(),0,0,'L');        
				$pdf->SetXY(55,$y);        
				$pdf->Cell(35,6,$alumno->getPersonas()->getNombre(),0,0,'L');              
				$pdf->SetXY(140,$y);
				$pdf->SetFont("Times", "", 9);				
		        $pdf->Cell(50,6,$alumno->getPlanesEstudios()->getCarreras()->getNombre(),0,0,'L'); 
		        $pdf->SetFont("Times", "", 10);
		        			        				
				$y=$y+6; $contador++; $contadortotal++; $contadoralu++;
				if ($contador==37) {
		            $pdf->Line(10,$y,199,$y);	
					//lineas verticales             
					$pdf->Line(90,47,90,$y);
					$pdf->Line(100,47,100,$y);
					$pdf->Line(110,47,110,$y);
					$pdf->Line(120,47,120,$y);
					$pdf->Line(130,47,130,$y);
					$pdf->Line(140,47,140,$y);	

					$contador = 1;						
					// add a page
			    	$pdf->AddPage();
						
					$encabezado = '
						<div style="text-align: center; font-family: Times New Roman,Times,serif;"><span
						style="font-size: 12;"><img src="'.$request->getRelativeUrlRoot().'/images/CabeceraSIG-UCU.jpg" width="550px">
						PLANILLA DE EVALUACION PREUNIVERSITARIO - CICLO LECTIVO '.$oCicloLectivo->getCiclo().'</div>';        
					
					$pdf->writeHTML($encabezado, true, false, true, false, '');   

					$y = 40;
					$pdf->SetXY(10,$y);
					$pdf->Cell(5,7,'Nº',0,0,'C');
					$pdf->SetXY(15,$y);
					$pdf->Cell(40,7,'APELLIDO',0,0,'C');
					$pdf->SetXY(55,$y);
					$pdf->Cell(35,7,'NOMBRE',0,0,'C');
					$pdf->SetXY(90,$y);
					$pdf->Cell(50,7,'EVALUACION',0,0,'C');
					$pdf->SetXY(140,$y);
					$pdf->Cell(50,7,'CARRERA',0,0,'C');
					
					$y = $y + 7;
					$pdf->Line(10,$y,199,$y);
					
					$pdf->SetXY(90,$y);
					$pdf->Cell(10,6,'1',0,0,'C');
					$pdf->SetXY(100,$y);
					$pdf->Cell(10,6,'2',0,0,'C');
					$pdf->SetXY(110,$y);
					$pdf->Cell(10,6,'3',0,0,'C');
					$pdf->SetXY(120,$y);
					$pdf->Cell(10,6,'4',0,0,'C');
					$pdf->SetXY(130,$y);
					$pdf->Cell(10,6,'5',0,0,'C');					
					$y = $y + 6;
					
					$pdf->Line(10,$y,199,$y);	
				}
		        $pdf->Line(10,$y,199,$y);	
		    } // fin (foreach)*/
			//lineas verticales             
			$pdf->Line(90,47,90,$y);
			$pdf->Line(100,47,100,$y);
			$pdf->Line(110,47,110,$y);
			$pdf->Line(120,47,120,$y);
			$pdf->Line(130,47,130,$y);
			$pdf->Line(140,47,140,$y);			    
		} // fin (if*1)
			
		$pdf->Output('planilla.pdf', 'I');
 
		// stop symfony process
		throw new sfStopException();
  	
    	return sfView::NONE;    		       
	}  	

	// 8 Planilla de Evaluacion PreUniversitario por Carrera
	public function executeEvaluacionpreuniversitarioporcarrerapdf(sfWebRequest $request) 
	{
		$config = sfTCPDFPluginConfigHandler::loadConfig();
		$oCicloLectivo = Doctrine_Core::getTable('CiclosLectivos')->find($request->getParameter('idciclo'));
		// pdf object
		$pdf = new PDF();       
		// settings
		$pdf->SetFont("Times", "", 10);
		// sentencias para retirar encabezados y pie por defecto
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);  
        // add a page
		$pdf->AddPage();

		$encabezado = '
			<div style="text-align: center; font-family: Times New Roman,Times,serif;"><span
			style="font-size: 12;"><img src="'.$request->getRelativeUrlRoot().'/images/CabeceraSIG-UCU.jpg" width="550px">
			PLANILLA DE EVALUACION PREUNIVERSITARIO - CICLO LECTIVO '.$oCicloLectivo->getCiclo().'</div>';        
			
		$pdf->writeHTML($encabezado, true, false, true, false, '');   

		$y = 40;
		$pdf->SetXY(10,$y);
		$pdf->Cell(5,7,'Nº',0,0,'C');    
		$pdf->SetXY(15,$y);
		$pdf->Cell(40,7,'APELLIDO',0,0,'C');    
		$pdf->SetXY(65,$y);
		$pdf->Cell(35,7,'NOMBRE',0,0,'C');    
		$pdf->SetXY(140,$y);
		$pdf->Cell(60,7,'EVALUACION',0,0,'C');

		$y = $y + 7;
		$pdf->Line(10,$y,199,$y);
	        		
		$oAreas = new Areas();
		$idmateria = 104; // esto se dejo fijo por que este modulo no debe estar para el ciclo 2013
		$oAlumnos = $oAreas->obtenerAspirantesCicloArea($request->getParameter('idciclo'),$this->getUser()->getProfile()->getIdarea(),$this->getUser()->getProfile()->getIdsede());        
		
		$contador = 1;       
		$contadoralu = 1;
		$contadortotal = 0;
        $carrera = '';
		// verificacion de existencia del objeto alumnos  (if*1)
		if($oAlumnos){	
		    $idPlanAnterior = 0;
		    $idPlan = 0;			
		    foreach ($oAlumnos as $alumat){		
		    	$alumno = Doctrine_Core::getTable('Alumnos')->find($alumat['idalumno']);
				$idPlan = $alumat['idplanestudio']; 
				// cuando cambia de carrera se deba agregar un rotulo (if*2)
				if( $idPlanAnterior!=$idPlan) {
				    $contadoralu = 1;    // por cada carrera tengo el contador de alumnos
	                $pdf->SetXY(0,$y);
	                //Se muestra una etiqueta del grupo
	                $pdf->Cell(140,7,$alumat['nomcar'],0,0,'C'); 
	                $y = $y + 7;
	                
	                $pdf->Line(10,$y,199,$y);
	                 
	                $contador++;     
				} // fin (if*2)

				$pdf->SetXY(10,$y);
				$pdf->Cell(50,6,$contadoralu,0,0,'L');
				$pdf->SetXY(17,$y);        
				$pdf->Cell(35,6,$alumno->getPersonas()->getApellido(),0,0,'L');        
				$pdf->SetXY(65,$y);        
				$pdf->Cell(50,6,$alumno->getPersonas()->getNombre(),0,0,'L');              

				$y=$y+6; $contador++; $contadortotal++; $contadoralu++;  $idPlanAnterior=$idPlan;
				if ($contador==37){
					$pdf->Line(10,$y,199,$y);
					//lineas verticales         
					$pdf->Line(10,47,10,$y);
					$pdf->Line(140,47,140,$y);
					$pdf->Line(199,47,199,$y);
					
					$contador = 1;	
					// add a page
			    	$pdf->AddPage();
						
					$encabezado = '
						<div style="text-align: center; font-family: Times New Roman,Times,serif;"><span
						style="font-size: 12;"><img src="'.$request->getRelativeUrlRoot().'/images/CabeceraSIG-UCU.jpg" width="550px">
						PLANILLA DE EVALUACION PREUNIVERSITARIO - CICLO LECTIVO '.$oCicloLectivo->getCiclo().'</div>';        
					
					$pdf->writeHTML($encabezado, true, false, true, false, '');
					   
					$y = 40;
					$pdf->SetXY(10,$y);
					$pdf->Cell(5,7,'Nº',0,0,'C');    
					$pdf->SetXY(15,$y);
					$pdf->Cell(40,7,'APELLIDO',0,0,'C');    
					$pdf->SetXY(65,$y);
					$pdf->Cell(35,7,'NOMBRE',0,0,'C');    
					$pdf->SetXY(140,$y);
					$pdf->Cell(60,7,'EVALUACION',0,0,'C');		
					$y = $y + 7;
					
					$pdf->Line(10,$y,199,$y);
				}
				$pdf->Line(10,$y,199,$y);	
		    } // fin (foreach)*/
		    
		    //lineas verticales
		    $pdf->Line(10,47,10,$y);
		    $pdf->Line(140,47,140,$y);
		    $pdf->Line(199,47,199,$y);		    
		} // fin (if*1)
		
		$pdf->Output('planilla.pdf', 'I');
 
		// stop symfony process
		throw new sfStopException();
  	
    	return sfView::NONE;    		           
	}	

	// 9 Planilla de Aspirantes (Excel)
	public function executeListadoparasegurocsv(sfWebRequest $request) 
	{
	
		$oCicloLectivo = Doctrine_Core::getTable('CiclosLectivos')->find($request->getParameter('idciclo'));
        // Obtener nuevos inscriptos por anio
		$oAreas = new Areas();
		$oAlumnos = $oAreas->obtenerAspirantesSeguroAlfabetico($request->getParameter('idciclo'),$this->getUser()->getProfile()->getIdarea(),$this->getUser()->getProfile()->getIdsede());

		// verificacion de existencia del objeto alumnos  (if*1)
		if($oAlumnos){
		     //Creamos el archivo temporal de exportación
		    $file = 'listado-aspirantes-'.$oCicloLectivo->getCiclo().'.csv';

		    $fh = fopen($file,"w+") or die ("unable to open file");


			$titulo = ",Legajo, Apellido, Nombre, NroDoc, FecNac, Carrera , TipoDoc, FecIngreso , Foto, FotocopiaDNI, TituloLegalizado, TituloGrado, TituloTramite, CertAlumnoRegular, Libredeuda, Email, EmailUCU, Titulo, NivelEstudio, Establecimiento, Fecha, Duracion, AñoIngreso, AñoEgreso, UnidadTiempo, CantidadMaterias, CantidadMateriasAprobadas, Promedio, Concluyo, Continua, CategoriaTitulo \n";
			fwrite($fh,$titulo); 

		    foreach ($oAlumnos as $alumat){	
		    	$alumno = Doctrine_Core::getTable('Alumnos')->find($alumat['idalumno']);
		    	//Cabecera - Cambienla por sus necesidades

				//se incorpora a la planilla el libredeuda
				// CONTROL LIBREDEUDA //
				$this->administracion = new Administracion();
				$fechalibredeuda = $this->administracion->obtenerlibredeudaalumno($alumat['idalumno'],$alumno->getPersonas()->getNrodoc()); 
				if(!is_array($fechalibredeuda)) {
					$date_format = 'Y-m-d';
					$input = trim($fechalibredeuda);
					$time = strtotime($input);
					
					if (date($date_format, $time) == $input) {
						$libredeuda = $fechalibredeuda;
					} else {
						$libredeuda = "---------";
					}
				} else {
					$libredeuda = "---------";
				}

				$estudios = '';
				if(isset($alumat['titulo'])) {
					$estudios='*'.$alumat['titulo'].",".$alumat['nivel'].",".$alumat['establecimiento'].",".$alumat['fecha'].",".$alumat['duracion'].",".$alumat['anioingreso'].",".$alumat['anioegreso'].",".$alumat['unidad'].",".$alumat['cantmaterias'].",".$alumat['cantmatapro'].",".$alumat['promedio'].",".$alumat['concluyo'].",".$alumat['continua'].",".$alumat['categoria'];
				}
				$row = $alumno->getLegajo().",".$alumno->getPersonas()->getApellido().",".$alumno->getPersonas()->getNombre().",".$alumno->getPersonas()->getNroDoc().",".$alumno->getPersonas()->getFechaNac().",".$alumno->getPlanesEstudios()->getCarreras().",".$alumno->getPersonas()->getTiposDocumentos().",".$alumno->getFechaingreso().",".$alumno->getFotografia().",".$alumno->getFotocopiadni().",".$alumno->getFotocopialegtitulo().",".$alumno->getFotocopialegtitulogrado().",".$alumno->getCerttittramite().",".$alumno->getCertalureg().",".$libredeuda.",".$alumat['e1'].",".$estudios.$alumat['e2'].",".$estudios."\n";
		    	
				fwrite($fh,$row); 
			} 
		}
		
		// Close file            
		fclose($fh);  

		header("Content-Type: application/vnd.ms-excel");
		header("Content-Type: application/force-download");
		header("Content-Transfer-Encoding: binary");
		header("Content-Disposition: attachment;filename=".$file );
		header("Content-Length: ".filesize($file));
		header("Pragma: no-cache");
		header("Expires: 0");
		readfile($file);
		
		// stop symfony process
		throw new sfStopException();
		
		return sfView::NONE;		
	}	

	// 10 Listado de Inscriptos a Curso Anticipado
	public function executeInscriptosCursoAnticipadopdf(sfWebRequest $request)
	{
		$config = sfTCPDFPluginConfigHandler::loadConfig();
		$oCicloLectivo = Doctrine_Core::getTable('CiclosLectivos')->find($request->getParameter('idciclo'));
		// pdf object
		$pdf = new PDF();
		// settings
		$pdf->SetFont("Times", "", 9);
		// sentencias para retirar encabezados y pie por defecto
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		// add a page
		$pdf->AddPage();
	
		$encabezado = '
			<div style="text-align: center; font-family: Times New Roman,Times,serif;"><span
			style="font-size: 12;"><img src="'.$request->getRelativeUrlRoot().'/images/CabeceraSIG-UCU.jpg" width="550px">
			INFORME DE INSCRIPTOS A CURSO ANTICIPADO '.$oCicloLectivo->getCiclo().'</div>';
	
		$pdf->writeHTML($encabezado, true, false, true, false, '');
	
		$y = 40;
		$pdf->SetXY(10,$y);
		$pdf->Cell(5,10,'Nº',0,0,'C');
		$pdf->SetXY(15,$y);
		$pdf->Cell(40,10,'APELLIDO',0,0,'C');
		$pdf->SetXY(55,$y);
		$pdf->Cell(40,10,'NOMBRE',0,0,'C');
		$pdf->SetXY(95,$y);
		$pdf->Cell(20,10,'DOC.',0,0,'C');
		$pdf->SetXY(115,$y);
		$pdf->Cell(10,10,'BAJA',0,0,'C');
		$pdf->SetXY(125,$y);
		$pdf->Cell(20,10,'COM',0,0,'C');
		$pdf->SetXY(145,$y);
		$pdf->Cell(10,10,'USU',0,0,'C');
		$pdf->SetXY(155,$y);
		$pdf->Cell(30,10,'EMAIL',0,0,'C');
	
		$oAreas = new Areas();
		$oAlumnos = $oAreas->obtenerInscriptosCursoAnticipado($request->getParameter('idciclo'),$this->getUser()->getProfile()->getIdarea(),$this->getUser()->getProfile()->getIdsede());
	
		$y = $y + 5;
		$contador = 1;
		$contadorcar = 0;
		$contadoralu = 1;
		$contadortotal = 0;
		// verificacion de existencia del objeto alumnos  (if*1)
		if($oAlumnos){
			$idPlanAnterior = 0;
			$idPlan = 0;
			foreach ($oAlumnos as $alumno){
				$idPlan = $alumno['idplanestudio'];
				// cuando cambia de carrera se deba agregar un rotulo (if*2)
				if( $idPlanAnterior!=$idPlan)   {
					//lineas del rotulo
					$pdf->Line(10,$y+3,199,$y+3);
					$pdf->Line(10,$y+7,199,$y+7);
	
					$y = $y+5;
					$contadoralu = 1;    // por cada carrera tengo el contador de alumnos
					$pdf->SetXY(0,$y-5);
					//Se muestra una etiqueta del grupo
					$pdf->Cell(200,10,$alumno['nomcar'],0,0,'C');
					$contadorcar++;
				} // fin (if*2)
					
				$pdf->SetXY(10,$y);
				$pdf->Cell(5,10,$contadoralu,0,0,'L');
				$pdf->SetXY(15,$y);
				$pdf->Cell(40,10,$alumno['ape'],0,0,'L');
				$pdf->SetXY(55,$y);
				$pdf->Cell(40,10,$alumno['nom'],0,0,'L');
				$pdf->SetXY(95,$y);
				$pdf->Cell(20,10,$alumno['tipodoc'].' '.$alumno['documento'],0,0,'C');
				$activo = $alumno['activo'];
				$estado = "";
				if (!$activo) {$estado = "BAJA";};
				$pdf->SetXY(115,$y);
				$pdf->Cell(10,10,$estado,0,0,'C');
	
				$idmateria = 104;
				$oAlumno = Doctrine_Core::getTable('Alumnos')->find($alumno['idalumno']);
				$alumat = $oAlumno->obtenerComision($idmateria);
				$pdf->SetXY(125,$y);
				$pdf->Cell(20,10,$alumat['idcomision'],0,0,'L');
				$profile = $oAlumno->getPersonas()->existeUsuario();
				// verifico que exista registro en profile
				if($profile) $usuario = 'X'; else $usuario = '';
				$pdf->SetXY(145,$y);
				$pdf->Cell(10,10,$usuario,0,0,'C');
				$contacto = $oAlumno->getPersonas()->getContacto();
				$pdf->SetXY(155,$y);
				$pdf->Cell(30,10,$contacto['email'],0,0,'L');
	
				$y=$y+4; $contador++; $contadortotal++; $contadoralu++;  $idPlanAnterior=$idPlan;
				// chequeo que la cantidad de registros por pagina sea 55 (if*3)
				if ($contador+$contadorcar==55	){
					$pdf->Line(10,$y+3,199,$y+3);
					$contador = 1;
					$contadorcar = 0;
					// add a page
					$pdf->AddPage();
					 
					$encabezado = '
						<div style="text-align: center; font-family: Times New Roman,Times,serif;"><span
						style="font-size: 12;"><img src="'.$request->getRelativeUrlRoot().'/images/CabeceraSIG-UCU.jpg" width="550px">
						INFORME DE ASPIRANTES - CICLO LECTIVO '.$oCicloLectivo->getCiclo().'</div>';
					 
					$pdf->writeHTML($encabezado, true, false, true, false, '');
						
					$y = 40;
					$pdf->SetXY(10,$y);
					$pdf->Cell(5,10,'Nº',0,0,'C');
					$pdf->SetXY(15,$y);
					$pdf->Cell(40,10,'APELLIDO',0,0,'C');
					$pdf->SetXY(55,$y);
					$pdf->Cell(40,10,'NOMBRE',0,0,'C');
					$pdf->SetXY(95,$y);
					$pdf->Cell(20,10,'DOC.',0,0,'C');
					$pdf->SetXY(115,$y);
					$pdf->Cell(10,10,'BAJA',0,0,'C');
					$pdf->SetXY(125,$y);
					$pdf->Cell(20,10,'COM',0,0,'C');
					$pdf->SetXY(145,$y);
					$pdf->Cell(10,10,'USU',0,0,'C');
					$pdf->SetXY(155,$y);
					$pdf->Cell(30,10,'EMAIL',0,0,'C');
					 
					$y = $y + 5;
				}    // fin (if*3)
				$pdf->Line(10,$y+3,199,$y+3);
			}
			$pdf->SetXY(10,$y+10);
			$pdf->Cell(50,10,'CANTIDAD TOTAL:'.$contadortotal,0,0,'L');
		} // fin (if*1)
	
		$pdf->Output('planilla-inscriptos.pdf', 'I');
	
		// stop symfony process
		throw new sfStopException();
		 
		return sfView::NONE;
	}	

	// 11 Listado de Inscriptos a Pre-Universitario
	public function executeInscriptosPreuniversitariopdf(sfWebRequest $request)
	{
		$config = sfTCPDFPluginConfigHandler::loadConfig();
		$oCicloLectivo = Doctrine_Core::getTable('CiclosLectivos')->find($request->getParameter('idciclo'));
		// pdf object
		$pdf = new PDF();
		// settings
		$pdf->SetFont("Times", "", 9);
		// sentencias para retirar encabezados y pie por defecto
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		// add a page
		$pdf->AddPage();
	
		$encabezado = '
			<div style="text-align: center; font-family: Times New Roman,Times,serif;"><span
			style="font-size: 12;"><img src="'.$request->getRelativeUrlRoot().'/images/CabeceraSIG-UCU.jpg" width="550px">
			INFORME DE ASPIRANTES - CICLO LECTIVO '.$oCicloLectivo->getCiclo().'</div>';
	
		$pdf->writeHTML($encabezado, true, false, true, false, '');
	
		$y = 40;
		$pdf->SetXY(10,$y);
		$pdf->Cell(5,10,'Nº',0,0,'C');
		$pdf->SetXY(15,$y);
		$pdf->Cell(40,10,'APELLIDO',0,0,'C');
		$pdf->SetXY(55,$y);
		$pdf->Cell(40,10,'NOMBRE',0,0,'C');
		$pdf->SetXY(95,$y);
		$pdf->Cell(20,10,'DOC.',0,0,'C');
		$pdf->SetXY(115,$y);
		$pdf->Cell(10,10,'BAJA',0,0,'C');
		$pdf->SetXY(125,$y);
		$pdf->Cell(20,10,'COM',0,0,'C');
		$pdf->SetXY(145,$y);
		$pdf->Cell(10,10,'USU',0,0,'C');
		$pdf->SetXY(155,$y);
		$pdf->Cell(30,10,'EMAIL',0,0,'C');
	
		$oAreas = new Areas();
		$oAlumnos = $oAreas->obtenerInscriptosPreCicloArea($request->getParameter('idciclo'),$this->getUser()->getProfile()->getIdarea(),$this->getUser()->getProfile()->getIdsede());
	
		$y = $y + 5;
		$contador = 1;
		$contadorcar = 0;
		$contadoralu = 1;
		$contadortotal = 0;
		// verificacion de existencia del objeto alumnos  (if*1)
		if($oAlumnos){
			$idPlanAnterior = 0;
			$idPlan = 0;
			foreach ($oAlumnos as $alumno){
				$idPlan = $alumno['idplanestudio'];
				// cuando cambia de carrera se deba agregar un rotulo (if*2)
				if( $idPlanAnterior!=$idPlan)   {
					//lineas del rotulo
					$pdf->Line(10,$y+3,199,$y+3);
					$pdf->Line(10,$y+7,199,$y+7);
	
					$y = $y+5;
					$contadoralu = 1;    // por cada carrera tengo el contador de alumnos
					$pdf->SetXY(0,$y-5);
					//Se muestra una etiqueta del grupo
					$pdf->Cell(200,10,$alumno['nomcar'],0,0,'C');
					$contadorcar++;
				} // fin (if*2)
					
				$pdf->SetXY(10,$y);
				$pdf->Cell(5,10,$contadoralu,0,0,'L');
				$pdf->SetXY(15,$y);
				$pdf->Cell(40,10,$alumno['ape'],0,0,'L');
				$pdf->SetXY(55,$y);
				$pdf->Cell(40,10,$alumno['nom'],0,0,'L');
				$pdf->SetXY(95,$y);
				$pdf->Cell(20,10,$alumno['tipodoc'].' '.$alumno['documento'],0,0,'C');
				$activo = $alumno['activo'];
				$estado = "";
				if (!$activo) {$estado = "BAJA";};
				$pdf->SetXY(115,$y);
				$pdf->Cell(10,10,$estado,0,0,'C');
	
				$idmateria = 104;
				$oAlumno = Doctrine_Core::getTable('Alumnos')->find($alumno['idalumno']);
				$alumat = $oAlumno->obtenerComision($idmateria);
				$pdf->SetXY(125,$y);
				$pdf->Cell(20,10,$alumat['idcomision'],0,0,'L');
				$profile = $oAlumno->getPersonas()->existeUsuario();
				// verifico que exista registro en profile
				if($profile) $usuario = 'X'; else $usuario = '';
				$pdf->SetXY(145,$y);
				$pdf->Cell(10,10,$usuario,0,0,'C');
				$contacto = $oAlumno->getPersonas()->getContacto();
				$pdf->SetXY(155,$y);
				$pdf->Cell(30,10,$contacto['email'],0,0,'L');
	
				$y=$y+4; $contador++; $contadortotal++; $contadoralu++;  $idPlanAnterior=$idPlan;
				// chequeo que la cantidad de registros por pagina sea 55 (if*3)
				if ($contador+$contadorcar==55	){
					$pdf->Line(10,$y+3,199,$y+3);
					$contador = 1;
					$contadorcar = 0;
					// add a page
					$pdf->AddPage();
					 
					$encabezado = '
						<div style="text-align: center; font-family: Times New Roman,Times,serif;"><span
						style="font-size: 12;"><img src="'.$request->getRelativeUrlRoot().'/images/CabeceraSIG-UCU.jpg" width="550px">
						INFORME DE ASPIRANTES - CICLO LECTIVO '.$oCicloLectivo->getCiclo().'</div>';
					 
					$pdf->writeHTML($encabezado, true, false, true, false, '');
						
					$y = 40;
					$pdf->SetXY(10,$y);
					$pdf->Cell(5,10,'Nº',0,0,'C');
					$pdf->SetXY(15,$y);
					$pdf->Cell(40,10,'APELLIDO',0,0,'C');
					$pdf->SetXY(55,$y);
					$pdf->Cell(40,10,'NOMBRE',0,0,'C');
					$pdf->SetXY(95,$y);
					$pdf->Cell(20,10,'DOC.',0,0,'C');
					$pdf->SetXY(115,$y);
					$pdf->Cell(10,10,'BAJA',0,0,'C');
					$pdf->SetXY(125,$y);
					$pdf->Cell(20,10,'COM',0,0,'C');
					$pdf->SetXY(145,$y);
					$pdf->Cell(10,10,'USU',0,0,'C');
					$pdf->SetXY(155,$y);
					$pdf->Cell(30,10,'EMAIL',0,0,'C');
					 
					$y = $y + 5;
				}    // fin (if*3)
				$pdf->Line(10,$y+3,199,$y+3);
			}
			$pdf->SetXY(10,$y+10);
			$pdf->Cell(50,10,'CANTIDAD TOTAL:'.$contadortotal,0,0,'L');
		} // fin (if*1)
	
		$pdf->Output('planilla-inscriptos.pdf', 'I');
	
		// stop symfony process
		throw new sfStopException();
		 
		return sfView::NONE;
	}	

	// Plan de Correlatividades
	public function executePlancorrelatividadespdf(sfWebRequest $request) 
	{
		$config = sfTCPDFPluginConfigHandler::loadConfig();

		$salto = 48;
		$idplanestudio =$request->getParameter('idplanestudio');
		//$idplanestudio = 18;
		$oPlanCorrelatividades = Doctrine_Core::getTable('Correlatividades')->getPlanCorrelatividades($idplanestudio);

		// Obtener carrera
		$oCarrera = Doctrine_Core::getTable('Carreras')->find($idplanestudio);
		// Muestra el texto del primer parrafo de la constancia
		$carrera = strtr(strtoupper($oCarrera),"àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ");
		
		// pdf object
		$pdf = new PDF();

    		// settings
		$pdf->SetFont("Times", "", 9);
		// sentencias para retirar encabezados y pie por defecto
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false); 
 
        	// add a page
		$pdf->AddPage();

				
		$encabezado = '
			<div style="text-align: center; font-family: Times New Roman,Times,serif;"><span
			style="font-size: 12;"><img src="'.$request->getRelativeUrlRoot().'/images/CabeceraSIG-UCU.jpg" width="550px">
			PLAN DE CORRELATIVIDADES: '.$carrera.'</div>';        

		$pdf->writeHTML($encabezado, true, false, true, false, '');   
		
		$y = 40;
		$pdf->SetXY(10,$y);
		$pdf->Cell(10,5,'ID',0,0,'C');    
		$pdf->SetXY(20,$y);
		$pdf->Cell(80,5,'MATERIA',0,0,'C');    
		$pdf->SetXY(100,$y);
		$pdf->Cell(50,5,'CURSAR',0,0,'C');    
   		$pdf->SetXY(150,$y);
		$pdf->Cell(50,5,'RENDIR',0,0,'C');
		$pdf->Line(10,$y+5,199,$y+5);
		$pdf->SetXY(100,$y+5);
		$pdf->Cell(25,5,'Regular',0,0,'C');   
		$pdf->Cell(25,5,'Aprobada',0,0,'C');  
		$pdf->Cell(25,5,'Regular',0,0,'C');  
		$pdf->Cell(25,5,'Aprobada',0,0,'C');   	
						
		$y = $y + 5;		
		$contador = 1;
		$contadoranios = 1;
		$idaniocursadaant = 0;
		$idaniocursadaactual = 0;
		
		$pdf->Line(10,$y+5,199,$y+5);
		
	    foreach ($oPlanCorrelatividades as $materia){	
		    			    		
		    	$idaniocursadaactual=$materia['anodecursada'];
				// verifico si cambia de año para mostrar encabezado
			if ($idaniocursadaactual!=$idaniocursadaant) {
				//lineas del rotulo
				$pdf->Line(10,$y+5,199,$y+5);
				//$pdf->Line(10,$y+7,199,$y+7);   
	             
				$y = $y + 5;	
				$contadoranios++;
					
                   	$pdf->SetXY(0,$y-5);
                   	$anioDesc = '';
                   	switch ($idaniocursadaactual) {
					    case 1:
					        $anioDesc='Primer Año';
					        break;
					    case 2:
					        $anioDesc='Segundo Año';
					        break;
					    case 3:
					        $anioDesc='Tercer Año';
					        break;
					    case 4:
					        $anioDesc='Cuarto Año';
					        break;
					    case 5:
					        $anioDesc='Quinto Año';
					        break;
					    case 6:
					        $anioDesc='Sexto Año';
					        break;
					}
                   	$pdf->Cell(100,5,$anioDesc,0,0,'C');	
                   	    																			
	    	    } 
		    	    	    	       	    
		        $pdf->SetXY(10,$y);
		        $pdf->Cell(10,5,$materia['idmateriaplan'],0,0,'L');
		        $pdf->SetXY(20,$y);        
		        $pdf->Cell(80,5,SUBSTR($materia['nombre'],0,60),0,0,'L');        
		        $pdf->SetXY(100,$y);  

		        $pdf->SetFont("Times", "", 8); 
		        $maximalongitud = max(strlen($materia['para_cursar_tener_regular']), strlen($materia['para_cursar_tener_aprobada']), strlen($materia['para_rendir_tener_regular']), strlen($materia['para_rendir_tener_aprobada']));
		        if ($maximalongitud<16){
		        	$pdf->Cell(25,5,$materia['para_cursar_tener_regular']=='' ? '-' : $materia['para_cursar_tener_regular'],0,0,'C');
		        	$pdf->SetXY(125,$y);
		        	$pdf->Cell(25,5,$materia['para_cursar_tener_aprobada']=='' ? '-' : $materia['para_cursar_tener_aprobada'],0,0,'C');
		        	$pdf->SetXY(150,$y);
		        	$pdf->Cell(25,5,$materia['para_rendir_tener_regular']=='' ? '-' : $materia['para_rendir_tener_regular'],0,0,'C');
		        	$pdf->SetXY(175,$y);
		        	$pdf->Cell(25,5,$materia['para_rendir_tener_aprobada']=='' ? '-' : $materia['para_rendir_tener_aprobada'],0,0,'C');
		        }elseif($maximalongitud<45){
		        	$pdf->MultiCell(25,10,$materia['para_cursar_tener_regular']=='' ? '-' : $materia['para_cursar_tener_regular'],0,'C');
		        	$pdf->SetXY(125,$y);
		        	$pdf->MultiCell(25,10,$materia['para_cursar_tener_aprobada']=='' ? '-' : $materia['para_cursar_tener_aprobada'],0,'C');
		        	$pdf->SetXY(150,$y);
		        	$pdf->MultiCell(25,10,$materia['para_rendir_tener_regular']=='' ? '-' : $materia['para_rendir_tener_regular'],0,'C');
		        	$pdf->SetXY(175,$y);
		        	$pdf->MultiCell(25,10,$materia['para_rendir_tener_aprobada']=='' ? '-' : $materia['para_rendir_tener_aprobada'],0,'C');
		        	$y=$y+5;
		        }else{
		        	$pdf->MultiCell(25,15,$materia['para_cursar_tener_regular']=='' ? '-' : $materia['para_cursar_tener_regular'],0,'C');
		        	$pdf->SetXY(125,$y);
		        	$pdf->MultiCell(25,15,$materia['para_cursar_tener_aprobada']=='' ? '-' : $materia['para_cursar_tener_aprobada'],0,'C');
		        	$pdf->SetXY(150,$y);
		        	$pdf->MultiCell(25,15,$materia['para_rendir_tener_regular']=='' ? '-' : $materia['para_rendir_tener_regular'],0,'C');
		        	$pdf->SetXY(175,$y);
		        	$pdf->MultiCell(25,15,$materia['para_rendir_tener_aprobada']=='' ? '-' : $materia['para_rendir_tener_aprobada'],0,'C');
		        	$y=$y+10;		        	
		        }
				
                $pdf->SetFont("Times", "", 9);
    	    
				$y=$y+5; $contador++; $idaniocursadaant=$idaniocursadaactual;
				if (($contador+$contadoranios == $salto) or ($pdf->GetY()>250)){				            
					// add a page
			    	$pdf->AddPage();
			    	
					$encabezado = '
					<div style="text-align: center; font-family: Times New Roman,Times,serif;"><span
					style="font-size: 12;"><img src="'.$request->getRelativeUrlRoot().'/images/CabeceraSIG-UCU.jpg" width="550px">
					PLAN DE CORRELATIVIDADES: '.$carrera.'</div>';         

					$pdf->writeHTML($encabezado, true, false, true, false, '');   
		
					$y = 40;
					$pdf->SetXY(10,$y);
					$pdf->Cell(10,5,'ID',0,0,'C');    
					$pdf->SetXY(20,$y);
					$pdf->Cell(80,5,'MATERIA',0,0,'C');    
					$pdf->SetXY(100,$y);
					$pdf->Cell(50,5,'CURSAR',0,0,'C');    
			   		$pdf->SetXY(150,$y);
					$pdf->Cell(50,5,'RENDIR',0,0,'C');
					$pdf->Line(10,$y+5,199,$y+5);
					$pdf->SetXY(100,$y+5);
					$pdf->Cell(25,5,'Regular',0,0,'C');   
					$pdf->Cell(25,5,'Aprobada',0,0,'C');  
					$pdf->Cell(25,5,'Regular',0,0,'C');  
					$pdf->Cell(25,5,'Aprobada',0,0,'C');  

					$y = $y + 5;
					$contador = 1;
					$contadoranios = 1;
					
					$pdf->Line(10,$y+5,199,$y+5);				
										
					$y = $y + 5;							
				}
				if(strlen($materia['para_rendir_tener_aprobada'])>100) $y=$y+50;		
				$pdf->Line(10,$y,199,$y);
 
	
		    } // fin (foreach)	

		$pdf->Output('planilla.pdf', 'I');
 
		// stop symfony process
		throw new sfStopException();
  	
    	return sfView::NONE;    		
	}   	

	// Plan de estudios
	public function executePlanesestudios(sfWebRequest $request)	{	
    	$this->mensaje = "";	
		$this->form = new BuscarCarrerasActivasPersonasForm(array(
		    'referer' => $request->getGetParameter('referer', str_replace($request->getUriPrefix(), '', $request->getUri()))
		));	
	  	if ($request->isMethod('post')) {		

			// Obtener la fecha actual
			$hoy = date('Y-m-d');
			// Obtener el ciclo lectivo activo
			$idciclolectivo = Doctrine_Core::getTable('CiclosLectivos')->getIdUltimoCicloLectivoActivo();
			// Obtener el alumno
			$oAlumno = Doctrine_Core::getTable('Alumnos')->find($request->getParameter('idalumno'));
			// Controla si esta inscripto el alumno en el ciclo lectivo
			$inscripto = Doctrine_Core::getTable('InscripcionesCicloLectivo')->getControlActivo($idciclolectivo, $oAlumno->getIdalumno());

       			$oCalendario = Doctrine_Core::getTable('Calendarios')->obtenerCalendario($oAlumno->getPlanesEstudios()->getCarreras()->getIdfacultad(), $oAlumno->getIdsede());      	        	        					    

			$fechas = $oCalendario->obtenerFechasPorTipo(4);
			
			// Controla que la fecha actual este dentro de un periodo de inscripcion
			$habilitado = false;
			foreach ($fechas as $fecha) {
				if(strtotime($hoy) > strtotime($fecha->getInicio()) && strtotime($hoy) < strtotime($fecha->getFin())) {
					$habilitado = true;
				}
			}	
			
			// Controla si es un aspirante en el ciclo lectivo activo
			$aspirante = false;
			if ($idciclolectivo == $oAlumno->getIdciclolectivo()) {
				$aspirante = true;
			}

			if ($inscripto && $habilitado && !$aspirante) {
			//$this->form->setDefault('idalumno', $request->getParameter('idalumno')); 	
       		 	$this->executeObtenermateriascursar($request);
			}
	  	}	
	}	

	public function executePadronsocios()	{	
	}

	// Plan de estudios (PDF)
	public function executePadronsociospdf(sfWebRequest $request)	{	
		
		$oSocios = Doctrine_Core::getTable('Personas')->obtenerSocios();

		// pdf object
		$pdf = new PDF();

    	// settings
		$pdf->SetFont("Times", "", 9);
		// sentencias para retirar encabezados y pie por defecto
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false); 
 
        // add a page
		$pdf->AddPage();
		$current_date = date("Y");
		$encabezado = '
			<div style="text-align: center; font-family: Times New Roman,Times,serif;"><span
			style="font-size: 12;"><img src="'.$request->getRelativeUrlRoot().'/images/alcec3.jpg" width="550px">
			Padron Socios: '.$current_date.'</div>';        

		$pdf->writeHTML($encabezado, true, false, true, false, '');   
		
		$y = 60;
		$pdf->SetXY(10,$y);
		$pdf->Cell(10,5,'Nro',0,0,'C');    
		$pdf->SetXY(20,$y);
		$pdf->Cell(80,5,'Nombre',0,0,'C');    
		$pdf->SetXY(20,$y);
		$pdf->Cell(235,5,'Nro Doc',0,0,'C'); 
		$pdf->SetXY(20,$y);
		$pdf->Cell(280,5,'Fecha Ing.',0,0,'C'); 
		$pdf->SetXY(20,$y);
		$y = $y + 5;		
		$contador = 1;
		
		$pdf->Line(10,$y,199,$y);
		
	    foreach ($oSocios as $socio){	
		    			    		
		   	$pdf->SetXY(0,$y-5);
            $pdf->SetXY(10,$y);
		    $pdf->Cell(10,5,$socio['idpersona'],0,0,'L');
		    $pdf->SetXY(20,$y);        
		    $pdf->Cell(80,5,$socio['nombrecompleto'],0,0,'L');        
		    $pdf->SetXY(130,$y); 
		    $pdf->Cell(10,5,$socio['nrodoc'],0,0,'L'); 
		    $pdf->SetXY(150,$y); 
		    $pdf->Cell(10,5,$socio['fechaingreso'],0,0,'L'); 
		    
		
 			$y = $y + 5;  
		 	// add a page
			if($y>=265) {
				$pdf->AddPage();

				$encabezado = '
			<div style="text-align: center; font-family: Times New Roman,Times,serif;"><span
			style="font-size: 12;"><img src="'.$request->getRelativeUrlRoot().'/images/alcec3.jpg" width="550px">
			Padron Socios: '.$current_date.'</div>';        
	
				$pdf->writeHTML($encabezado, true, false, true, false, '');   
				$y=60;

			}
	
		    } // fin (foreach)	

			 
		$pdf->Output('planilla.pdf', 'I');
 
		// stop symfony process
		throw new sfStopException();
				
		return sfView::NONE;
	}
	

	// Plan de estudios (PDF)
	public function executePlanespdf(sfWebRequest $request)	{	
		$config = sfTCPDFPluginConfigHandler::loadConfig();

		$salto = 48;

		//$oMateriasPlanes = new MateriasPlanes();
		//$oMateriasPlanes->setIdPlanestudio($request->getParameter('idplanestudio'));
		$oMateriasPlanes = Doctrine_Core::getTable('MateriasPlanes')->obtenerMateriasPlan($request->getParameter('idplanestudio'));

		// Obtener carrera
		$oPlan = Doctrine_Core::getTable('PlanesEstudios')->find($request->getParameter('idplanestudio'));
		$oCarrera = Doctrine_Core::getTable('Carreras')->find($oPlan->getIdcarrera());
		// Muestra el texto del primer parrafo de la constancia
		//$carrera = strtr(strtoupper($oCarrera),"àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ");
		$carrera=$oCarrera;
		$plan= $oPlan;

		// pdf object
		$pdf = new PDF();

    	// settings
		$pdf->SetFont("Times", "", 9);
		// sentencias para retirar encabezados y pie por defecto
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false); 
 
        // add a page
		$pdf->AddPage();
		
		$encabezado = '
			<div style="text-align: center; font-family: Times New Roman,Times,serif;"><span
			style="font-size: 12;"><img src="'.$request->getRelativeUrlRoot().'/images/CabeceraSIG-UCU.jpg" width="550px">
			Carrera: '.$plan.'</div>';        

		$pdf->writeHTML($encabezado, true, false, true, false, '');   
		
		$y = 45;
		$pdf->SetXY(10,$y);
		$pdf->Cell(10,5,'ID',0,0,'C');    
		$pdf->SetXY(20,$y);
		$pdf->Cell(80,5,'MATERIA',0,0,'C');    
		$pdf->SetXY(20,$y);
		$pdf->Cell(230,5,'Orden',0,0,'C'); 
		$pdf->SetXY(20,$y);
		$pdf->Cell(250,5,'Cuatri.',0,0,'C'); 
		$pdf->SetXY(20,$y);
		$pdf->Cell(290,5,'Disposición',0,0,'C'); 
		$pdf->SetXY(20,$y);
		$pdf->Cell(330,5,'Tipo',0,0,'C'); 
		$pdf->SetXY(20,$y);
		$pdf->Cell(350,5,'Vence',0,0,'C'); 
		$y = $y + 5;		
		$contador = 1;
		$contadoranios = 1;
		$idaniocursadaant = -1;
		$idaniocursadaactual = 0;
		
		$pdf->Line(10,$y+5,199,$y+5);
		
	    foreach ($oMateriasPlanes as $materia){	
		    			    		
		    $idaniocursadaactual=$materia['anodecursada'];
				// verifico si cambia de año para mostrar encabezado
			if ($idaniocursadaactual!=$idaniocursadaant) {
				//lineas del rotulo
				$pdf->Line(10,$y+5,199,$y+5);
				//$pdf->Line(10,$y+7,199,$y+7);   
	             
				//$y = $y + 5;	
				$contadoranios++;
					
                   	$pdf->SetXY(0,$y-5);
                   	$anioDesc = '';
                   	switch ($idaniocursadaactual) {
					    case 0:
					        $anioDesc='Preuniversitario/Propedeutico';
					        break;
					    case 1:
					        $anioDesc='Primer Año';
					        break;
					    case 2:
					        $anioDesc='Segundo Año';
					        break;
					    case 3:
					        $anioDesc='Tercer Año';
					        break;
					    case 4:
					        $anioDesc='Cuarto Año';
					        break;
					    case 5:
					        $anioDesc='Quinto Año';
					        break;
					    case 6:
					        $anioDesc='Sexto Año';
					        break;
					}
				$y = $y + 4;
			$pdf->SetXY(0,$y-5);
                   	$pdf->Cell(200,5,$anioDesc,0,0,'C');	
				$pdf->Line(10,$y,199,$y);
                   	   $idaniocursadaant=$idaniocursadaactual; 																			
	    	    } 
	 	    	       	    
		        $pdf->SetXY(10,$y);
		        $pdf->Cell(10,5,$materia['idmateriaplan'],0,0,'L');
		        $pdf->SetXY(20,$y);        
		        $pdf->Cell(80,5,SUBSTR($materia->getMaterias()->getNombre(),0,60),0,0,'L');        
		        $pdf->SetXY(135,$y); 
		        $pdf->Cell(10,5,$materia['orden'],0,0,'L'); 
		        $pdf->SetXY(145,$y); 
		        $pdf->Cell(10,5,$materia->getPeriododecursada(),0,0,'L'); 
		        $pdf->SetXY(155,$y); 
		        $pdf->Cell(10,5,$materia->getTiposCursadas(),0,0,'L'); 
		        $pdf->SetXY(175,$y); 
		        $pdf->Cell(10,5,$materia->getTiposMaterias(),0,0,'L'); 
		        $pdf->SetXY(195,$y); 
		        $pdf->Cell(10,5,$materia->getCantidadaplazos(),0,0,'L'); 

 			$y = $y + 5;  
		 	// add a page
			if($y>=265) {
				$pdf->AddPage();

				$encabezado = '
				<div style="text-align: center; font-family: Times New Roman,Times,serif;"><span
				style="font-size: 12;"><img src="'.$request->getRelativeUrlRoot().'/images/CabeceraSIG-UCU.jpg" width="550px">
				PLAN DE ESTUDIO: '.$carrera.'</div>';        
	
				$pdf->writeHTML($encabezado, true, false, true, false, '');   
				$y=45;

			}
	
		    } // fin (foreach)	

			 
		$pdf->Output('planilla.pdf', 'I');
 
		// stop symfony process
		throw new sfStopException();
				
		return sfView::NONE;
	}

	// Registros de Estados por Ciclo
	public function executeRegistrosEstadosPorCiclopdf(sfWebRequest $request) 
	{
		$config = sfTCPDFPluginConfigHandler::loadConfig();
 		$oCicloLectivo = Doctrine_Core::getTable('CiclosLectivos')->find($request->getParameter('idciclo'));
 		$oEstados = Doctrine_Core::getTable('EstadosAlumno')->find($request->getParameter('idestado'));
		// pdf object
		$pdf = new PDF();
		// settings
		$pdf->SetFont("Times", "", 9);
		// sentencias para retirar encabezados y pie por defecto
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);  
		// add a page
		$pdf->AddPage();
                $estado="";
		$encabezado = '
			<div style="text-align: center; font-family: Times New Roman,Times,serif;"><span
			style="font-size: 12;"><img src="'.$request->getRelativeUrlRoot().'/images/CabeceraSIG-UCU.jpg" width="550px">
			Informe de Alumnos con Estado "'.$oEstados->getDescripcion().'" en Ciclo Lectivo '.$oCicloLectivo->getCiclo().'</div>';        
        
		$pdf->writeHTML($encabezado, true, false, true, false, '');
		
		$y = 40;
		$pdf->SetXY(10,$y);
		$pdf->Cell(5,10,'Nº',0,0,'C');    
		$pdf->SetXY(15,$y);
		$pdf->Cell(40,10,'APELLIDO',0,0,'C');    
		$pdf->SetXY(55,$y);
		$pdf->Cell(40,10,'NOMBRE',0,0,'C');    
		$pdf->SetXY(95,$y);
		$pdf->Cell(20,10,'FECHA',0,0,'C');    
		$pdf->SetXY(115,$y);		
		//$pdf->Cell(10,10,'BAJA',0,0,'C');    
		$pdf->SetXY(125,$y);
		//$pdf->Cell(20,10,'COM',0,0,'C');    
		$pdf->SetXY(145,$y);
  		//$pdf->Cell(10,10,'USU',0,0,'C');       
		$pdf->SetXY(155,$y);
        $pdf->Cell(30,10,'EMAIL',0,0,'C');   		      

		$oAreas = new Areas();
//($anio, $idarea, $idsede, $idestado)
		$oAlumnos = $oAreas->obtenerAlumnosEstadoArea($oCicloLectivo->getId(),$this->getUser()->getProfile()->getIdarea(),$this->getUser()->getProfile()->getIdsede(),$request->getParameter('idestado'));
        
		$y = $y + 5;
		$contador = 1;
		$contadorcar = 0;
		$contadoralu = 1;
		$contadortotal = 0;
		// verificacion de existencia del objeto alumnos  (if*1)
		if($oAlumnos){
		    $idPlanAnterior = 0;
		    $idPlan = 0;
		    foreach ($oAlumnos as $alumno){		
				$idPlan = $alumno['idplanestudio'];
				// cuando cambia de carrera se deba agregar un rotulo (if*2)
				if( $idPlanAnterior!=$idPlan)   {
					//lineas del rotulo
					$pdf->Line(10,$y+3,199,$y+3);
			        $pdf->Line(10,$y+7,199,$y+7);   
			                             
					$y = $y+5;
				    $contadoralu = 1;    // por cada carrera tengo el contador de alumnos
	                $pdf->SetXY(0,$y-5);
	                //Se muestra una etiqueta del grupo
	                $pdf->Cell(200,10,$alumno['nomcar'],0,0,'C'); 
	                $contadorcar++;     
				} // fin (if*2)
					
		        $pdf->SetXY(10,$y);
		        $pdf->Cell(5,10,$contadoralu,0,0,'L');
		        $pdf->SetXY(15,$y);        
		        $pdf->Cell(40,10,$alumno['ape'],0,0,'L');        
		        $pdf->SetXY(55,$y);        
		        $pdf->Cell(40,10,$alumno['nom'],0,0,'L');              
		        $pdf->SetXY(95,$y);        
		        $pdf->Cell(20,10, date("d-m-Y", strtotime($alumno['fechaestado'])),0,0,'C'); 
		  		$activo = $alumno['activo'];
				$estado = "";
				if (!$activo) {$estado = "BAJA";};
		        $pdf->SetXY(115,$y);        
				//$pdf->Cell(10,10,$alumno['obs'],0,0,'C');  
	
				$idmateria = 104;
				$oAlumno = Doctrine_Core::getTable('Alumnos')->find($alumno['idalumno']);
		        $alumat = $oAlumno->obtenerComision($idmateria);
		        $pdf->SetXY(125,$y);        
		        $pdf->Cell(20,10,$alumat['idcomision'],0,0,'L'); 		
		        $profile = $oAlumno->getPersonas()->existeUsuario();
				// verifico que exista registro en profile 
				if($profile) $usuario = 'X'; else $usuario = '';
		        $pdf->SetXY(145,$y);        
		        $pdf->Cell(10,10,$usuario,0,0,'C'); 
				$contacto = $oAlumno->getPersonas()->getContacto();	
		        $pdf->SetXY(145,$y);
		        //$pdf->Cell(30,10,$contacto['cel'],0,0,'L'); 
		        $pdf->SetXY(155,$y);
		        $pdf->Cell(30,10,$contacto['email'],0,0,'L'); 
	
		        $y=$y+4; $contador++; $contadortotal++; $contadoralu++;  $idPlanAnterior=$idPlan;
				// chequeo que la cantidad de registros por pagina sea 55 (if*3)
		        if ($contador+$contadorcar==55	){
		        	$pdf->Line(10,$y+3,199,$y+3);
		            $contador = 1;
		            $contadorcar = 0;
		            // add a page
			    	$pdf->AddPage();
				    	
					$encabezado = '
						<div style="text-align: center; font-family: Times New Roman,Times,serif;"><span
						style="font-size: 12;"><img src="'.$request->getRelativeUrlRoot().'/images/CabeceraSIG-UCU.jpg" width="550px">
						INFORME DE ASPIRANTES - CICLO LECTIVO '.$oCicloLectivo->getCiclo().'</div>';        
					        
					$pdf->writeHTML($encabezado, true, false, true, false, '');	
							
					$y = 40;
					$pdf->SetXY(10,$y);
					$pdf->Cell(5,10,'Nº',0,0,'C');    
					$pdf->SetXY(15,$y);
					$pdf->Cell(40,10,'APELLIDO',0,0,'C');    
					$pdf->SetXY(55,$y);
					$pdf->Cell(40,10,'NOMBRE',0,0,'C');    
					$pdf->SetXY(95,$y);
					$pdf->Cell(20,10,'DOC.',0,0,'C');    
					$pdf->SetXY(115,$y);		
					//$pdf->Cell(10,10,'BAJA',0,0,'C');    
					$pdf->SetXY(125,$y);
					//$pdf->Cell(20,10,'COM',0,0,'C');    
					$pdf->SetXY(145,$y);
			  		//$pdf->Cell(10,10,'USU',0,0,'C');       
					$pdf->SetXY(155,$y);
			        $pdf->Cell(30,10,'EMAIL',0,0,'C');
			        
			        $y = $y + 5;
		        }    // fin (if*3)           
				$pdf->Line(10,$y+3,199,$y+3);       
		    }
		    $pdf->SetXY(10,$y+10);
			$pdf->Cell(50,10,'CANTIDAD TOTAL:'.$contadortotal,0,0,'L');	
		} // fin (if*1)
		
		$pdf->Output('planilla-asistencia.pdf', 'I');
 
		// stop symfony process
		throw new sfStopException();
  	
    	return sfView::NONE;    		 
	}	

	// Listado de Aspirantes SAO AUTOGESTION
	public function executeSaoAutogestionpdf(sfWebRequest $request) 
	{
		$config = sfTCPDFPluginConfigHandler::loadConfig();
 		$oCicloLectivo = Doctrine_Core::getTable('CiclosLectivos')->find($request->getParameter('idciclo'));

 		$oPlanesestudios = Doctrine_Core::getTable('PlanesEstudios')->find($request->getParameter('idplanestudio'));
		// pdf object
		$pdf = new PDF();
		// settings
		$pdf->SetFont("Times", "", 9);
		// sentencias para retirar encabezados y pie por defecto
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);  
		// add a page
		$pdf->AddPage();
                if($oCicloLectivo<>''){
		    $encabezado = '
			<div style="text-align: center; font-family: Times New Roman,Times,serif;"><span
			style="font-size: 12;"><img src="'.$request->getRelativeUrlRoot().'/images/CabeceraSIG-UCU.jpg" width="550px">
			INFORME DE ASPIRANTES - SAO AUTOGESTION '.$oCicloLectivo->getCiclo().'</div>';        
        	} else {
			if($oPlanesestudios<>'') $carrera=$oPlanesestudios->getCarreras()->getNombre();
		    $encabezado = '
			<div style="text-align: center; font-family: Times New Roman,Times,serif;"><span
			style="font-size: 12;"><img src="'.$request->getRelativeUrlRoot().'/images/CabeceraSIG-UCU.jpg" width="550px">
			INFORME DE CONTROL DE DOCUMENACIONES Y ESTADOS - FECHA: '.date("d-m-Y H:i").'<br> CARRERA: '.$carrera.' </div>';    
		};
		$pdf->writeHTML($encabezado, true, false, true, false, '');
		
		$y = 40;
		$pdf->SetXY(10,$y);
		$pdf->Cell(5,10,'Nº',0,0,'C');    
		$pdf->SetXY(15,$y);
		$pdf->Cell(40,10,'APELLIDO',0,0,'C');    
		$pdf->SetXY(55,$y);
		$pdf->Cell(40,10,'NOMBRE',0,0,'C');    
		$pdf->SetXY(95,$y);
		$pdf->Cell(20,10,'DOC.',0,0,'C');    
		$pdf->SetXY(115,$y);		
		$pdf->Cell(10,10,'ESTADO',0,0,'C');    
		$pdf->SetXY(128,$y);
		$pdf->Cell(20,10,'F-D-R-T-FT-P',0,0,'C');    
		$pdf->SetXY(148,$y);
  		$pdf->Cell(10,10,'USU',0,0,'C');       
		$pdf->SetXY(155,$y);
        $pdf->Cell(30,10,'EMAIL SAO',0,0,'C');   		      

		$oAreas = new Areas();
		if($request->getParameter('idciclo')<>''){
			$oAlumnos = $oAreas->obtenerAspirantesCicloAreaAutogestion($request->getParameter('idciclo'),$this->getUser()->getProfile()->getIdarea(),$this->getUser()->getProfile()->getIdsede());
		} else {
			$oAlumnos = $oAreas->obtenerInformeControlGeneral($request->getParameter('idplanestudio'), $this->getUser()->getProfile()->getIdsede()); 
		};
        
		$y = $y + 5;
		$contador = 1;
		$contadorcar = 0;
		$contadoralu = 1;
		$contadortotal = 0;
		// verificacion de existencia del objeto alumnos  (if*1)
		if($oAlumnos){
		    $idPlanAnterior = 0;
		    $idPlan = 0;
		    $this->administracion = new Administracion();
		    $contador_estado=0;
		    $contador_acreditabanco=0;
		    $contador_ag=0;
		    $contador_fin =0;
		    $contador_finhasta =0;
		    $contador_recursante =0;
		    $contador_nodefinido=0;
		    foreach ($oAlumnos as $alumno){	
				$mensajelibredeuda="";
				$mensajeestado='';
				$mensajeacreditabanco='';
				$mensaje_fechafinag='';
		    		$mensaje_fin ='';
		    		$mensaje_finhasta ='';
		    		$mensaje_recursante ='';
				$mensaje_verificar="";
				$baja ="";
				$numerodoc ="";
				$ndni ="";
				if($request->getParameter('idciclo')<>''){
					$fechalibredeuda = $this->administracion->obtenerlibredeudaalumno($alumno['idalumno'],$alumno['documento']);
				} else {
					$datosalumnows = $this->administracion->obtenerestadoalumno($alumno['idalumno'],$alumno['documento']);  
				}
				if (count($datosalumnows)){
					$fechalibredeuda =$datosalumnows[0];
					$estadoadm=$datosalumnows[1];
					$acreditabanco=$datosalumnows[2];
					$fechafinag =$datosalumnows[3];
					$fin =$datosalumnows[4];
					$finhasta =$datosalumnows[5];
					$recursante =$datosalumnows[6];
					$baja =$datosalumnows[7];
					$numerodoc =$datosalumnows[8];
					$ndni =$datosalumnows[9];
				}
				if($fechalibredeuda >= date('Y-m-d')) {
					$mensajelibredeuda = "(CL)";
				} else {
					$pos=strpos($fechalibredeuda,'-');
					if($pos>0) {
						$mensajelibredeuda = "(SL)"; 
					} else {
						$mensajelibredeuda = "(?)"; 
					};

				}

				if($finhasta >= date('Y-m-d')) {
					$mensaje_finhasta = "#";
					$contador_finhasta++;
				}
				if($fin) {
					$mensaje_fin='F';
					$contador_fin++;
				}
				if($recursante) {
					$mensaje_recursante='R';
					$contador_recursante++;
				}
				if($baja==1) {
					$baja='B';
				} else $baja='';

				if($estadoadm) {
					$mensajeestado='*';
					$contador_estado++;
				}
				if($fechafinag) {
					if ($fechafinag>= date('Y-m-d')) {
						$mensaje_fechafinag='AG';
						$contador_ag++;
					}
				}
				if($estadoadm & $acreditabanco) {
					$mensajeacreditabanco='$';
					$contador_acreditabanco++;
				}

				if($mensajelibredeuda != "(?)" and $mensajeestado=='' and $mensaje_fechafinag=='' and $mensaje_fin =='' and $mensaje_recursante =='') {
					 $contador_nodefinido++;
					 $mensaje_verificar="VER";
				}


				$idPlan = $alumno['idplanestudio'];
				// cuando cambia de carrera se deba agregar un rotulo (if*2)
				if( $idPlanAnterior!=$idPlan)   {
					//lineas del rotulo
					$pdf->Line(10,$y+3,199,$y+3);
			        $pdf->Line(10,$y+7,199,$y+7);   
			                             
					$y = $y+5;
				    $contadoralu = 1;    // por cada carrera tengo el contador de alumnos
	                $pdf->SetXY(0,$y-5);
	                //Se muestra una etiqueta del grupo
	                $pdf->Cell(200,10,$alumno['nomcar'],0,0,'C'); 
	                $contadorcar++;     
				} // fin (if*2)

		        $pdf->SetXY(8,$y);
		        $pdf->Cell(5,10,$baja,0,0,'L');					
		        $pdf->SetXY(10,$y);
		        $pdf->Cell(5,10,$alumno['idalumno'],0,0,'L'); //$contadoralu
		        $pdf->SetXY(18,$y);        
		        $pdf->Cell(40,10,$alumno['ape'],0,0,'L');        
		        $pdf->SetXY(55,$y);        
		        $pdf->Cell(40,10,$alumno['nom'],0,0,'L');              
		        $pdf->SetXY(95,$y);    
			//if($ndni<>$alumno['documento']) $doc=$ndni.'!!'.$numerodoc; else $doc=$alumno['documento'];  
		        $pdf->Cell(20,10,$alumno['ciclo'].' '.$alumno['documento'],0,0,'C'); 
		  		$activo = $alumno['activo'];
				$estado = "";
				if ($alumno['idestado']!=1) {$estado = "(".$alumno['idestado'].")";};
				if($oCicloLectivo=='') $estado="(".$mensaje_verificar.$mensajeestado.$mensajeacreditabanco.$mensaje_fechafinag.$mensaje_fin.$mensaje_finhasta.$mensaje_recursante.")";
		        $pdf->SetXY(116,$y);        
				$pdf->Cell(10,10,$estado,0,0,'C');  
		        $pdf->SetXY(125,$y);        
				$pdf->Cell(10,10,$mensajelibredeuda,0,0,'C'); 	
				$idmateria = 104;
				$oAlumno = Doctrine_Core::getTable('Alumnos')->find($alumno['idalumno']);
		        $alumat = $oAlumno->obtenerComision($idmateria);
		        $pdf->SetXY(133,$y);        
		        $pdf->Cell(20,10,$alumno['fotografia'].'-'.$alumno['fotocopiadni'].'-'.$alumno['certalureg'].'-'.$alumno['certtittramite'].'- '.$alumno['fotocopialegtitulo'].'-'.$alumno['fotocopialegpartidanac'],0,0,'L'); 		
		        $profile = $oAlumno->getPersonas()->existeUsuario();
				// verifico que exista registro en profile 
				if($profile) $usuario = 'X'; else $usuario = '';
		        $pdf->SetXY(147,$y);        
		        $pdf->Cell(10,10,$usuario,0,0,'C'); 
				$contacto = $oAlumno->getPersonas()->getContacto();	
		        $pdf->SetXY(155,$y);
		        $pdf->Cell(30,10,$contacto['email1'],0,0,'L'); 
	
		        $y=$y+4; $contador++; $contadortotal++; $contadoralu++;  $idPlanAnterior=$idPlan;
				// chequeo que la cantidad de registros por pagina sea 55 (if*3)
		        if ($contador+$contadorcar==50	){
		        	$pdf->Line(10,$y+3,199,$y+3);
		            $contador = 1;
		            $contadorcar = 0;
		            // add a page
			    	$pdf->AddPage();
				if($oCicloLectivo<>''){
				    $encabezado = '
					<div style="text-align: center; font-family: Times New Roman,Times,serif;"><span
					style="font-size: 12;"><img src="'.$request->getRelativeUrlRoot().'/images/CabeceraSIG-UCU.jpg" width="550px">
					INFORME DE ASPIRANTES - SAO AUTOGESTION '.$oCicloLectivo->getCiclo().'</div>';        
				} else {
					if($oPlanesestudios<>'') $carrera=$oPlanesestudios->getCarreras()->getNombre();
				    $encabezado = '
					<div style="text-align: center; font-family: Times New Roman,Times,serif;"><span
					style="font-size: 12;"><img src="'.$request->getRelativeUrlRoot().'/images/CabeceraSIG-UCU.jpg" width="550px">
					INFORME DE CONTROL DE DOCUMENACIONES Y ESTADOS - FECHA: '.date("d-m-Y H:i").'<br> CARRERA: '.$carrera.' </div>';    
				};     
					        
					$pdf->writeHTML($encabezado, true, false, true, false, '');	
							
					$y = 40;
					$pdf->SetXY(10,$y);
					$pdf->Cell(5,10,'Nº',0,0,'C');    
					$pdf->SetXY(15,$y);
					$pdf->Cell(40,10,'APELLIDO',0,0,'C');    
					$pdf->SetXY(55,$y);
					$pdf->Cell(40,10,'NOMBRE',0,0,'C');    
					$pdf->SetXY(95,$y);
					$pdf->Cell(20,10,'DOC.',0,0,'C');    
					$pdf->SetXY(115,$y);		
					$pdf->Cell(10,10,'ESTADO',0,0,'C');    
					$pdf->SetXY(128,$y);
					$pdf->Cell(20,10,'F-D-R-T-FT-P',0,0,'C');    
					$pdf->SetXY(148,$y);
			  		$pdf->Cell(10,10,'USU',0,0,'C');       
					$pdf->SetXY(155,$y);
			        $pdf->Cell(30,10,'EMAIL SAO',0,0,'C');
			        
			        $y = $y + 5;
		        }    // fin (if*3)           
				$pdf->Line(10,$y+3,199,$y+3);       
		    }


		    $pdf->SetXY(10,$y+10);
			$pdf->Cell(50,10,'CANTIDAD TOTAL:'.$contadortotal,0,0,'L');
		    if($request->getParameter('idciclo')==''){
				$y = $y + 4;	
			    $pdf->SetXY(10,$y+10);
				$pdf->Cell(50,10,'CANTIDAD ACTIVOS ADM:'.$contador_estado,0,0,'L');	
				$y = $y + 4;	
			    $pdf->SetXY(10,$y+10);
				$pdf->Cell(50,10,'CANTIDAD ACREDITAN BANCO:'.$contador_acreditabanco,0,0,'L');	
				$y = $y + 4;	
			    $pdf->SetXY(10,$y+10);
				$pdf->Cell(50,10,'CANTIDAD AÑO DE GRACIA:'.$contador_ag,0,0,'L');	
				$y = $y + 4;	
			    $pdf->SetXY(10,$y+10);
				$pdf->Cell(50,10,'CANTIDAD FIN DE CARRERA:'.$contador_fin,0,0,'L');	
				$y = $y + 4;	
			    $pdf->SetXY(10,$y+10);
				$pdf->Cell(50,10,'CANTIDAD RECURSANTES:'.$contador_recursante,0,0,'L');	
				$y = $y + 4;	
			    $pdf->SetXY(10,$y+10);
				$pdf->Cell(50,10,'ALUMNOS SIN ESTADO DEFINIDO:'.$contador_nodefinido,0,0,'L');	

 
	
		   }
		} // fin (if*1)
		if($request->getParameter('idciclo')<>''){
			$y = $y + 5;
			$pdf->SetXY(10,$y+10);
			$pdf->Cell(50,10,'Estados: 2-Baja / 3-Egresado / 6-Enmienda',0,0,'L');	
		} 
	        $y = $y + 5;
	        $pdf->SetXY(10,$y+10);
		$pdf->Cell(50,10,'Estados Libredeuda: SL=Sin Libre Deuda / CL=Con Libre Deuda / F= Fin de Carrera / R=Recursante / ?=Falta Vincular Alumno',0,0,'L');
	
		if($request->getParameter('idciclo')==''){
			$y = $y + 5;
			$pdf->SetXY(10,$y+10);
			$pdf->Cell(50,10,'Estados Contables: *=Activo / $=Acredita Banco / AG=Año de Gracia',0,0,'L');
		}
		$pdf->Output('planilla-asistencia.pdf', 'I');
 
		// stop symfony process
		throw new sfStopException();
  	
    	return sfView::NONE;    		 
	}

	// Listado de Aspirantes SAO AUTOGESTION
	public function executeInformesAlumnosAutogestionProblemaspdf(sfWebRequest $request) 
	{
		$config = sfTCPDFPluginConfigHandler::loadConfig();
 		$oCicloLectivo = Doctrine_Core::getTable('CiclosLectivos')->find($request->getParameter('idciclo'));

 		$oPlanesestudios = Doctrine_Core::getTable('PlanesEstudios')->find($request->getParameter('idplanestudio'));
		// pdf object
		$pdf = new PDF();
		// settings
		$pdf->SetFont("Times", "", 9);
		// sentencias para retirar encabezados y pie por defecto
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);  
		// add a page
		$pdf->AddPage();
                if($oCicloLectivo<>''){
		    $encabezado = '
			<div style="text-align: center; font-family: Times New Roman,Times,serif;"><span
			style="font-size: 12;"><img src="'.$request->getRelativeUrlRoot().'/images/CabeceraSIG-UCU.jpg" width="550px">
			INFORME DE ASPIRANTES - SAO AUTOGESTION '.$oCicloLectivo->getCiclo().'</div>';        
        	} else {
			if($oPlanesestudios<>'') $carrera=$oPlanesestudios->getCarreras()->getNombre();
		    $encabezado = '
			<div style="text-align: center; font-family: Times New Roman,Times,serif;"><span
			style="font-size: 12;"><img src="'.$request->getRelativeUrlRoot().'/images/CabeceraSIG-UCU.jpg" width="550px">
			INFORME DE CONTROL DE DOCUMENACIONES Y ESTADOS - FECHA: '.date("d-m-Y H:i").'<br> CARRERA: '.$carrera.' </div>';    
		};
		$pdf->writeHTML($encabezado, true, false, true, false, '');
		
		$y = 40;
		$pdf->SetXY(10,$y);
		$pdf->Cell(5,10,'Nº',0,0,'C');    
		$pdf->SetXY(15,$y);
		$pdf->Cell(40,10,'APELLIDO',0,0,'C');    
		$pdf->SetXY(55,$y);
		$pdf->Cell(40,10,'NOMBRE',0,0,'C');    
		$pdf->SetXY(95,$y);
		$pdf->Cell(20,10,'DOC.',0,0,'C');    
		$pdf->SetXY(115,$y);		
		$pdf->Cell(10,10,'ESTADO',0,0,'C');    
		$pdf->SetXY(128,$y);
		$pdf->Cell(20,10,'F-D-R-T-FT-P',0,0,'C');    
		$pdf->SetXY(148,$y);
  		$pdf->Cell(10,10,'USU',0,0,'C');       
		$pdf->SetXY(155,$y);
        $pdf->Cell(30,10,'EMAIL SAO',0,0,'C');   		      

		$oAreas = new Areas();
		if($request->getParameter('idciclo')<>''){
			$oAlumnos = $oAreas->obtenerAspirantesCicloAreaAutogestion($request->getParameter('idciclo'),$this->getUser()->getProfile()->getIdarea(),$this->getUser()->getProfile()->getIdsede());
		} else {
			$oAlumnos = $oAreas->obtenerInformeControlGeneral($request->getParameter('idplanestudio'), $this->getUser()->getProfile()->getIdsede()); 
		};

		$y = $y + 5;
		$contador = 1;
		$contadorcar = 0;
		$contadoralu = 1;
		$contadortotal = 0;
		// verificacion de existencia del objeto alumnos  (if*1)
		if($oAlumnos){
		    $idPlanAnterior = 0;
		    $idPlan = 0;
		    $this->administracion = new Administracion();
		    $contador_estado=0;
		    $contador_acreditabanco=0;
		    $contador_ag=0;
		    $contador_fin =0;
		    $contador_finhasta =0;
		    $contador_recursante =0;
		    $contador_nodefinido=0;
		    foreach ($oAlumnos as $alumno){	
				$mensajelibredeuda="";
				$mensajeestado='';
				$mensajeacreditabanco='';
				$mensaje_fechafinag='';
		    		$mensaje_fin ='';
		    		$mensaje_finhasta ='';
		    		$mensaje_recursante ='';
				$mensaje_verificar="";
				$baja ="";
				$numerodoc ="";
				$ndni ="";
				if($request->getParameter('idciclo')<>''){
					$fechalibredeuda = $this->administracion->obtenerlibredeudaalumno($alumno['idalumno'],$alumno['documento']);
				} else {
					$datosalumnows = $this->administracion->obtenerestadoalumno($alumno['idalumno'],$alumno['documento']);  
				}
				if (count($datosalumnows)){
					$fechalibredeuda =$datosalumnows[0];
					$estadoadm=$datosalumnows[1];
					$acreditabanco=$datosalumnows[2];
					$fechafinag =$datosalumnows[3];
					$fin =$datosalumnows[4];
					$finhasta =$datosalumnows[5];
					$recursante =$datosalumnows[6];
					$baja =$datosalumnows[7];
					$numerodoc =$datosalumnows[8];
					$ndni =$datosalumnows[9];
				}
				if($fechalibredeuda >= date('Y-m-d')) {
					$mensajelibredeuda = "(CL)";
				} else {
					$pos=strpos($fechalibredeuda,'-');
					if($pos>0) {
						$mensajelibredeuda = "(SL)"; 
					} else {
						$mensajelibredeuda = "(?)"; 
					};

				}

				if($finhasta >= date('Y-m-d')) {
					$mensaje_finhasta = "#";
					$contador_finhasta++;
				}
				if($fin) {
					$mensaje_fin='F';
					$contador_fin++;
				}
				if($recursante) {
					$mensaje_recursante='R';
					$contador_recursante++;
				}
				if($baja==1) {
					$baja='B';
				} else $baja='';

				if($estadoadm) {
					$mensajeestado='*';
					$contador_estado++;
				}
				if($fechafinag) {
					if ($fechafinag>= date('Y-m-d')) {
						$mensaje_fechafinag='AG';
						$contador_ag++;
					}
				}
				if($estadoadm & $acreditabanco) {
					$mensajeacreditabanco='$';
					$contador_acreditabanco++;
				}

				if($mensajelibredeuda != "(?)" and $mensajeestado=='' and $mensaje_fechafinag=='' and $mensaje_fin =='' and $mensaje_recursante =='') {
					 $contador_nodefinido++;
					 $mensaje_verificar="VER";
				}


				$idPlan = $alumno['idplanestudio'];
				// cuando cambia de carrera se deba agregar un rotulo (if*2)
			$mensaje_control="";
			if (($mensajelibredeuda == "(SL)") || ($alumno['certtittramite']==0 && $alumno['fotocopialegtitulo']==0)) 				$mensaje_control="NO";

				if( $idPlanAnterior!=$idPlan)   {
					//lineas del rotulo
					$pdf->Line(10,$y+3,199,$y+3);
			        $pdf->Line(10,$y+7,199,$y+7);   
			                             
					$y = $y+5;
				    $contadoralu = 1;    // por cada carrera tengo el contador de alumnos
	                $pdf->SetXY(0,$y-5);
	                //Se muestra una etiqueta del grupo
	                $pdf->Cell(200,10,$alumno['nomcar'],0,0,'C'); 
	                $contadorcar++;     
				} // fin (if*2)
		        $pdf->SetXY(3,$y);
		        $pdf->Cell(5,10,$mensaje_control,0,0,'L');	
		        $pdf->SetXY(8,$y);
		        $pdf->Cell(5,10,$baja,0,0,'L');					
		        $pdf->SetXY(10,$y);
		        $pdf->Cell(5,10,$alumno['idalumno'],0,0,'L'); //$contadoralu
		        $pdf->SetXY(18,$y);        
		        $pdf->Cell(40,10,$alumno['ape'],0,0,'L');        
		        $pdf->SetXY(55,$y);        
		        $pdf->Cell(40,10,$alumno['nom'],0,0,'L');              
		        $pdf->SetXY(95,$y);    
			//if($ndni<>$alumno['documento']) $doc=$ndni.'!!'.$numerodoc; else $doc=$alumno['documento'];  
		        $pdf->Cell(20,10,$alumno['ciclo'].' '.$alumno['documento'],0,0,'C'); 
		  		$activo = $alumno['activo'];
				$estado = "";
				if ($alumno['idestado']!=1) {$estado = "(".$alumno['idestado'].")";};
				if($oCicloLectivo=='') $estado="(".$mensaje_verificar.$mensajeestado.$mensajeacreditabanco.$mensaje_fechafinag.$mensaje_fin.$mensaje_finhasta.$mensaje_recursante.")";
		        $pdf->SetXY(116,$y);        
				$pdf->Cell(10,10,$estado,0,0,'C');  
		        $pdf->SetXY(125,$y);        
				$pdf->Cell(10,10,$mensajelibredeuda,0,0,'C'); 	
				$idmateria = 104;
				$oAlumno = Doctrine_Core::getTable('Alumnos')->find($alumno['idalumno']);
		        $alumat = $oAlumno->obtenerComision($idmateria);
		        $pdf->SetXY(133,$y);        
		        $pdf->Cell(20,10,$alumno['fotografia'].'-'.$alumno['fotocopiadni'].'-'.$alumno['certalureg'].'-'.$alumno['certtittramite'].'- '.$alumno['fotocopialegtitulo'].'-'.$alumno['fotocopialegpartidanac'],0,0,'L'); 		
		        $profile = $oAlumno->getPersonas()->existeUsuario();
				// verifico que exista registro en profile 
				if($profile) $usuario = 'X'; else $usuario = '';
		        $pdf->SetXY(147,$y);        
		        $pdf->Cell(10,10,$usuario,0,0,'C'); 
				$contacto = $oAlumno->getPersonas()->getContacto();	
		        $pdf->SetXY(155,$y);
		        $pdf->Cell(30,10,$contacto['email1'],0,0,'L'); 
	
		        $y=$y+4; $contador++; $contadortotal++; $contadoralu++;  $idPlanAnterior=$idPlan;
				// chequeo que la cantidad de registros por pagina sea 55 (if*3)
		        if ($contador+$contadorcar==50	){
		        	$pdf->Line(10,$y+3,199,$y+3);
		            $contador = 1;
		            $contadorcar = 0;
		            // add a page
			    	$pdf->AddPage();
					if($oCicloLectivo<>''){
					    $encabezado = '
						<div style="text-align: center; font-family: Times New Roman,Times,serif;"><span
						style="font-size: 12;"><img src="'.$request->getRelativeUrlRoot().'/images/CabeceraSIG-UCU.jpg" width="550px">
						INFORME DE ASPIRANTES - SAO AUTOGESTION '.$oCicloLectivo->getCiclo().'</div>';        
					} else {
						if($oPlanesestudios<>'') $carrera=$oPlanesestudios->getCarreras()->getNombre();
					    $encabezado = '
						<div style="text-align: center; font-family: Times New Roman,Times,serif;"><span
						style="font-size: 12;"><img src="'.$request->getRelativeUrlRoot().'/images/CabeceraSIG-UCU.jpg" width="550px">
						INFORME DE CONTROL DE DOCUMENACIONES Y ESTADOS - FECHA: '.date("d-m-Y H:i").'<br> CARRERA: '.$carrera.' </div>';    
					};     
					        
					$pdf->writeHTML($encabezado, true, false, true, false, '');	
							
					$y = 40;
					$pdf->SetXY(10,$y);
					$pdf->Cell(5,10,'Nº',0,0,'C');    
					$pdf->SetXY(15,$y);
					$pdf->Cell(40,10,'APELLIDO',0,0,'C');    
					$pdf->SetXY(55,$y);
					$pdf->Cell(40,10,'NOMBRE',0,0,'C');    
					$pdf->SetXY(95,$y);
					$pdf->Cell(20,10,'DOC.',0,0,'C');    
					$pdf->SetXY(115,$y);		
					$pdf->Cell(10,10,'ESTADO',0,0,'C');    
					$pdf->SetXY(128,$y);
					$pdf->Cell(20,10,'F-D-R-T-FT-P',0,0,'C');    
					$pdf->SetXY(148,$y);
			  		$pdf->Cell(10,10,'USU',0,0,'C');       
					$pdf->SetXY(155,$y);
			        $pdf->Cell(30,10,'EMAIL SAO',0,0,'C');
			        
			        $y = $y + 5;
		        }    // fin (if*3)           
				$pdf->Line(10,$y+3,199,$y+3);       
		    }

		    $pdf->SetXY(10,$y+10);
			$pdf->Cell(50,10,'CANTIDAD TOTAL:'.$contadortotal,0,0,'L');
		    if($request->getParameter('idciclo')==''){
				$y = $y + 4;	
			    $pdf->SetXY(10,$y+10);
				$pdf->Cell(50,10,'CANTIDAD ACTIVOS ADM:'.$contador_estado,0,0,'L');	
				$y = $y + 4;	
			    $pdf->SetXY(10,$y+10);
				$pdf->Cell(50,10,'CANTIDAD ACREDITAN BANCO:'.$contador_acreditabanco,0,0,'L');	
				$y = $y + 4;	
			    $pdf->SetXY(10,$y+10);
				$pdf->Cell(50,10,'CANTIDAD AÑO DE GRACIA:'.$contador_ag,0,0,'L');	
				$y = $y + 4;	
			    $pdf->SetXY(10,$y+10);
				$pdf->Cell(50,10,'CANTIDAD FIN DE CARRERA:'.$contador_fin,0,0,'L');	
				$y = $y + 4;	
			    $pdf->SetXY(10,$y+10);
				$pdf->Cell(50,10,'CANTIDAD RECURSANTES:'.$contador_recursante,0,0,'L');	
				$y = $y + 4;	
			    $pdf->SetXY(10,$y+10);
				$pdf->Cell(50,10,'ALUMNOS SIN ESTADO DEFINIDO:'.$contador_nodefinido,0,0,'L');	
		   }
		} // fin (if*1)
		if($request->getParameter('idciclo')<>''){
			$y = $y + 5;
			$pdf->SetXY(10,$y+10);
			$pdf->Cell(50,10,'Estados: 2-Baja / 3-Egresado / 6-Enmienda',0,0,'L');	
		} 
	        $y = $y + 5;
	        $pdf->SetXY(10,$y+10);
		$pdf->Cell(50,10,'Estados Libredeuda: SL=Sin Libre Deuda / CL=Con Libre Deuda / F= Fin de Carrera / R=Recursante / ?=Falta Vincular Alumno',0,0,'L');
	
		if($request->getParameter('idciclo')==''){
			$y = $y + 5;
			$pdf->SetXY(10,$y+10);
			$pdf->Cell(50,10,'Estados Contables: *=Activo / $=Acredita Banco / AG=Año de Gracia',0,0,'L');
		}
		$pdf->Output('planilla-asistencia.pdf', 'I');
 
		// stop symfony process
		throw new sfStopException();
  	
    	return sfView::NONE;    		 
	}

	public function executeGenerarUsuariosSao(sfWebRequest $request) 
	{
		$config = sfTCPDFPluginConfigHandler::loadConfig();
 		$oCicloLectivo = Doctrine_Core::getTable('CiclosLectivos')->find($request->getParameter('idciclo'));

 		$oPlanesestudios = Doctrine_Core::getTable('PlanesEstudios')->find($request->getParameter('idplanestudio'));
		// pdf object
		$pdf = new PDF();
		// settings
		$pdf->SetFont("Times", "", 9);
		// sentencias para retirar encabezados y pie por defecto
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);  
		// add a page
		$pdf->AddPage();
                if($oCicloLectivo<>''){
		    $encabezado = '
			<div style="text-align: center; font-family: Times New Roman,Times,serif;"><span
			style="font-size: 12;"><img src="'.$request->getRelativeUrlRoot().'/images/CabeceraSIG-UCU.jpg" width="550px">
			INFORME DE ASPIRANTES - SAO AUTOGESTION '.$oCicloLectivo->getCiclo().'</div>';        
        	} else {
			if($oPlanesestudios<>'') $carrera=$oPlanesestudios->getCarreras()->getNombre();
		    $encabezado = '
			<div style="text-align: center; font-family: Times New Roman,Times,serif;"><span
			style="font-size: 12;"><img src="'.$request->getRelativeUrlRoot().'/images/CabeceraSIG-UCU.jpg" width="550px">
			INFORME DE CONTROL DE DOCUMENACIONES Y ESTADOS - FECHA: '.date("d-m-Y H:i").'<br> CARRERA: '.$carrera.' </div>';    
		};
		$pdf->writeHTML($encabezado, true, false, true, false, '');
		
		$y = 40;
		$pdf->SetXY(10,$y);
		$pdf->Cell(5,10,'Nº',0,0,'C');    
		$pdf->SetXY(15,$y);
		$pdf->Cell(40,10,'APELLIDO',0,0,'C');    
		$pdf->SetXY(55,$y);
		$pdf->Cell(40,10,'NOMBRE',0,0,'C');    
		$pdf->SetXY(95,$y);
		$pdf->Cell(20,10,'DOC.',0,0,'C');    
		$pdf->SetXY(115,$y);		
		$pdf->Cell(10,10,'ESTADO',0,0,'C');    
		$pdf->SetXY(128,$y);
		$pdf->Cell(20,10,'F-D-R-T-FT-P',0,0,'C');    
		$pdf->SetXY(148,$y);
  		$pdf->Cell(10,10,'USU',0,0,'C');       
		$pdf->SetXY(155,$y);
        $pdf->Cell(30,10,'EMAIL SAO',0,0,'C');   		      

		$oAreas = new Areas();
		if($request->getParameter('idciclo')<>''){
			$oAlumnos = $oAreas->obtenerAspirantesCicloAreaAutogestion($request->getParameter('idciclo'),$this->getUser()->getProfile()->getIdarea(),$this->getUser()->getProfile()->getIdsede());
		} else {
			$oAlumnos = $oAreas->obtenerInformeControlGeneral($request->getParameter('idplanestudio'), $this->getUser()->getProfile()->getIdsede()); 
		};
        
		$y = $y + 5;
		$contador = 1;
		$contadorcar = 0;
		$contadoralu = 1;
		$contadortotal = 0;
		$creados=0;
		$contadorusuarios = 0;
		// verificacion de existencia del objeto alumnos  (if*1)
		if($oAlumnos){
		    $idPlanAnterior = 0;
		    $idPlan = 0;
		    $this->administracion = new Administracion();
		    $contador_estado=0;
		    $contador_acreditabanco=0;
		    $contador_ag=0;
		    $contador_fin =0;
		    $contador_finhasta =0;
		    $contador_recursante =0;
		    $contador_nodefinido=0;
		    foreach ($oAlumnos as $alumno){	
				$idPlan = $alumno['idplanestudio'];
				// cuando cambia de carrera se deba agregar un rotulo (if*2)
				if( $idPlanAnterior!=$idPlan)   {
					//lineas del rotulo
					$pdf->Line(10,$y+3,199,$y+3);
			        $pdf->Line(10,$y+7,199,$y+7);   
			                             
					$y = $y+5;
				    $contadoralu = 1;    // por cada carrera tengo el contador de alumnos
	                $pdf->SetXY(0,$y-5);
	                //Se muestra una etiqueta del grupo
	                $pdf->Cell(200,10,$alumno['nomcar'],0,0,'C'); 
	                $contadorcar++;     
				} // fin (if*2)
					
		        $pdf->SetXY(10,$y);
		        $pdf->Cell(5,10,$contadoralu,0,0,'L');
		        $pdf->SetXY(15,$y);        
		        $pdf->Cell(40,10,$alumno['ape'],0,0,'L');        
		        $pdf->SetXY(55,$y);        
		        $pdf->Cell(40,10,$alumno['nom'],0,0,'L');              
		        $pdf->SetXY(95,$y);        
		        $pdf->Cell(20,10,$alumno['ciclo'].' '.$alumno['documento'],0,0,'C'); 
		  		$activo = $alumno['activo'];
				$estado = "";
				if ($alumno['idestado']!=1) { $estado = "(".$alumno['idestado'].")"; };
				if($oCicloLectivo=='') $estado="(".$mensaje_verificar.$mensajeestado.$mensajeacreditabanco.$mensaje_fechafinag.$mensaje_fin.$mensaje_finhasta.$mensaje_recursante.")";
		        $pdf->SetXY(116,$y);        
				$pdf->Cell(10,10,$estado,0,0,'C');  
		        $pdf->SetXY(125,$y);        
				$pdf->Cell(10,10,$acceso,0,0,'C'); 	
				$idmateria = 104;
				$oAlumno = Doctrine_Core::getTable('Alumnos')->find($alumno['idalumno']);
		        $alumat = $oAlumno->obtenerComision($idmateria);
		        	
		        $profile = $oAlumno->getPersonas()->existeUsuario();
				// verifico que exista registro en profile 
				$ultimo=''; $usuario = '';
				if($profile) {
					$usuario = 'X'; 
					$contadorusuarios++;
					//$ultimo= $profile->getLastLogin();
					} else { $usuario = '';};
				$contacto = $oAlumno->getPersonas()->getContacto();	
				$ultimo='';
			if((!$profile) and ($creados<20) and (strpos($contacto['email1'],'@')>1) and ($emailanterior!=$contacto['email1']) and ($usuario != 'X')){
				$creados++;
				$ultimo="Generado";
				$this->Generarusuario($alumno['idpersona']);

			}	
			$emailanterior=$contacto['email1']; 
		        //$profile = $oAlumno->getPersonas()->existeUsuario();
				// verifico que exista registro en profile 
			//	if($profile) $usuario = 'X'; else $usuario = '';
		        $pdf->SetXY(137,$y);        
		        $pdf->Cell(10,10,$ultimo,0,0,'C'); 
		        $pdf->SetXY(147,$y);        
		        $pdf->Cell(10,10,$usuario,0,0,'C'); 
				
		        $pdf->SetXY(155,$y);
		        $pdf->Cell(30,10,$contacto['email1'],0,0,'L'); 
		        $y=$y+4; $contador++; $contadortotal++; $contadoralu++;  $idPlanAnterior=$idPlan;
				// chequeo que la cantidad de registros por pagina sea 55 (if*3)
		        if ($contador+$contadorcar==50	){
		        	$pdf->Line(10,$y+3,199,$y+3);
		            $contador = 1;
		            $contadorcar = 0;
		            
		            // add a page
			    	$pdf->AddPage();
					if($oCicloLectivo<>''){
					    $encabezado = '
						<div style="text-align: center; font-family: Times New Roman,Times,serif;"><span
						style="font-size: 12;"><img src="'.$request->getRelativeUrlRoot().'/images/CabeceraSIG-UCU.jpg" width="550px">
						INFORME DE ASPIRANTES - SAO AUTOGESTION '.$oCicloLectivo->getCiclo().'</div>';        
					} else {
						if($oPlanesestudios<>'') $carrera=$oPlanesestudios->getCarreras()->getNombre();
					    $encabezado = '
						<div style="text-align: center; font-family: Times New Roman,Times,serif;"><span
						style="font-size: 12;"><img src="'.$request->getRelativeUrlRoot().'/images/CabeceraSIG-UCU.jpg" width="550px">
						INFORME DE CONTROL DE DOCUMENACIONES Y ESTADOS - FECHA: '.date("d-m-Y H:i").'<br> CARRERA: '.$carrera.' </div>';    
					};     
					        
					$pdf->writeHTML($encabezado, true, false, true, false, '');	
							
					$y = 40;
					$pdf->SetXY(10,$y);
					$pdf->Cell(5,10,'Nº',0,0,'C');    
					$pdf->SetXY(15,$y);
					$pdf->Cell(40,10,'APELLIDO',0,0,'C');    
					$pdf->SetXY(55,$y);
					$pdf->Cell(40,10,'NOMBRE',0,0,'C');    
					$pdf->SetXY(95,$y);
					$pdf->Cell(20,10,'DOC.',0,0,'C');    
					$pdf->SetXY(115,$y);		
					$pdf->Cell(10,10,'ESTADO',0,0,'C');    
					$pdf->SetXY(128,$y);
					$pdf->Cell(20,10,'F-D-R-T-FT-P',0,0,'C');    
					$pdf->SetXY(148,$y);
			  		$pdf->Cell(10,10,'USU',0,0,'C');       
					$pdf->SetXY(155,$y);
			        $pdf->Cell(30,10,'EMAIL SAO',0,0,'C');
			        
			        $y = $y + 5;
		        }    // fin (if*3)           
				$pdf->Line(10,$y+3,199,$y+3);       
		    }

		    $pdf->SetXY(10,$y+10);
			$pdf->Cell(50,10,'CANTIDAD USUARIOS:'.$contadorusuarios.' DE UN TOTAL DE:'.$contadortotal,0,0,'L');
		} // fin (if*1)

		$pdf->Output('planilla-asistencia.pdf', 'I');
 
		// stop symfony process
		throw new sfStopException();
  	
    	return sfView::NONE;    		 
	}

	public function Generarusuario($idpersona) {
		// Obtiene la persona
		$oPersona = Doctrine::getTable('Personas')->find($idpersona);

		// Obtiene el contacto de la persona
		$oContacto = $oPersona->getContacto();
		if($oContacto && ($oContacto->getEmail1() != "")) {
			// Busca si ya se encuentra registrado dicho email
			$oUsuarioPorEmail = Doctrine::getTable('sfGuardUser')->buscarEmail($oContacto->getEmail1());
			$oUsuarioPorDni = Doctrine::getTable('sfGuardUser')->buscarPerfil($oPersona->getIdtipodoc(), $oPersona->getNrodoc());

			if ($oUsuarioPorEmail && ($oUsuarioPorEmail != $oUsuarioPorDni)) {
				//echo "No se ha creado el usuario ".$oContacto->getEmail1()." correctamente. El usuario o email ya se encuentra registrado.";
			} else {
				if (!$oUsuarioPorDni) {
					$oPerfil = new Profile();
					$oUsuario = new sfGuardUser();
					$oGrupo = new sfGuardUserGroup();
			  		$oPermiso = new sfGuardUserPermission();						
				} else {
					$oUsuario = Doctrine::getTable('sfGuardUser')->find($oUsuarioPorDni);
					$oPerfil = $oUsuario->getProfile();
		  			$oGrupo = $oUsuario->obtenerGrupoUsuario();
		  			if (!$oGrupo) $oGrupo= new sfGuardUserGroup();
		  			$oPermiso = $oUsuario->obtenerPermisoUsuario();
		  			if (!$oPermiso) $oPermiso = new sfGuardUserPermission();					
				}
		
				// Guarda la informacion
				$oUsuario->setFirstName($oPersona->getNombre());
				$oUsuario->setLastName($oPersona->getApellido());
				$oUsuario->setEmailAddress($oContacto->getEmail1());
				$oUsuario->setUsername($oContacto->getEmail1());
				$oUsuario->getAlgorithm('sha1');
				//$password = $this->executeGenerarpassword(8);
				$password = $oPersona->getNrodoc();
				$oUsuario->setPassword($password);
				$oUsuario->setIsActive(1);
				$oUsuario->setIsSuperAdmin(0);	  				
				$oUsuario->save();
		  		
		  		$oPerfil->setTipodoc($oPersona->getIdtipodoc());
		  		$oPerfil->setNrodoc($oPersona->getNrodoc());  	  		
		  		$oPerfil->setSfGuardUserId($oUsuario->getId());
		  		$oPerfil->setIdsede($this->getUser()->getGuardUser()->getProfile()->getIdsede());

		  		$oPerfil->save();
			
		  		$oGrupo->setGroupId(3);	  		
				$oGrupo->setUserId($oUsuario->getId());
				$oGrupo->save();
				
				$oPermiso->setPermissionId(3);
				$oPermiso->setUserId($oUsuario->getId());
				$oPermiso->save();
			
	  			//echo "Se ha creado el usuario ".$oUsuario->getUsername()." correctamente.";
      	
	  			// Enviar un correo a biblioteca y administracionalumnos
				$message = $this->getMailer()->compose();
				$cid = $message->embed(Swift_Image::fromPath('images/Imagen-Entorno-Virtual-Alumnos.jpg'));
				$message->setSubject('UCU - Sistema de Alumnos On-line: Solicitud de usuario');
				$message->setTo(array($oUsuario->getEmailAddress() => $oUsuario->getFirstName().' '.$oUsuario->getLastName()));
				$message->setFrom(array('sistemas@ucu.edu.ar' => 'UCU - Informes'));

    			$html = '
				<p align="center">**************************************************************************************<br>
				********************* NO RESPONDER ESTE CORREO *********************<br>
				**************************************************************************************</p>
				<b>'.$oUsuario->getFirstName().' '.$oUsuario->getLastName().'</b>, se ha generado un usuario para 
				que puedas utilizar el Sistema de Alumnos On-line de la <b>Universidad de Concepción del Uruguay</b>.<br> 
				A través del mismo, podrás inscribirte a cursar, ver los programas y horarios de las distintas 
				asignaturas y realizar consultas de todo tipo de manera virtual.<br><br>
				
				Tu usuario es: <b>'.$oUsuario->getUsername().'</b><br>
				La contraseña es: <b>'.$password.'</b><br>
				
				Ingresá a <b>http://alumnos.ucu.edu.ar/autogestion.php</b> a la brevedad para dar tus primeros pasos en 
				la <b>Universidad de Concepción del Uruguay</b>!<br><br>
				
				NOTA: <b>Te recomendamos guardes este correo para conservar tu usuario y contraseñas originales</b>.<br>
				<p align="center"><img src="'. $cid.'" alt="UCU - Ingresantes 2012" /></p>';
    			
    			$message->setBody($html, 'text/html');

    			$this->getMailer()->send($message);	  		  				
  			}
		} else {
			//echo "Debe registrar un email, antes de poder generar un usuario.";
		}
	}

	public function executeGenerarcsv(sfWebRequest $request) {

        // Obtener nuevos inscriptos por anio
		$oAreas = new Areas();
        $arr_emails = array();

		$oAlumnos = $oAreas->obtenerAspirantesSeguroAlfabetico($request->getParameter('idciclo'),$this->getUser()->getProfile()->getIdarea(),$this->getUser()->getProfile()->getIdsede());

		// verificacion de existencia del objeto alumnos  (if*1)
		if($oAlumnos){
			     //Creamos el archivo temporal de exportación

			    $file='gmail.csv';
			    $fh = fopen($file,"w+") or die ("unable to open file");
				$titulo = "First Name,Last Name,Email Address,Password,Secondary Email,Work Phone 1,Home Phone 1,Mobile Phone 1,Work address 1,Home address 1,Employee Id,Employee Type,Employee Title,Manager,Department,Cost Center\n";
				fwrite($fh,$titulo); 

				$arrPersonas= array();
			    foreach ($oAlumnos as $alu){	

				if(!in_array($alu['idpersona'],$arrPersonas)){

					array_push($arrPersonas,$alu['idpersona']);
					// Obtiene la persona
					$oPersona = Doctrine::getTable('Personas')->find($alu['idpersona']);

					// Obtiene el contacto de la persona
					$oContacto = $oPersona->getContacto();
					if($oContacto && ($oContacto->getEmail1() != "")) {
						$simbolopositivo='';
						$simbolopositivo= strpos($oContacto->getEMail1(),'+');
						if(is_numeric($simbolopositivo)){
                            $email=substr($oContacto->getEMail1(),1);
						    if(!in_array($email, $arr_emails )){

								array_push($arr_emails, $email);

								$row = $oPersona->getNombre().",".$oPersona->getApellido().",".substr($oContacto->getEMail1(),1).",".$oPersona->getNroDoc().",".$oContacto->getEMail().",,".$oContacto->getTelefonofijocar()."-".$oContacto->getTelefonofijonum() .",".$oContacto->getCelularcar()."-".$oContacto->getCelularnum().",,,,,,,,\n";
								fwrite($fh,$row); 
                            }
						} 
				    }
				}
			}
		}
		// Close file            
		fclose($fh);  

		header("Content-Type: application/vnd.ms-excel");
		header("Content-Type: application/force-download");
		header("Content-Transfer-Encoding: binary");
		header("Content-Disposition: attachment;filename=".$file );
		header("Content-Length: ".filesize($file));
		header("Pragma: no-cache");
		header("Expires: 0");
		readfile($file);
		
		// stop symfony process
		throw new sfStopException();

		return sfView::NONE;
	}



	public function executeGenerarusuarioscampus(sfWebRequest $request) {

        // Obtener nuevos inscriptos por anio
		$oAreas = new Areas();
        $arr_emails = array();

		$file='campus.csv';
		$fh = fopen($file,"w+") or die ("unable to open file");

		$encabezado = "id,username,email,firstname,lastname,idnumber,institution,department,phone1,phone2,city,url,icq,skype,aim,yahoo,msn,country\n";
				fwrite($fh,$encabezado); 

		$oAlumnos = $oAreas->obtenerAlumnosCicloActivos($request->getParameter('idciclo'),$this->getUser()->getProfile()->getIdarea(),$this->getUser()->getProfile()->getIdsede());

		// verificacion de existencia del objeto alumnos  (if*1)
		if($oAlumnos){

			    foreach ($oAlumnos as $alu){	
				// Obtiene la persona
				$oPersona = Doctrine::getTable('Personas')->find($alu['idpersona']);

				// Obtiene el contacto de la persona
				$oContacto = $oPersona->getContacto();
				if($oContacto && ($oContacto->getEmail1() != "")) {



					$simbolopositivo='';
					$simbolopositivo= strpos($oContacto->getEMail1(),'+');
					$simboloarroba= strpos($oContacto->getEMail1(),'@');
					if(is_numeric($simbolopositivo)){
						$email=substr($oContacto->getEMail1(),1);
						if(!in_array($email, $arr_emails )){

							array_push($arr_emails, $email);
							$username=substr($oContacto->getEMail1(),1,$simboloarroba-1);
	//2,admin,informatica@ucu.edu.ar,Admin,Usuario,,,,,,,,,,,,,
	$row =  ",".$username.",".$email.",".$oPersona->getNombre().",".$oPersona->getApellido().",".$oPersona->getIdpersona().",,,".$oContacto->getTelefonofijocar()."-".$oContacto->getTelefonofijonum() .",".$oContacto->getCelularcar()."-".$oContacto->getCelularnum().",,,,,,,,\n";
								fwrite($fh,$row); 
                        } // if in_array						
					} 
			    	}
			   }
		}


		fclose($fh);  

		header("Content-Type: application/vnd.ms-excel");
		header("Content-Type: application/force-download");
		header("Content-Transfer-Encoding: binary");
		header("Content-Disposition: attachment;filename=".$file );
		header("Content-Length: ".filesize($file));
		header("Pragma: no-cache");
		header("Expires: 0");
		readfile($file);
		
		// stop symfony process
		throw new sfStopException();

		return sfView::NONE;

		
	}


	public function executeConfirmarcsv(sfWebRequest $request) {
        // Obtener nuevos inscriptos por anio
		$oAreas = new Areas();

		$oAlumnos = $oAreas->obtenerAlumnosCicloActivos($request->getParameter('idciclo'),$this->getUser()->getProfile()->getIdarea(),$this->getUser()->getProfile()->getIdsede());

		// verificacion de existencia del objeto alumnos  (if*1)
		if($oAlumnos){

			    foreach ($oAlumnos as $alu){	
				// Obtiene la persona
				$oPersona = Doctrine::getTable('Personas')->find($alu['idpersona']);

				// Obtiene el contacto de la persona
				$oContacto = $oPersona->getContacto();
				if($oContacto && ($oContacto->getEmail1() != "")) {
					$simbolopositivo='';
					$simbolopositivo= strpos($oContacto->getEMail1(),'+');
					if(is_numeric($simbolopositivo)){
						$oContacto->setEmail1(substr($oContacto->getEMail1(),1));
						$oContacto->save();
					} 
			    }
			}
		}

		echo "Se Confirmo CSV";

		return sfView::NONE;
	}

	public function limpiar($String){
	    $String = str_replace(array('á','à','â','ã','ª','ä'),"a",$String);
	    $String = str_replace(array('Á','À','Â','Ã','Ä'),"A",$String);
	    $String = str_replace(array('Í','Ì','Î','Ï'),"I",$String);
	    $String = str_replace(array('í','ì','î','ï'),"i",$String);
	    $String = str_replace(array('é','è','ê','ë'),"e",$String);
	    $String = str_replace(array('É','È','Ê','Ë'),"E",$String);
	    $String = str_replace(array('ó','ò','ô','õ','ö','º'),"o",$String);
	    $String = str_replace(array('Ó','Ò','Ô','Õ','Ö'),"O",$String);
	    $String = str_replace(array('ú','ù','û','ü'),"u",$String);
	    $String = str_replace(array('Ú','Ù','Û','Ü'),"U",$String);
	    $String = str_replace(array('[','^','´','`','¨','~',']'),"",$String);
	    $String = str_replace("ç","c",$String);
	    $String = str_replace("Ç","C",$String);
	    $String = str_replace("ñ","n",$String);
	    $String = str_replace("Ñ","N",$String);
	    $String = str_replace("Ý","Y",$String);
	    $String = str_replace("ý","y",$String);
	     
	    $String = str_replace("&aacute;","a",$String);
	    $String = str_replace("&Aacute;","A",$String);
	    $String = str_replace("&eacute;","e",$String);
	    $String = str_replace("&Eacute;","E",$String);
	    $String = str_replace("&iacute;","i",$String);
	    $String = str_replace("&Iacute;","I",$String);
	    $String = str_replace("&oacute;","o",$String);
	    $String = str_replace("&Oacute;","O",$String);
	    $String = str_replace("&uacute;","u",$String);
	    $String = str_replace("&Uacute;","U",$String);
	    return $String;
	}
		
	public function limpiaremail($String){
	    $String = str_replace(array('á','à','â','ã','ª','ä'),"a",$String);
	    $String = str_replace(array('Á','À','Â','Ã','Ä'),"a",$String);
	    $String = str_replace(array('Í','Ì','Î','Ï'),"i",$String);
	    $String = str_replace(array('í','ì','î','ï'),"i",$String);
	    $String = str_replace(array('é','è','ê','ë'),"e",$String);
	    $String = str_replace(array('É','È','Ê','Ë'),"e",$String);
	    $String = str_replace(array('ó','ò','ô','õ','ö','º'),"o",$String);
	    $String = str_replace(array('Ó','Ò','Ô','Õ','Ö'),"o",$String);
	    $String = str_replace(array('ú','ù','û','ü'),"u",$String);
	    $String = str_replace(array('Ú','Ù','Û','Ü'),"u",$String);
	    $String = str_replace(array('[','^','´','`','¨','~',']'),"",$String);
	    $String = str_replace("ç","c",$String);
	    $String = str_replace("Ç","c",$String);
	    $String = str_replace("ñ","n",$String);
	    $String = str_replace("Ñ","n",$String);
	    $String = str_replace("Ý","y",$String);
	    $String = str_replace("ý","y",$String);

	    $String = str_replace("&aacute;","a",$String);
	    $String = str_replace("&Aacute;","A",$String);
	    $String = str_replace("&eacute;","e",$String);
	    $String = str_replace("&Eacute;","E",$String);
	    $String = str_replace("&iacute;","i",$String);
	    $String = str_replace("&Iacute;","I",$String);
	    $String = str_replace("&oacute;","o",$String);
	    $String = str_replace("&Oacute;","O",$String);
	    $String = str_replace("&uacute;","u",$String);
	    $String = str_replace("&Uacute;","U",$String);
	    return $String;
	}

	public function executeGenerarpreuniversitario(sfWebRequest $request){
		// Busco la persona para verificar si esta inscripto en el preuniversitario
		$oAlumnos = Doctrine_Core::getTable('Alumnos')->findByIdpersona($request->getParameter('idpersona'));
		foreach($oAlumnos as $alumno){
			$arrCarreras= array();
			array_push($arrCarreras, $alumno->getIdplanestudio());
		}
		// Si el alumno no esta inscripto al preuniversitario se debe agregar
		if(!in_array(168,$arrCarreras)){
			// se debe crear al alumno
			// primero en SAO (base datos alumnos servidor 195)
				
			$oNuevoAlumno= new Alumnos();
			$oNuevoAlumno->setIdpersona($request->getParameter('idpersona'));
			$oNuevoAlumno->setIdplanestudio(168);
			$oNuevoAlumno->setIdciclolectivo($request->getParameter('idciclo'));
			$oNuevoAlumno->setIdsede($this->getUser()->getProfile()->getIdsede());

			$oNuevoAlumno->save();
				
			echo "Se inscribio al preuniversitario correctamente";

			return sfView::NONE;
		} 
	}

	public function executeGeneraremailmasivo(sfWebRequest $request) {
        // Obtener nuevos inscriptos por anio
		$oAreas = new Areas();

		$oAlumnos = $oAreas->obtenerAlumnosCicloActivos($request->getParameter('idciclo'),$this->getUser()->getProfile()->getIdarea(),$this->getUser()->getProfile()->getIdsede());

		// verificacion de existencia del objeto alumnos  (if*1)
		if($oAlumnos){
			    $contador_alumnos=0;
			    foreach ($oAlumnos as $alu){	
					// Obtiene la persona
					$oPersona = Doctrine::getTable('Personas')->find($alu['idpersona']);
	
					// Obtiene el contacto de la persona
					$oContacto = $oPersona->getContacto();
	
					// si existe contacto y el email institucional esta vacio
					if($oContacto && ($oContacto->getEmail1() == "")  ) {
						// formato utilizado (APELLIDOCOMPLETOSINESPACIOS GUION BAJO Y PRIMER NOMBRE)
							
						$apellido = strtolower(trim($oPersona->getApellido()));
						$apellido = str_replace(" ","",$apellido);
						$nombre = strtolower(trim($oPersona->getNombre()));
						$posespacio = strpos($nombre,' ');
						if($posespacio=='') { 
							$posespacio=strlen($nombre);
						}
						$nombre = substr($nombre,0,$posespacio);
						$nombrecompleto = $this->limpiaremail($apellido.'_'.$nombre);
						$correocompleto = '+'.$nombrecompleto.'@ucu.edu.ar';
						
						$oContacto->setEMail1($correocompleto);
						$oContacto->save();
					  		  	
						$contador_alumnos++;
					}
			   } // foreach alumnos
		} // si existen alumnos
		return sfView::NONE;
	}

	public function executeNotificaremailmasivo(sfWebRequest $request) {

        // Obtener nuevos inscriptos por anio
		$oAreas = new Areas();
		/*$oAlumnos = $oAreas->obtenerAspirantesSeguroAlfabetico($request->getParameter('idciclo'),$this->getUser()->getProfile()->getIdarea(),$this->getUser()->getProfile()->getIdsede());*/

		$oAlumnos = $oAreas->obtenerAlumnosCicloActivos($request->getParameter('idciclo'),$this->getUser()->getProfile()->getIdarea(),$this->getUser()->getProfile()->getIdsede());

		$contador_alumnos=0;
		// verificacion de existencia del objeto alumnos  (if*1)
		if($oAlumnos){
			    foreach ($oAlumnos as $alu){	
				// Obtiene la persona
				$oPersona = Doctrine::getTable('Personas')->find($alu['idpersona']);

				// Obtiene el contacto de la persona
				$oContacto = $oPersona->getContacto();

				// si existe contacto y el email posee un simbolo +
				if($oContacto && strpos($oContacto->getEmail1(),'+') !== ''  && $oContacto->getEmail()!='')   {

					$sexo=$oPersona->getIdsexo(); 
					if ($sexo==1) { $texto='o'; }{ $texto='a'; };
					$apellido=str_replace(" ","",$apellido);
					$nombre=strtolower(trim($oPersona->getNombre()));
		  			// Enviar un correo a biblioteca y administracionalumnos
					$message = $this->getMailer()->compose();
					//$cid = $message->embed(Swift_Image::fromPath('images/Imagen-Entorno-Virtual-Alumnos.jpg'));
					$message->setSubject('UCU - Bienvenid'.$texto.' '.$apellido.' '.$nombre.'!!');
					//$message->setTo(array($oContacto->getEmail() => $oPersona->getNombre().' '.$oPersona->getApellido()));
					$message->setTo(array($oContacto->getEmail() ));
					$message->setFrom(array('sistemas@ucu.edu.ar' => 'UCU - Sistemas'));
					$emailucu=substr($oContacto->getEmail1(),1);
	    			$html = '<div><img src="http://alumnos.ucu.edu.ar/images/cabeceraucu_2015.jpg" height="116" width="923" class="CToWUd"></div><P>Bienvenid'.$texto.' a la Universidad de Concepción del Uruguay, te invitamos a que ingreses a tu nueva cuenta de Correo Electrónico Institucional, esta cuenta sera tu medio de contacto con con las diversas Áreas de la Institución, te mantendremos informado de los eventos UCU , recibirás materiales de estudio e información que te va a ser útil en tu vida académica. Vas a poder disfrutar de las Aplicaciones Google Apps (Gmail, Hangout, Calendar, Driver , etc.)<br><br> Ingresar en:<br><br>http://correo.ucu.edu.ar<br><br>usuario: '.$emailucu.'<br>clave: '.$oPersona->getNrodoc().'<br><br>En el primer acceso tendrás que aceptar las condiciones dispuestas en la pantalla de ingreso y luego vas a tener que ingresar dos veces la nueva clave de acceso a tu cuenta de correo UCU.<br><br>Ante cualquier duda envíanos la consulta a informatica@ucu.edu.ar<br><br>Saludos<br><br>Ing. Guillermo A. Zdanowicz<br>Jefe Departamento Informática UCU<br>';

		    		$message->setBody($html, 'text/html');

		    		$this->getMailer()->send($message);	

					$contador_alumnos++;	
					}	
			   } // foreach alumnos
		} // si existen alumnos

		//throw new sfStopException();
		echo "Se enviaron ".$contador_alumnos." Emails de Bienvenida";
		
		return sfView::NONE;
	}

	// 1 Listado de Aspirantes por Carrera
	public function executeAspirantescarreraacadpdf(sfWebRequest $request) 
	{
		$config = sfTCPDFPluginConfigHandler::loadConfig();
 		$oCicloLectivo = Doctrine_Core::getTable('CiclosLectivos')->find($request->getParameter('idciclo'));
		
 		$lineas_hoja = $request->getParameter('formatos');
 			
		// pdf object
		$pdf = new PDF();
		// settings
		$pdf->SetFont("Times", "", 9);
		// sentencias para retirar encabezados y pie por defecto
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);  
		// add a page
		$pdf->AddPage();
                
		$encabezado = '
			<div style="text-align: center; font-family: Times New Roman,Times,serif;"><span
			style="font-size: 12;"><img src="'.$request->getRelativeUrlRoot().'/images/CabeceraSIG-UCU.jpg" width="550px">
			INFORME DE ASPIRANTES - CICLO LECTIVO '.$oCicloLectivo->getCiclo().'</div>';        
        
		$pdf->writeHTML($encabezado, true, false, true, false, '');
		
		$y = 40;
		$pdf->SetXY(10,$y);
		$pdf->Cell(5,10,'Nº',0,0,'C');    
		$pdf->SetXY(15,$y);
		$pdf->Cell(40,10,'APELLIDO',0,0,'C');    
		$pdf->SetXY(55,$y);
		$pdf->Cell(40,10,'NOMBRE',0,0,'C');    
		$pdf->SetXY(95,$y);
		$pdf->Cell(20,10,'DOC.',0,0,'C');    
		$pdf->SetXY(115,$y);		
		$pdf->Cell(10,10,'BAJA',0,0,'C');    
		$pdf->SetXY(125,$y);
		$pdf->Cell(20,10,'COM',0,0,'C');    
		$pdf->SetXY(145,$y);
  		$pdf->Cell(10,10,'USU',0,0,'C');       
		$pdf->SetXY(155,$y);
        $pdf->Cell(30,10,'EMAIL',0,0,'C');   		      

		$oAreas = new Areas();
		$oAlumnos = $oAreas->obtenerAspirantesCicloAcademica($request->getParameter('idciclo'));
        
		$y = $y + 5;
		$contador = 1;
		$contadorcar = 0;
		$contadoralu = 1;
		$contadortotal = 0;
		// verificacion de existencia del objeto alumnos  (if*1)
		if($oAlumnos){
		    $idPlanAnterior = 0;
		    $idPlan = 0;
		    foreach ($oAlumnos as $alumno){		
				$idPlan = $alumno['idplanestudio'];
				// cuando cambia de carrera se deba agregar un rotulo (if*2)
				if( $idPlanAnterior!=$idPlan)   {
					//lineas del rotulo
					$pdf->Line(10,$y+3,199,$y+3);
			        $pdf->Line(10,$y+7,199,$y+7);   
			                             
					$y = $y+5;
				    $contadoralu = 1;    // por cada carrera tengo el contador de alumnos
	                $pdf->SetXY(0,$y-5);
	                //Se muestra una etiqueta del grupo
	                $pdf->Cell(200,10,$alumno['nomcar'],0,0,'C'); 
	                $contadorcar++;     
				} // fin (if*2)
					
		        $pdf->SetXY(6,$y);        
		        $pdf->Cell(40,10,'('.$alumno['idsede'].')',0,0,'L'); 
		        $pdf->SetXY(10,$y);
		        $pdf->Cell(5,10,$contadoralu,0,0,'L');

		        $pdf->SetXY(15,$y);        
		        $pdf->Cell(40,10,$alumno['ape'],0,0,'L');        
		        $pdf->SetXY(55,$y);        
		        $pdf->Cell(40,10,$alumno['nom'],0,0,'L');              
		        $pdf->SetXY(95,$y);        
		        $pdf->Cell(20,10,$alumno['tipodoc'].' '.$alumno['documento'],0,0,'C'); 
		  		$activo = $alumno['activo'];
				$estado = "";
				if ($alumno['idestado']==2) {$estado = "BAJA";};
		        $pdf->SetXY(115,$y);        
				$pdf->Cell(10,10,$estado,0,0,'C');  
	
				$idmateria = 104;
				$oAlumno = Doctrine_Core::getTable('Alumnos')->find($alumno['idalumno']);
		        $alumat = $oAlumno->obtenerComision($idmateria);
		        $pdf->SetXY(125,$y);        
		        $pdf->Cell(20,10,$alumat['idcomision'],0,0,'L'); 		
		        $profile = $oAlumno->getPersonas()->existeUsuario();
				// verifico que exista registro en profile 
				if($profile) $usuario = 'X'; else $usuario = '';
		        $pdf->SetXY(145,$y);        
		        $pdf->Cell(10,10,$usuario,0,0,'C'); 
				$contacto = $oAlumno->getPersonas()->getContacto();	
		        $pdf->SetXY(155,$y);
		        $pdf->Cell(30,10,$contacto['email'],0,0,'L'); 
	
		        $y=$y+4; $contador++; $contadortotal++; $contadoralu++;  $idPlanAnterior=$idPlan;
				// chequeo que la cantidad de registros por pagina sea 55 (if*3)
		        if ($contador+$contadorcar==$lineas_hoja){				
		        	$pdf->Line(10,$y+3,199,$y+3);
		            $contador = 1;
		            $contadorcar = 0;
		            // add a page
			    	$pdf->AddPage();
				    	
					$encabezado = '
						<div style="text-align: center; font-family: Times New Roman,Times,serif;"><span
						style="font-size: 12;"><img src="'.$request->getRelativeUrlRoot().'/images/CabeceraSIG-UCU.jpg" width="550px">
						INFORME DE ASPIRANTES - CICLO LECTIVO '.$oCicloLectivo->getCiclo().'</div>';        
					        
					$pdf->writeHTML($encabezado, true, false, true, false, '');	
							
					$y = 40;
					$pdf->SetXY(10,$y);
					$pdf->Cell(5,10,'Nº',0,0,'C');    
					$pdf->SetXY(15,$y);
					$pdf->Cell(40,10,'APELLIDO',0,0,'C');    
					$pdf->SetXY(55,$y);
					$pdf->Cell(40,10,'NOMBRE',0,0,'C');    
					$pdf->SetXY(95,$y);
					$pdf->Cell(20,10,'DOC.',0,0,'C');    
					$pdf->SetXY(115,$y);		
					$pdf->Cell(10,10,'BAJA',0,0,'C');    
					$pdf->SetXY(125,$y);
					$pdf->Cell(20,10,'COM',0,0,'C');    
					$pdf->SetXY(145,$y);
			  		$pdf->Cell(10,10,'USU',0,0,'C');       
					$pdf->SetXY(155,$y);
			        $pdf->Cell(30,10,'EMAIL',0,0,'C');
			        
			        $y = $y + 5;
		        }    // fin (if*3)           
				$pdf->Line(10,$y+3,199,$y+3);       
		    }
		    $pdf->SetXY(10,$y+10);
			$pdf->Cell(50,10,'CANTIDAD TOTAL:'.$contadortotal,0,0,'L');
		    $pdf->SetXY(10,$y+14);
			$pdf->Cell(50,10,'Sedes: 1-Central / 2-Gualeguaychu / 3-Villaguay / 4-Rosario / 5-Santa Fe / 6-Paraná / 7-Gualeguay / 8-Venado Tuerto / 11-Concordia',0,0,'L');

	
		} // fin (if*1)
		
		$pdf->Output('planilla-asistencia.pdf', 'I');
 
		// stop symfony process
		throw new sfStopException();
  	
    	return sfView::NONE;    		 
	}	
}

<?php

/**
 * atenciones actions.
 *
 * @package    sig
 * @subpackage atenciones
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class atencionesActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->criterio = '';
    $f_apellido = NULL; $f_nrodoc = NULL;

    if ( $request->getParameter('idbuscarname')<>''){

      if ( $request->getParameter('idtipobusqueda')==1)
        $f_apellido = $request->getParameter('idbuscarname');

      if ( $request->getParameter('idtipobusqueda')==2)
          $f_nrodoc = $request->getParameter('idbuscarname');
    }

    $this->pacientess = Doctrine_Core::getTable('Pacientes')->obtenerPacientes($f_apellido,NULL, $f_nrodoc, 1, 300);

    $this->criterio = $request->getParameter('idbuscarname');
    $this->idtipobusqueda = $request->getParameter('idtipobusqueda');

  }

   // Obtiene tratamiento por idtratamiento
  public function executeObtenertratamiento(sfWebRequest $request)  {
    $this->tratamiento = Doctrine_Core::getTable('Tratamientos')->find($request->getParameter('idtratamiento'));
  }

    /** Actual month last day **/
  public function data_last_month_day() {
      $month = date('m');
      $year = date('Y');
      $day = date("d", mktime(0,0,0, $month+1, 0, $year));

      return date('Y-m-d', mktime(0,0,0, $month, $day, $year));
  }

  /** Actual month first day **/
  public function data_first_month_day() {
      $month = date('m');
      $year = date('Y');
      return date('Y-m-d', mktime(0,0,0, $month, 1, $year));
  }

  public function ultimo_dia_del_mes() {
      $month = date('m');
      $year = date('Y');
      $day = date("d", mktime(0,0,0, $month+1, 0, $year));

      return date('d', mktime(0,0,0, $month, $day, $year));
  }

  public function executeCerrar(sfWebRequest $request)
  {

    /*$aniohasta = date ("Y");
    $aniodesde = $aniohasta - 25;

    $this->aAnios = array();
    $this->aMeses = array();*/
    $this->periodo = '';
    $this->mostrar_boton_cerrar =false;

    // Obtener usuario logueado
    $user_id = $this->getUser()->getGuardUser()->getId();
    $persona = Doctrine_Core::getTable('Personas')->obtenerProfesionalxUser($user_id);
    $matricula = $persona[0]['matricula'];
    $this->atencioness = Doctrine_Core::getTable('Atenciones')->obtenerAtencionesAbiertasPorProfesional($matricula);

    $fechaactual = date('Y-m-j');
    $fechaanterior = strtotime ( '-1 month' , strtotime ( $fechaactual ) ) ;

    // si es primer o segundo dia muestra periodo del mes anterior
    if (date('j')==1 OR date('j')==2){
        $this->periodo = date ( 'Y-m' , $fechaanterior );
        $this->mostrar_boton_cerrar = true;
    } else { // sino analiza si es ultimo o ante ultimo dia del mes
        //$ultimo_dia = $this->ultimo_dia_del_mes();
        //$anterior_ultimo_dia = $ultimo_dia - 1;
        if (date('j')>=20){
           $this->periodo = date('Y-m');
           $this->mostrar_boton_cerrar = true;
        }
    }


   /* for( $i= $aniohasta ; $i >= $aniodesde ; $i-- )
    {
      $this->aAnios[$i] =  $i;
    }

    $mes = '';

    for( $i= 1 ; $i <= 12 ; $i++ )
    {
        switch($i) {
          case 1:
          $mes = 'Enero';
          break;

          case 2:
          $mes = 'Febrero';
          break;

          case 3:
          $mes = 'Marzo';
          break;

          case 4:
          $mes = 'abril';
          break;

          case 5:
          $mes = 'Mayo';
          break;

          case 6:
          $mes = 'Junio';
          break;

          case 7:
          $mes = 'Julio';
          break;

          case 8:
          $mes = 'Agosto';
          break;

          case 9:
          $mes = 'Septiembre';
          break;

          case 10:
          $mes = 'Octubre';
          break;

          case 11:
          $mes = 'Noviembre';
          break;

          case 12:
          $mes = 'Diciembre';
          break;

          default:

          $mes = 'Enero';

          }

          $this->aMeses[$i] =  $mes;
    }

    $this->criterio = '';
    $f_apellido = NULL; $f_nrodoc = NULL;

    if ( $request->getParameter('idAnio')<>'' && $request->getParameter('idMes')<>''){

      $this->atencioness = Doctrine_Core::getTable('Atenciones')->obtenerAtencionesPorProfesionalPeriodo($matricula, $request->getParameter('idMes'), $request->getParameter('idAnio'));

    }

    $this->idAnio = $request->getParameter('idAnio');
    $this->idMes = $request->getParameter('idMes');*/

  }

  public function executeCerrarperiodo(sfWebRequest $request)
  {

    // Obtiene atenciones seleccionadoas para no cerrar
    $idcase = $request->getParameter('idcase', '');
    $periodo = $request->getParameter('periodo');
    // $arr[0]  es año, $arr[1] es mes
    $arr = explode('-', $periodo);
    $arr_asignaciones = array();

    // Obtener usuario logueado
    $user_id = $this->getUser()->getGuardUser()->getId();
    $persona = Doctrine_Core::getTable('Personas')->obtenerProfesionalxUser($user_id);
    $matricula = $persona[0]['matricula'];

    foreach($idcase as $seleccionados){
      if(is_numeric($seleccionados))
          $arr_asignaciones[] = $seleccionados;
    }

    // Se cierran las atenciones seleccionadas
    if ( count($arr_asignaciones)>0 ){
        Doctrine_Core::getTable('Atenciones')->cerrarAtencionesPorProfesionalPeriodo($matricula, $arr[1], $arr[0], $arr_asignaciones);
        $this->mensaje = 'Período cerrado exitosamente :  '.$arr[1].'/'.$arr[0];
    } else {
        Doctrine_Core::getTable('Atenciones')->cerrarAtencionesPorProfesionalPeriodo($matricula, $arr[1], $arr[0]);
        $this->mensaje = 'Período cerrado exitosamente :  '.$arr[1].'/'.$arr[0];
    }

  }

  public function executeEditar(sfWebRequest $request)
  {
     // PRIMER TAB - Obtener paciente seleccionado
    $this->forward404Unless($pacientes = Doctrine_Core::getTable('Pacientes')->find(array($request->getParameter('id'))), sprintf('Object pacientes does not exist (%s).', $request->getParameter('id')));

    if (!$pacientes->getActivo())  $this->redirect('atenciones/index');  // tiene que estar activo para editarlo

    $this->form = new PacientesForm($pacientes);
    $this->paciente = $pacientes;

    if($request->getParameter('selectedtab')>0)
        $this->selectedtab = $request->getParameter('selectedtab');
     else {
        $this->selectedtab = '1';
     }

     // Si hay algun mensaje de error del tab 2
     if($request->getParameter('selectedtab')==2)
         $this->error_tab2 = $request->getParameter('msgerror');

     // SEGUNDO TAB - Obtener pacientes segun filtro
     $this->criterio = '';
     $f_apellido = NULL; $f_idobrasocial = NULL;

     if ( $request->getParameter('idbuscarname')<>'')
       $f_apellido = $request->getParameter('idbuscarname');

     if ( $request->getParameter('idobrasocial')>0)
       $f_idobrasocial = $request->getParameter('idobrasocial');

    $this->superadmin = false;
    if ($this->getUser()->getGuardUser()->getIsSuperAdmin())
        $this->superadmin = true;

    // Obtener usuario logueado
    $user_id = $this->getUser()->getGuardUser()->getId();
    $persona = Doctrine_Core::getTable('Personas')->obtenerProfesionalxUser($user_id);
    $this->profesional = $persona[0]['apellido'].', '.$persona[0]['nombre'];
    $this->idprofesional = $persona[0]['idpersona'];
    $this->matricula = $persona[0]['matricula'];

     $this->atencioness = Doctrine_Core::getTable('Atenciones')->obtenerAtencionesPorPaciente($pacientes->getId());
     $this->idpaciente = $request->getParameter('id');

    // Obtener atenciones abiertas por profesional
      $arrFiltro = array('matricula'=> $persona[0]['matricula'], 'idestadoatencion' => '1', 'idestadopago' => '1', 'pacientedoc' => $pacientes->getNrodoc(), 'nofacturadasenficha' => true);
      $this->atencionessa = Doctrine_Core::getTable('Atenciones')->obtenerDetalleAtencionesFiltro($arrFiltro);


     if ($request->getParameter('idatencion')>0){
       $this->forward404Unless($atencion = Doctrine_Core::getTable('Atenciones')->find(array($request->getParameter('idatencion'))), sprintf('Object atenciones does not exist (%s).', $request->getParameter('id')));
       $this->formatenciones = new AtencionesForm($atencion);
     }


     // TERCER TAB

     // CUARTO TAB
     // Obtener json desde base de datos con atenciones para Odontograma
   

    $fecha = date("d/m/Y"); 
    $arr = explode('/', $fecha);
    $fec = $arr[2]."-".$arr[1]."-".$arr[0];
   
    if($request->getParameter('filtrofec')<>''){
       $fecha = $request->getParameter('filtrofec');
       $arr = explode('/', $fecha);
       $fec = $arr[2]."-".$arr[1]."-".$arr[0];
    } 

    // SI es un post verifico si fue una consulta y la fecha de la consulta para saber que mostrar en odontograma
    if ($request->isMethod(sfRequest::POST) && ($fec<>date("Y-m-d"))){
          $ultimoOdonto = Doctrine_Core::getTable('Odontograma')->obtenerUltimoAnteriorAfecha($request->getParameter('id'), $fec);
     } else {
         $ultimoOdonto = Doctrine_Core::getTable('Odontograma')->obtenerUltimo($request->getParameter('id'));
     }

    $jsonatenciones='[]';
    foreach($ultimoOdonto as $datos){
        $jsonatenciones = $datos['infodontograma'];
    }  
    $this->jsonatenciones = $jsonatenciones;
    // $this->jsonatenciones = '[{"diente":{"id":17,"x":25,"y":0},"cara":"S","tratamiento":{"id":"10.16.01","nombre":"Hasta 1 cm. de diámetro","aplicaCara":true,"aplicaDiente":true,"color":"blue"}},{"diente":{"id":18,"x":50,"y":0},"cara":"C","tratamiento":{"id":"10.16.01","nombre":"Hasta 1 cm. de diámetro","aplicaCara":true,"aplicaDiente":true,"color":"red"}}]';
  }

  // Guarda la asignacion
  public function executeGuardarodontograma(sfWebRequest $request) {  

    $filename = $request->getParameter('idpaciente') . '.png';
    
    $base64_string = $request->getParameter('odontoimg');
    $ifp = fopen( $filename, 'wb' ); 

    // split the string on commas
    // $data[ 0 ] == "data:image/png;base64"
    // $data[ 1 ] == <actual base64 string>
    $data = explode( ',', $base64_string );

    // we could add validation here with ensuring count( $data ) > 1
    fwrite( $ifp, base64_decode( $data[ 1 ] ) );

    // clean up the file resource
    fclose( $ifp ); 

    //Save the image
    // $targetFolder = sfConfig::get('app_pathfiles_folder')."/../fotosodontograma".'/';
    // move_uploaded_file($ifp, $targetFolder);

    // echo $targetFolder;exit;

    file_put_contents($filename, $ifp);


  /*  $result = file_put_contents( "fotos/".$filename, file_get_contents('php://input') );
    if (!$result) {
      $resultado = "ERROR: No se pudo escribir el archivo $filename, verificar los permisos.\n";
    } else {
      $resultado = "EXITO: Se pudo escribir correctamente el archivo $filename.\n";
    } */
  
    $oOdontograma = new Odontograma();
    $oOdontograma->setMatricula($request->getParameter('matricula'));
    $oOdontograma->setIdpaciente($request->getParameter('idpaciente'));
    $oOdontograma->setInfodontograma($request->getParameter('jsonatenciones'));
    $oOdontograma->setImgodontograma($request->getParameter('odontoimg'));
    $oOdontograma->save();
    
    echo "Se ha guardado correctamente el odontograma";
    
    return sfView::NONE;  
  }

  public function executeMostrarficha(sfWebRequest $request)
  {
     $atenciones_seleccionadas = $request->getParameter('case');
     $arrAtenciones = array();
     $this->idpaciente = $request->getParameter('idpaciente');
     $this->selectedtab = 2;
      
    if(count($atenciones_seleccionadas) > 0) {
      foreach ($atenciones_seleccionadas as $atencion) {
        if($atencion>0)
          $arrAtenciones[] = $atencion;
      }
    
      $arrFiltro = array('idatenciones'=> $arrAtenciones);

      $this->atencioness = Doctrine_Core::getTable('Atenciones')->obtenerDetalleAtencionesFiltro($arrFiltro);
    }
 
  }

  public function executeFacturar(sfWebRequest $request)
  {
     $atenciones_seleccionadas = $request->getParameter('case');
     $arrAtenciones = array();

     $idpaciente = $request->getParameter('idpaciente');
     $tab_selected = $request->getParameter('selectedtab');
     $msg_error = '';

    if(count($atenciones_seleccionadas) > 10) {

       $msg_error = 'ATENCION: Solo puede seleccionar hasta 10 atenciones por Ficha!!';
       
       $this->redirect('atenciones/editar?id='.$idpaciente.'&selectedtab='.$tab_selected.'&msgerror='.$msg_error);
    }

    if(count($atenciones_seleccionadas) == 0) {

       $msg_error = 'ATENCION: Debe seleccionar al menos una atención para realizar la nueva ficha!!';
       
       $this->redirect('atenciones/editar?id='.$idpaciente.'&selectedtab='.$tab_selected.'&msgerror='.$msg_error);
    }
      
    if(count($atenciones_seleccionadas) > 0) {
      foreach ($atenciones_seleccionadas as $atencion) {
        if($atencion>0)
          $arrAtenciones[] = $atencion;
      }

      $arrFiltro = array('idatenciones'=> $arrAtenciones);

      $this->atencioness = Doctrine_Core::getTable('Atenciones')->obtenerDetalleAtencionesFiltro($arrFiltro);

      $total =  0; $matricula=0;
      foreach($this->atencioness as $atencion){
         $total+= $atencion['importe'];
         $matricula = $atencion['matricula'];
      }

    // Grabar factura con importe total
      $factura = new Facturaciones();
      $factura->setMatricula($matricula);
      $factura->setFecha(date('Y-m-j'));
      $factura->setIdPaciente($idpaciente);
      // $fecha = $request->getPostParameter('atenciones[fecha][year]').'-'.$request->getPostParameter('atenciones[fecha][month]').'-'.$request->getPostParameter('atenciones[fecha][day]');
      // $atenciones->setFecha($fecha);
      $factura->setImporte($total);
      $factura->save();
      $idfactura = $factura->getId();
    
      // Luego agregar el idfactura en atenciones 
      Doctrine_Core::getTable('Atenciones')->marcarComoFacturados($arrAtenciones, $idfactura);

      $this->redirect('atenciones/index');  // tiene que estar activo para editarlo

    } 
   
  }

  public function executeVerhistorialfichas(sfWebRequest $request)
  {
    
    $aniohasta = date ("Y");
    $aniodesde = $aniohasta - 25;
    $this->aAnios = array();

    for( $i= $aniohasta ; $i >= $aniodesde ; $i-- )
    {
      $this->aAnios[$i] =  $i;
    }

    $this->idAnio = $request->getParameter('idAnio');

    $this->superadmin = false;
    if ($this->getUser()->getGuardUser()->getIsSuperAdmin())
        $this->superadmin = true;

     // Obtener usuario logueado
    $user_id = $this->getUser()->getGuardUser()->getId();
    $persona = Doctrine_Core::getTable('Personas')->obtenerProfesionalxUser($user_id);
    $matricula = $persona[0]['matricula'];
    $this->persona = $persona[0]['apellido'].', '.$persona[0]['nombre'];

    // $matricula = $request->getParameter('matricula');
     
     $arrFiltro = array('matricula'=> $matricula, 'anio'=> $this->idAnio);

     $arrGroup = array('iddesc'=> 'iddesc');

     $this->facturacionss = Doctrine_Core::getTable('Atenciones')->obtenerFacturasFiltro($arrFiltro, NULL, $arrGroup);
     $this->idpaciente = $request->getParameter('idpaciente');

     /* AGREGADO PARA GENERAR ODONTOGRAMA EN LA FICHA 
     $ultimoOdonto = Doctrine_Core::getTable('Odontograma')->obtenerUltimo($this->idpaciente);
     
     $jsonatenciones='[]';
     foreach($ultimoOdonto as $datos){
        $jsonatenciones = $datos['infodontograma'];
     }  
     $this->jsonatenciones = $jsonatenciones; */

  }

 

public function executeVerdetallefichas(sfWebRequest $request)
{
    
    $this->superadmin = false;
    if ($this->getUser()->getGuardUser()->getIsSuperAdmin())
        $this->superadmin = true;

    $id = $request->getParameter('id');
    $encrypt_method = "AES-256-CBC";
    $secret_key = 'DieGo123';
    $secret_iv = 'ReiNo123';
           
    // hash
    $key = hash('sha256', $secret_key);
             
    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
           
    $idfacturacion = openssl_decrypt(base64_decode($id), $encrypt_method, $key, 0, $iv);
   
    $arrFiltro = array('idfacturacion'=> $idfacturacion);

    if(trim($idfacturacion)=='')
         $this->redirect('atenciones/index');

    $this->atencioness = Doctrine_Core::getTable('Atenciones')->obtenerDetalleAtencionesFiltro($arrFiltro);

    $this->idfactura = $idfacturacion;

 }


  public function executeConsultar(sfWebRequest $request)
  {

    //Filtros
    $matricula = ''; $idAnio =''; $arrFiltro = ''; $this->arregloProf='';

    $aniohasta = date ("Y");
    $aniodesde = $aniohasta - 25;

    $this->aAnios = array();
    //$this->aMeses = array();
    $this->periodo = '';
    $this->mostrar_boton_cerrar =false;

    // Obtener usuario logueado y matricula del profesional logueado
    $user_id = $this->getUser()->getGuardUser()->getId();
    $persona = Doctrine_Core::getTable('Personas')->obtenerProfesionalxUser($user_id);
    $matricula = $persona[0]['matricula'];

    // Si es el administrador, la matricula se obtiene del formulario POST
    if ($this->getUser()->getGuardUser()->getIsSuperAdmin()){
       $matricula = $request->getParameter('idmatricula');
    }

    $orden = 2;
    $oprof = Doctrine_Core::getTable('Personas')->obtenerProfesionales(1, $orden);
    foreach($oprof as $op){
        $this->arregloProf[$op['matricula']] = $op['matricula'].' - '.$op['apellido'].', '.$op['nombre'];
    }

    for( $i= $aniohasta ; $i >= $aniodesde ; $i-- )
    {
      $this->aAnios[$i] =  $i;
    }

    if ($request->isMethod(sfRequest::POST)){

        if ($request->getParameter('idAnio') > 0)
            $idAnio = $request->getParameter('idAnio');

        $arrFiltro = array('matricula'=> $matricula, 'anio' =>  $idAnio);

        $this->atencioness = Doctrine_Core::getTable('Atenciones')->obtenerAtencionesCerradasFiltro($arrFiltro);

    }

    $this->idAnio = $request->getParameter('idAnio');
    $this->idmatricula = $matricula;
    //$this->idMes = $request->getParameter('idMes');

  }

  public function executeRevisarperiodos(sfWebRequest $request)
  {

    // solo administrador puede gestionar este modulo
    if (!$this->getUser()->getGuardUser()->getIsSuperAdmin()){
       $this->redirect('atenciones/index');
    }

    $this->aMeses =  array(1 =>'Enero', 2 =>'Febrero', 3 =>'Marzo', 4 =>'Abril', 5 =>'Mayo', 6 =>'Junio', 7 =>'Julio', 8 =>'Agosto', 9 =>'Setiembre', 10 =>'Octubre',11 =>'Noviembre',12 =>'Diciembre');

    //Filtros
    $matricula = ''; $idAnio =''; $arrFiltro = ''; $this->arregloProf='';

    $mes = '';

    $this->idmes = $request->getParameter('idmes');

    if(!$this->idmes>0)
        $this->idmes = date('n');

    $mesnombre = $this->aMeses[$this->idmes];


    $aniohasta = date ("Y");
    $aniodesde = $aniohasta - 25;

    $this->aAnios = array();
    //$this->aMeses = array();
    $this->periodo = '';
    $this->mostrar_boton_cerrar =false;

    // Obtener usuario logueado y matricula del profesional logueado
    $user_id = $this->getUser()->getGuardUser()->getId();
    $persona = Doctrine_Core::getTable('Personas')->obtenerProfesionalxUser($user_id);
    $matricula = $persona[0]['matricula'];

    // Si es el administrador, la matricula se obtiene del formulario POST
    if ($this->getUser()->getGuardUser()->getIsSuperAdmin()){
       $matricula = $request->getParameter('idmatricula');
    }

    $orden = 2;
    $oprof = Doctrine_Core::getTable('Personas')->obtenerProfesionales(1, $orden);
    foreach($oprof as $op){
        $this->arregloProf[$op['matricula']] = $op['matricula'].' - '.$op['apellido'].', '.$op['nombre'];
    }

    for( $i= $aniohasta ; $i >= $aniodesde ; $i-- )
    {
      $this->aAnios[$i] =  $i;
    }

    if ($request->isMethod(sfRequest::POST)){

        if ($request->getParameter('idAnio') > 0)
            $idAnio = $request->getParameter('idAnio');

        $arrFiltro = array('idmes'=> $this->idmes, 'anio' =>  $idAnio, 'idestadoatencion' => '0');

        $this->atencioness = Doctrine_Core::getTable('Atenciones')->obtenerDetalleAtencionesFiltro($arrFiltro);

    }

    $this->idAnio = $request->getParameter('idAnio');

  }

  public function executeGenerarcsv(sfWebRequest $request)
  {

    // solo administrador puede gestionar este modulo
    if (!$this->getUser()->getGuardUser()->getIsSuperAdmin()){
       $this->redirect('atenciones/index');
    }

    if ($request->getParameter('idAnio') > 0)
        $idAnio = $request->getParameter('idAnio');
    else
        $idAnio = date ("Y");

    if ($request->getParameter('idmes') > 0)
        $idMes = $request->getParameter('idmes');
    else
        $idMes = date ("n");

    //Filtros
    $arrFiltro = array('idmes'=> $idMes, 'anio' =>  $idAnio, 'idestadoatencion' => '0');

    $this->atencioness = Doctrine_Core::getTable('Atenciones')->obtenerDetalleAtencionesFiltro($arrFiltro);

    // verificacion de existencia del objeto alumnos  (if*1)
    if($this->atencioness){
      //Creamos el archivo temporal de exportación
      $file = 'atenciones.csv';

      $fh = fopen($file,"w+") or die ("No se puede abrir el archivo");

      $titulo = "ID;MATRICULA;PROFESIONAL;PACIENTENRODOC;PACIENTE;MES;ANIO;IDOBRASOCIAL;OBRASOCIAL;IDPLAN;PLAN;IDTRATAMIENTO;TRATAMIENTO;PIEZA;CARAS;IMPORTE;COSEGURO;BONO;IMPORTEOS;ESTADOPAGO;FECHA;\n";
      fwrite($fh,$titulo);

      foreach ($this->atencioness as $atencion){
        $areaDestino = "";
        if ($alumno['idexpediente']) {
          $oExpediente = Doctrine_Core::getTable('ExpedientesEgresados')->find($alumno['idexpediente']);
          $oDerivacion = $oExpediente->obtenerUltimaDerivacion();
          $areaDestino = $oDerivacion->obtenerAreaDestino();
        }
        $row = $atencion['id'].";".$atencion['matricula'].";".$atencion['profesional'].";".$atencion['nrodoc'].";".$atencion['paciente'].";".$atencion['mes'].";".$atencion['anio'].";".$atencion['idobrasocial'].";".$atencion['obrasocial'].";".$atencion['idplanobrasocial'].";".$atencion['planobrasocial'].";".$atencion['idtratamiento'].";".$atencion['tratamiento'].";".$atencion['pieza'].";".$atencion['caras'].";".$atencion['importe'].";".$atencion['coseguro'].";".$atencion['bono'].";".$atencion['importeos'].";".$atencion['idestadopago'].";".$atencion['fecha'].";"."\n";

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

  public function executeDetalle(sfWebRequest $request)
  {

    $aniohasta = date ("Y");
    $aniodesde = $aniohasta - 25;

    //Filtros
    if ($request->getParameter('idanio') <= 0) {
       $idanio = date ("Y");
    } else {
       $idanio = $request->getParameter('idanio');
    }


    if ($request->getParameter('idmes') <= 0) {
      $idmes = date ("m");
    } else {
       $idmes = $request->getParameter('idmes');
    }

    $idestado = 0;

    // Obtener usuario logueado y matricula del profesional logueado
    $user_id = $this->getUser()->getGuardUser()->getId();
    $persona = Doctrine_Core::getTable('Personas')->obtenerProfesionalxUser($user_id);
    $matricula = $persona[0]['matricula'];

    // Si es el administrador, la matricula se obtiene del formulario POST
    if ($this->getUser()->getGuardUser()->getIsSuperAdmin()){
       $matricula = $request->getParameter('idmatricula');
    }

    $this->profesional = Doctrine_Core::getTable('Personas')->obtenerProfesionalxMatricula($matricula);

    for( $i= $aniohasta ; $i >= $aniodesde ; $i-- )
    {
      $this->aAnios[$i] =  $i; 
    }

    $orden = 2; //obra social y luego apellido
    $this->atencioness = Doctrine_Core::getTable('Atenciones')->obtenerAtencionesPorProfesionalPeriodo($matricula, $idmes, $idanio, $idestado, $orden);

    $this->idAnio = $idanio;
    $this->idmes = $request->getParameter('idmes');

  }

  public function executeDetalleabiertas(sfWebRequest $request)
  {

    $idestado = 1; // abiertas
    $orden = 2;

    // Obtener usuario logueado y matricula del profesional logueado
    $user_id = $this->getUser()->getGuardUser()->getId();
    $persona = Doctrine_Core::getTable('Personas')->obtenerProfesionalxUser($user_id);
    $matricula = $persona[0]['matricula'];

    // Si es el administrador, la matricula se obtiene del formulario POST
    if ($this->getUser()->getGuardUser()->getIsSuperAdmin()){
       $matricula = $request->getParameter('idmatricula');
    }

    if ( $matricula<>''){
      $this->profesional = Doctrine_Core::getTable('Personas')->obtenerProfesionalxMatricula($matricula);

      $this->atencioness = Doctrine_Core::getTable('Atenciones')->obtenerAtencionesPorProfesionalPeriodo($matricula, NULL, NULL, $idestado);
    }
    
    $this->idAnio = $idanio;
    //$this->idMes = $request->getParameter('idMes');

  }

  public function executeShow(sfWebRequest $request)
  {
    $this->atenciones = Doctrine_Core::getTable('Atenciones')->find(array($request->getParameter('id')));
    $this->forward404Unless($this->atenciones);
  }

  public function executeMasivas(sfWebRequest $request)
  {

    $this->archivos_profesionaless = Doctrine_Core::getTable('Actualizacionestrat')
      ->createQuery('a')
      ->orderby(nombre)
      ->execute();

    $this->ficheros = array();

    foreach($this->archivos_profesionaless as $archivos){
        $targetFolder = sfConfig::get('app_pathfiles_folder')."/../actualizacionestrat".'/'.$archivos->getNombre();

      $image_file = 'image.png';
      switch (pathinfo($archivos->getImagefile(), PATHINFO_EXTENSION)) {
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
          case 'ppt':
              $image_file = 'ppt.png';
              break;
          case 'pptx':
              $image_file = 'ppt.png';
              break;
      }

      $this->ficheros[] = array($archivos->getNombre(), $archivos->getImagefile(), $image_file, $archivos->getId());

      sort($this->ficheros);
    }

  }

  public function executeNew(sfWebRequest $request)
  {

    $atencion = new Atenciones();
    $this->form = new AtencionesForm($atencion, array('idpaciente' => $request->getParameter('idpaciente')));

    $this->idpaciente = $request->getParameter('idpaciente');
    $this->forward404Unless($paciente = Doctrine_Core::getTable('Pacientes')->find(array($request->getParameter('idpaciente'))), sprintf('Object pacientes does not exist (%s).', $request->getParameter('id')));
    $this->paciente = $paciente;
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->forward404Unless($paciente = Doctrine_Core::getTable('Pacientes')->find(array($request->getParameter('idpaciente'))), sprintf('Object pacientes does not exist (%s).', $request->getParameter('id')));
    $this->forward404Unless($tratamiento = Doctrine_Core::getTable('Tratamientos')->find(array($request->getPostParameter('atenciones[idtratamiento]'))), sprintf('Object pacientes does not exist (%s).', $request->getPostParameter('atenciones[idtratamiento]')));
    $this->forward404Unless($obrasocial = Doctrine_Core::getTable('ObrasSociales')->find(array($paciente->getIdobrasocial())), sprintf('Object pacientes does not exist (%s).', $paciente->getIdobrasocial()));
    $this->forward404Unless($planobrasoc = Doctrine_Core::getTable('PlanesObras')->find(array($paciente->getIdplan())), sprintf('Object pacientes does not exist (%s).', $paciente->getIdplan()));
    
    // Obtener usuario logueado
    $user_id = $this->getUser()->getGuardUser()->getId();
    $persona = Doctrine_Core::getTable('Personas')->obtenerProfesionalxUser($user_id);
    $matricula = $persona[0]['matricula'];

    // Si es el administrador, la matricula se obtiene del formulario POST
    if ($this->getUser()->getGuardUser()->getIsSuperAdmin()){
       $matricula = $request->getPostParameter('atenciones[matricula]');
    }

    $atenciones = new Atenciones();
    $atenciones->setNrodoc($paciente->getNrodoc());
    $atenciones->setMatricula($matricula);
    $atenciones->setIdobrasocial($paciente->getIdobrasocial());
    $atenciones->setIdplan($paciente->getIdplan());
    $atenciones->setObrasocial($obrasocial->getDenominacion());
    $atenciones->setPlanobrasocial($planobrasoc->getNombre());
    $atenciones->setIdtratamiento($tratamiento->getId());
    $atenciones->setTratamiento($tratamiento->getNombre());
    $atenciones->setMes($request->getPostParameter('atenciones[mes]'));
    $atenciones->setAnio($request->getPostParameter('atenciones[anio]'));
    $atenciones->setImporte($request->getPostParameter('atenciones[importe]'));
    $atenciones->setCoseguro($request->getPostParameter('atenciones[coseguro]'));
    $atenciones->setCaras($request->getPostParameter('atenciones[caras]'));
    $atenciones->setPieza($request->getPostParameter('atenciones[pieza]'));
    $fecha = $request->getPostParameter('atenciones[fecha][year]').'-'.$request->getPostParameter('atenciones[fecha][month]').'-'.$request->getPostParameter('atenciones[fecha][day]');
    $atenciones->setFecha($fecha);
    $atenciones->setIdAutorizacion($request->getPostParameter('atenciones[idautorizacion]'));
    $atenciones->setAnotacion($request->getPostParameter('atenciones[anotacion]'));
    if ($request->getPostParameter('atenciones[autorizada]') == 'on') {
      $atenciones->setAutorizada(1);
    } else {
      $atenciones->setAutorizada(0);
    }
    $atenciones->save();

    //$this->redirect('atenciones/editar?id='.$request->getParameter('idpaciente'));
    return sfView::NONE;

  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($this->atenciones = Doctrine_Core::getTable('Atenciones')->find(array($request->getParameter('id'))), sprintf('Object atenciones does not exist (%s).', $request->getParameter('id')));
    $this->form = new AtencionesForm($this->atenciones);
    $this->idpaciente = $request->getParameter('idpaciente');
    $this->forward404Unless($paciente = Doctrine_Core::getTable('Pacientes')->find(array($request->getParameter('idpaciente'))), sprintf('Object pacientes does not exist (%s).', $request->getParameter('id')));
    $this->paciente = $paciente;

    // Obtener usuario logueado
    $user_id = $this->getUser()->getGuardUser()->getId();
    $persona = Doctrine_Core::getTable('Personas')->obtenerProfesionalxUser($user_id);
    $matricula = $persona[0]['matricula'];

    if ( $this->getUser()->getGuardUser()->getIsSuperAdmin() && $this->atenciones->getIdEstadoAtencion()<>1) {
        $this->redirect('atenciones/index');
    }

    // Si no es superadmin
    if ( !$this->getUser()->getGuardUser()->getIsSuperAdmin()){
      if ($matricula<>$this->atenciones->getMatricula() || $this->atenciones->getIdEstadoAtencion()<>1){
          $this->redirect('atenciones/index');
      }
    }

  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($atenciones = Doctrine_Core::getTable('Atenciones')->find(array($request->getParameter('id'))), sprintf('Object atenciones does not exist (%s).', $request->getParameter('id')));

    $atenciones->setMes($request->getPostParameter('atenciones[mes]'));
    $atenciones->setAnio($request->getPostParameter('atenciones[anio]'));
    //$atenciones->setImporte($request->getPostParameter('atenciones[importe]'));
    $atenciones->setCaras($request->getPostParameter('atenciones[caras]'));
    $atenciones->setPieza($request->getPostParameter('atenciones[pieza]'));
    $fecha = $request->getPostParameter('atenciones[fecha][year]').'-'.$request->getPostParameter('atenciones[fecha][month]').'-'.$request->getPostParameter('atenciones[fecha][day]');
    $atenciones->setFecha($fecha);
    $atenciones->setIdAutorizacion($request->getPostParameter('atenciones[idautorizacion]'));
    $atenciones->setAnotacion($request->getPostParameter('atenciones[anotacion]'));
    if ($request->getPostParameter('atenciones[autorizada]') == 'on') {
      $atenciones->setAutorizada(1);
    } else {
      $atenciones->setAutorizada(0);
    }
    $atenciones->save();

    $this->redirect('atenciones/editar?id='.$request->getParameter('idpaciente'));


    /*$this->form = new AtencionesForm($atenciones);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit'); */
  }

  public function executeDelete(sfWebRequest $request)
  {
    //$request->checkCSRFProtection();

    $this->forward404Unless($atenciones = Doctrine_Core::getTable('Atenciones')->find(array($request->getParameter('id'))), sprintf('Object atenciones does not exist (%s).', $request->getParameter('id')));

    // Obtener usuario logueado
    $user_id = $this->getUser()->getGuardUser()->getId();
    $persona = Doctrine_Core::getTable('Personas')->obtenerProfesionalxUser($user_id);
    $matricula = $persona[0]['matricula'];

    if ( $this->getUser()->getGuardUser()->getIsSuperAdmin() && $atenciones->getIdEstadoAtencion()==1 ){
        $atenciones->delete();
    } elseif ($matricula==$atenciones->getMatricula() && $atenciones->getIdEstadoAtencion()==1){
            $atenciones->delete();
    }


    $this->redirect('atenciones/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $atenciones = $form->save();

      $this->redirect('atenciones/edit?id='.$atenciones->getId());
    }
  }

// IMPRIMIR FACTURA

  public function executeImprimirficha(sfWebRequest $request)
      {
        
          $id = $request->getParameter('id');
          $encrypt_method = "AES-256-CBC";
          $secret_key = 'DieGo123';
          $secret_iv = 'ReiNo123';
           
          // hash
          $key = hash('sha256', $secret_key);
              
          // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
          $iv = substr(hash('sha256', $secret_iv), 0, 16);
           
          $idficha = openssl_decrypt(base64_decode($id), $encrypt_method, $key, 0, $iv);
          //$id_encriptado = base64_encode($output);

          if(trim($idficha)=='')
              $this->redirect('atenciones/index');

         
          // Obtener informacion de la ficha a imprimir
          $oFicha = Doctrine_Core::getTable('Facturaciones')->find($idficha);

          // Obtener informacion del Paciente
          $oPaciente = Doctrine_Core::getTable('Pacientes')->find($oFicha->getIdpaciente());

          // Obtener informacion de la Obra Social
          $oOsocial = Doctrine_Core::getTable('ObrasSociales')->find($oPaciente->getIdobrasocial());

          // Obtener informacion del plan de Obra Social
          $oPlanOsocial = Doctrine_Core::getTable('PlanesObras')->find($oPaciente->getIdplan());

          // Ciudad de Nacimiento
          $oCiudad = Doctrine_Core::getTable('Ciudades')->find($oPaciente->getIdciudadnac());

          // Odontograma a imprimir   

          //HARDCODEADO!!!!!!!!!!!!!
          
          $oOdontograma = Doctrine_Core::getTable('Odontograma')->find(23);

          // Obtener informacion del profesional logueado
          // Obtener usuario logueado y matricula del profesional logueado
          $user_id = $this->getUser()->getGuardUser()->getId();
          $persona = Doctrine_Core::getTable('Personas')->obtenerProfesionalxUser($user_id);
          $matricula = $persona[0]['matricula'];
          $profesional = $persona[0]['apellido'].', '.$persona[0]['nombre'];

          
         // Obtener atenciones a  mostrar
          $arrFiltro = array('idfacturacion'=> $oFicha->getId());
          $atencioness = Doctrine_Core::getTable('Atenciones')->obtenerDetalleAtencionesFiltro($arrFiltro);

         
          $mes = date('m', strtotime($oFicha->getFecha()));
          $anio = date('Y', strtotime($oFicha->getFecha()));
          $mesd='';
          if ($mes==1) $mesd='Enero';
          if ($mes==2) $mesd='Febrero';
          if ($mes==3) $mesd='Marzo';
          if ($mes==4) $mesd='Abril';
          if ($mes==5) $mesd='Mayo';
          if ($mes==6) $mesd='Junio';
          if ($mes==7) $mesd='Julio';
          if ($mes==8) $mesd='Agosto';
          if ($mes==9) $mesd='Septiembre';
          if ($mes==10) $mesd='Octubre';
          if ($mes==11) $mesd='Noviembre';
          if ($mes==12) $mesd='Diciembre';

          // Analisis parentesco
          $parentesco = 'Titular';
          switch ($oPaciente->getTitular()) {
              case 1:
                  $parentesco = "Titular";
                  break;
              case 2:
                  $parentesco = "Esposo/a";
                  break;
              case 3:
                  $parentesco = "Hijo/a";
                  break;
              case 4:
                  $parentesco = "Hermano/a";
                  break;
              case 5:
                  $parentesco = "Padre/Madre";
                  break;
              default:
                  $parentesco = "Titular";   
                  break;        
          }

          $fechacnac='';
          $arrf = explode('-', $oPaciente->getFechanac());
          $fechanac = $arrf[2]."/".$arrf[1]."/".$arrf[0];

          //$pdf = new PDF();
          $pdf = new PDF('P','mm',array(160,235));
          $pdf->setPrintHeader(false);
          $pdf->setPrintFooter(false);
          $pdf->SetMargins(5, 20, 0, true);
         
          // setear fuente y agregar una pagina
          $pdf->SetFont('Times','',9);
          $pdf->AddPage();

          $pdf->setX(60);
          $pdf->setY(3);
          $pdf->Cell(0,5,'REGISTRO DE PRESTACIONES ODONTOLOGICAS',0,1,'L');


          $pdf->SetY(8);
          $pdf->SetX(53);

          // TABLA de ficha nro arriba derecha
          $html='<table border="1" style="width:267px">
                  <tr>
                     <td colspan="10"></td><td colspan="11">Ficha N°: '.$oFicha->getId().'</td>
                  </tr>
                  <tr>
                     <td valign="bottom" style="font-size:26px;height:35px;" colspan="17">OBRA SOCIAL: <br><b>'.$oOsocial->getAbreviada().'</b></td><td valign="bottom" style="height:35px;" colspan="4">Nro. <b>'.$oOsocial->getNinterno().'</b></td>
                  </tr>
                  <tr>
                     <td colspan="21">Credencial Plan: <b>'.$oPlanOsocial->getNombre().'</b></td>
                  </tr>
                  <tr>
                     <td colspan="3">Nro.</td><td colspan="18"><b>'.$oPaciente->getNroafiliado().'</b></td>
                  </tr>
                </table>';

          $pdf->WriteHTML($html); 

          $pdf->setX(70);
          $pdf->setY(10);
          $pdf->SetFont('Times','',7);
          $pdf->Cell(20,5,'                                  Círculo Odontológico',0,1,'L');
          $pdf->setY(13);
          $pdf->Cell(20,5,'                                  Concepción del Uruguay',0,1,'L');
          $pdf->setY(16);
          $pdf->Cell(20,5,'                                  T. Rocamora 471',0,1,'L');
          $pdf->setY(19);
          $pdf->Cell(20,5,'                                  03442-422957',0,1,'L');

          $pdf->setX(70);
          $pdf->setY(27);
          
          $pdf->SetFont('Times','',9);
          $pdf->Cell(0,5,'MES: ',0);
          $pdf->setX(20);
          $pdf->SetFont('Times','B',9);
          $pdf->Cell(0,5,$mesd,0);
          $pdf->SetFont('Times','',9);
          $pdf->Ln();
     
          $pdf->Cell(0,5,'AÑO: ',0);
          $pdf->SetFont('Times','B',9);
          $pdf->setX(20);
          $pdf->Cell(0,5,$anio,0);
          $pdf->SetFont('Times','',9);
          $pdf->Ln();
                 
          $ximage=5; $yimage=10;
          $pdf->Image('images/logcirculo.jpg',$ximage,$yimage,21);  

          $pdf->SetY(37);
          $pdf->SetX(5);

          // TABLA de informacion del paciente
          $htmlInfoPaciente='<table border="0.5" style="width:403px;">
                  <tr style="border-bottom: 1px solid #ccc;">
                     <td valign="center" style="width:80px;height:20px;">Paciente</td>
                      <td style="width:175px;"><b>'.$oPaciente->getApellido().', '.$oPaciente->getNombre().'</b></td>
                      <td style="width:50px;">D.N.I.</td>
                      <td style="width:97px;"><b>'.$oPaciente->getNrodoc().'</b></td>
                  </tr>
                  <tr>
                     <td style="width:80px;height:20px">Titular &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; '.($oPaciente->getTitular()==1 ? 'Si' : 'No').'</td>
                      <td style="width:175px;">Parentesco: <b>'.$parentesco.'</b></td>
                      <td style="width:50px;">Fecha de Nacimiento</td>
                      <td style="width:97px;"><b>'.$fechanac.'</b></td>
                  </tr>
                  <tr>
                     <td style="width:80px;height:20px">Domicilio</td>
                      <td style="width:175px;"><b>'.$oPaciente->getDireccion().'</b></td>
                      <td style="width:50px;">C.P.</td>
                      <td style="width:97px;"><b>'.$oCiudad->getCodpostal().'</b></td>
                  </tr>
                  <tr>
                     <td style="width:80px;height:20px">Localidad</td>
                      <td style="width:175px;"><b>'.$oCiudad->getDescripcion().'</b></td>
                      <td style="width:50px;">Teléfono</td>
                      <td style="width:97px;"><b>'.$oPaciente->getCelular().'</b></td>
                  </tr>
                  <tr>
                     <td style="width:80px;height:20px">Lugar de Trabajo del Titular</td>
                      <td style="width:175px;"><b>'.$oPaciente->getTrabajo().'</b></td>
                      <td style="width:50px;">Jerarquía</td>
                      <td style="width:97px;"><b>'.$oPaciente->getJerarquia().'</b></td>
                  </tr>
                </table>';

          $pdf->WriteHTML($htmlInfoPaciente); 

            // TABLA de informacion del paciente
          $htmlInfoProfesional='<table border="0.5" style="width:403px;">
                  <tr style="border-bottom: 1px solid #ccc;">
                     <td style="width:285px;height:10px;">Odontólogo : <b>'.$profesional.'</b></td>
                      <td style="width:88px;height:10px;">Matrícula Profesional</td>
                      <td style="width:30px;height:10px;"><b>'.$matricula.'</b></td>
                  </tr>
                  </table>';

          $pdf->SetY(77);

          $pdf->WriteHTML($htmlInfoProfesional);      
    

          $header=array(' FECHA ','PIEZA N°','CARA','CODIGO','CONFORMIDAD PACIENTE','IMPORTE');
          $pdf->SetY(83);
          $this->TablaSimple($header, $pdf, $atencioness);
         
        
          
          $total = "                                                                                                                              Total: $".$oFicha->getImporte();
          $pdf->SetFont('Times','B',10);
          $pdf->Cell(0,5, $total,0,1,'L');
          $pdf->SetFont('Times','',9);

          $pdf->Cell(0,5, "Cantidad de RX Adjuntas",0,1,'L');
          $pdf->SetY(134);$pdf->SetX(45);
          $htmlTableRight ='<table border="0.5" style="width:16px;">
                  <tr style="border-bottom: 1px solid #ccc;">
                     <td style="width:16px;height:16px;"></td>
                     <td style="width:16px;height:16px;"></td>
                  </tr></table>';
          $pdf->WriteHTML($htmlTableRight); 
          

          $texto = "He sido informado por el profesional sobre la naturaleza y propósito del tratamiento, posibles complicaciones, riesgos alternativos y aceptación del mismo.";

          $firma = "<b><br><br>Firma y aclaración del Paciente : ___________________________</b><br>";
          
           $htmlInfoPie='<br><br><table border="0.5" style="width:260px;">
                  <tr style="border-bottom: 1px solid #ccc;">
                     <td style="width:260px;height:50px;">'.$texto.'
                     '.$firma.'</td>
                  </tr></table>';

          $pdf->SetY(143);        

          $pdf->WriteHTML($htmlInfoPie);  

                              
          
          $pdf->SetY(183);$pdf->SetX(80);
          $pdf->Cell(0,5,'_____________________________________',0,1,'C');
          $pdf->SetX(100);  $pdf->SetY(188);
          $pdf->Cell(0,5,'SELLO, FIRMA DEL PROFESIONAL        ',0,1,'R');

          
          // Agregar pagina 2 donde se imprime el odontograma
          $pdf->SetFont('Times','',9);
          $pdf->AddPage();

          $pdf->setX(3);
          $pdf->setY(3);

       /*   $h_img = fopen('4.png', "rb");
$img = fread($h_img, filesize('4.png'));
fclose($h_img);
// prepare a base64 encoded "data url"
$pic = 'data://text/plain;base64,' . base64_encode($img);
// extract dimensions from image
$info = getimagesize($pic);*/

          
         
          // TABLA de ficha nro arriba derecha
          $html='<table border="1" style="width:400px">
                  <tr>
                     <td valign="bottom" style="font-size:26px;height:100px;">RX <br><b></b></td>
                     <td align="center" valign="bottom" style="height:100px;">RESERVADO OBRA SOCIAL</td>
                  </tr>
                  
                </table>';
          $html2='<table border="1" style="width:400px;height:400px">
                 
                </table>';  

          
          $pdf->WriteHTML($html.$html2); 
          $ximage=50; $yimage=00;
       //   $pdf->Image($pic, 10, 30, $info[0], $info[1], 'png');
       //  $pdf->Image('4.jpg',$ximage,$yimage,21);  

         $pdf->Image('dientes.jpg',$ximage,$yimage,21);   

 //  $tmpFile = 'tempimg.png';       

 /*         $dataURI    = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAPCAMAAADarb8dAAAABlBMVEUAAADtHCTeKUOwAAAAF0lEQVR4AWOgAWBE4zISkMbDZQRyaQkABl4ADHmgWUYAAAAASUVORK5CYII=";
$dataPieces = explode(',',$dataURI);
$encodedImg = $dataPieces[1];
$decodedImg = base64_decode($encodedImg);

//  Check if image was properly decoded
if( $decodedImg!==false )
{
    //  Save image to a temporary location
    if( file_put_contents($tmpFile,$decodedImg)!==false )
    {
       
        $pdf->Image($tmpFile);
       
        //  Delete image from server
        unlink($tmpFile);
    }
}*/

          
               

          // Mostrar PDF
          $filename="invoice.pdf";
          $pdf->Output($filename,'I');

        //  $pdf->Output('solicitud-baja.pdf', 'I');
      
          // Stop symfony process
          throw new sfStopException();

          return sfView::NONE;
    }

  function TablaSimple($header, &$pdf, &$atencioness)
  {
    //Cabecera
    $x = 17; $y=0; $xancho = 30; $xanchoextra = 44;
    $line = 1;

    // encabezado
      $pdf->Cell($x,$y,$header[0],$line);
      $pdf->Cell($x,$y,$header[1],$line);
      $pdf->Cell($x,$y,$header[2],$line);
      $pdf->Cell($x,$y,$header[3],$line);
      $pdf->Cell($xanchoextra,$y,$header[4],$line);
      $pdf->Cell($xancho,$y,$header[5],$line);
      $pdf->Ln();

    $fecha='';
    $contador=0;
    
    foreach($atencioness as $item){ 

          $arrf = explode('-', $item['fecha']);
          $fecha = $arrf[2]."/".$arrf[1]."/".$arrf[0];
   
          $pdf->Cell($x,$y,$fecha,$line);
          $pdf->Cell($x,$y,$item['pieza'],$line);
          $pdf->Cell($x,$y,$item['cara'],$line);
          $pdf->Cell($x,$y,$item['tratamiento'],$line);
          $pdf->Cell($xanchoextra,$y,"",$line);
          $pdf->Cell($xancho,$y,$item['importe'],$line);
          $pdf->Ln();

          $contador++;

    }

    for( $i = $contador; $i<10; $i++ ) {
           $arrf = explode('-', $item['fecha']);
          $fecha = $arrf[2]."/".$arrf[1]."/".$arrf[0];
   
          $pdf->Cell($x,$y,'  /  /  ',$line);
          $pdf->Cell($x,$y,'',$line);
          $pdf->Cell($x,$y,'',$line);
          $pdf->Cell($x,$y,'',$line);
          $pdf->Cell($xanchoextra,$y,'',$line);
          $pdf->Cell($xancho,$y,'',$line);
          $pdf->Ln();

    }
     
  }

    function Footer(&$pdf)
    {
      $pdf->SetY(-15);
      $pdf->SetFont('Times','I',8);
      $pdf->Cell(0,10,'Page '.$pdf->PageNo().'/{nb}',0,0,'C');
    }

    function ChapterTitle($num, $label,&$pdf)
    {
      $pdf->SetFont('Times','',9);
      //$pdf->SetFillColor(200,220,255);
      $pdf->Cell(0,6,"$num $label",0,1,'L',true);
      //$pdf->Ln(0);
    }

    function ChapterTitle2($num, $label,&$pdf)
    {
        $pdf->SetFont('Times','',9);
        //$pdf->SetFillColor(249,249,249);
        $pdf->Cell(0,6,"$num $label",0,1,'L',true);
        //$pdf->Ln(0);
    }
}

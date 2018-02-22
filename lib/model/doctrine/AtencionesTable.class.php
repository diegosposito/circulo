<?php

/**
 * AtencionesTable
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class AtencionesTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object AtencionesTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Atenciones');
    }

    // Obtener obras sociales
    public static function obtenerAtenciones()
    {
        $sql ="SELECT at.id, at.nrodoc, at.mes, at.anio, at.matricula, at.fecha, at.pieza, at.caras, at.tratamiento, at.importe, at.coseguro, at.bono, at.importe, at.idestadoatencion,
            pac.apellido, pac.nombre, os.denominacion, os.abreviada as obrasocial, concat(per.apellido,', ' , per.nombre) as profesional
            FROM atenciones at JOIN pacientes pac ON at.nrodoc = pac.nrodoc
            JOIN obras_sociales os ON at.idobrasocial = os.idobrasocial
            JOIN personas per ON at.matricula = per.nrolector ";

		/* if($estado !== NULL)
		    $sql .=  " WHERE t.activo = ".$estado." ";	*/

		$sql .= " ORDER BY os.abreviada, at.fecha DESC;";

        $q = Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAssoc($sql);

        return $q;
    }

    // Obtener obras sociales
    public static function obtenerAtencionesPorPaciente($idpaciente=NULL)
    {
        $sql ="SELECT at.id, at.nrodoc, at.mes, at.anio, at.matricula, at.fecha, at.pieza, at.caras, at.tratamiento, at.importe, at.coseguro, at.bono, at.importe, at.idestadoatencion,
            pac.apellido, pac.nombre, os.denominacion, os.abreviada as obrasocial, concat(per.apellido,', ' , per.nombre) as profesional, per.idpersona as idprofesional,
            CASE at.mes WHEN 1 THEN 'Enero' WHEN 2 THEN 'Febrero' WHEN 3 THEN 'Marzo' WHEN 4 THEN 'Abril' WHEN 5 THEN 'Mayo' WHEN 6 THEN 'Junio' WHEN 7 THEN 'Julio' WHEN 8 THEN 'Agosto' WHEN 9 THEN 'Septiembre' WHEN 10 THEN 'Octubre' WHEN 11 THEN 'Noviembre' WHEN 12 THEN 'Diciembre'   ELSE ''  END as mesdetalle,
            CASE at.idestadopago WHEN 1 THEN 'Pendiente' WHEN 2 THEN 'Pagado' WHEN 3 THEN 'Debitado' ELSE ''  END as estadopago 
            FROM atenciones at JOIN pacientes pac ON at.nrodoc = pac.nrodoc
            JOIN obras_sociales os ON at.idobrasocial = os.idobrasocial
            JOIN personas per ON at.matricula = per.nrolector ";

		 if($idpaciente !== NULL)
		    $sql .=  " WHERE pac.id = ".$idpaciente." ";

		$sql .= " ORDER BY at.anio DESC, at.mes DESC, at.fecha DESC;";

        $q = Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAssoc($sql);

        return $q;
    }

     // crear recibos de personas seleccionadas
    public static function marcarComoFacturados($arrAtenciones, $idfactura)
    {

        // Definir elemenos para filtrar por IN
        $datos=''; $cantidad=0;
        foreach($arrAtenciones as $info)
            $datos .= $info.', ';

        $datos = substr($datos, 0, strlen($datos)-2);

        // actualizar designaciones
        $sql = "UPDATE atenciones set idfacturacion = ".$idfactura." WHERE id IN (".$datos.");";

        $q = Doctrine_Manager::getInstance()->getCurrentConnection();

        return $q->execute($sql);
    }

    // Obtener obras sociales
    public static function obtenerAtencionesPorProfesionalPeriodo($matricula, $idmes=NULL, $idanio=NULL, $idestado=NULL, $orden=1)
    {
        $sql ="SELECT at.id, at.nrodoc, at.mes, at.anio, at.matricula, at.fecha, at.pieza, at.caras, at.tratamiento, at.importe, at.coseguro, at.bono, at.importe,
            pac.apellido, pac.nombre, os.denominacion, os.abreviada as obrasocial, concat(per.apellido,', ' , per.nombre) as profesional,
            CASE at.mes WHEN 1 THEN 'Enero' WHEN 2 THEN 'Febrero' WHEN 3 THEN 'Marzo' WHEN 4 THEN 'Abril' WHEN 5 THEN 'Mayo' WHEN 6 THEN 'Junio' WHEN 7 THEN 'Julio' WHEN 8 THEN 'Agosto' WHEN 9 THEN 'Septiembre' WHEN 10 THEN 'Octubre' WHEN 11 THEN 'Noviembre' WHEN 12 THEN 'Diciembre'   ELSE ''  END as mesdetalle,
            CASE at.idestadoatencion WHEN 1 THEN 'Abierta' WHEN 0 THEN 'Cerrada' END as estadoatencion,
            CASE at.idestadopago WHEN 1 THEN 'Pendiente' WHEN 2 THEN 'Pagado' WHEN 3 THEN 'Debitado' ELSE ''  END as estadopago  
            FROM atenciones at JOIN pacientes pac ON at.nrodoc = pac.nrodoc
            JOIN obras_sociales os ON at.idobrasocial = os.idobrasocial
            JOIN personas per ON at.matricula = per.nrolector
            WHERE 1 = 1 ";

		if($matricula !== NULL)
		    $sql .=  " AND at.matricula = ".$matricula." ";

        if($idmes !== NULL)
            $sql .=  " AND at.mes = ".$idmes." ";

        if($idanio !== NULL)
            $sql .=  " AND at.anio = ".$idanio." ";

        if($idestado !== NULL)
            $sql .=  " AND at.idestadoatencion = ".$idestado." ";

        switch ($orden) {
          case '1':
              $sql .= " ORDER BY at.anio DESC, at.mes DESC, at.fecha DESC;";
              break;
          case '2':
              $sql .= " ORDER BY os.abreviada, pac.apellido, pac.nombre; ";
              break;
        }

        $q = Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAssoc($sql);

        return $q;
    }

    // Obtener atenciones cerradas segun filtro
    public static function obtenerAtencionesCerradasFiltro($arrFiltros)
    {
        $sql ="SELECT COUNT(DISTINCT at.id) as cantidad, at.id, at.mes, at.anio, CONCAT(LPAD(at.mes,2,'0'),'-',at.anio) as periodo, SUM(at.importe) as importe, SUM(at.coseguro) as coseguro,
            CASE at.mes WHEN 1 THEN 'Enero' WHEN 2 THEN 'Febrero' WHEN 3 THEN 'Marzo' WHEN 4 THEN 'Abril' WHEN 5 THEN 'Mayo' WHEN 6 THEN 'Junio' WHEN 7 THEN 'Julio' WHEN 8 THEN 'Agosto' WHEN 9 THEN 'Septiembre' WHEN 10 THEN 'Octubre' WHEN 11 THEN 'Noviembre' WHEN 12 THEN 'Diciembre'   ELSE ''  END as mesdetalle,
            at.anio
            FROM atenciones at JOIN pacientes pac ON at.nrodoc = pac.nrodoc
            JOIN obras_sociales os ON at.idobrasocial = os.idobrasocial
            JOIN personas per ON at.matricula = per.nrolector
            WHERE at.idestadoatencion <> 1 ";

        if($arrFiltros['matricula'] <> '')
            $sql .=  " AND at.matricula = ".$arrFiltros['matricula']." ";

        if($arrFiltros['anio'] <> '')
            $sql .=  " AND at.anio = ".$arrFiltros['anio']." ";

        $sql .= " GROUP BY at.anio, at.mes ORDER BY at.mes DESC;";

        $q = Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAssoc($sql);

            return $q;
        }

    // Obtener detalle de atenciones segun criterio
    public static function obtenerDetalleAtencionesFiltro($arrFiltros, $arrGroup=null, $arrOrder=null)
    {
        $sql ="SELECT at.id, at.mes, at.anio, CONCAT(LPAD(at.mes,2,'0'),'-',at.anio) as periodo, at.matricula, at.importe, at.coseguro, at.bono, at.importeos,at.pieza, at.caras, at.idtratamiento, at.tratamiento, at.idobrasocial,
            CASE at.mes WHEN 1 THEN 'Enero' WHEN 2 THEN 'Febrero' WHEN 3 THEN 'Marzo' WHEN 4 THEN 'Abril' WHEN 5 THEN 'Mayo' WHEN 6 THEN 'Junio' WHEN 7 THEN 'Julio' WHEN 8 THEN 'Agosto' WHEN 9 THEN 'Septiembre' WHEN 10 THEN 'Octubre' WHEN 11 THEN 'Noviembre' WHEN 12 THEN 'Diciembre'   ELSE ''  END as mesdetalle,
            pac.apellido, pac.nombre, pac.nrodoc, per.apellido, per.nombre, concat(pac.apellido,' ', pac.nombre) as paciente,
            concat(per.apellido, ' ', per.nombre) as profesional, at.fecha, os.abreviada as obrasocial, at.idplan as idplanobrasocial, po.nombre as planobrasocial, at.idestadopago 
            FROM atenciones at
            JOIN pacientes pac ON at.nrodoc = pac.nrodoc
            JOIN obras_sociales os ON at.idobrasocial = os.idobrasocial 
            JOIN planes_obras po ON at.idplan = po.id 
            JOIN personas per ON at.matricula = per.nrolector
            WHERE 1=1 ";

        if($arrFiltros['matricula'] <> '')
            $sql .=  " AND at.matricula = ".$arrFiltros['matricula']." ";

        if($arrFiltros['idestadoatencion'] <> '')
            $sql .=  " AND at.idestadoatencion = ".$arrFiltros['idestadoatencion']." ";

        if($arrFiltros['idestadopago'] <> '')
            $sql .=  " AND at.idestadopago = ".$arrFiltros['idestadopago']." ";

        if($arrFiltros['anio'] <> '')
            $sql .=  " AND at.anio = ".$arrFiltros['anio']." ";

        if($arrFiltros['idmes'] <> '')
            $sql .=  " AND at.mes = ".$arrFiltros['idmes']." ";

         if($arrFiltros['idfacturacion'] <> '')
            $sql .=  " AND at.idfacturacion = ".$arrFiltros['idfacturacion']." ";

        if($arrFiltros['pacientedoc'] <> '')
            $sql .=  " AND at.nrodoc = ".$arrFiltros['pacientedoc']." ";

        if($arrFiltros['nofacturadasenficha'] <> '')
            $sql .=  " AND at.idfacturacion IS NULL ";

        if(count($arrFiltros['idatenciones']) >0 ){
            $datos='';
            foreach($arrFiltros['idatenciones'] as $info)
               $datos .= $info.', ';

            $datos = substr($datos, 0, strlen($datos)-2);

            $sql .=  " AND at.id IN (".$datos.") ";
        }

        $q = Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAssoc($sql);

        return $q;
    }

    // Obtener ficha de impresion por matricula lista para imprimir
    public static function obtenerFichaImpresion($matricula)
    {
        $sql ="SELECT fact.id, fact.matricula, fact.fecha, fact.importe, fact.imprimir FROM facturaciones fact WHERE fact.imprimir AND fact.matricula= ".$matricula.";";

        $q = Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAssoc($sql);

        return $q;
    }

    // Obtener detalle de facturas segun criterio
    public static function obtenerFacturasFiltro($arrFiltros, $arrGroup=null, $arrOrder=null)
    {
        $sql ="SELECT fact.id, fact.matricula, fact.fecha, fact.importe, fact.imprimir FROM facturaciones fact WHERE 1=1 ";

        if($arrFiltros['matricula'] <> '')
            $sql .=  " AND fact.matricula = ".$arrFiltros['matricula']." ";

        if($arrFiltros['anio'] <> '')
            $sql .=  " AND YEAR(fact.fecha) = ".$arrFiltros['anio']." ";

        if(count($arrFiltros['idfacturaciones']) >0 ){
            $datos='';
            foreach($arrFiltros['idfacturaciones'] as $info)
               $datos .= $info.', ';

            $datos = substr($datos, 0, strlen($datos)-2);

            $sql .=  " AND fact.id IN (".$datos.") ";
        }

        if($arrOrder['iddesc'] <> '')
            $sql .=  " ORDER BY fact.id DESC ";

        $q = Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAssoc($sql);

        return $q;
    }

    // Desactivar Registros
    public static function actualizarPreciosAtenciones($importe=0, $coseguro=0)
    {

         // desactivar registros
        $sql ="UPDATE atenciones at JOIN tratamientos t ON at.idtratamiento = t.id
                SET at.importe = ".$importe.", at.coseguro = ".$coseguro." WHERE at.idestadoatencion = 1;";

        $q = Doctrine_Manager::getInstance()->getCurrentConnection();

        return $q->execute($sql);

    }

     // Desactivar Registros
    public static function actualizarFichaImprimir($idficha)
    {
        
         $q = Doctrine_Manager::getInstance()->getCurrentConnection();

        // resetear todas las fichas del profesional logueado a NO IMPRIMIR
        $sql ="UPDATE facturaciones fact JOIN
        (SELECT matricula FROM facturaciones where id = ".$idficha.") as mat ON fact.matricula = mat.matricula
        set fact.imprimir = false;";

        $q->execute($sql);

         // Setear la ficha elegida para imprimir
        $sqlu ="UPDATE facturaciones set imprimir = true WHERE id =".$idficha.";";

        $q->execute($sqlu);

    }

    // Obtener obras sociales
    public static function obtenerAtencionesAbiertasPorProfesional($matricula)
    {
        $sql ="SELECT at.id, at.nrodoc, at.mes, at.anio, at.matricula, at.fecha, at.pieza, at.caras, at.tratamiento, at.importe, at.coseguro, at.bono, at.importe,
            pac.apellido, pac.nombre, os.denominacion, os.abreviada as obrasocial, concat(per.apellido,', ' , per.nombre) as profesional,
            CASE at.mes WHEN 1 THEN 'Enero' WHEN 2 THEN 'Febrero' WHEN 3 THEN 'Marzo' WHEN 4 THEN 'Abril' WHEN 5 THEN 'Mayo' WHEN 6 THEN 'Junio' WHEN 7 THEN 'Julio' WHEN 8 THEN 'Agosto' WHEN 9 THEN 'Septiembre' WHEN 10 THEN 'Octubre' WHEN 11 THEN 'Noviembre' WHEN 12 THEN 'Diciembre'   ELSE ''  END as mesdetalle,
            CASE at.idestadoatencion WHEN 1 THEN 'Abierta' WHEN 0 THEN 'Cerrada' END as estadoatencion
            FROM atenciones at JOIN pacientes pac ON at.nrodoc = pac.nrodoc
            JOIN obras_sociales os ON at.idobrasocial = os.idobrasocial
            JOIN personas per ON at.matricula = per.nrolector
            WHERE at.idestadoatencion = 1 ";

         if($matricula !== NULL)
            $sql .=  " AND at.matricula = ".$matricula." ";

        $sql .= " ORDER BY os.abreviada, pac.apellido;";

        $q = Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAssoc($sql);

        return $q;
    }

    // Cerrar atenciones por periodo por Profesional
    public static function cerrarAtencionesPorProfesionalPeriodo($matricula, $idmes, $idanio, $arrAtenciones)
    {

        // Recorro atenciones que no deben cerrarse y preparo string
        $datos=''; $cantidad=0;
        if ( count($arrAtenciones)>0 ){

            foreach($arrAtenciones as $info)
                $datos .= $info.', ';

            $datos = substr($datos, 0, strlen($datos)-2);

        }

        $sql ="UPDATE atenciones SET idestadoatencion = 0, anio = ".$idanio.", mes = ".$idmes." WHERE idestadoatencion=1 AND matricula = '".$matricula."' ";

        if ($datos<>'')
            $sql .= " AND id NOT IN (".$datos.") ";

        $sql .= "; ";

        $q = Doctrine_Manager::getInstance()->getCurrentConnection();

        return $q->execute($sql);

    }

}

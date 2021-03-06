<?php

/**
 * TratamientosTable
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class TratamientosTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object TratamientosTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Tratamientos');
    }

    // Obtener obras sociales
    public static function obtenerTratamientos($estado=NULL)
    {
        $sql ="SELECT t.id, t.nombre as tratamiento, t.abreviacion, grt.nombre as grupo, t.idobrasocial, os.abreviada as osabreviada, os.denominacion as obrasocial,
				t.idontologia, CASE t.idontologia WHEN 1 THEN 'General' WHEN 2 THEN 'Prótesis' WHEN 3 THEN 'Implantes' WHEN 4 THEN 'Ortodoncia' END AS odontologia,
				t.garantia, t.importe, t.coseguro, t.bono, t.importeos, t.idautorizacion, t.visible, t.activo, po.nombre as planos, concat(os.abreviada,' - ', po.nombre) as obraplan
				FROM tratamientos t
				JOIN obras_sociales os ON t.idobrasocial = os.idobrasocial
        JOIN planes_obras po ON t.idplan = po.id
				JOIN grupo_tratamiento grt ON t.idgrupotratamiento = grt.id ";

		if($estado !== NULL)
		    $sql .=  " WHERE t.activo = ".$estado." ";

		$sql .= " ORDER BY os.denominacion, t.nombre;";

        $q = Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAssoc($sql);

        return $q;
    }

    // Obtener obras sociales
    public static function obtenerPorObraSocial($idobrasocial, $estado=NULL)
    {
        $sql ="SELECT t.id, t.nombre as tratamiento, t.abreviacion, t.idobrasocial, os.abreviada as osabreviada, os.denominacion as obrasocial,
                t.idontologia, CASE t.idontologia WHEN 1 THEN 'General' WHEN 2 THEN 'Prótesis' WHEN 3 THEN 'Implantes' WHEN 4 THEN 'Ortodoncia' END AS odontologia,
                t.garantia, t.importe, t.coseguro, t.bono, t.importeos, t.idautorizacion, t.visible, t.activo
                FROM tratamientos t
                JOIN obras_sociales os ON t.idobrasocial = os.idobrasocial  ";

        if($estado !== NULL)
            $sql .=  " WHERE t.idobrasocial = ".$idobrasocial." AND t.activo = ".$estado." ";

        $sql .= " ORDER BY os.denominacion, t.nombre;";

        $q = Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAssoc($sql);

        return $q;
    }

    public static function obtenerPorPaciente($idpaciente, $estado=NULL)
    {
        $sql ="SELECT t.id, t.nombre as tratamiento, t.abreviacion, t.idobrasocial, os.abreviada as osabreviada, os.denominacion as obrasocial,
                t.idontologia, CASE t.idontologia WHEN 1 THEN 'General' WHEN 2 THEN 'Prótesis' WHEN 3 THEN 'Implantes' WHEN 4 THEN 'Ortodoncia' END AS odontologia,
                t.garantia, t.importe, t.coseguro, t.bono, t.importeos, t.idautorizacion, t.visible, t.activo
                FROM tratamientos t
                JOIN obras_sociales os ON t.idobrasocial = os.idobrasocial
                JOIN pacientes pac ON os.idobrasocial = pac.idobrasocial 
                JOIN planes_obras po ON pac.idobrasocial = po.idobrasocial AND pac.idplan = po.id ";

        if($estado !== NULL)
            $sql .=  " WHERE pac.id = ".$idpaciente." AND t.activo = ".$estado." AND po.activo = ".$estado." ";

        $sql .= " ORDER BY os.denominacion, t.nombre;";

        $q = Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAssoc($sql);

        return $q;
    }
}

<?php

/**
 * ActualizacionesatenTable
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class ActualizacionesatenTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object ActualizacionesatenTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Actualizacionesaten');
    }

    public static function prepararRegistros()
    {

         // actualizar designaciones
        $sql ="UPDATE tmp_atenciones tmp SET tmp.actualizar = 0;";

        $q = Doctrine_Manager::getInstance()->getCurrentConnection();

        return $q->execute($sql);

    }

    public static function actualizarPeriodoCerrado()
    {

         // actualizar AtencionesCerradas
        $sql ="update atenciones at JOIN tmp_periodos tp ON at.id = tp.id
                SET at.matricula= tp.matricula, at.nrodoc = tp.nrodoc, at.mes = tp.mes, at.anio = tp.anio, at.idobrasocial = tp.idobrasocial, at.idplan = tp.idplanobrasocial, at.idtratamiento = tp.idtratamiento, at.tratamiento = tp.tratamiento,
                at.pieza = tp.pieza, at.caras = tp.caras, at.importe = tp.importe, at.coseguro = tp.coseguro, at.bono = tp.bono, at.importeos = tp.importeos, at.idestadopago = tp.idestadopago, at.fecha = STR_TO_DATE(tp.fecha, '%d/%m/%Y');";

        $q = Doctrine_Manager::getInstance()->getCurrentConnection();

        return $q->execute($sql);

    }

    // Obtener obras sociales
    public static function insertarAtenciones()
    {

         // actualizar designaciones
        $sql ="INSERT INTO `atenciones`
                SELECT NULL,ta.nrodoc,ta.mes,ta.anio,ta.idobrasocial, ta.obrasocial, ta.idplanobrasocial, ta.planobrasocial, ta.idtratamiento, ta.matricula, ta.pieza, ta.caras, ta.tratamiento,ta.importe,ta.coseguro,ta.bono,ta.importeos,now(),now(),1,1,1,1,1,1,'','','',STR_TO_DATE(ta.fecha, '%d/%m/%Y')
                 FROM tmp_atenciones ta JOIN tratamientos t ON ta.tratamiento = t.nombre WHERE ta.actualizar = 0;";

        $q = Doctrine_Manager::getInstance()->getCurrentConnection();

        $resultado = $q->execute($sql);

         // Marcar atenciones temporales para que no vuelvan a intertarse, por si sinquerer se da ejecutar de nuevo
        $sql ="UPDATE tmp_atenciones tmp SET tmp.actualizar = 1;";

        $q = Doctrine_Manager::getInstance()->getCurrentConnection();

        return $q->execute($sql);

    }

    // Obtener registros a actualizar
   /* public static function obtenerRegistrosAActualizar($campo_en_tratamientos,$campo, $tipo_campo)
    {
        $sql ="UPDATE tratamientos trat JOIN tmp_tratamiento tmp ON trat.id = tmp.id SET trat.".$campo_en_tratamientos." = tmp.".$campo." WHERE tmp.actualizar = 1 ";

        if ($tipo_campo=='N'){
            $sql .=" AND tmp.".$campo." > 0 ";
        } else {
            $sql .=" AND tmp.".$campo." IS NOT NULL AND tmp.".$campo." <> '' ";
        }

        $sql .=" ; ";

        return $sql; // RETORNA el string con la consulta solamente
    }*/
}

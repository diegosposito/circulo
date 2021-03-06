<?php

/**
 * ActualizacionestratTable
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class ActualizacionestratTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object ActualizacionestratTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Actualizacionestrat');
    }

    // NUEVAS FUNCIONES

    public static function prepararRegistros()
    {

         // actualizar designaciones
        $sql ="UPDATE tmp_tratamiento tmp JOIN tratamientos trat ON tmp.id = trat.id SET tmp.actualizar = 1;";

        $q = Doctrine_Manager::getInstance()->getCurrentConnection();

        return $q->execute($sql);

    }

    // Obtener obras sociales
    public static function insertarTratamientos()
    {

         // actualizar designaciones
        $sql ="INSERT INTO `tratamientos`
                SELECT NULL, nombre, abreviacion, idgrupotratamiento, idobrasocial, idplan, idontologia, garantia, importe, coseguro, bono, importeos, idautorizacion, visible, descripcion, normas, activo, now(), now(), 1, 1
                FROM tmp_tratamiento WHERE actualizar = 0;";

        $q = Doctrine_Manager::getInstance()->getCurrentConnection();

        return $q->execute($sql);

    }

    // Obtener registros a actualizar
    public static function obtenerRegistrosAActualizar($campo_en_tratamientos,$campo, $tipo_campo)
    {
        $sql ="UPDATE tratamientos trat JOIN tmp_tratamiento tmp ON trat.id = tmp.id SET trat.".$campo_en_tratamientos." = tmp.".$campo." WHERE tmp.actualizar = 1 ";

        if ($tipo_campo=='N'){
            $sql .=" AND tmp.".$campo." > 0 ";
        } else {
            $sql .=" AND tmp.".$campo." IS NOT NULL AND tmp.".$campo." <> '' ";
        }

        $sql .=" ; ";

        return $sql; // RETORNA el string con la consulta solamente
    }

}

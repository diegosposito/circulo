<?php

/**
 * GrupoTratamientoTable
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class GrupoTratamientoTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object GrupoTratamientoTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('GrupoTratamiento');
    }


        // Obtiene todos los grupos de tratamientos activos
        public static function obtenerTodos()
        {
            $q = Doctrine_Query::create()
                ->select('gt.*')
                ->from('GrupoTratamiento gt')
                ->where('gt.activo=1')
                ->orderby('gt.nombre ASC ');

            return $q->execute();
        }
}

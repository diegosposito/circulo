<?php

/**
 * DedicacionesTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class DedicacionesTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object DedicacionesTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Dedicaciones');
    }

    // Obtener dedicaciones
    public static function obtenerDedicacionesProfesores()
    {
    	$sql ="SELECT iddedicacion, descripcion, rangohorario FROM dedicaciones;";

        $q = Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAssoc($sql);
    	
    	return $q;
    }
}

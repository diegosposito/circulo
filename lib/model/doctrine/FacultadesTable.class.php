<?php

/**
 * FacultadesTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class FacultadesTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object FacultadesTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Facultades');
    }

    // Obtiene facultades por area
    public static function obtenerFacultadesPorArea($idarea)
    {
		$resultado = Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAssoc("
					SELECT DISTINCT fac.nombre, fac.idfacultad 
					FROM facultades fac
					JOIN carreras car on fac.idfacultad = car.idfacultad
					JOIN areas_carrera ac ON car.idcarrera = ac.idcarrera
					WHERE ac.idarea = ".$idarea
				);

		return $resultado;		
    }          

}
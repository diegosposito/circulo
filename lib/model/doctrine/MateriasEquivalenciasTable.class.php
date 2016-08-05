<?php

/**
 * MateriasEquivalenciasTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class MateriasEquivalenciasTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object MateriasEquivalenciasTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('MateriasEquivalencias');
    }
    
    // Obtiene el objeto AluMat buscado
    public static function getMateriasEquivalencias($idequivalencia,$idmateriaplan)
    {
    	$q = Doctrine_Query::create()
    	->select('*')
    	->from('MateriasEquivalencias')
    	->where('idequivalencia = '.$idequivalencia)
    	->andWhere('idmateriaplan = '.$idmateriaplan);
    
    	return $q->fetchOne();
    }    
}
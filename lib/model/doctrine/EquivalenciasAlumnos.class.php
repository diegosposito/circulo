<?php

/**
 * EquivalenciasAlumnos
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    sig
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class EquivalenciasAlumnos extends BaseEquivalenciasAlumnos
{
	public function tieneEquivalenciasPendientes()
	{
		$resultado = 0;
		$q = Doctrine_Query::create()
			->select('m.*')
			->from('MateriasEquivalencias m')
			->where('m.idequivalencia = ?', $this->getIdequivalencia())
			->andWhere('m.idestadoequivalencia=2')
			->execute();
	
		foreach ($q as $k => $v){
			$resultado = 1;
		}
	
		return $resultado;
	}	
}

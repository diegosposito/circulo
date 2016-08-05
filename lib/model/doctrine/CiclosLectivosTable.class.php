<?php

/**
 * CiclosLectivosTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class CiclosLectivosTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object CiclosLectivosTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('CiclosLectivos');
    }
    
	public function obtenerCiclosLectivosActivos()
	{
		$q = Doctrine_Query::create()
			->from('CiclosLectivos c')
			->where('activo = 1')
			->orderBy('c.ciclo DESC');
	
		return $q->execute();    
	}	

	public function getIdUltimoCicloLectivoActivo()
	{
		$q = Doctrine_Query::create()
			->from('CiclosLectivos c')
			->where('inicio <= ?' , date("Y-m-d"))
			->andWhere('fin >= ?' , date("Y-m-d"))
			->andWhere('activo = 1');
			
		$obj = $q->fetchOne();
		
		if(count($obj) != 0) {
			return $obj->getId();
		} else {
			return 0;
		}
	}
	
	public function getIdCicloLectivoActual()
	{
		$q = Doctrine_Query::create()
			->from('CiclosLectivos c')
			->where('ciclo = ?' , date ("Y"))
			->andWhere('activo = 1');

		$obj = $q->fetchOne();
		
		if(count($obj) != 0) {
			return $obj->getId();
		} else {
			return 0;
		}		
		
	}

	 // parameters: idalumno
    public static function getAlumnoTieneCicloLectivoMayor2011($idalumno)
    {
        $tieneCiclo = false;

        $resultado = Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAssoc(
                "SELECT cl.id FROM alumnos a JOIN ciclos_lectivos cl ON a.idciclolectivo = cl.id WHERE cl.ciclo>=2012 AND a.idalumno = ".$idalumno. "; "
                );

        // si encuentra algun registro, es porque el alumno esta en un ciclo >=2012
        foreach($resultado as $datos){
        	$tieneCiclo = true;
        }
     
        return $tieneCiclo;              
    }       	
}
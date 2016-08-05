<?php

/**
 * Catedras
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    sig
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Catedras extends BaseCatedras
{


    public function obtenerMateriaDeCatedra() {

    	$resultado = Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAssoc("
			SELECT m.nombre FROM materias m 
			JOIN materias_planes mp ON m.idmateria = mp.idmateria 
			JOIN catedras c ON mp.idmateriaplan = c.idmateriaplan 
			WHERE c.idcatedra=".$this->getIdcatedra(). " "
		);

		foreach ($resultado as $info){
			return $info['nombre'];
		}    	
    } 

    public function obtenerCarreraDeCatedra() {

    	$resultado = Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAssoc("
			SELECT ca.nombre FROM materias m 
			JOIN materias_planes mp ON m.idmateria = mp.idmateria 
			JOIN catedras c ON mp.idmateriaplan = c.idmateriaplan 
			JOIN planes_estudios pe ON pe.idplanestudio=mp.idplanestudio 
			JOIN carreras ca ON ca.idcarrera = pe.idcarrera 
			WHERE c.idcatedra=".$this->getIdcatedra(). " "
		);

		foreach ($resultado as $info){
			return $info['nombre'];
		}    	
    } 

	// Obtener las comisiones de una catedra
	public function obtenerComisiones() {
		$q = Doctrine_Query::create()
			->select('c.*')
			->from('Comisiones c')
			->where('c.idcatedra = '.$this->idcatedra)	 		
			->execute();			
   			
		return $q;
	}  


	// Obtener las comisiones de una catedra
	public function obtenerLlamadosAutogestion() {
		$q = Doctrine_Query::create()
			->select('im.*')
			->from('InscripcionesMesas im')
	 		->innerJoin('im.LlamadosTurno ll ON ll.idllamado = im.idllamado')
			->where('im.idcatedra = '.$this->idcatedra)	 		
			->execute();			
   			
		return $q;
	}  



	// Obtener las comisiones de una catedra
	/*public function obtenerLlamadosAutogestion() {
		$q = Doctrine_Query::create()
			->select('ll.*')
			->from('LlamadosTurno ll')
			->execute();			
   			
		return $q;
	}  
*/

	// Obtener los profesores designados en la materia o plan de estudios
	public function obtenerProfesores($tipo) 
    {
   		$idplanestudio = $this->getMateriasPlanes()->getIdplanestudio();
   		$q = Doctrine_Query::create()
	  		->select('pe.*, pr.idpersona, de.iddesignacion, pr.idprofesor')
	  		->distinct(true)
	 		->from('Designaciones de')
	 		->innerJoin('de.Profesores pr ON de.idprofesor = pr.idprofesor')
	 		->innerJoin('pr.Personas pe ON pr.idpersona = pe.idpersona')
	 		->innerJoin('de.Catedras ca ON de.idcatedra = ca.idcatedra')
	 		->innerJoin('ca.MateriasPlanes mp ON ca.idmateriaplan = mp.idmateriaplan')
	    	->where('mp.idplanestudio = '.$idplanestudio)
	    	->andWhere('now() BETWEEN de.inicio AND de.fin')
	    	->groupBy('pr.idpersona');		

		return $q->execute();
    }  	
    
	// Obtener las mesas de examenes de la materia por estado
	public function obtenerMesasExamenes($estado) 
    {
	    $q = Doctrine_Query::create()
	  		->select('me.*')
	 		->from('MesasExamenes me')
	    	->where('me.idestadomesaexamen = '.$estado)
			->andWhere('me.idcatedra = '.$this->idcatedra);
			
		return $q->execute();
    }  	   

    // Obtener las mesas de examenes (Creadas o publicadas) de la materia por estado
    public function obtenerMesasExamenesDisponibles()
    {
    	$q = Doctrine_Query::create()
    	->select('me.*')
    	->from('MesasExamenes me')
    	->where('(me.idestadomesaexamen=1 or me.idestadomesaexamen=2)')
    	->andWhere('me.idcatedra = '.$this->idcatedra);
    		
    	return $q->execute();
    }
        
	// Obtener las mesas de examenes de tipo Promocion
	public function obtenerMesasExamenesPromocion() 
    {
	    $q = Doctrine_Query::create()
	  		->select('me.*')
	 		->from('MesasExamenes me')
	    	->where('me.idcondicion = 3')
	    	->andWhere('(me.idestadomesaexamen = 1) OR (me.idestadomesaexamen = 2)')
			->andWhere('me.idcatedra = '.$this->idcatedra);
			
		return $q->execute();
    }  	    
    

	// Obtener las mesas de examenes de tipo Promocion
	public function obtenerMesasExamenesAutogestion($idllamado) 
    {

	    $q = Doctrine_Query::create()
	  		->select('me.*')
	 		->from('MesasExamenes me')
	    	->where('(me.idestadomesaexamen = 1) OR (me.idestadomesaexamen = 2)')
			->andWhere('me.idcatedra = '.$this->idcatedra)
			->andWhere('me.idllamado = '.$idllamado);
			
		return $q->execute();
    }  	    
    
    // Obtiene los alumnos cursando a una carrera
  	public function getAlumnosCursando()
 	{
	    $arreglo = array();
		
	    $q = Doctrine_Query::create()
	  		->select('am.*')
	 		->from('AluMat am')	
	 		->innerjoin('am.Alumnos al on am.idalumno=al.idalumno')
	 		->innerjoin('am.Comisiones co on am.idcomision=co.idcomision')
	 		->innerjoin('al.Personas pe on al.idpersona=pe.idpersona')	
	    	->where('am.idestadomateria = 1')
	    	->andWhere('co.idcatedra = '.$this->idcatedra)
	    	->orderBy('pe.apellido ASC, pe.nombre ASC')
	    	->execute();
    	
		//por cada alumno obtenido verifico que el ultimo estado sea cursando
		foreach($q as $item) {
			if (Doctrine_Core::getTable('AluMat')->getVefificarUltimoEstado($item->getIdalumno(), $this->getMateriasPlanes()->getIdmateria(), 1)) {
				// si el ultimo estado es cursando de alumno lo agrego al arreglo
				$arreglo[$item->getIdalumno()] = $item->getAlumnos();
			}
		} 

	return $arreglo;
    }    
    
    // Obtiene los alumnos cursando a una carrera
  	/*public function getCantidadAlumnosCursando()
 	{
	    $arreglo = array();
		
	    $q = Doctrine_Query::create()
	  		->select('am.*')
	 		->from('AluMat am')	
	 		->innerjoin('am.Alumnos al on am.idalumno=al.idalumno')
	 		->innerjoin('am.Comisiones co on am.idcomision=co.idcomision')
	 		->innerjoin('al.Personas pe on al.idpersona=pe.idpersona')	
	    	->where('am.idestadomateria = 1')
	    	->andWhere('co.idcatedra = '.$this->idcatedra)
	    	->orderBy('pe.apellido ASC, pe.nombre ASC')
	    	->execute();
    	$i=0;
		//por cada alumno obtenido verifico que el ultimo estado sea cursando
		foreach($q as $item) {
			if (Doctrine_Core::getTable('AluMat')->getVefificarUltimoEstado($item->getIdalumno(), $this->getMateriasPlanes()->getIdmateria(), 1)) {
				// si el ultimo estado es cursando de alumno lo agrego al arreglo
				$i++;
			}
		} */
		
 		public function getCantidadAlumnosCursando() {
		$q = Doctrine_Query::create()
	  		->select('COUNT(am.idalumno) as cantidad')
	 		->from('AluMat AS am')
	 		->innerjoin('am.Comisiones co on am.idcomision=co.idcomision')
	 		->innerjoin('co.Catedras ca on co.idcatedra=ca.idcatedra')
	 		->innerjoin('ca.MateriasPlanes mp on ca.idmateriaplan=mp.idmateriaplan')
	    	->where('ca.idcatedra = '.$this->idcatedra)
	    	->andWhere('am.idestadomateria = 1')
	    	->andWhere('am.fecha=(
	    				SELECT MAX(alu.fecha) 
	    				FROM AluMat as alu
						INNER JOIN alu.Comisiones com on alu.idcomision=com.idcomision
						INNER JOIN com.Catedras cat on com.idcatedra=cat.idcatedra	    			
	    				WHERE alu.idalumno = am.idalumno
	    				AND cat.idcatedra = '.$this->idcatedra.')')
	    	->execute();
		foreach($q as $v){
			return $v['cantidad'];
		}
    } 

    public function getMateriaPorCatedra($pIdCatedra) {
		$q = Doctrine_Query::create()
	  		->select('m.nombre')
	 		->from('Materias AS m')
	 		->innerjoin('m.MateriasPlanes mp ON m.idmateria = mp.idmateria')
	 		->innerjoin('mp.Catedras ca ON mp.idmateriaplan = ca.idmateriaplan')
	 		->where('ca.idcatedra = '.$pIdCatedra)
	    	->execute();
		foreach($q as $v){
			return $v['nombre'];
		}    
    }               
}

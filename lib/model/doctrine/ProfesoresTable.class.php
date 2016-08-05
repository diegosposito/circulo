<?php

/**
 * ProfesoresTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class ProfesoresTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object ProfesoresTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Profesores');
    }

    // Obtiene designaciones por profesor/facultad x rango de fechas
  	public function obtenerDesignacionesxFecha($idSede, $idPersona, $fdesde, $fhasta) {
		// Obtener materias a visualizar en pantalla
		$idfacultad = Doctrine_Core::getTable('AreasCarrera')->obtenerFacultadxdesignacion();
        
    	$q = Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAssoc("
			SELECT d.iddesignacion,f.nombre as facultad,c.nombre as carrera,m.nombre as materia,tp.descripcion,d.inicio,d.fin,d.fechaaprobacion FROM designaciones d 
				INNER JOIN catedras cat ON d.idcatedra = cat.idcatedra
				INNER JOIN materias_planes mp ON cat.idmateriaplan = mp.idmateriaplan
				INNER JOIN planes_estudios pe ON mp.idplanestudio = pe.idplanestudio
				INNER JOIN carreras c ON pe.idcarrera = c.idcarrera
				INNER JOIN facultades f ON c.idfacultad = f.idfacultad
				INNER JOIN materias m ON mp.idmateria = m.idmateria
				INNER JOIN tipos_designaciones tp ON d.idtipodesignacion = tp.idtipodesignacion
			  WHERE cat.idsede = ".$idSede." AND f.idfacultad = ".$idfacultad.". AND d.idpersona = ".$idPersona.". AND d.inicio between date('".$fdesde."') AND date('".$fhasta."')"
		);
		
		return $q;  	
  	}

    // Obtiene designaciones por profesor/facultad x rango de fechas
    public function obtenerProfesoresPorArea($idarea) {
        
      $q = Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAssoc("
      SELECT per.idpersona, CONCAT(per.apellido,', ',per.nombre) as profesor
      FROM personas per 
      JOIN profesores prof on per.idpersona = prof.idpersona
      JOIN facultades fac on prof.idfacultad = fac.idfacultad
      JOIN carreras car on fac.idfacultad = car.idfacultad
      JOIN (SELECT DISTINCT idcarrera from areas_carrera WHERE idarea = ".$idarea.") ac ON car.idcarrera = ac.idcarrera ORDER BY per.apellido, per.nombre "
    );
    
    return $q;    
    }

    // Obtiene profesores por facultad
    public function obtenerProfesoresPorFacultad($idfacultad) {
        
      $q = Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAssoc("
      SELECT per.idpersona, CONCAT(per.apellido,', ',per.nombre) as profesor
      FROM personas per 
      JOIN profesores prof on per.idpersona = prof.idpersona
      JOIN facultades fac on prof.idfacultad = fac.idfacultad
      WHERE fac.idfacultad = ".$idfacultad." ORDER BY per.apellido "
    );
    
    return $q;    
    }

    // Obtiene Facultades disponibles a asignar segun el area, y que no hayan sido previamente asignadas a la persona
    public function obtenerFacultadesAAsignar($idPersona, $idArea) {
      
      $sql = "SELECT DISTINCT fac.idfacultad, fac.nombre 
          FROM facultades fac
          JOIN carreras car on fac.idfacultad = car.idfacultad
          JOIN areas_carrera ac ON car.idcarrera= ac.idcarrera
          LEFT JOIN profesores prof ON fac.idfacultad = prof.idfacultad AND prof.idpersona = ".$idPersona."
          WHERE ac.idarea = ".$idArea." AND prof.idfacultad IS NULL;";

      return Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAssoc($sql);
    
    }

    // Obtiene Facultades asociadas al area, y asignadas al profesor
    public function obtenerFacultadSegunArea($idPersona, $idArea) {
      
      $sql = "SELECT DISTINCT fac.idfacultad, fac.nombre 
          FROM facultades fac
          JOIN carreras car on fac.idfacultad = car.idfacultad
          JOIN areas_carrera ac ON car.idcarrera= ac.idcarrera
          LEFT JOIN profesores prof ON fac.idfacultad = prof.idfacultad AND prof.idpersona = ".$idPersona."
          WHERE ac.idarea = ".$idArea." AND prof.idfacultad IS NOT NULL;";

      return Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAssoc($sql);
    
    }

  	// Busca todas las personas, candidatas a ser profesores 
    public static function buscarPosibleProfesores($tipocriterio, $criterio)
    {
    	
    	if($tipocriterio==1) {
    		$q = Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAssoc("
    			SELECT p.idpersona, p.nombre, p.apellido, p.nrodoc FROM personas p
    				WHERE
    				((p.apellido LIKE '%".$criterio."%') OR (p.nombre LIKE '%".$criterio."%'))
    				ORDER BY p.apellido ASC, p.nombre ASC
    		");
		}else{
    		$q = Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAssoc("
    			SELECT p.idpersona, p.nombre, p.apellido, p.nrodoc FROM personas p
    				WHERE
    					(p.nrodoc LIKE '%".$criterio."%')
    					ORDER BY p.apellido ASC, p.nombre ASC
    		");
		}		
		
		return $q;
    }   

    // Busca profesores segun filtros
    public static function buscarProfesores($tipocriterio, $criterio, $idArea)
    {
      
      if($tipocriterio==1) {
        $q = Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAssoc("
          SELECT DISTINCT prof.idprofesor, p.idpersona, p.nombre, p.apellido, p.nrodoc FROM personas p JOIN
            profesores prof ON p.idpersona = prof.idpersona
            JOIN facultades fac ON prof.idfacultad = fac.idfacultad
            JOIN carreras car ON fac.idfacultad = car.idfacultad
            JOIN areas_carrera ac ON car.idcarrera = ac.idcarrera
            WHERE ac.idarea = ".$idArea." AND 
            ((p.apellido LIKE '%".$criterio."%') OR (p.nombre LIKE '%".$criterio."%'))
            ORDER BY p.apellido ASC, p.nombre ASC
        ");
    }else{
        $q = Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAssoc("
          SELECT DISTINCT prof.idprofesor, p.idpersona, p.nombre, p.apellido, p.nrodoc FROM personas p JOIN
            profesores prof ON p.idpersona = prof.idpersona
            JOIN facultades fac ON prof.idfacultad = fac.idfacultad
            JOIN carreras car ON fac.idfacultad = car.idfacultad
            JOIN areas_carrera ac ON car.idcarrera = ac.idcarrera
            WHERE ac.idarea = ".$idArea." AND 
              (p.nrodoc LIKE '%".$criterio."%')
              ORDER BY p.apellido ASC, p.nombre ASC
        ");
    }   
    
    return $q;
    }   

    // Obtiene designaciones por profesor/facultad
  	public function obtenerDesignaciones($idSede, $idPersona) {
		// Obtener materias a visualizar en pantalla
		$idfacultad = Doctrine_Core::getTable('AreasCarrera')->obtenerFacultadxdesignacion();
        
    	$q = Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAssoc("
			SELECT d.iddesignacion,f.idfacultad,m.nombre, tp.descripcion, d.inicio, d.fin, d.fechaaprobacion FROM designaciones d 
				INNER JOIN catedras cat ON d.idcatedra = cat.idcatedra
				INNER JOIN materias_planes mp ON cat.idmateriaplan = mp.idmateriaplan
				INNER JOIN planes_estudios pe ON mp.idplanestudio = pe.idplanestudio
				INNER JOIN carreras c ON pe.idcarrera = c.idcarrera
				INNER JOIN facultades f ON c.idfacultad = f.idfacultad
				INNER JOIN materias m ON mp.idmateria = m.idmateria
				INNER JOIN tipos_designaciones tp ON d.idtipodesignacion = tp.idtipodesignacion
			  WHERE cat.idsede = ".$idSede." AND f.idfacultad = ".$idfacultad.". AND d.idpersona = ".$idPersona
		);
		
		return $q;  	
  	}
  	
	// Busca el profesor
  	public function buscarProfesor($idpersona, $idfacultad)
    {
    	$q = Doctrine_Query::create()
	  		->select("*")
	 		->from("Profesores p")
	 		->where("p.idpersona = ".$idpersona)
	    	->andWhere("p.idfacultad = ".$idfacultad)
	    	->fetchOne();
	       
        return $q;
    }      	
}
<?php

/**
 * PlanesEstudiosTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class PlanesEstudiosTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object PlanesEstudiosTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('PlanesEstudios');
    }

    public static function obtenerMateriasPlan($idplan) {
    	$q = Doctrine_Query::create()
			->select('mp.idmateriaplan , m.nombre as nombre')
			->from("Materiasplanes mp")
			->innerJoin("mp.Materias m on mp.idmateria=m.idmateria")
	    	->where("mp.idplanestudio = ".$idplan)
			->orderBy('m.nombre ASC');

		return $q->execute();  	
    } 

     // Obtener catedras por Plan y Sede
    public static function obtenerCatedrasPorPlanSede($idplanestudio, $idsede)
    {
        $sql ="SELECT cat.idcatedra, m.idmateria, mp.idplanestudio, cat.idsede, m.nombre as materia
                FROM materias m
                JOIN materias_planes mp ON m.idmateria = mp.idmateria
                JOIN catedras cat ON mp.idmateriaplan = cat.idmateriaplan
                WHERE mp.idplanestudio = ".$idplanestudio." AND mp.generica = 0 
                AND cat.idsede = ".$idsede." AND cat.activa = 1
                ORDER BY m.nombre; ";
        
        $q = Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAssoc($sql);
        
        return $q;
    }

     // Obtener oferta academica para memoria
    public static function obtenerOfertaAcademica()
    {
        $sql ="SELECT car.idcarrera, se.abreviacion as uacademica, car.nombre as carrera,
                      t.nombre as titulo,tcar.descripcion as nivel, mc.nombre as modalidad,
                      CONCAT(car.nroresolucionhcd,'-',car.nroresolucioncsu) as resolucionhcdcsu,
                      car.nroresolucion as resolucionministerial,
                      car.nroresolucionconeau as resolucionconeau,
                      YEAR(pe.fecha) as inicio, pe.nombre as planestudio, 
                      pe.horastotales as horas
              FROM planes_estudios pe 
              JOIN carreras car ON pe.idcarrera = car.idcarrera
              LEFT JOIN carreras_sede cs ON car.idcarrera = cs.idcarrera
              LEFT JOIN modalidades_carreras mc ON car.idmodalidad = mc.idmodalidad
              LEFT JOIN sedes se ON cs.idsede = se.idsede
              LEFT JOIN titulos_planes tp ON pe.idplanestudio = tp.idplanestudio
              LEFT JOIN titulos t ON tp.idtitulo = t.idtitulo 
              LEFT JOIN tipos_carreras tcar ON car.idtipocarrera = tcar.idtipocarrera
              LEFT JOIN estados_planes ep ON pe.idestadoplan = ep.idestadoplan
              WHERE pe.idestadoplan = 2 AND car.idtipocarrera IN (3,4,5,8,10,12)  ; ";
        
        $q = Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAssoc($sql);
        
        return $q;
    }

     // Obtener oferta academica para memoria
    public static function obtenerInformacionMemoriaAnexo8($ciclo)
    {
        $sql ="SELECT '".$ciclo."' as ciclo, cs.iddependenciaaraucano as Dependencia, cs.idtituloaraucano as Titulo,
                COUNT(DISTINCT if(NOT a.aspirante AND ae.idSituacion = 2, a.idalumno, null)) as NI_total,
                COUNT(DISTINCT if(p.idsexo = 1 AND ae.idSituacion = 2 AND NOT a.aspirante, a.idalumno, null)) as NI_varones,
                COUNT(DISTINCT if(p.idsexo = 2 AND ae.idSituacion = 2 AND NOT a.aspirante, a.idalumno, null)) as NI_mujeres,
                COUNT(DISTINCT if(NOT a.aspirante AND ae.idSituacion = 2 AND aeq.idAlumno IS NOT NULL, a.idalumno, null)) as NIeq_total,
                COUNT(DISTINCT if(p.idsexo = 1 AND ae.idSituacion = 2  AND aeq.idAlumno IS NOT NULL AND NOT a.aspirante, a.idalumno, null)) as NIeq_varones,
                COUNT(DISTINCT if(p.idsexo = 2 AND ae.idSituacion = 2  AND aeq.idAlumno IS NOT NULL AND NOT a.aspirante, a.idalumno, null)) as NIeq_mujeres,
                COUNT(DISTINCT if(NOT a.aspirante AND ae.idSituacion = 3, a.idalumno, null)) as REINSCRIPTOS_total,
                COUNT(DISTINCT if(p.idsexo = 1 AND ae.idSituacion = 3 AND NOT a.aspirante, a.idalumno, null)) as REINSCRIPTOS_varones,
                COUNT(DISTINCT if(p.idsexo = 2 AND ae.idSituacion = 3 AND NOT a.aspirante, a.idalumno, null)) as REINSCRIPTOS_mujeres,
                COUNT(DISTINCT if(NOT a.aspirante AND no_reinscriptos.idalumno IS NOT NULL AND eah2.fecha IS NULL AND eah3.fecha IS NULL, a.idalumno, null)) as NOREINSCRIPTOS_total,
                COUNT(DISTINCT if(p.idsexo = 1 AND no_reinscriptos.idalumno IS NOT NULL AND NOT a.aspirante AND eah2.fecha IS NULL AND eah3.fecha IS NULL, a.idalumno, null)) as NOREINSCRIPTOS_varones,
                COUNT(DISTINCT if(p.idsexo = 2 AND no_reinscriptos.idalumno IS NOT NULL AND NOT a.aspirante AND eah2.fecha IS NULL AND eah3.fecha IS NULL, a.idalumno, null)) as NOREINSCRIPTOS_mujeres,
                COUNT(DISTINCT if(NOT a.aspirante AND ae.idSituacion IN (2,3,4) AND eah3.fecha IS NOT NULL, a.idalumno, null)) as Bajas_total,
                COUNT(DISTINCT if(NOT a.aspirante AND ae.idSituacion IN (2,3,4) AND eah3.fecha IS NOT NULL AND p.idsexo = 1, a.idalumno, null)) as Bajas_varones,
                COUNT(DISTINCT if(NOT a.aspirante AND ae.idSituacion IN (2,3,4) AND eah3.fecha IS NOT NULL AND p.idsexo = 2, a.idalumno, null)) as Bajas_mujeres,
                COUNT(DISTINCT if(NOT a.aspirante AND ae.idSituacion = 3 AND eah.fecha IS NOT NULL, a.idalumno, null)) as Egresados_total,
                COUNT(DISTINCT if(NOT a.aspirante AND ae.idSituacion = 3 AND eah.fecha IS NOT NULL AND p.idsexo = 1, a.idalumno, null)) as Egresados_varones,
                COUNT(DISTINCT if(NOT a.aspirante AND ae.idSituacion = 3 AND eah.fecha IS NOT NULL AND p.idsexo = 2, a.idalumno, null)) as Egresados_mujeres,
                COUNT(DISTINCT if(NOT a.aspirante AND ae.idSituacion IN (2,3), a.idalumno, null)) as TOTAL,
                COUNT(DISTINCT if(NOT a.aspirante AND ae.idSituacion IN (2,3) AND p.idsexo = 1, a.idalumno, null)) as TOTAL_varones,
                COUNT(DISTINCT if(NOT a.aspirante AND ae.idSituacion IN (2,3) AND p.idsexo = 2, a.idalumno, null)) as TOTAL_mujeres,
                c.nombre as Carrera,
                fac.nombre as Facultad,
                sed.abreviacion as Sede, tc.nombre as Tipocarrera
                FROM memoria_estadisticas ae 
                LEFT JOIN (
                  SELECT  idAlumno, count(DISTINCT if(idSituacion IN (2,3),id,NULL)) as idsituacion23, count(DISTINCT if(idSituacion IN (4),id,NULL)) as idsituacion4
                  FROM memoria_estadisticas WHERE ciclo = ".$ciclo." GROUP BY idAlumno HAVING idsituacion23=0 AND idsituacion4>0
                ) as no_reinscriptos ON ae.idalumno = no_reinscriptos.idalumno 
                JOIN alumnos a ON ae.idAlumno = a.idalumno
                JOIN personas p ON a.idpersona = p.idpersona
                JOIN sedes sed on a.idsede = sed.idsede
                JOIN carreras c ON a.idplanestudio = c.idcarrera 
                JOIN tipos_carreras tc ON c.idtipocarrera = tc.idtipocarrera
                JOIN facultades fac ON c.idfacultad = fac.idfacultad
                LEFT JOIN carreras_sede cs ON c.idcarrera =cs.idcarrera AND a.idsede = cs.idsede
                LEFT JOIN memoria_equivalencias aeq ON ae.idAlumno = aeq.idAlumno
                LEFT JOIN araucano_extranjeros aex ON a.idalumno = aex.idalumno
                LEFT JOIN estados_alumno_historial eah ON a.idalumno = eah.idalumno AND eah.idestadoalumno = 3 AND DATE(eah.fecha)>= DATE('".$ciclo."-01-01') AND DATE(eah.fecha)<= DATE('".$ciclo."-12-31')
                LEFT JOIN estados_alumno_historial eah2 ON a.idalumno = eah2.idalumno AND eah2.idestadoalumno = 3 AND DATE(eah2.fecha)>= DATE_ADD('".$ciclo."-01-01',INTERVAL -1 YEAR) AND DATE(eah2.fecha)<= DATE_ADD('".$ciclo."-12-31',INTERVAL -1 YEAR)
                LEFT JOIN estados_alumno_historial eah3 ON a.idalumno = eah3.idalumno AND eah3.idestadoalumno = 2 AND DATE(eah3.fecha)>= DATE('".$ciclo."-01-01') AND DATE(eah3.fecha)<= DATE('".$ciclo."-12-31')
                WHERE ae.idSituacion IN (2,3,4) AND ae.ciclo = ".$ciclo." 
                GROUP BY c.idcarrera, fac.idfacultad, sed.idsede
                ORDER BY c.nombre, sed.nombre 
                ; ";
        
        $q = Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAssoc($sql);
        
        return $q;
    }

    
}

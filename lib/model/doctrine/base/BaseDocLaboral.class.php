<?php

/**
 * BaseDocLaboral
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $iddoclaboral
 * @property integer $idpersona
 * @property integer $idprofesion
 * @property integer $iddedicacion
 * @property string $lugar
 * @property string $horas
 * @property integer $idunidadtiempo
 * @property integer $certificado
 * @property integer $trabaja
 * @property Personas $Personas
 * @property Profesiones $Profesiones
 * 
 * @method integer     getIddoclaboral()   Returns the current record's "iddoclaboral" value
 * @method integer     getIdpersona()      Returns the current record's "idpersona" value
 * @method integer     getIdprofesion()    Returns the current record's "idprofesion" value
 * @method integer     getIddedicacion()   Returns the current record's "iddedicacion" value
 * @method string      getLugar()          Returns the current record's "lugar" value
 * @method string      getHoras()          Returns the current record's "horas" value
 * @method integer     getIdunidadtiempo() Returns the current record's "idunidadtiempo" value
 * @method integer     getCertificado()    Returns the current record's "certificado" value
 * @method integer     getTrabaja()        Returns the current record's "trabaja" value
 * @method Personas    getPersonas()       Returns the current record's "Personas" value
 * @method Profesiones getProfesiones()    Returns the current record's "Profesiones" value
 * @method DocLaboral  setIddoclaboral()   Sets the current record's "iddoclaboral" value
 * @method DocLaboral  setIdpersona()      Sets the current record's "idpersona" value
 * @method DocLaboral  setIdprofesion()    Sets the current record's "idprofesion" value
 * @method DocLaboral  setIddedicacion()   Sets the current record's "iddedicacion" value
 * @method DocLaboral  setLugar()          Sets the current record's "lugar" value
 * @method DocLaboral  setHoras()          Sets the current record's "horas" value
 * @method DocLaboral  setIdunidadtiempo() Sets the current record's "idunidadtiempo" value
 * @method DocLaboral  setCertificado()    Sets the current record's "certificado" value
 * @method DocLaboral  setTrabaja()        Sets the current record's "trabaja" value
 * @method DocLaboral  setPersonas()       Sets the current record's "Personas" value
 * @method DocLaboral  setProfesiones()    Sets the current record's "Profesiones" value
 * 
 * @package    sig
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseDocLaboral extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('doc_laboral');
        $this->hasColumn('iddoclaboral', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('idpersona', 'integer', null, array(
             'type' => 'integer',
             'primary' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('idprofesion', 'integer', null, array(
             'type' => 'integer',
             'primary' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('iddedicacion', 'integer', null, array(
             'type' => 'integer',
             'primary' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('lugar', 'string', 150, array(
             'type' => 'string',
             'primary' => false,
             'notnull' => true,
             'default' => ' ',
             'autoincrement' => false,
             'length' => 150,
             ));
        $this->hasColumn('horas', 'string', 10, array(
             'type' => 'string',
             'primary' => false,
             'notnull' => true,
             'default' => ' ',
             'autoincrement' => false,
             'length' => 10,
             ));
        $this->hasColumn('idunidadtiempo', 'integer', null, array(
             'type' => 'integer',
             'primary' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('certificado', 'integer', null, array(
             'type' => 'integer',
             'primary' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('trabaja', 'integer', null, array(
             'type' => 'integer',
             'primary' => false,
             'autoincrement' => false,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Personas', array(
             'local' => 'idpersona',
             'foreign' => 'idpersona'));

        $this->hasOne('Profesiones', array(
             'local' => 'idprofesion',
             'foreign' => 'idprofesion'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $fzblameable0 = new Doctrine_Template_fzblameable();
        $this->actAs($timestampable0);
        $this->actAs($fzblameable0);
    }
}
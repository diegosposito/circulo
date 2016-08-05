<?php

/**
 * BaseCategoriasTitulos
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $idcategoriatitulo
 * @property string $descripcion
 * @property Doctrine_Collection $CategoriasTitulos
 * 
 * @method integer             getIdcategoriatitulo() Returns the current record's "idcategoriatitulo" value
 * @method string              getDescripcion()       Returns the current record's "descripcion" value
 * @method Doctrine_Collection getCategoriasTitulos() Returns the current record's "CategoriasTitulos" collection
 * @method CategoriasTitulos   setIdcategoriatitulo() Sets the current record's "idcategoriatitulo" value
 * @method CategoriasTitulos   setDescripcion()       Sets the current record's "descripcion" value
 * @method CategoriasTitulos   setCategoriasTitulos() Sets the current record's "CategoriasTitulos" collection
 * 
 * @package    sig
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseCategoriasTitulos extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('categorias_titulos');
        $this->hasColumn('idcategoriatitulo', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('descripcion', 'string', 50, array(
             'type' => 'string',
             'primary' => false,
             'notnull' => true,
             'default' => '',
             'length' => 50,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('Estudios as CategoriasTitulos', array(
             'local' => 'idcategoriatitulo',
             'foreign' => 'idcategoriatitulo'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $fzblameable0 = new Doctrine_Template_fzblameable();
        $this->actAs($timestampable0);
        $this->actAs($fzblameable0);
    }
}
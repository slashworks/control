<?php

namespace Slashworks\AppBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'country' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    propel.generator.src.Slashworks.AppBundle.Model.map
 */
class CountryTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.Slashworks.AppBundle.Model.map.CountryTableMap';

    /**
     * Initialize the table attributes, columns and validators
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('country');
        $this->setPhpName('Country');
        $this->setClassname('Slashworks\\AppBundle\\Model\\Country');
        $this->setPackage('src.Slashworks.AppBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, 10, null);
        $this->addColumn('code', 'Code', 'CHAR', true, 2, null);
        $this->addColumn('en', 'En', 'VARCHAR', true, 50, '');
        $this->addColumn('de', 'De', 'VARCHAR', true, 50, '');
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Customer', 'Slashworks\\AppBundle\\Model\\Customer', RelationMap::ONE_TO_MANY, array('id' => 'country_id', ), null, 'CASCADE', 'Customers');
    } // buildRelations()

} // CountryTableMap

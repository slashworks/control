<?php

namespace Slashworks\AppBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'license' table.
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
class LicenseTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.Slashworks.AppBundle.Model.map.LicenseTableMap';

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
        $this->setName('license');
        $this->setPhpName('License');
        $this->setClassname('Slashworks\\AppBundle\\Model\\License');
        $this->setPackage('src.Slashworks.AppBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, 10, null);
        $this->addColumn('max_clients', 'MaxClients', 'INTEGER', true, 3, null);
        $this->addColumn('domain', 'Domain', 'VARCHAR', true, 255, null);
        $this->addColumn('valid_until', 'ValidUntil', 'VARCHAR', true, 255, null);
        $this->addColumn('serial', 'Serial', 'LONGVARCHAR', true, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
    } // buildRelations()

} // LicenseTableMap

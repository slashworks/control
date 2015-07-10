<?php

namespace Slashworks\BackendBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'role' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    propel.generator.src.Slashworks.BackendBundle.Model.map
 */
class RoleTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.Slashworks.BackendBundle.Model.map.RoleTableMap';

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
        $this->setName('role');
        $this->setPhpName('Role');
        $this->setClassname('Slashworks\\BackendBundle\\Model\\Role');
        $this->setPackage('src.Slashworks.BackendBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('name', 'Name', 'VARCHAR', true, 30, null);
        $this->addColumn('role', 'Role', 'VARCHAR', true, 20, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('UserRole', 'Slashworks\\BackendBundle\\Model\\UserRole', RelationMap::ONE_TO_MANY, array('id' => 'role_id', ), 'CASCADE', null, 'UserRoles');
    } // buildRelations()

} // RoleTableMap

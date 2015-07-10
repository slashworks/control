<?php

namespace Slashworks\AppBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'user_customer_relation' table.
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
class UserCustomerRelationTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.Slashworks.AppBundle.Model.map.UserCustomerRelationTableMap';

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
        $this->setName('user_customer_relation');
        $this->setPhpName('UserCustomerRelation');
        $this->setClassname('Slashworks\\AppBundle\\Model\\UserCustomerRelation');
        $this->setPackage('src.Slashworks.AppBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, 10, null);
        $this->addForeignKey('user_id', 'UserId', 'INTEGER', 'user', 'id', true, null, null);
        $this->addForeignKey('customer_id', 'CustomerId', 'INTEGER', 'customer', 'id', true, 10, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('User', 'Slashworks\\BackendBundle\\Model\\User', RelationMap::MANY_TO_ONE, array('user_id' => 'id', ), 'CASCADE', 'CASCADE');
        $this->addRelation('Customer', 'Slashworks\\AppBundle\\Model\\Customer', RelationMap::MANY_TO_ONE, array('customer_id' => 'id', ), 'CASCADE', 'CASCADE');
    } // buildRelations()

} // UserCustomerRelationTableMap

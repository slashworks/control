<?php

namespace Slashworks\AppBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'customer' table.
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
class CustomerTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.Slashworks.AppBundle.Model.map.CustomerTableMap';

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
        $this->setName('customer');
        $this->setPhpName('Customer');
        $this->setClassname('Slashworks\\AppBundle\\Model\\Customer');
        $this->setPackage('src.Slashworks.AppBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, 10, null);
        $this->addColumn('name', 'Name', 'VARCHAR', true, 100, null);
        $this->addColumn('street', 'Street', 'VARCHAR', false, 50, null);
        $this->addColumn('zip', 'Zip', 'VARCHAR', false, 8, null);
        $this->addColumn('city', 'City', 'VARCHAR', false, 50, null);
        $this->addForeignKey('country_id', 'CountryId', 'INTEGER', 'country', 'id', true, 10, null);
        $this->addColumn('phone', 'Phone', 'VARCHAR', false, 20, null);
        $this->addColumn('fax', 'Fax', 'VARCHAR', false, 20, null);
        $this->addColumn('email', 'Email', 'VARCHAR', true, 50, null);
        $this->addColumn('legalform', 'Legalform', 'VARCHAR', false, 20, null);
        $this->addColumn('logo', 'Logo', 'VARCHAR', false, 255, null);
        $this->addColumn('created', 'Created', 'TIMESTAMP', true, null, null);
        $this->addColumn('notes', 'Notes', 'LONGVARCHAR', false, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Country', 'Slashworks\\AppBundle\\Model\\Country', RelationMap::MANY_TO_ONE, array('country_id' => 'id', ), null, 'CASCADE');
        $this->addRelation('RemoteApp', 'Slashworks\\AppBundle\\Model\\RemoteApp', RelationMap::ONE_TO_MANY, array('id' => 'customer_id', ), 'SET NULL', 'CASCADE', 'RemoteApps');
        $this->addRelation('UserCustomerRelation', 'Slashworks\\AppBundle\\Model\\UserCustomerRelation', RelationMap::ONE_TO_MANY, array('id' => 'customer_id', ), 'CASCADE', 'CASCADE', 'UserCustomerRelations');
    } // buildRelations()

} // CustomerTableMap

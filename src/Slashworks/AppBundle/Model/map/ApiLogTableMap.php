<?php

namespace Slashworks\AppBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'api_log' table.
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
class ApiLogTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.Slashworks.AppBundle.Model.map.ApiLogTableMap';

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
        $this->setName('api_log');
        $this->setPhpName('ApiLog');
        $this->setClassname('Slashworks\\AppBundle\\Model\\ApiLog');
        $this->setPackage('src.Slashworks.AppBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('dt_call', 'DtCall', 'TIMESTAMP', true, null, null);
        $this->addForeignKey('remote_app_id', 'RemoteAppId', 'INTEGER', 'remote_app', 'id', true, 10, null);
        $this->addColumn('statuscode', 'Statuscode', 'INTEGER', true, 3, null);
        $this->addColumn('last_response', 'LastResponse', 'BLOB', true, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('RemoteApp', 'Slashworks\\AppBundle\\Model\\RemoteApp', RelationMap::MANY_TO_ONE, array('remote_app_id' => 'id', ), 'CASCADE', 'CASCADE');
    } // buildRelations()

} // ApiLogTableMap

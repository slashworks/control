<?php

namespace Slashworks\AppBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'remote_history_contao' table.
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
class RemoteHistoryContaoTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.Slashworks.AppBundle.Model.map.RemoteHistoryContaoTableMap';

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
        $this->setName('remote_history_contao');
        $this->setPhpName('RemoteHistoryContao');
        $this->setClassname('Slashworks\\AppBundle\\Model\\RemoteHistoryContao');
        $this->setPackage('src.Slashworks.AppBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, 10, null);
        $this->addForeignKey('remote_app_id', 'RemoteAppId', 'INTEGER', 'remote_app', 'id', true, 10, null);
        $this->addColumn('apiVersion', 'Apiversion', 'VARCHAR', true, 10, null);
        $this->addColumn('name', 'Name', 'VARCHAR', true, 255, null);
        $this->addColumn('version', 'Version', 'VARCHAR', true, 10, null);
        $this->addColumn('config_displayErrors', 'ConfigDisplayerrors', 'VARCHAR', true, 3, 'Off');
        $this->addColumn('config_bypassCache', 'ConfigBypasscache', 'VARCHAR', true, 3, 'Off');
        $this->addColumn('config_minifyMarkup', 'ConfigMinifymarkup', 'VARCHAR', true, 3, 'Off');
        $this->addColumn('config_debugMode', 'ConfigDebugmode', 'VARCHAR', true, 3, 'Off');
        $this->addColumn('config_maintenanceMode', 'ConfigMaintenancemode', 'VARCHAR', true, 3, 'Off');
        $this->addColumn('config_gzipScripts', 'ConfigGzipscripts', 'VARCHAR', true, 3, 'Off');
        $this->addColumn('config_rewriteURL', 'ConfigRewriteurl', 'VARCHAR', true, 3, 'Off');
        $this->addColumn('config_adminEmail', 'ConfigAdminemail', 'VARCHAR', true, 255, null);
        $this->addColumn('config_cacheMode', 'ConfigCachemode', 'VARCHAR', true, 10, null);
        $this->addColumn('statuscode', 'Statuscode', 'INTEGER', true, 3, null);
        $this->addColumn('extensions', 'Extensions', 'OBJECT', true, null, null);
        $this->addColumn('log', 'Log', 'OBJECT', false, null, null);
        $this->addColumn('php', 'PHP', 'OBJECT', false, null, null);
        $this->addColumn('mysql', 'MySQL', 'OBJECT', false, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('RemoteApp', 'Slashworks\\AppBundle\\Model\\RemoteApp', RelationMap::MANY_TO_ONE, array('remote_app_id' => 'id', ), 'CASCADE', 'CASCADE');
    } // buildRelations()

} // RemoteHistoryContaoTableMap

<?php

namespace Slashworks\AppBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'remote_app' table.
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
class RemoteAppTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.Slashworks.AppBundle.Model.map.RemoteAppTableMap';

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
        $this->setName('remote_app');
        $this->setPhpName('RemoteApp');
        $this->setClassname('Slashworks\\AppBundle\\Model\\RemoteApp');
        $this->setPackage('src.Slashworks.AppBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, 10, null);
        $this->addColumn('type', 'Type', 'CHAR', true, null, 'contao');
        $this->getColumn('type', false)->setValueSet(array (
  0 => 'contao',
));
        $this->addColumn('name', 'Name', 'VARCHAR', true, 255, null);
        $this->addColumn('domain', 'Domain', 'VARCHAR', true, 255, null);
        $this->addColumn('api_url', 'ApiUrl', 'VARCHAR', true, 255, null);
        $this->addColumn('api_auth_http_user', 'ApiAuthHttpUser', 'VARCHAR', false, 50, null);
        $this->addColumn('api_auth_http_password', 'ApiAuthHttpPassword', 'VARCHAR', false, 255, null);
        $this->addColumn('api_auth_type', 'ApiAuthType', 'CHAR', true, null, 'none');
        $this->getColumn('api_auth_type', false)->setValueSet(array (
  0 => 'none',
  1 => 'http-basic',
  2 => 'url-user-password',
  3 => 'url-token',
));
        $this->addColumn('api_auth_user', 'ApiAuthUser', 'VARCHAR', false, 255, null);
        $this->addColumn('api_auth_password', 'ApiAuthPassword', 'VARCHAR', false, 255, null);
        $this->addColumn('api_auth_token', 'ApiAuthToken', 'VARCHAR', false, 255, null);
        $this->addColumn('api_auth_url_user_key', 'ApiAuthUrlUserKey', 'VARCHAR', false, 50, null);
        $this->addColumn('api_auth_url_pw_key', 'ApiAuthUrlPwKey', 'VARCHAR', false, 50, null);
        $this->addColumn('cron', 'Cron', 'VARCHAR', false, 20, null);
        $this->addForeignKey('customer_id', 'CustomerId', 'INTEGER', 'customer', 'id', false, 10, null);
        $this->addColumn('activated', 'Activated', 'BOOLEAN', true, 1, false);
        $this->addColumn('notes', 'Notes', 'LONGVARCHAR', false, null, null);
        $this->addColumn('last_run', 'LastRun', 'TIMESTAMP', false, null, null);
        $this->addColumn('includeLog', 'Includelog', 'BOOLEAN', true, 1, false);
        $this->addColumn('public_key', 'PublicKey', 'VARCHAR', false, 512, null);
        $this->addColumn('website_hash', 'WebsiteHash', 'VARCHAR', false, 255, '');
        $this->addColumn('notification_recipient', 'NotificationRecipient', 'VARCHAR', true, 255, '');
        $this->addColumn('notification_sender', 'NotificationSender', 'VARCHAR', true, 255, '');
        $this->addColumn('notification_change', 'NotificationChange', 'BOOLEAN', true, 1, true);
        $this->addColumn('notification_error', 'NotificationError', 'BOOLEAN', true, 1, true);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Customer', 'Slashworks\\AppBundle\\Model\\Customer', RelationMap::MANY_TO_ONE, array('customer_id' => 'id', ), 'SET NULL', 'CASCADE');
        $this->addRelation('ApiLog', 'Slashworks\\AppBundle\\Model\\ApiLog', RelationMap::ONE_TO_MANY, array('id' => 'remote_app_id', ), 'CASCADE', 'CASCADE', 'ApiLogs');
        $this->addRelation('RemoteHistoryContao', 'Slashworks\\AppBundle\\Model\\RemoteHistoryContao', RelationMap::ONE_TO_MANY, array('id' => 'remote_app_id', ), 'CASCADE', 'CASCADE', 'RemoteHistoryContaos');
    } // buildRelations()

} // RemoteAppTableMap

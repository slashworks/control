<?php

namespace Slashworks\AppBundle\Model\om;

use \BasePeer;
use \Criteria;
use \PDO;
use \PDOStatement;
use \Propel;
use \PropelException;
use \PropelPDO;
use Slashworks\AppBundle\Model\ApiLogPeer;
use Slashworks\AppBundle\Model\CustomerPeer;
use Slashworks\AppBundle\Model\RemoteApp;
use Slashworks\AppBundle\Model\RemoteAppPeer;
use Slashworks\AppBundle\Model\RemoteHistoryContaoPeer;
use Slashworks\AppBundle\Model\map\RemoteAppTableMap;

abstract class BaseRemoteAppPeer
{

    /** the default database name for this class */
    const DATABASE_NAME = 'default';

    /** the table name for this class */
    const TABLE_NAME = 'remote_app';

    /** the related Propel class for this table */
    const OM_CLASS = 'Slashworks\\AppBundle\\Model\\RemoteApp';

    /** the related TableMap class for this table */
    const TM_CLASS = 'Slashworks\\AppBundle\\Model\\map\\RemoteAppTableMap';

    /** The total number of columns. */
    const NUM_COLUMNS = 25;

    /** The number of lazy-loaded columns. */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /** The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS) */
    const NUM_HYDRATE_COLUMNS = 25;

    /** the column name for the id field */
    const ID = 'remote_app.id';

    /** the column name for the type field */
    const TYPE = 'remote_app.type';

    /** the column name for the name field */
    const NAME = 'remote_app.name';

    /** the column name for the domain field */
    const DOMAIN = 'remote_app.domain';

    /** the column name for the api_url field */
    const API_URL = 'remote_app.api_url';

    /** the column name for the api_auth_http_user field */
    const API_AUTH_HTTP_USER = 'remote_app.api_auth_http_user';

    /** the column name for the api_auth_http_password field */
    const API_AUTH_HTTP_PASSWORD = 'remote_app.api_auth_http_password';

    /** the column name for the api_auth_type field */
    const API_AUTH_TYPE = 'remote_app.api_auth_type';

    /** the column name for the api_auth_user field */
    const API_AUTH_USER = 'remote_app.api_auth_user';

    /** the column name for the api_auth_password field */
    const API_AUTH_PASSWORD = 'remote_app.api_auth_password';

    /** the column name for the api_auth_token field */
    const API_AUTH_TOKEN = 'remote_app.api_auth_token';

    /** the column name for the api_auth_url_user_key field */
    const API_AUTH_URL_USER_KEY = 'remote_app.api_auth_url_user_key';

    /** the column name for the api_auth_url_pw_key field */
    const API_AUTH_URL_PW_KEY = 'remote_app.api_auth_url_pw_key';

    /** the column name for the cron field */
    const CRON = 'remote_app.cron';

    /** the column name for the customer_id field */
    const CUSTOMER_ID = 'remote_app.customer_id';

    /** the column name for the activated field */
    const ACTIVATED = 'remote_app.activated';

    /** the column name for the notes field */
    const NOTES = 'remote_app.notes';

    /** the column name for the last_run field */
    const LAST_RUN = 'remote_app.last_run';

    /** the column name for the includeLog field */
    const INCLUDELOG = 'remote_app.includeLog';

    /** the column name for the public_key field */
    const PUBLIC_KEY = 'remote_app.public_key';

    /** the column name for the website_hash field */
    const WEBSITE_HASH = 'remote_app.website_hash';

    /** the column name for the notification_recipient field */
    const NOTIFICATION_RECIPIENT = 'remote_app.notification_recipient';

    /** the column name for the notification_sender field */
    const NOTIFICATION_SENDER = 'remote_app.notification_sender';

    /** the column name for the notification_change field */
    const NOTIFICATION_CHANGE = 'remote_app.notification_change';

    /** the column name for the notification_error field */
    const NOTIFICATION_ERROR = 'remote_app.notification_error';

    /** The enumerated values for the type field */
    const TYPE_CONTAO = 'contao';

    /** The enumerated values for the api_auth_type field */
    const API_AUTH_TYPE_NONE = 'none';
    const API_AUTH_TYPE_HTTP_BASIC = 'http-basic';
    const API_AUTH_TYPE_URL_USER_PASSWORD = 'url-user-password';
    const API_AUTH_TYPE_URL_TOKEN = 'url-token';

    /** The default string format for model objects of the related table **/
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * An identity map to hold any loaded instances of RemoteApp objects.
     * This must be public so that other peer classes can access this when hydrating from JOIN
     * queries.
     * @var        array RemoteApp[]
     */
    public static $instances = array();


    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. RemoteAppPeer::$fieldNames[RemoteAppPeer::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        BasePeer::TYPE_PHPNAME => array ('Id', 'Type', 'Name', 'Domain', 'ApiUrl', 'ApiAuthHttpUser', 'ApiAuthHttpPassword', 'ApiAuthType', 'ApiAuthUser', 'ApiAuthPassword', 'ApiAuthToken', 'ApiAuthUrlUserKey', 'ApiAuthUrlPwKey', 'Cron', 'CustomerId', 'Activated', 'Notes', 'LastRun', 'Includelog', 'PublicKey', 'WebsiteHash', 'NotificationRecipient', 'NotificationSender', 'NotificationChange', 'NotificationError', ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('id', 'type', 'name', 'domain', 'apiUrl', 'apiAuthHttpUser', 'apiAuthHttpPassword', 'apiAuthType', 'apiAuthUser', 'apiAuthPassword', 'apiAuthToken', 'apiAuthUrlUserKey', 'apiAuthUrlPwKey', 'cron', 'customerId', 'activated', 'notes', 'lastRun', 'includelog', 'publicKey', 'websiteHash', 'notificationRecipient', 'notificationSender', 'notificationChange', 'notificationError', ),
        BasePeer::TYPE_COLNAME => array (RemoteAppPeer::ID, RemoteAppPeer::TYPE, RemoteAppPeer::NAME, RemoteAppPeer::DOMAIN, RemoteAppPeer::API_URL, RemoteAppPeer::API_AUTH_HTTP_USER, RemoteAppPeer::API_AUTH_HTTP_PASSWORD, RemoteAppPeer::API_AUTH_TYPE, RemoteAppPeer::API_AUTH_USER, RemoteAppPeer::API_AUTH_PASSWORD, RemoteAppPeer::API_AUTH_TOKEN, RemoteAppPeer::API_AUTH_URL_USER_KEY, RemoteAppPeer::API_AUTH_URL_PW_KEY, RemoteAppPeer::CRON, RemoteAppPeer::CUSTOMER_ID, RemoteAppPeer::ACTIVATED, RemoteAppPeer::NOTES, RemoteAppPeer::LAST_RUN, RemoteAppPeer::INCLUDELOG, RemoteAppPeer::PUBLIC_KEY, RemoteAppPeer::WEBSITE_HASH, RemoteAppPeer::NOTIFICATION_RECIPIENT, RemoteAppPeer::NOTIFICATION_SENDER, RemoteAppPeer::NOTIFICATION_CHANGE, RemoteAppPeer::NOTIFICATION_ERROR, ),
        BasePeer::TYPE_RAW_COLNAME => array ('ID', 'TYPE', 'NAME', 'DOMAIN', 'API_URL', 'API_AUTH_HTTP_USER', 'API_AUTH_HTTP_PASSWORD', 'API_AUTH_TYPE', 'API_AUTH_USER', 'API_AUTH_PASSWORD', 'API_AUTH_TOKEN', 'API_AUTH_URL_USER_KEY', 'API_AUTH_URL_PW_KEY', 'CRON', 'CUSTOMER_ID', 'ACTIVATED', 'NOTES', 'LAST_RUN', 'INCLUDELOG', 'PUBLIC_KEY', 'WEBSITE_HASH', 'NOTIFICATION_RECIPIENT', 'NOTIFICATION_SENDER', 'NOTIFICATION_CHANGE', 'NOTIFICATION_ERROR', ),
        BasePeer::TYPE_FIELDNAME => array ('id', 'type', 'name', 'domain', 'api_url', 'api_auth_http_user', 'api_auth_http_password', 'api_auth_type', 'api_auth_user', 'api_auth_password', 'api_auth_token', 'api_auth_url_user_key', 'api_auth_url_pw_key', 'cron', 'customer_id', 'activated', 'notes', 'last_run', 'includeLog', 'public_key', 'website_hash', 'notification_recipient', 'notification_sender', 'notification_change', 'notification_error', ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. RemoteAppPeer::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'Type' => 1, 'Name' => 2, 'Domain' => 3, 'ApiUrl' => 4, 'ApiAuthHttpUser' => 5, 'ApiAuthHttpPassword' => 6, 'ApiAuthType' => 7, 'ApiAuthUser' => 8, 'ApiAuthPassword' => 9, 'ApiAuthToken' => 10, 'ApiAuthUrlUserKey' => 11, 'ApiAuthUrlPwKey' => 12, 'Cron' => 13, 'CustomerId' => 14, 'Activated' => 15, 'Notes' => 16, 'LastRun' => 17, 'Includelog' => 18, 'PublicKey' => 19, 'WebsiteHash' => 20, 'NotificationRecipient' => 21, 'NotificationSender' => 22, 'NotificationChange' => 23, 'NotificationError' => 24, ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('id' => 0, 'type' => 1, 'name' => 2, 'domain' => 3, 'apiUrl' => 4, 'apiAuthHttpUser' => 5, 'apiAuthHttpPassword' => 6, 'apiAuthType' => 7, 'apiAuthUser' => 8, 'apiAuthPassword' => 9, 'apiAuthToken' => 10, 'apiAuthUrlUserKey' => 11, 'apiAuthUrlPwKey' => 12, 'cron' => 13, 'customerId' => 14, 'activated' => 15, 'notes' => 16, 'lastRun' => 17, 'includelog' => 18, 'publicKey' => 19, 'websiteHash' => 20, 'notificationRecipient' => 21, 'notificationSender' => 22, 'notificationChange' => 23, 'notificationError' => 24, ),
        BasePeer::TYPE_COLNAME => array (RemoteAppPeer::ID => 0, RemoteAppPeer::TYPE => 1, RemoteAppPeer::NAME => 2, RemoteAppPeer::DOMAIN => 3, RemoteAppPeer::API_URL => 4, RemoteAppPeer::API_AUTH_HTTP_USER => 5, RemoteAppPeer::API_AUTH_HTTP_PASSWORD => 6, RemoteAppPeer::API_AUTH_TYPE => 7, RemoteAppPeer::API_AUTH_USER => 8, RemoteAppPeer::API_AUTH_PASSWORD => 9, RemoteAppPeer::API_AUTH_TOKEN => 10, RemoteAppPeer::API_AUTH_URL_USER_KEY => 11, RemoteAppPeer::API_AUTH_URL_PW_KEY => 12, RemoteAppPeer::CRON => 13, RemoteAppPeer::CUSTOMER_ID => 14, RemoteAppPeer::ACTIVATED => 15, RemoteAppPeer::NOTES => 16, RemoteAppPeer::LAST_RUN => 17, RemoteAppPeer::INCLUDELOG => 18, RemoteAppPeer::PUBLIC_KEY => 19, RemoteAppPeer::WEBSITE_HASH => 20, RemoteAppPeer::NOTIFICATION_RECIPIENT => 21, RemoteAppPeer::NOTIFICATION_SENDER => 22, RemoteAppPeer::NOTIFICATION_CHANGE => 23, RemoteAppPeer::NOTIFICATION_ERROR => 24, ),
        BasePeer::TYPE_RAW_COLNAME => array ('ID' => 0, 'TYPE' => 1, 'NAME' => 2, 'DOMAIN' => 3, 'API_URL' => 4, 'API_AUTH_HTTP_USER' => 5, 'API_AUTH_HTTP_PASSWORD' => 6, 'API_AUTH_TYPE' => 7, 'API_AUTH_USER' => 8, 'API_AUTH_PASSWORD' => 9, 'API_AUTH_TOKEN' => 10, 'API_AUTH_URL_USER_KEY' => 11, 'API_AUTH_URL_PW_KEY' => 12, 'CRON' => 13, 'CUSTOMER_ID' => 14, 'ACTIVATED' => 15, 'NOTES' => 16, 'LAST_RUN' => 17, 'INCLUDELOG' => 18, 'PUBLIC_KEY' => 19, 'WEBSITE_HASH' => 20, 'NOTIFICATION_RECIPIENT' => 21, 'NOTIFICATION_SENDER' => 22, 'NOTIFICATION_CHANGE' => 23, 'NOTIFICATION_ERROR' => 24, ),
        BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'type' => 1, 'name' => 2, 'domain' => 3, 'api_url' => 4, 'api_auth_http_user' => 5, 'api_auth_http_password' => 6, 'api_auth_type' => 7, 'api_auth_user' => 8, 'api_auth_password' => 9, 'api_auth_token' => 10, 'api_auth_url_user_key' => 11, 'api_auth_url_pw_key' => 12, 'cron' => 13, 'customer_id' => 14, 'activated' => 15, 'notes' => 16, 'last_run' => 17, 'includeLog' => 18, 'public_key' => 19, 'website_hash' => 20, 'notification_recipient' => 21, 'notification_sender' => 22, 'notification_change' => 23, 'notification_error' => 24, ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, )
    );

    /** The enumerated values for this table */
    protected static $enumValueSets = array(
        RemoteAppPeer::TYPE => array(
            RemoteAppPeer::TYPE_CONTAO,
        ),
        RemoteAppPeer::API_AUTH_TYPE => array(
            RemoteAppPeer::API_AUTH_TYPE_NONE,
            RemoteAppPeer::API_AUTH_TYPE_HTTP_BASIC,
            RemoteAppPeer::API_AUTH_TYPE_URL_USER_PASSWORD,
            RemoteAppPeer::API_AUTH_TYPE_URL_TOKEN,
        ),
    );

    /**
     * Translates a fieldname to another type
     *
     * @param      string $name field name
     * @param      string $fromType One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *                         BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
     * @param      string $toType   One of the class type constants
     * @return string          translated name of the field.
     * @throws PropelException - if the specified name could not be found in the fieldname mappings.
     */
    public static function translateFieldName($name, $fromType, $toType)
    {
        $toNames = RemoteAppPeer::getFieldNames($toType);
        $key = isset(RemoteAppPeer::$fieldKeys[$fromType][$name]) ? RemoteAppPeer::$fieldKeys[$fromType][$name] : null;
        if ($key === null) {
            throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(RemoteAppPeer::$fieldKeys[$fromType], true));
        }

        return $toNames[$key];
    }

    /**
     * Returns an array of field names.
     *
     * @param      string $type The type of fieldnames to return:
     *                      One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *                      BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
     * @return array           A list of field names
     * @throws PropelException - if the type is not valid.
     */
    public static function getFieldNames($type = BasePeer::TYPE_PHPNAME)
    {
        if (!array_key_exists($type, RemoteAppPeer::$fieldNames)) {
            throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME, BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. ' . $type . ' was given.');
        }

        return RemoteAppPeer::$fieldNames[$type];
    }

    /**
     * Gets the list of values for all ENUM columns
     * @return array
     */
    public static function getValueSets()
    {
      return RemoteAppPeer::$enumValueSets;
    }

    /**
     * Gets the list of values for an ENUM column
     *
     * @param string $colname The ENUM column name.
     *
     * @return array list of possible values for the column
     */
    public static function getValueSet($colname)
    {
        $valueSets = RemoteAppPeer::getValueSets();

        if (!isset($valueSets[$colname])) {
            throw new PropelException(sprintf('Column "%s" has no ValueSet.', $colname));
        }

        return $valueSets[$colname];
    }

    /**
     * Gets the SQL value for the ENUM column value
     *
     * @param string $colname ENUM column name.
     * @param string $enumVal ENUM value.
     *
     * @return int SQL value
     */
    public static function getSqlValueForEnum($colname, $enumVal)
    {
        $values = RemoteAppPeer::getValueSet($colname);
        if (!in_array($enumVal, $values)) {
            throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $colname));
        }

        return array_search($enumVal, $values);
    }

    /**
     * Convenience method which changes table.column to alias.column.
     *
     * Using this method you can maintain SQL abstraction while using column aliases.
     * <code>
     *		$c->addAlias("alias1", TablePeer::TABLE_NAME);
     *		$c->addJoin(TablePeer::alias("alias1", TablePeer::PRIMARY_KEY_COLUMN), TablePeer::PRIMARY_KEY_COLUMN);
     * </code>
     * @param      string $alias The alias for the current table.
     * @param      string $column The column name for current table. (i.e. RemoteAppPeer::COLUMN_NAME).
     * @return string
     */
    public static function alias($alias, $column)
    {
        return str_replace(RemoteAppPeer::TABLE_NAME.'.', $alias.'.', $column);
    }

    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param      Criteria $criteria object containing the columns to add.
     * @param      string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(RemoteAppPeer::ID);
            $criteria->addSelectColumn(RemoteAppPeer::TYPE);
            $criteria->addSelectColumn(RemoteAppPeer::NAME);
            $criteria->addSelectColumn(RemoteAppPeer::DOMAIN);
            $criteria->addSelectColumn(RemoteAppPeer::API_URL);
            $criteria->addSelectColumn(RemoteAppPeer::API_AUTH_HTTP_USER);
            $criteria->addSelectColumn(RemoteAppPeer::API_AUTH_HTTP_PASSWORD);
            $criteria->addSelectColumn(RemoteAppPeer::API_AUTH_TYPE);
            $criteria->addSelectColumn(RemoteAppPeer::API_AUTH_USER);
            $criteria->addSelectColumn(RemoteAppPeer::API_AUTH_PASSWORD);
            $criteria->addSelectColumn(RemoteAppPeer::API_AUTH_TOKEN);
            $criteria->addSelectColumn(RemoteAppPeer::API_AUTH_URL_USER_KEY);
            $criteria->addSelectColumn(RemoteAppPeer::API_AUTH_URL_PW_KEY);
            $criteria->addSelectColumn(RemoteAppPeer::CRON);
            $criteria->addSelectColumn(RemoteAppPeer::CUSTOMER_ID);
            $criteria->addSelectColumn(RemoteAppPeer::ACTIVATED);
            $criteria->addSelectColumn(RemoteAppPeer::NOTES);
            $criteria->addSelectColumn(RemoteAppPeer::LAST_RUN);
            $criteria->addSelectColumn(RemoteAppPeer::INCLUDELOG);
            $criteria->addSelectColumn(RemoteAppPeer::PUBLIC_KEY);
            $criteria->addSelectColumn(RemoteAppPeer::WEBSITE_HASH);
            $criteria->addSelectColumn(RemoteAppPeer::NOTIFICATION_RECIPIENT);
            $criteria->addSelectColumn(RemoteAppPeer::NOTIFICATION_SENDER);
            $criteria->addSelectColumn(RemoteAppPeer::NOTIFICATION_CHANGE);
            $criteria->addSelectColumn(RemoteAppPeer::NOTIFICATION_ERROR);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.type');
            $criteria->addSelectColumn($alias . '.name');
            $criteria->addSelectColumn($alias . '.domain');
            $criteria->addSelectColumn($alias . '.api_url');
            $criteria->addSelectColumn($alias . '.api_auth_http_user');
            $criteria->addSelectColumn($alias . '.api_auth_http_password');
            $criteria->addSelectColumn($alias . '.api_auth_type');
            $criteria->addSelectColumn($alias . '.api_auth_user');
            $criteria->addSelectColumn($alias . '.api_auth_password');
            $criteria->addSelectColumn($alias . '.api_auth_token');
            $criteria->addSelectColumn($alias . '.api_auth_url_user_key');
            $criteria->addSelectColumn($alias . '.api_auth_url_pw_key');
            $criteria->addSelectColumn($alias . '.cron');
            $criteria->addSelectColumn($alias . '.customer_id');
            $criteria->addSelectColumn($alias . '.activated');
            $criteria->addSelectColumn($alias . '.notes');
            $criteria->addSelectColumn($alias . '.last_run');
            $criteria->addSelectColumn($alias . '.includeLog');
            $criteria->addSelectColumn($alias . '.public_key');
            $criteria->addSelectColumn($alias . '.website_hash');
            $criteria->addSelectColumn($alias . '.notification_recipient');
            $criteria->addSelectColumn($alias . '.notification_sender');
            $criteria->addSelectColumn($alias . '.notification_change');
            $criteria->addSelectColumn($alias . '.notification_error');
        }
    }

    /**
     * Returns the number of rows matching criteria.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @return int Number of matching rows.
     */
    public static function doCount(Criteria $criteria, $distinct = false, PropelPDO $con = null)
    {
        // we may modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(RemoteAppPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            RemoteAppPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count
        $criteria->setDbName(RemoteAppPeer::DATABASE_NAME); // Set the correct dbName

        if ($con === null) {
            $con = Propel::getConnection(RemoteAppPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }
        // BasePeer returns a PDOStatement
        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }
    /**
     * Selects one object from the DB.
     *
     * @param      Criteria $criteria object used to create the SELECT statement.
     * @param      PropelPDO $con
     * @return RemoteApp
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectOne(Criteria $criteria, PropelPDO $con = null)
    {
        $critcopy = clone $criteria;
        $critcopy->setLimit(1);
        $objects = RemoteAppPeer::doSelect($critcopy, $con);
        if ($objects) {
            return $objects[0];
        }

        return null;
    }
    /**
     * Selects several row from the DB.
     *
     * @param      Criteria $criteria The Criteria object used to build the SELECT statement.
     * @param      PropelPDO $con
     * @return array           Array of selected Objects
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelect(Criteria $criteria, PropelPDO $con = null)
    {
        return RemoteAppPeer::populateObjects(RemoteAppPeer::doSelectStmt($criteria, $con));
    }
    /**
     * Prepares the Criteria object and uses the parent doSelect() method to execute a PDOStatement.
     *
     * Use this method directly if you want to work with an executed statement directly (for example
     * to perform your own object hydration).
     *
     * @param      Criteria $criteria The Criteria object used to build the SELECT statement.
     * @param      PropelPDO $con The connection to use
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     * @return PDOStatement The executed PDOStatement object.
     * @see        BasePeer::doSelect()
     */
    public static function doSelectStmt(Criteria $criteria, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(RemoteAppPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        if (!$criteria->hasSelectClause()) {
            $criteria = clone $criteria;
            RemoteAppPeer::addSelectColumns($criteria);
        }

        // Set the correct dbName
        $criteria->setDbName(RemoteAppPeer::DATABASE_NAME);

        // BasePeer returns a PDOStatement
        return BasePeer::doSelect($criteria, $con);
    }
    /**
     * Adds an object to the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database.  In some cases -- especially when you override doSelect*()
     * methods in your stub classes -- you may need to explicitly add objects
     * to the cache in order to ensure that the same objects are always returned by doSelect*()
     * and retrieveByPK*() calls.
     *
     * @param RemoteApp $obj A RemoteApp object.
     * @param      string $key (optional) key to use for instance map (for performance boost if key was already calculated externally).
     */
    public static function addInstanceToPool($obj, $key = null)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if ($key === null) {
                $key = (string) $obj->getId();
            } // if key === null
            RemoteAppPeer::$instances[$key] = $obj;
        }
    }

    /**
     * Removes an object from the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database.  In some cases -- especially when you override doDelete
     * methods in your stub classes -- you may need to explicitly remove objects
     * from the cache in order to prevent returning objects that no longer exist.
     *
     * @param      mixed $value A RemoteApp object or a primary key value.
     *
     * @return void
     * @throws PropelException - if the value is invalid.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && $value !== null) {
            if (is_object($value) && $value instanceof RemoteApp) {
                $key = (string) $value->getId();
            } elseif (is_scalar($value)) {
                // assume we've been passed a primary key
                $key = (string) $value;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or RemoteApp object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value,true)));
                throw $e;
            }

            unset(RemoteAppPeer::$instances[$key]);
        }
    } // removeInstanceFromPool()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param      string $key The key (@see getPrimaryKeyHash()) for this instance.
     * @return RemoteApp Found object or null if 1) no instance exists for specified key or 2) instance pooling has been disabled.
     * @see        getPrimaryKeyHash()
     */
    public static function getInstanceFromPool($key)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (isset(RemoteAppPeer::$instances[$key])) {
                return RemoteAppPeer::$instances[$key];
            }
        }

        return null; // just to be explicit
    }

    /**
     * Clear the instance pool.
     *
     * @return void
     */
    public static function clearInstancePool($and_clear_all_references = false)
    {
      if ($and_clear_all_references) {
        foreach (RemoteAppPeer::$instances as $instance) {
          $instance->clearAllReferences(true);
        }
      }
        RemoteAppPeer::$instances = array();
    }

    /**
     * Method to invalidate the instance pool of all tables related to remote_app
     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in ApiLogPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        ApiLogPeer::clearInstancePool();
        // Invalidate objects in RemoteHistoryContaoPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        RemoteHistoryContaoPeer::clearInstancePool();
    }

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param      array $row PropelPDO resultset row.
     * @param      int $startcol The 0-based offset for reading from the resultset row.
     * @return string A string version of PK or null if the components of primary key in result array are all null.
     */
    public static function getPrimaryKeyHashFromRow($row, $startcol = 0)
    {
        // If the PK cannot be derived from the row, return null.
        if ($row[$startcol] === null) {
            return null;
        }

        return (string) $row[$startcol];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param      array $row PropelPDO resultset row.
     * @param      int $startcol The 0-based offset for reading from the resultset row.
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $startcol = 0)
    {

        return (int) $row[$startcol];
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function populateObjects(PDOStatement $stmt)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = RemoteAppPeer::getOMClass();
        // populate the object(s)
        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key = RemoteAppPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj = RemoteAppPeer::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                RemoteAppPeer::addInstanceToPool($obj, $key);
            } // if key exists
        }
        $stmt->closeCursor();

        return $results;
    }
    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param      array $row PropelPDO resultset row.
     * @param      int $startcol The 0-based offset for reading from the resultset row.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     * @return array (RemoteApp object, last column rank)
     */
    public static function populateObject($row, $startcol = 0)
    {
        $key = RemoteAppPeer::getPrimaryKeyHashFromRow($row, $startcol);
        if (null !== ($obj = RemoteAppPeer::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $startcol, true); // rehydrate
            $col = $startcol + RemoteAppPeer::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = RemoteAppPeer::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $startcol);
            RemoteAppPeer::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }


    /**
     * Returns the number of rows matching criteria, joining the related Customer table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinCustomer(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(RemoteAppPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            RemoteAppPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(RemoteAppPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(RemoteAppPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(RemoteAppPeer::CUSTOMER_ID, CustomerPeer::ID, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }


    /**
     * Selects a collection of RemoteApp objects pre-filled with their Customer objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of RemoteApp objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinCustomer(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(RemoteAppPeer::DATABASE_NAME);
        }

        RemoteAppPeer::addSelectColumns($criteria);
        $startcol = RemoteAppPeer::NUM_HYDRATE_COLUMNS;
        CustomerPeer::addSelectColumns($criteria);

        $criteria->addJoin(RemoteAppPeer::CUSTOMER_ID, CustomerPeer::ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = RemoteAppPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = RemoteAppPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = RemoteAppPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                RemoteAppPeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = CustomerPeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = CustomerPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = CustomerPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    CustomerPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (RemoteApp) to $obj2 (Customer)
                $obj2->addRemoteApp($obj1);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Returns the number of rows matching criteria, joining all related tables
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAll(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(RemoteAppPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            RemoteAppPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(RemoteAppPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(RemoteAppPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(RemoteAppPeer::CUSTOMER_ID, CustomerPeer::ID, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }

    /**
     * Selects a collection of RemoteApp objects pre-filled with all related objects.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of RemoteApp objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAll(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(RemoteAppPeer::DATABASE_NAME);
        }

        RemoteAppPeer::addSelectColumns($criteria);
        $startcol2 = RemoteAppPeer::NUM_HYDRATE_COLUMNS;

        CustomerPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + CustomerPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(RemoteAppPeer::CUSTOMER_ID, CustomerPeer::ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = RemoteAppPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = RemoteAppPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = RemoteAppPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                RemoteAppPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

            // Add objects for joined Customer rows

            $key2 = CustomerPeer::getPrimaryKeyHashFromRow($row, $startcol2);
            if ($key2 !== null) {
                $obj2 = CustomerPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = CustomerPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    CustomerPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 loaded

                // Add the $obj1 (RemoteApp) to the collection in $obj2 (Customer)
                $obj2->addRemoteApp($obj1);
            } // if joined row not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }

    /**
     * Returns the TableMap related to this peer.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getDatabaseMap(RemoteAppPeer::DATABASE_NAME)->getTable(RemoteAppPeer::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this peer class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getDatabaseMap(BaseRemoteAppPeer::DATABASE_NAME);
      if (!$dbMap->hasTable(BaseRemoteAppPeer::TABLE_NAME)) {
        $dbMap->addTableObject(new \Slashworks\AppBundle\Model\map\RemoteAppTableMap());
      }
    }

    /**
     * The class that the Peer will make instances of.
     *
     *
     * @return string ClassName
     */
    public static function getOMClass($row = 0, $colnum = 0)
    {
        return RemoteAppPeer::OM_CLASS;
    }

    /**
     * Performs an INSERT on the database, given a RemoteApp or Criteria object.
     *
     * @param      mixed $values Criteria or RemoteApp object containing data that is used to create the INSERT statement.
     * @param      PropelPDO $con the PropelPDO connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doInsert($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(RemoteAppPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity
        } else {
            $criteria = $values->buildCriteria(); // build Criteria from RemoteApp object
        }

        if ($criteria->containsKey(RemoteAppPeer::ID) && $criteria->keyContainsValue(RemoteAppPeer::ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.RemoteAppPeer::ID.')');
        }


        // Set the correct dbName
        $criteria->setDbName(RemoteAppPeer::DATABASE_NAME);

        try {
            // use transaction because $criteria could contain info
            // for more than one table (I guess, conceivably)
            $con->beginTransaction();
            $pk = BasePeer::doInsert($criteria, $con);
            $con->commit();
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }

        return $pk;
    }

    /**
     * Performs an UPDATE on the database, given a RemoteApp or Criteria object.
     *
     * @param      mixed $values Criteria or RemoteApp object containing data that is used to create the UPDATE statement.
     * @param      PropelPDO $con The connection to use (specify PropelPDO connection object to exert more control over transactions).
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doUpdate($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(RemoteAppPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $selectCriteria = new Criteria(RemoteAppPeer::DATABASE_NAME);

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity

            $comparison = $criteria->getComparison(RemoteAppPeer::ID);
            $value = $criteria->remove(RemoteAppPeer::ID);
            if ($value) {
                $selectCriteria->add(RemoteAppPeer::ID, $value, $comparison);
            } else {
                $selectCriteria->setPrimaryTableName(RemoteAppPeer::TABLE_NAME);
            }

        } else { // $values is RemoteApp object
            $criteria = $values->buildCriteria(); // gets full criteria
            $selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
        }

        // set the correct dbName
        $criteria->setDbName(RemoteAppPeer::DATABASE_NAME);

        return BasePeer::doUpdate($selectCriteria, $criteria, $con);
    }

    /**
     * Deletes all rows from the remote_app table.
     *
     * @param      PropelPDO $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException
     */
    public static function doDeleteAll(PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(RemoteAppPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += RemoteAppPeer::doOnDeleteCascade(new Criteria(RemoteAppPeer::DATABASE_NAME), $con);
            $affectedRows += BasePeer::doDeleteAll(RemoteAppPeer::TABLE_NAME, $con, RemoteAppPeer::DATABASE_NAME);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            RemoteAppPeer::clearInstancePool();
            RemoteAppPeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs a DELETE on the database, given a RemoteApp or Criteria object OR a primary key value.
     *
     * @param      mixed $values Criteria or RemoteApp object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param      PropelPDO $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *				if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, PropelPDO $con = null)
     {
        if ($con === null) {
            $con = Propel::getConnection(RemoteAppPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = clone $values;
        } elseif ($values instanceof RemoteApp) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(RemoteAppPeer::DATABASE_NAME);
            $criteria->add(RemoteAppPeer::ID, (array) $values, Criteria::IN);
        }

        // Set the correct dbName
        $criteria->setDbName(RemoteAppPeer::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();

            // cloning the Criteria in case it's modified by doSelect() or doSelectStmt()
            $c = clone $criteria;
            $affectedRows += RemoteAppPeer::doOnDeleteCascade($c, $con);

            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            if ($values instanceof Criteria) {
                RemoteAppPeer::clearInstancePool();
            } elseif ($values instanceof RemoteApp) { // it's a model object
                RemoteAppPeer::removeInstanceFromPool($values);
            } else { // it's a primary key, or an array of pks
                foreach ((array) $values as $singleval) {
                    RemoteAppPeer::removeInstanceFromPool($singleval);
                }
            }

            $affectedRows += BasePeer::doDelete($criteria, $con);
            RemoteAppPeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * This is a method for emulating ON DELETE CASCADE for DBs that don't support this
     * feature (like MySQL or SQLite).
     *
     * This method is not very speedy because it must perform a query first to get
     * the implicated records and then perform the deletes by calling those Peer classes.
     *
     * This method should be used within a transaction if possible.
     *
     * @param      Criteria $criteria
     * @param      PropelPDO $con
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    protected static function doOnDeleteCascade(Criteria $criteria, PropelPDO $con)
    {
        // initialize var to track total num of affected rows
        $affectedRows = 0;

        // first find the objects that are implicated by the $criteria
        $objects = RemoteAppPeer::doSelect($criteria, $con);
        foreach ($objects as $obj) {


            // delete related ApiLog objects
            $criteria = new Criteria(ApiLogPeer::DATABASE_NAME);

            $criteria->add(ApiLogPeer::REMOTE_APP_ID, $obj->getId());
            $affectedRows += ApiLogPeer::doDelete($criteria, $con);

            // delete related RemoteHistoryContao objects
            $criteria = new Criteria(RemoteHistoryContaoPeer::DATABASE_NAME);

            $criteria->add(RemoteHistoryContaoPeer::REMOTE_APP_ID, $obj->getId());
            $affectedRows += RemoteHistoryContaoPeer::doDelete($criteria, $con);
        }

        return $affectedRows;
    }

    /**
     * Validates all modified columns of given RemoteApp object.
     * If parameter $columns is either a single column name or an array of column names
     * than only those columns are validated.
     *
     * NOTICE: This does not apply to primary or foreign keys for now.
     *
     * @param RemoteApp $obj The object to validate.
     * @param      mixed $cols Column name or array of column names.
     *
     * @return mixed TRUE if all columns are valid or the error message of the first invalid column.
     */
    public static function doValidate($obj, $cols = null)
    {
        $columns = array();

        if ($cols) {
            $dbMap = Propel::getDatabaseMap(RemoteAppPeer::DATABASE_NAME);
            $tableMap = $dbMap->getTable(RemoteAppPeer::TABLE_NAME);

            if (! is_array($cols)) {
                $cols = array($cols);
            }

            foreach ($cols as $colName) {
                if ($tableMap->hasColumn($colName)) {
                    $get = 'get' . $tableMap->getColumn($colName)->getPhpName();
                    $columns[$colName] = $obj->$get();
                }
            }
        } else {

        }

        return BasePeer::doValidate(RemoteAppPeer::DATABASE_NAME, RemoteAppPeer::TABLE_NAME, $columns);
    }

    /**
     * Retrieve a single object by pkey.
     *
     * @param int $pk the primary key.
     * @param      PropelPDO $con the connection to use
     * @return RemoteApp
     */
    public static function retrieveByPK($pk, PropelPDO $con = null)
    {

        if (null !== ($obj = RemoteAppPeer::getInstanceFromPool((string) $pk))) {
            return $obj;
        }

        if ($con === null) {
            $con = Propel::getConnection(RemoteAppPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria = new Criteria(RemoteAppPeer::DATABASE_NAME);
        $criteria->add(RemoteAppPeer::ID, $pk);

        $v = RemoteAppPeer::doSelect($criteria, $con);

        return !empty($v) > 0 ? $v[0] : null;
    }

    /**
     * Retrieve multiple objects by pkey.
     *
     * @param      array $pks List of primary keys
     * @param      PropelPDO $con the connection to use
     * @return RemoteApp[]
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function retrieveByPKs($pks, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(RemoteAppPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $objs = null;
        if (empty($pks)) {
            $objs = array();
        } else {
            $criteria = new Criteria(RemoteAppPeer::DATABASE_NAME);
            $criteria->add(RemoteAppPeer::ID, $pks, Criteria::IN);
            $objs = RemoteAppPeer::doSelect($criteria, $con);
        }

        return $objs;
    }

} // BaseRemoteAppPeer

// This is the static code needed to register the TableMap for this table with the main Propel class.
//
BaseRemoteAppPeer::buildTableMap();


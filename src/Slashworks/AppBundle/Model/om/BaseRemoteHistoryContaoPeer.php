<?php

namespace Slashworks\AppBundle\Model\om;

use \BasePeer;
use \Criteria;
use \PDO;
use \PDOStatement;
use \Propel;
use \PropelException;
use \PropelPDO;
use Slashworks\AppBundle\Model\RemoteAppPeer;
use Slashworks\AppBundle\Model\RemoteHistoryContao;
use Slashworks\AppBundle\Model\RemoteHistoryContaoPeer;
use Slashworks\AppBundle\Model\map\RemoteHistoryContaoTableMap;

abstract class BaseRemoteHistoryContaoPeer
{

    /** the default database name for this class */
    const DATABASE_NAME = 'default';

    /** the table name for this class */
    const TABLE_NAME = 'remote_history_contao';

    /** the related Propel class for this table */
    const OM_CLASS = 'Slashworks\\AppBundle\\Model\\RemoteHistoryContao';

    /** the related TableMap class for this table */
    const TM_CLASS = 'Slashworks\\AppBundle\\Model\\map\\RemoteHistoryContaoTableMap';

    /** The total number of columns. */
    const NUM_COLUMNS = 19;

    /** The number of lazy-loaded columns. */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /** The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS) */
    const NUM_HYDRATE_COLUMNS = 19;

    /** the column name for the id field */
    const ID = 'remote_history_contao.id';

    /** the column name for the remote_app_id field */
    const REMOTE_APP_ID = 'remote_history_contao.remote_app_id';

    /** the column name for the apiVersion field */
    const APIVERSION = 'remote_history_contao.apiVersion';

    /** the column name for the name field */
    const NAME = 'remote_history_contao.name';

    /** the column name for the version field */
    const VERSION = 'remote_history_contao.version';

    /** the column name for the config_displayErrors field */
    const CONFIG_DISPLAYERRORS = 'remote_history_contao.config_displayErrors';

    /** the column name for the config_bypassCache field */
    const CONFIG_BYPASSCACHE = 'remote_history_contao.config_bypassCache';

    /** the column name for the config_minifyMarkup field */
    const CONFIG_MINIFYMARKUP = 'remote_history_contao.config_minifyMarkup';

    /** the column name for the config_debugMode field */
    const CONFIG_DEBUGMODE = 'remote_history_contao.config_debugMode';

    /** the column name for the config_maintenanceMode field */
    const CONFIG_MAINTENANCEMODE = 'remote_history_contao.config_maintenanceMode';

    /** the column name for the config_gzipScripts field */
    const CONFIG_GZIPSCRIPTS = 'remote_history_contao.config_gzipScripts';

    /** the column name for the config_rewriteURL field */
    const CONFIG_REWRITEURL = 'remote_history_contao.config_rewriteURL';

    /** the column name for the config_adminEmail field */
    const CONFIG_ADMINEMAIL = 'remote_history_contao.config_adminEmail';

    /** the column name for the config_cacheMode field */
    const CONFIG_CACHEMODE = 'remote_history_contao.config_cacheMode';

    /** the column name for the statuscode field */
    const STATUSCODE = 'remote_history_contao.statuscode';

    /** the column name for the extensions field */
    const EXTENSIONS = 'remote_history_contao.extensions';

    /** the column name for the log field */
    const LOG = 'remote_history_contao.log';

    /** the column name for the php field */
    const PHP = 'remote_history_contao.php';

    /** the column name for the mysql field */
    const MYSQL = 'remote_history_contao.mysql';

    /** The default string format for model objects of the related table **/
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * An identity map to hold any loaded instances of RemoteHistoryContao objects.
     * This must be public so that other peer classes can access this when hydrating from JOIN
     * queries.
     * @var        array RemoteHistoryContao[]
     */
    public static $instances = array();


    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. RemoteHistoryContaoPeer::$fieldNames[RemoteHistoryContaoPeer::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        BasePeer::TYPE_PHPNAME => array ('Id', 'RemoteAppId', 'Apiversion', 'Name', 'Version', 'ConfigDisplayerrors', 'ConfigBypasscache', 'ConfigMinifymarkup', 'ConfigDebugmode', 'ConfigMaintenancemode', 'ConfigGzipscripts', 'ConfigRewriteurl', 'ConfigAdminemail', 'ConfigCachemode', 'Statuscode', 'Extensions', 'Log', 'PHP', 'MySQL', ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('id', 'remoteAppId', 'apiversion', 'name', 'version', 'configDisplayerrors', 'configBypasscache', 'configMinifymarkup', 'configDebugmode', 'configMaintenancemode', 'configGzipscripts', 'configRewriteurl', 'configAdminemail', 'configCachemode', 'statuscode', 'extensions', 'log', 'pHP', 'mySQL', ),
        BasePeer::TYPE_COLNAME => array (RemoteHistoryContaoPeer::ID, RemoteHistoryContaoPeer::REMOTE_APP_ID, RemoteHistoryContaoPeer::APIVERSION, RemoteHistoryContaoPeer::NAME, RemoteHistoryContaoPeer::VERSION, RemoteHistoryContaoPeer::CONFIG_DISPLAYERRORS, RemoteHistoryContaoPeer::CONFIG_BYPASSCACHE, RemoteHistoryContaoPeer::CONFIG_MINIFYMARKUP, RemoteHistoryContaoPeer::CONFIG_DEBUGMODE, RemoteHistoryContaoPeer::CONFIG_MAINTENANCEMODE, RemoteHistoryContaoPeer::CONFIG_GZIPSCRIPTS, RemoteHistoryContaoPeer::CONFIG_REWRITEURL, RemoteHistoryContaoPeer::CONFIG_ADMINEMAIL, RemoteHistoryContaoPeer::CONFIG_CACHEMODE, RemoteHistoryContaoPeer::STATUSCODE, RemoteHistoryContaoPeer::EXTENSIONS, RemoteHistoryContaoPeer::LOG, RemoteHistoryContaoPeer::PHP, RemoteHistoryContaoPeer::MYSQL, ),
        BasePeer::TYPE_RAW_COLNAME => array ('ID', 'REMOTE_APP_ID', 'APIVERSION', 'NAME', 'VERSION', 'CONFIG_DISPLAYERRORS', 'CONFIG_BYPASSCACHE', 'CONFIG_MINIFYMARKUP', 'CONFIG_DEBUGMODE', 'CONFIG_MAINTENANCEMODE', 'CONFIG_GZIPSCRIPTS', 'CONFIG_REWRITEURL', 'CONFIG_ADMINEMAIL', 'CONFIG_CACHEMODE', 'STATUSCODE', 'EXTENSIONS', 'LOG', 'PHP', 'MYSQL', ),
        BasePeer::TYPE_FIELDNAME => array ('id', 'remote_app_id', 'apiVersion', 'name', 'version', 'config_displayErrors', 'config_bypassCache', 'config_minifyMarkup', 'config_debugMode', 'config_maintenanceMode', 'config_gzipScripts', 'config_rewriteURL', 'config_adminEmail', 'config_cacheMode', 'statuscode', 'extensions', 'log', 'php', 'mysql', ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. RemoteHistoryContaoPeer::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'RemoteAppId' => 1, 'Apiversion' => 2, 'Name' => 3, 'Version' => 4, 'ConfigDisplayerrors' => 5, 'ConfigBypasscache' => 6, 'ConfigMinifymarkup' => 7, 'ConfigDebugmode' => 8, 'ConfigMaintenancemode' => 9, 'ConfigGzipscripts' => 10, 'ConfigRewriteurl' => 11, 'ConfigAdminemail' => 12, 'ConfigCachemode' => 13, 'Statuscode' => 14, 'Extensions' => 15, 'Log' => 16, 'PHP' => 17, 'MySQL' => 18, ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('id' => 0, 'remoteAppId' => 1, 'apiversion' => 2, 'name' => 3, 'version' => 4, 'configDisplayerrors' => 5, 'configBypasscache' => 6, 'configMinifymarkup' => 7, 'configDebugmode' => 8, 'configMaintenancemode' => 9, 'configGzipscripts' => 10, 'configRewriteurl' => 11, 'configAdminemail' => 12, 'configCachemode' => 13, 'statuscode' => 14, 'extensions' => 15, 'log' => 16, 'pHP' => 17, 'mySQL' => 18, ),
        BasePeer::TYPE_COLNAME => array (RemoteHistoryContaoPeer::ID => 0, RemoteHistoryContaoPeer::REMOTE_APP_ID => 1, RemoteHistoryContaoPeer::APIVERSION => 2, RemoteHistoryContaoPeer::NAME => 3, RemoteHistoryContaoPeer::VERSION => 4, RemoteHistoryContaoPeer::CONFIG_DISPLAYERRORS => 5, RemoteHistoryContaoPeer::CONFIG_BYPASSCACHE => 6, RemoteHistoryContaoPeer::CONFIG_MINIFYMARKUP => 7, RemoteHistoryContaoPeer::CONFIG_DEBUGMODE => 8, RemoteHistoryContaoPeer::CONFIG_MAINTENANCEMODE => 9, RemoteHistoryContaoPeer::CONFIG_GZIPSCRIPTS => 10, RemoteHistoryContaoPeer::CONFIG_REWRITEURL => 11, RemoteHistoryContaoPeer::CONFIG_ADMINEMAIL => 12, RemoteHistoryContaoPeer::CONFIG_CACHEMODE => 13, RemoteHistoryContaoPeer::STATUSCODE => 14, RemoteHistoryContaoPeer::EXTENSIONS => 15, RemoteHistoryContaoPeer::LOG => 16, RemoteHistoryContaoPeer::PHP => 17, RemoteHistoryContaoPeer::MYSQL => 18, ),
        BasePeer::TYPE_RAW_COLNAME => array ('ID' => 0, 'REMOTE_APP_ID' => 1, 'APIVERSION' => 2, 'NAME' => 3, 'VERSION' => 4, 'CONFIG_DISPLAYERRORS' => 5, 'CONFIG_BYPASSCACHE' => 6, 'CONFIG_MINIFYMARKUP' => 7, 'CONFIG_DEBUGMODE' => 8, 'CONFIG_MAINTENANCEMODE' => 9, 'CONFIG_GZIPSCRIPTS' => 10, 'CONFIG_REWRITEURL' => 11, 'CONFIG_ADMINEMAIL' => 12, 'CONFIG_CACHEMODE' => 13, 'STATUSCODE' => 14, 'EXTENSIONS' => 15, 'LOG' => 16, 'PHP' => 17, 'MYSQL' => 18, ),
        BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'remote_app_id' => 1, 'apiVersion' => 2, 'name' => 3, 'version' => 4, 'config_displayErrors' => 5, 'config_bypassCache' => 6, 'config_minifyMarkup' => 7, 'config_debugMode' => 8, 'config_maintenanceMode' => 9, 'config_gzipScripts' => 10, 'config_rewriteURL' => 11, 'config_adminEmail' => 12, 'config_cacheMode' => 13, 'statuscode' => 14, 'extensions' => 15, 'log' => 16, 'php' => 17, 'mysql' => 18, ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, )
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
        $toNames = RemoteHistoryContaoPeer::getFieldNames($toType);
        $key = isset(RemoteHistoryContaoPeer::$fieldKeys[$fromType][$name]) ? RemoteHistoryContaoPeer::$fieldKeys[$fromType][$name] : null;
        if ($key === null) {
            throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(RemoteHistoryContaoPeer::$fieldKeys[$fromType], true));
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
        if (!array_key_exists($type, RemoteHistoryContaoPeer::$fieldNames)) {
            throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME, BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. ' . $type . ' was given.');
        }

        return RemoteHistoryContaoPeer::$fieldNames[$type];
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
     * @param      string $column The column name for current table. (i.e. RemoteHistoryContaoPeer::COLUMN_NAME).
     * @return string
     */
    public static function alias($alias, $column)
    {
        return str_replace(RemoteHistoryContaoPeer::TABLE_NAME.'.', $alias.'.', $column);
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
            $criteria->addSelectColumn(RemoteHistoryContaoPeer::ID);
            $criteria->addSelectColumn(RemoteHistoryContaoPeer::REMOTE_APP_ID);
            $criteria->addSelectColumn(RemoteHistoryContaoPeer::APIVERSION);
            $criteria->addSelectColumn(RemoteHistoryContaoPeer::NAME);
            $criteria->addSelectColumn(RemoteHistoryContaoPeer::VERSION);
            $criteria->addSelectColumn(RemoteHistoryContaoPeer::CONFIG_DISPLAYERRORS);
            $criteria->addSelectColumn(RemoteHistoryContaoPeer::CONFIG_BYPASSCACHE);
            $criteria->addSelectColumn(RemoteHistoryContaoPeer::CONFIG_MINIFYMARKUP);
            $criteria->addSelectColumn(RemoteHistoryContaoPeer::CONFIG_DEBUGMODE);
            $criteria->addSelectColumn(RemoteHistoryContaoPeer::CONFIG_MAINTENANCEMODE);
            $criteria->addSelectColumn(RemoteHistoryContaoPeer::CONFIG_GZIPSCRIPTS);
            $criteria->addSelectColumn(RemoteHistoryContaoPeer::CONFIG_REWRITEURL);
            $criteria->addSelectColumn(RemoteHistoryContaoPeer::CONFIG_ADMINEMAIL);
            $criteria->addSelectColumn(RemoteHistoryContaoPeer::CONFIG_CACHEMODE);
            $criteria->addSelectColumn(RemoteHistoryContaoPeer::STATUSCODE);
            $criteria->addSelectColumn(RemoteHistoryContaoPeer::EXTENSIONS);
            $criteria->addSelectColumn(RemoteHistoryContaoPeer::LOG);
            $criteria->addSelectColumn(RemoteHistoryContaoPeer::PHP);
            $criteria->addSelectColumn(RemoteHistoryContaoPeer::MYSQL);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.remote_app_id');
            $criteria->addSelectColumn($alias . '.apiVersion');
            $criteria->addSelectColumn($alias . '.name');
            $criteria->addSelectColumn($alias . '.version');
            $criteria->addSelectColumn($alias . '.config_displayErrors');
            $criteria->addSelectColumn($alias . '.config_bypassCache');
            $criteria->addSelectColumn($alias . '.config_minifyMarkup');
            $criteria->addSelectColumn($alias . '.config_debugMode');
            $criteria->addSelectColumn($alias . '.config_maintenanceMode');
            $criteria->addSelectColumn($alias . '.config_gzipScripts');
            $criteria->addSelectColumn($alias . '.config_rewriteURL');
            $criteria->addSelectColumn($alias . '.config_adminEmail');
            $criteria->addSelectColumn($alias . '.config_cacheMode');
            $criteria->addSelectColumn($alias . '.statuscode');
            $criteria->addSelectColumn($alias . '.extensions');
            $criteria->addSelectColumn($alias . '.log');
            $criteria->addSelectColumn($alias . '.php');
            $criteria->addSelectColumn($alias . '.mysql');
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
        $criteria->setPrimaryTableName(RemoteHistoryContaoPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            RemoteHistoryContaoPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count
        $criteria->setDbName(RemoteHistoryContaoPeer::DATABASE_NAME); // Set the correct dbName

        if ($con === null) {
            $con = Propel::getConnection(RemoteHistoryContaoPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return RemoteHistoryContao
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectOne(Criteria $criteria, PropelPDO $con = null)
    {
        $critcopy = clone $criteria;
        $critcopy->setLimit(1);
        $objects = RemoteHistoryContaoPeer::doSelect($critcopy, $con);
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
        return RemoteHistoryContaoPeer::populateObjects(RemoteHistoryContaoPeer::doSelectStmt($criteria, $con));
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
            $con = Propel::getConnection(RemoteHistoryContaoPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        if (!$criteria->hasSelectClause()) {
            $criteria = clone $criteria;
            RemoteHistoryContaoPeer::addSelectColumns($criteria);
        }

        // Set the correct dbName
        $criteria->setDbName(RemoteHistoryContaoPeer::DATABASE_NAME);

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
     * @param RemoteHistoryContao $obj A RemoteHistoryContao object.
     * @param      string $key (optional) key to use for instance map (for performance boost if key was already calculated externally).
     */
    public static function addInstanceToPool($obj, $key = null)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if ($key === null) {
                $key = (string) $obj->getId();
            } // if key === null
            RemoteHistoryContaoPeer::$instances[$key] = $obj;
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
     * @param      mixed $value A RemoteHistoryContao object or a primary key value.
     *
     * @return void
     * @throws PropelException - if the value is invalid.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && $value !== null) {
            if (is_object($value) && $value instanceof RemoteHistoryContao) {
                $key = (string) $value->getId();
            } elseif (is_scalar($value)) {
                // assume we've been passed a primary key
                $key = (string) $value;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or RemoteHistoryContao object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value,true)));
                throw $e;
            }

            unset(RemoteHistoryContaoPeer::$instances[$key]);
        }
    } // removeInstanceFromPool()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param      string $key The key (@see getPrimaryKeyHash()) for this instance.
     * @return RemoteHistoryContao Found object or null if 1) no instance exists for specified key or 2) instance pooling has been disabled.
     * @see        getPrimaryKeyHash()
     */
    public static function getInstanceFromPool($key)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (isset(RemoteHistoryContaoPeer::$instances[$key])) {
                return RemoteHistoryContaoPeer::$instances[$key];
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
        foreach (RemoteHistoryContaoPeer::$instances as $instance) {
          $instance->clearAllReferences(true);
        }
      }
        RemoteHistoryContaoPeer::$instances = array();
    }

    /**
     * Method to invalidate the instance pool of all tables related to remote_history_contao
     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
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
        $cls = RemoteHistoryContaoPeer::getOMClass();
        // populate the object(s)
        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key = RemoteHistoryContaoPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj = RemoteHistoryContaoPeer::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                RemoteHistoryContaoPeer::addInstanceToPool($obj, $key);
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
     * @return array (RemoteHistoryContao object, last column rank)
     */
    public static function populateObject($row, $startcol = 0)
    {
        $key = RemoteHistoryContaoPeer::getPrimaryKeyHashFromRow($row, $startcol);
        if (null !== ($obj = RemoteHistoryContaoPeer::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $startcol, true); // rehydrate
            $col = $startcol + RemoteHistoryContaoPeer::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = RemoteHistoryContaoPeer::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $startcol);
            RemoteHistoryContaoPeer::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }


    /**
     * Returns the number of rows matching criteria, joining the related RemoteApp table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinRemoteApp(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(RemoteHistoryContaoPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            RemoteHistoryContaoPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(RemoteHistoryContaoPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(RemoteHistoryContaoPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(RemoteHistoryContaoPeer::REMOTE_APP_ID, RemoteAppPeer::ID, $join_behavior);

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
     * Selects a collection of RemoteHistoryContao objects pre-filled with their RemoteApp objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of RemoteHistoryContao objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinRemoteApp(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(RemoteHistoryContaoPeer::DATABASE_NAME);
        }

        RemoteHistoryContaoPeer::addSelectColumns($criteria);
        $startcol = RemoteHistoryContaoPeer::NUM_HYDRATE_COLUMNS;
        RemoteAppPeer::addSelectColumns($criteria);

        $criteria->addJoin(RemoteHistoryContaoPeer::REMOTE_APP_ID, RemoteAppPeer::ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = RemoteHistoryContaoPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = RemoteHistoryContaoPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = RemoteHistoryContaoPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                RemoteHistoryContaoPeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = RemoteAppPeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = RemoteAppPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = RemoteAppPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    RemoteAppPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (RemoteHistoryContao) to $obj2 (RemoteApp)
                $obj2->addRemoteHistoryContao($obj1);

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
        $criteria->setPrimaryTableName(RemoteHistoryContaoPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            RemoteHistoryContaoPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(RemoteHistoryContaoPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(RemoteHistoryContaoPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(RemoteHistoryContaoPeer::REMOTE_APP_ID, RemoteAppPeer::ID, $join_behavior);

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
     * Selects a collection of RemoteHistoryContao objects pre-filled with all related objects.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of RemoteHistoryContao objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAll(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(RemoteHistoryContaoPeer::DATABASE_NAME);
        }

        RemoteHistoryContaoPeer::addSelectColumns($criteria);
        $startcol2 = RemoteHistoryContaoPeer::NUM_HYDRATE_COLUMNS;

        RemoteAppPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + RemoteAppPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(RemoteHistoryContaoPeer::REMOTE_APP_ID, RemoteAppPeer::ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = RemoteHistoryContaoPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = RemoteHistoryContaoPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = RemoteHistoryContaoPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                RemoteHistoryContaoPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

            // Add objects for joined RemoteApp rows

            $key2 = RemoteAppPeer::getPrimaryKeyHashFromRow($row, $startcol2);
            if ($key2 !== null) {
                $obj2 = RemoteAppPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = RemoteAppPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    RemoteAppPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 loaded

                // Add the $obj1 (RemoteHistoryContao) to the collection in $obj2 (RemoteApp)
                $obj2->addRemoteHistoryContao($obj1);
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
        return Propel::getDatabaseMap(RemoteHistoryContaoPeer::DATABASE_NAME)->getTable(RemoteHistoryContaoPeer::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this peer class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getDatabaseMap(BaseRemoteHistoryContaoPeer::DATABASE_NAME);
      if (!$dbMap->hasTable(BaseRemoteHistoryContaoPeer::TABLE_NAME)) {
        $dbMap->addTableObject(new \Slashworks\AppBundle\Model\map\RemoteHistoryContaoTableMap());
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
        return RemoteHistoryContaoPeer::OM_CLASS;
    }

    /**
     * Performs an INSERT on the database, given a RemoteHistoryContao or Criteria object.
     *
     * @param      mixed $values Criteria or RemoteHistoryContao object containing data that is used to create the INSERT statement.
     * @param      PropelPDO $con the PropelPDO connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doInsert($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(RemoteHistoryContaoPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity
        } else {
            $criteria = $values->buildCriteria(); // build Criteria from RemoteHistoryContao object
        }

        if ($criteria->containsKey(RemoteHistoryContaoPeer::ID) && $criteria->keyContainsValue(RemoteHistoryContaoPeer::ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.RemoteHistoryContaoPeer::ID.')');
        }


        // Set the correct dbName
        $criteria->setDbName(RemoteHistoryContaoPeer::DATABASE_NAME);

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
     * Performs an UPDATE on the database, given a RemoteHistoryContao or Criteria object.
     *
     * @param      mixed $values Criteria or RemoteHistoryContao object containing data that is used to create the UPDATE statement.
     * @param      PropelPDO $con The connection to use (specify PropelPDO connection object to exert more control over transactions).
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doUpdate($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(RemoteHistoryContaoPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $selectCriteria = new Criteria(RemoteHistoryContaoPeer::DATABASE_NAME);

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity

            $comparison = $criteria->getComparison(RemoteHistoryContaoPeer::ID);
            $value = $criteria->remove(RemoteHistoryContaoPeer::ID);
            if ($value) {
                $selectCriteria->add(RemoteHistoryContaoPeer::ID, $value, $comparison);
            } else {
                $selectCriteria->setPrimaryTableName(RemoteHistoryContaoPeer::TABLE_NAME);
            }

        } else { // $values is RemoteHistoryContao object
            $criteria = $values->buildCriteria(); // gets full criteria
            $selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
        }

        // set the correct dbName
        $criteria->setDbName(RemoteHistoryContaoPeer::DATABASE_NAME);

        return BasePeer::doUpdate($selectCriteria, $criteria, $con);
    }

    /**
     * Deletes all rows from the remote_history_contao table.
     *
     * @param      PropelPDO $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException
     */
    public static function doDeleteAll(PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(RemoteHistoryContaoPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += BasePeer::doDeleteAll(RemoteHistoryContaoPeer::TABLE_NAME, $con, RemoteHistoryContaoPeer::DATABASE_NAME);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            RemoteHistoryContaoPeer::clearInstancePool();
            RemoteHistoryContaoPeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs a DELETE on the database, given a RemoteHistoryContao or Criteria object OR a primary key value.
     *
     * @param      mixed $values Criteria or RemoteHistoryContao object or primary key or array of primary keys
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
            $con = Propel::getConnection(RemoteHistoryContaoPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            // invalidate the cache for all objects of this type, since we have no
            // way of knowing (without running a query) what objects should be invalidated
            // from the cache based on this Criteria.
            RemoteHistoryContaoPeer::clearInstancePool();
            // rename for clarity
            $criteria = clone $values;
        } elseif ($values instanceof RemoteHistoryContao) { // it's a model object
            // invalidate the cache for this single object
            RemoteHistoryContaoPeer::removeInstanceFromPool($values);
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(RemoteHistoryContaoPeer::DATABASE_NAME);
            $criteria->add(RemoteHistoryContaoPeer::ID, (array) $values, Criteria::IN);
            // invalidate the cache for this object(s)
            foreach ((array) $values as $singleval) {
                RemoteHistoryContaoPeer::removeInstanceFromPool($singleval);
            }
        }

        // Set the correct dbName
        $criteria->setDbName(RemoteHistoryContaoPeer::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();

            $affectedRows += BasePeer::doDelete($criteria, $con);
            RemoteHistoryContaoPeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Validates all modified columns of given RemoteHistoryContao object.
     * If parameter $columns is either a single column name or an array of column names
     * than only those columns are validated.
     *
     * NOTICE: This does not apply to primary or foreign keys for now.
     *
     * @param RemoteHistoryContao $obj The object to validate.
     * @param      mixed $cols Column name or array of column names.
     *
     * @return mixed TRUE if all columns are valid or the error message of the first invalid column.
     */
    public static function doValidate($obj, $cols = null)
    {
        $columns = array();

        if ($cols) {
            $dbMap = Propel::getDatabaseMap(RemoteHistoryContaoPeer::DATABASE_NAME);
            $tableMap = $dbMap->getTable(RemoteHistoryContaoPeer::TABLE_NAME);

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

        return BasePeer::doValidate(RemoteHistoryContaoPeer::DATABASE_NAME, RemoteHistoryContaoPeer::TABLE_NAME, $columns);
    }

    /**
     * Retrieve a single object by pkey.
     *
     * @param int $pk the primary key.
     * @param      PropelPDO $con the connection to use
     * @return RemoteHistoryContao
     */
    public static function retrieveByPK($pk, PropelPDO $con = null)
    {

        if (null !== ($obj = RemoteHistoryContaoPeer::getInstanceFromPool((string) $pk))) {
            return $obj;
        }

        if ($con === null) {
            $con = Propel::getConnection(RemoteHistoryContaoPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria = new Criteria(RemoteHistoryContaoPeer::DATABASE_NAME);
        $criteria->add(RemoteHistoryContaoPeer::ID, $pk);

        $v = RemoteHistoryContaoPeer::doSelect($criteria, $con);

        return !empty($v) > 0 ? $v[0] : null;
    }

    /**
     * Retrieve multiple objects by pkey.
     *
     * @param      array $pks List of primary keys
     * @param      PropelPDO $con the connection to use
     * @return RemoteHistoryContao[]
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function retrieveByPKs($pks, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(RemoteHistoryContaoPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $objs = null;
        if (empty($pks)) {
            $objs = array();
        } else {
            $criteria = new Criteria(RemoteHistoryContaoPeer::DATABASE_NAME);
            $criteria->add(RemoteHistoryContaoPeer::ID, $pks, Criteria::IN);
            $objs = RemoteHistoryContaoPeer::doSelect($criteria, $con);
        }

        return $objs;
    }

} // BaseRemoteHistoryContaoPeer

// This is the static code needed to register the TableMap for this table with the main Propel class.
//
BaseRemoteHistoryContaoPeer::buildTableMap();


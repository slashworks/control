<?php

namespace Slashworks\AppBundle\Model\om;

use \Criteria;
use \Exception;
use \ModelCriteria;
use \ModelJoin;
use \PDO;
use \Propel;
use \PropelCollection;
use \PropelException;
use \PropelObjectCollection;
use \PropelPDO;
use Slashworks\AppBundle\Model\RemoteApp;
use Slashworks\AppBundle\Model\RemoteHistoryContao;
use Slashworks\AppBundle\Model\RemoteHistoryContaoPeer;
use Slashworks\AppBundle\Model\RemoteHistoryContaoQuery;

/**
 * @method RemoteHistoryContaoQuery orderById($order = Criteria::ASC) Order by the id column
 * @method RemoteHistoryContaoQuery orderByRemoteAppId($order = Criteria::ASC) Order by the remote_app_id column
 * @method RemoteHistoryContaoQuery orderByApiversion($order = Criteria::ASC) Order by the apiVersion column
 * @method RemoteHistoryContaoQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method RemoteHistoryContaoQuery orderByVersion($order = Criteria::ASC) Order by the version column
 * @method RemoteHistoryContaoQuery orderByConfigDisplayerrors($order = Criteria::ASC) Order by the config_displayErrors column
 * @method RemoteHistoryContaoQuery orderByConfigBypasscache($order = Criteria::ASC) Order by the config_bypassCache column
 * @method RemoteHistoryContaoQuery orderByConfigMinifymarkup($order = Criteria::ASC) Order by the config_minifyMarkup column
 * @method RemoteHistoryContaoQuery orderByConfigDebugmode($order = Criteria::ASC) Order by the config_debugMode column
 * @method RemoteHistoryContaoQuery orderByConfigMaintenancemode($order = Criteria::ASC) Order by the config_maintenanceMode column
 * @method RemoteHistoryContaoQuery orderByConfigGzipscripts($order = Criteria::ASC) Order by the config_gzipScripts column
 * @method RemoteHistoryContaoQuery orderByConfigRewriteurl($order = Criteria::ASC) Order by the config_rewriteURL column
 * @method RemoteHistoryContaoQuery orderByConfigAdminemail($order = Criteria::ASC) Order by the config_adminEmail column
 * @method RemoteHistoryContaoQuery orderByConfigCachemode($order = Criteria::ASC) Order by the config_cacheMode column
 * @method RemoteHistoryContaoQuery orderByStatuscode($order = Criteria::ASC) Order by the statuscode column
 * @method RemoteHistoryContaoQuery orderByExtensions($order = Criteria::ASC) Order by the extensions column
 * @method RemoteHistoryContaoQuery orderByLog($order = Criteria::ASC) Order by the log column
 * @method RemoteHistoryContaoQuery orderByPHP($order = Criteria::ASC) Order by the php column
 * @method RemoteHistoryContaoQuery orderByMySQL($order = Criteria::ASC) Order by the mysql column
 *
 * @method RemoteHistoryContaoQuery groupById() Group by the id column
 * @method RemoteHistoryContaoQuery groupByRemoteAppId() Group by the remote_app_id column
 * @method RemoteHistoryContaoQuery groupByApiversion() Group by the apiVersion column
 * @method RemoteHistoryContaoQuery groupByName() Group by the name column
 * @method RemoteHistoryContaoQuery groupByVersion() Group by the version column
 * @method RemoteHistoryContaoQuery groupByConfigDisplayerrors() Group by the config_displayErrors column
 * @method RemoteHistoryContaoQuery groupByConfigBypasscache() Group by the config_bypassCache column
 * @method RemoteHistoryContaoQuery groupByConfigMinifymarkup() Group by the config_minifyMarkup column
 * @method RemoteHistoryContaoQuery groupByConfigDebugmode() Group by the config_debugMode column
 * @method RemoteHistoryContaoQuery groupByConfigMaintenancemode() Group by the config_maintenanceMode column
 * @method RemoteHistoryContaoQuery groupByConfigGzipscripts() Group by the config_gzipScripts column
 * @method RemoteHistoryContaoQuery groupByConfigRewriteurl() Group by the config_rewriteURL column
 * @method RemoteHistoryContaoQuery groupByConfigAdminemail() Group by the config_adminEmail column
 * @method RemoteHistoryContaoQuery groupByConfigCachemode() Group by the config_cacheMode column
 * @method RemoteHistoryContaoQuery groupByStatuscode() Group by the statuscode column
 * @method RemoteHistoryContaoQuery groupByExtensions() Group by the extensions column
 * @method RemoteHistoryContaoQuery groupByLog() Group by the log column
 * @method RemoteHistoryContaoQuery groupByPHP() Group by the php column
 * @method RemoteHistoryContaoQuery groupByMySQL() Group by the mysql column
 *
 * @method RemoteHistoryContaoQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method RemoteHistoryContaoQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method RemoteHistoryContaoQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method RemoteHistoryContaoQuery leftJoinRemoteApp($relationAlias = null) Adds a LEFT JOIN clause to the query using the RemoteApp relation
 * @method RemoteHistoryContaoQuery rightJoinRemoteApp($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RemoteApp relation
 * @method RemoteHistoryContaoQuery innerJoinRemoteApp($relationAlias = null) Adds a INNER JOIN clause to the query using the RemoteApp relation
 *
 * @method RemoteHistoryContao findOne(PropelPDO $con = null) Return the first RemoteHistoryContao matching the query
 * @method RemoteHistoryContao findOneOrCreate(PropelPDO $con = null) Return the first RemoteHistoryContao matching the query, or a new RemoteHistoryContao object populated from the query conditions when no match is found
 *
 * @method RemoteHistoryContao findOneByRemoteAppId(int $remote_app_id) Return the first RemoteHistoryContao filtered by the remote_app_id column
 * @method RemoteHistoryContao findOneByApiversion(string $apiVersion) Return the first RemoteHistoryContao filtered by the apiVersion column
 * @method RemoteHistoryContao findOneByName(string $name) Return the first RemoteHistoryContao filtered by the name column
 * @method RemoteHistoryContao findOneByVersion(string $version) Return the first RemoteHistoryContao filtered by the version column
 * @method RemoteHistoryContao findOneByConfigDisplayerrors(string $config_displayErrors) Return the first RemoteHistoryContao filtered by the config_displayErrors column
 * @method RemoteHistoryContao findOneByConfigBypasscache(string $config_bypassCache) Return the first RemoteHistoryContao filtered by the config_bypassCache column
 * @method RemoteHistoryContao findOneByConfigMinifymarkup(string $config_minifyMarkup) Return the first RemoteHistoryContao filtered by the config_minifyMarkup column
 * @method RemoteHistoryContao findOneByConfigDebugmode(string $config_debugMode) Return the first RemoteHistoryContao filtered by the config_debugMode column
 * @method RemoteHistoryContao findOneByConfigMaintenancemode(string $config_maintenanceMode) Return the first RemoteHistoryContao filtered by the config_maintenanceMode column
 * @method RemoteHistoryContao findOneByConfigGzipscripts(string $config_gzipScripts) Return the first RemoteHistoryContao filtered by the config_gzipScripts column
 * @method RemoteHistoryContao findOneByConfigRewriteurl(string $config_rewriteURL) Return the first RemoteHistoryContao filtered by the config_rewriteURL column
 * @method RemoteHistoryContao findOneByConfigAdminemail(string $config_adminEmail) Return the first RemoteHistoryContao filtered by the config_adminEmail column
 * @method RemoteHistoryContao findOneByConfigCachemode(string $config_cacheMode) Return the first RemoteHistoryContao filtered by the config_cacheMode column
 * @method RemoteHistoryContao findOneByStatuscode(int $statuscode) Return the first RemoteHistoryContao filtered by the statuscode column
 * @method RemoteHistoryContao findOneByExtensions( $extensions) Return the first RemoteHistoryContao filtered by the extensions column
 * @method RemoteHistoryContao findOneByLog( $log) Return the first RemoteHistoryContao filtered by the log column
 * @method RemoteHistoryContao findOneByPHP( $php) Return the first RemoteHistoryContao filtered by the php column
 * @method RemoteHistoryContao findOneByMySQL( $mysql) Return the first RemoteHistoryContao filtered by the mysql column
 *
 * @method array findById(int $id) Return RemoteHistoryContao objects filtered by the id column
 * @method array findByRemoteAppId(int $remote_app_id) Return RemoteHistoryContao objects filtered by the remote_app_id column
 * @method array findByApiversion(string $apiVersion) Return RemoteHistoryContao objects filtered by the apiVersion column
 * @method array findByName(string $name) Return RemoteHistoryContao objects filtered by the name column
 * @method array findByVersion(string $version) Return RemoteHistoryContao objects filtered by the version column
 * @method array findByConfigDisplayerrors(string $config_displayErrors) Return RemoteHistoryContao objects filtered by the config_displayErrors column
 * @method array findByConfigBypasscache(string $config_bypassCache) Return RemoteHistoryContao objects filtered by the config_bypassCache column
 * @method array findByConfigMinifymarkup(string $config_minifyMarkup) Return RemoteHistoryContao objects filtered by the config_minifyMarkup column
 * @method array findByConfigDebugmode(string $config_debugMode) Return RemoteHistoryContao objects filtered by the config_debugMode column
 * @method array findByConfigMaintenancemode(string $config_maintenanceMode) Return RemoteHistoryContao objects filtered by the config_maintenanceMode column
 * @method array findByConfigGzipscripts(string $config_gzipScripts) Return RemoteHistoryContao objects filtered by the config_gzipScripts column
 * @method array findByConfigRewriteurl(string $config_rewriteURL) Return RemoteHistoryContao objects filtered by the config_rewriteURL column
 * @method array findByConfigAdminemail(string $config_adminEmail) Return RemoteHistoryContao objects filtered by the config_adminEmail column
 * @method array findByConfigCachemode(string $config_cacheMode) Return RemoteHistoryContao objects filtered by the config_cacheMode column
 * @method array findByStatuscode(int $statuscode) Return RemoteHistoryContao objects filtered by the statuscode column
 * @method array findByExtensions( $extensions) Return RemoteHistoryContao objects filtered by the extensions column
 * @method array findByLog( $log) Return RemoteHistoryContao objects filtered by the log column
 * @method array findByPHP( $php) Return RemoteHistoryContao objects filtered by the php column
 * @method array findByMySQL( $mysql) Return RemoteHistoryContao objects filtered by the mysql column
 */
abstract class BaseRemoteHistoryContaoQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseRemoteHistoryContaoQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = null, $modelName = null, $modelAlias = null)
    {
        if (null === $dbName) {
            $dbName = 'default';
        }
        if (null === $modelName) {
            $modelName = 'Slashworks\\AppBundle\\Model\\RemoteHistoryContao';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new RemoteHistoryContaoQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   RemoteHistoryContaoQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return RemoteHistoryContaoQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof RemoteHistoryContaoQuery) {
            return $criteria;
        }
        $query = new RemoteHistoryContaoQuery(null, null, $modelAlias);

        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return   RemoteHistoryContao|RemoteHistoryContao[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = RemoteHistoryContaoPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(RemoteHistoryContaoPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Alias of findPk to use instance pooling
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return                 RemoteHistoryContao A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneById($key, $con = null)
     {
        return $this->findPk($key, $con);
     }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return                 RemoteHistoryContao A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `remote_app_id`, `apiVersion`, `name`, `version`, `config_displayErrors`, `config_bypassCache`, `config_minifyMarkup`, `config_debugMode`, `config_maintenanceMode`, `config_gzipScripts`, `config_rewriteURL`, `config_adminEmail`, `config_cacheMode`, `statuscode`, `extensions`, `log`, `php`, `mysql` FROM `remote_history_contao` WHERE `id` = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $obj = new RemoteHistoryContao();
            $obj->hydrate($row);
            RemoteHistoryContaoPeer::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return RemoteHistoryContao|RemoteHistoryContao[]|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($stmt);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return PropelObjectCollection|RemoteHistoryContao[]|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection($this->getDbName(), Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($stmt);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return RemoteHistoryContaoQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(RemoteHistoryContaoPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return RemoteHistoryContaoQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(RemoteHistoryContaoPeer::ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id >= 12
     * $query->filterById(array('max' => 12)); // WHERE id <= 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return RemoteHistoryContaoQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(RemoteHistoryContaoPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(RemoteHistoryContaoPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RemoteHistoryContaoPeer::ID, $id, $comparison);
    }

    /**
     * Filter the query on the remote_app_id column
     *
     * Example usage:
     * <code>
     * $query->filterByRemoteAppId(1234); // WHERE remote_app_id = 1234
     * $query->filterByRemoteAppId(array(12, 34)); // WHERE remote_app_id IN (12, 34)
     * $query->filterByRemoteAppId(array('min' => 12)); // WHERE remote_app_id >= 12
     * $query->filterByRemoteAppId(array('max' => 12)); // WHERE remote_app_id <= 12
     * </code>
     *
     * @see       filterByRemoteApp()
     *
     * @param     mixed $remoteAppId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return RemoteHistoryContaoQuery The current query, for fluid interface
     */
    public function filterByRemoteAppId($remoteAppId = null, $comparison = null)
    {
        if (is_array($remoteAppId)) {
            $useMinMax = false;
            if (isset($remoteAppId['min'])) {
                $this->addUsingAlias(RemoteHistoryContaoPeer::REMOTE_APP_ID, $remoteAppId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($remoteAppId['max'])) {
                $this->addUsingAlias(RemoteHistoryContaoPeer::REMOTE_APP_ID, $remoteAppId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RemoteHistoryContaoPeer::REMOTE_APP_ID, $remoteAppId, $comparison);
    }

    /**
     * Filter the query on the apiVersion column
     *
     * Example usage:
     * <code>
     * $query->filterByApiversion('fooValue');   // WHERE apiVersion = 'fooValue'
     * $query->filterByApiversion('%fooValue%'); // WHERE apiVersion LIKE '%fooValue%'
     * </code>
     *
     * @param     string $apiversion The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return RemoteHistoryContaoQuery The current query, for fluid interface
     */
    public function filterByApiversion($apiversion = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($apiversion)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $apiversion)) {
                $apiversion = str_replace('*', '%', $apiversion);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(RemoteHistoryContaoPeer::APIVERSION, $apiversion, $comparison);
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%'); // WHERE name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return RemoteHistoryContaoQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $name)) {
                $name = str_replace('*', '%', $name);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(RemoteHistoryContaoPeer::NAME, $name, $comparison);
    }

    /**
     * Filter the query on the version column
     *
     * Example usage:
     * <code>
     * $query->filterByVersion('fooValue');   // WHERE version = 'fooValue'
     * $query->filterByVersion('%fooValue%'); // WHERE version LIKE '%fooValue%'
     * </code>
     *
     * @param     string $version The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return RemoteHistoryContaoQuery The current query, for fluid interface
     */
    public function filterByVersion($version = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($version)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $version)) {
                $version = str_replace('*', '%', $version);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(RemoteHistoryContaoPeer::VERSION, $version, $comparison);
    }

    /**
     * Filter the query on the config_displayErrors column
     *
     * Example usage:
     * <code>
     * $query->filterByConfigDisplayerrors('fooValue');   // WHERE config_displayErrors = 'fooValue'
     * $query->filterByConfigDisplayerrors('%fooValue%'); // WHERE config_displayErrors LIKE '%fooValue%'
     * </code>
     *
     * @param     string $configDisplayerrors The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return RemoteHistoryContaoQuery The current query, for fluid interface
     */
    public function filterByConfigDisplayerrors($configDisplayerrors = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($configDisplayerrors)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $configDisplayerrors)) {
                $configDisplayerrors = str_replace('*', '%', $configDisplayerrors);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(RemoteHistoryContaoPeer::CONFIG_DISPLAYERRORS, $configDisplayerrors, $comparison);
    }

    /**
     * Filter the query on the config_bypassCache column
     *
     * Example usage:
     * <code>
     * $query->filterByConfigBypasscache('fooValue');   // WHERE config_bypassCache = 'fooValue'
     * $query->filterByConfigBypasscache('%fooValue%'); // WHERE config_bypassCache LIKE '%fooValue%'
     * </code>
     *
     * @param     string $configBypasscache The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return RemoteHistoryContaoQuery The current query, for fluid interface
     */
    public function filterByConfigBypasscache($configBypasscache = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($configBypasscache)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $configBypasscache)) {
                $configBypasscache = str_replace('*', '%', $configBypasscache);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(RemoteHistoryContaoPeer::CONFIG_BYPASSCACHE, $configBypasscache, $comparison);
    }

    /**
     * Filter the query on the config_minifyMarkup column
     *
     * Example usage:
     * <code>
     * $query->filterByConfigMinifymarkup('fooValue');   // WHERE config_minifyMarkup = 'fooValue'
     * $query->filterByConfigMinifymarkup('%fooValue%'); // WHERE config_minifyMarkup LIKE '%fooValue%'
     * </code>
     *
     * @param     string $configMinifymarkup The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return RemoteHistoryContaoQuery The current query, for fluid interface
     */
    public function filterByConfigMinifymarkup($configMinifymarkup = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($configMinifymarkup)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $configMinifymarkup)) {
                $configMinifymarkup = str_replace('*', '%', $configMinifymarkup);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(RemoteHistoryContaoPeer::CONFIG_MINIFYMARKUP, $configMinifymarkup, $comparison);
    }

    /**
     * Filter the query on the config_debugMode column
     *
     * Example usage:
     * <code>
     * $query->filterByConfigDebugmode('fooValue');   // WHERE config_debugMode = 'fooValue'
     * $query->filterByConfigDebugmode('%fooValue%'); // WHERE config_debugMode LIKE '%fooValue%'
     * </code>
     *
     * @param     string $configDebugmode The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return RemoteHistoryContaoQuery The current query, for fluid interface
     */
    public function filterByConfigDebugmode($configDebugmode = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($configDebugmode)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $configDebugmode)) {
                $configDebugmode = str_replace('*', '%', $configDebugmode);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(RemoteHistoryContaoPeer::CONFIG_DEBUGMODE, $configDebugmode, $comparison);
    }

    /**
     * Filter the query on the config_maintenanceMode column
     *
     * Example usage:
     * <code>
     * $query->filterByConfigMaintenancemode('fooValue');   // WHERE config_maintenanceMode = 'fooValue'
     * $query->filterByConfigMaintenancemode('%fooValue%'); // WHERE config_maintenanceMode LIKE '%fooValue%'
     * </code>
     *
     * @param     string $configMaintenancemode The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return RemoteHistoryContaoQuery The current query, for fluid interface
     */
    public function filterByConfigMaintenancemode($configMaintenancemode = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($configMaintenancemode)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $configMaintenancemode)) {
                $configMaintenancemode = str_replace('*', '%', $configMaintenancemode);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(RemoteHistoryContaoPeer::CONFIG_MAINTENANCEMODE, $configMaintenancemode, $comparison);
    }

    /**
     * Filter the query on the config_gzipScripts column
     *
     * Example usage:
     * <code>
     * $query->filterByConfigGzipscripts('fooValue');   // WHERE config_gzipScripts = 'fooValue'
     * $query->filterByConfigGzipscripts('%fooValue%'); // WHERE config_gzipScripts LIKE '%fooValue%'
     * </code>
     *
     * @param     string $configGzipscripts The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return RemoteHistoryContaoQuery The current query, for fluid interface
     */
    public function filterByConfigGzipscripts($configGzipscripts = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($configGzipscripts)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $configGzipscripts)) {
                $configGzipscripts = str_replace('*', '%', $configGzipscripts);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(RemoteHistoryContaoPeer::CONFIG_GZIPSCRIPTS, $configGzipscripts, $comparison);
    }

    /**
     * Filter the query on the config_rewriteURL column
     *
     * Example usage:
     * <code>
     * $query->filterByConfigRewriteurl('fooValue');   // WHERE config_rewriteURL = 'fooValue'
     * $query->filterByConfigRewriteurl('%fooValue%'); // WHERE config_rewriteURL LIKE '%fooValue%'
     * </code>
     *
     * @param     string $configRewriteurl The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return RemoteHistoryContaoQuery The current query, for fluid interface
     */
    public function filterByConfigRewriteurl($configRewriteurl = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($configRewriteurl)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $configRewriteurl)) {
                $configRewriteurl = str_replace('*', '%', $configRewriteurl);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(RemoteHistoryContaoPeer::CONFIG_REWRITEURL, $configRewriteurl, $comparison);
    }

    /**
     * Filter the query on the config_adminEmail column
     *
     * Example usage:
     * <code>
     * $query->filterByConfigAdminemail('fooValue');   // WHERE config_adminEmail = 'fooValue'
     * $query->filterByConfigAdminemail('%fooValue%'); // WHERE config_adminEmail LIKE '%fooValue%'
     * </code>
     *
     * @param     string $configAdminemail The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return RemoteHistoryContaoQuery The current query, for fluid interface
     */
    public function filterByConfigAdminemail($configAdminemail = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($configAdminemail)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $configAdminemail)) {
                $configAdminemail = str_replace('*', '%', $configAdminemail);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(RemoteHistoryContaoPeer::CONFIG_ADMINEMAIL, $configAdminemail, $comparison);
    }

    /**
     * Filter the query on the config_cacheMode column
     *
     * Example usage:
     * <code>
     * $query->filterByConfigCachemode('fooValue');   // WHERE config_cacheMode = 'fooValue'
     * $query->filterByConfigCachemode('%fooValue%'); // WHERE config_cacheMode LIKE '%fooValue%'
     * </code>
     *
     * @param     string $configCachemode The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return RemoteHistoryContaoQuery The current query, for fluid interface
     */
    public function filterByConfigCachemode($configCachemode = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($configCachemode)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $configCachemode)) {
                $configCachemode = str_replace('*', '%', $configCachemode);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(RemoteHistoryContaoPeer::CONFIG_CACHEMODE, $configCachemode, $comparison);
    }

    /**
     * Filter the query on the statuscode column
     *
     * Example usage:
     * <code>
     * $query->filterByStatuscode(1234); // WHERE statuscode = 1234
     * $query->filterByStatuscode(array(12, 34)); // WHERE statuscode IN (12, 34)
     * $query->filterByStatuscode(array('min' => 12)); // WHERE statuscode >= 12
     * $query->filterByStatuscode(array('max' => 12)); // WHERE statuscode <= 12
     * </code>
     *
     * @param     mixed $statuscode The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return RemoteHistoryContaoQuery The current query, for fluid interface
     */
    public function filterByStatuscode($statuscode = null, $comparison = null)
    {
        if (is_array($statuscode)) {
            $useMinMax = false;
            if (isset($statuscode['min'])) {
                $this->addUsingAlias(RemoteHistoryContaoPeer::STATUSCODE, $statuscode['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($statuscode['max'])) {
                $this->addUsingAlias(RemoteHistoryContaoPeer::STATUSCODE, $statuscode['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RemoteHistoryContaoPeer::STATUSCODE, $statuscode, $comparison);
    }

    /**
     * Filter the query on the extensions column
     *
     * @param     mixed $extensions The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return RemoteHistoryContaoQuery The current query, for fluid interface
     */
    public function filterByExtensions($extensions = null, $comparison = null)
    {
        if (is_object($extensions)) {
            $extensions = serialize($extensions);
        }

        return $this->addUsingAlias(RemoteHistoryContaoPeer::EXTENSIONS, $extensions, $comparison);
    }

    /**
     * Filter the query on the log column
     *
     * @param     mixed $log The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return RemoteHistoryContaoQuery The current query, for fluid interface
     */
    public function filterByLog($log = null, $comparison = null)
    {
        if (is_object($log)) {
            $log = serialize($log);
        }

        return $this->addUsingAlias(RemoteHistoryContaoPeer::LOG, $log, $comparison);
    }

    /**
     * Filter the query on the php column
     *
     * @param     mixed $pHP The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return RemoteHistoryContaoQuery The current query, for fluid interface
     */
    public function filterByPHP($pHP = null, $comparison = null)
    {
        if (is_object($pHP)) {
            $pHP = serialize($pHP);
        }

        return $this->addUsingAlias(RemoteHistoryContaoPeer::PHP, $pHP, $comparison);
    }

    /**
     * Filter the query on the mysql column
     *
     * @param     mixed $mySQL The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return RemoteHistoryContaoQuery The current query, for fluid interface
     */
    public function filterByMySQL($mySQL = null, $comparison = null)
    {
        if (is_object($mySQL)) {
            $mySQL = serialize($mySQL);
        }

        return $this->addUsingAlias(RemoteHistoryContaoPeer::MYSQL, $mySQL, $comparison);
    }

    /**
     * Filter the query by a related RemoteApp object
     *
     * @param   RemoteApp|PropelObjectCollection $remoteApp The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 RemoteHistoryContaoQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByRemoteApp($remoteApp, $comparison = null)
    {
        if ($remoteApp instanceof RemoteApp) {
            return $this
                ->addUsingAlias(RemoteHistoryContaoPeer::REMOTE_APP_ID, $remoteApp->getId(), $comparison);
        } elseif ($remoteApp instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(RemoteHistoryContaoPeer::REMOTE_APP_ID, $remoteApp->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByRemoteApp() only accepts arguments of type RemoteApp or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the RemoteApp relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return RemoteHistoryContaoQuery The current query, for fluid interface
     */
    public function joinRemoteApp($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('RemoteApp');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'RemoteApp');
        }

        return $this;
    }

    /**
     * Use the RemoteApp relation RemoteApp object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Slashworks\AppBundle\Model\RemoteAppQuery A secondary query class using the current class as primary query
     */
    public function useRemoteAppQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinRemoteApp($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'RemoteApp', '\Slashworks\AppBundle\Model\RemoteAppQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   RemoteHistoryContao $remoteHistoryContao Object to remove from the list of results
     *
     * @return RemoteHistoryContaoQuery The current query, for fluid interface
     */
    public function prune($remoteHistoryContao = null)
    {
        if ($remoteHistoryContao) {
            $this->addUsingAlias(RemoteHistoryContaoPeer::ID, $remoteHistoryContao->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}

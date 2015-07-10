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
use Slashworks\AppBundle\Model\ApiLog;
use Slashworks\AppBundle\Model\Customer;
use Slashworks\AppBundle\Model\RemoteApp;
use Slashworks\AppBundle\Model\RemoteAppPeer;
use Slashworks\AppBundle\Model\RemoteAppQuery;
use Slashworks\AppBundle\Model\RemoteHistoryContao;

/**
 * @method RemoteAppQuery orderById($order = Criteria::ASC) Order by the id column
 * @method RemoteAppQuery orderByType($order = Criteria::ASC) Order by the type column
 * @method RemoteAppQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method RemoteAppQuery orderByDomain($order = Criteria::ASC) Order by the domain column
 * @method RemoteAppQuery orderByApiUrl($order = Criteria::ASC) Order by the api_url column
 * @method RemoteAppQuery orderByApiAuthHttpUser($order = Criteria::ASC) Order by the api_auth_http_user column
 * @method RemoteAppQuery orderByApiAuthHttpPassword($order = Criteria::ASC) Order by the api_auth_http_password column
 * @method RemoteAppQuery orderByApiAuthType($order = Criteria::ASC) Order by the api_auth_type column
 * @method RemoteAppQuery orderByApiAuthUser($order = Criteria::ASC) Order by the api_auth_user column
 * @method RemoteAppQuery orderByApiAuthPassword($order = Criteria::ASC) Order by the api_auth_password column
 * @method RemoteAppQuery orderByApiAuthToken($order = Criteria::ASC) Order by the api_auth_token column
 * @method RemoteAppQuery orderByApiAuthUrlUserKey($order = Criteria::ASC) Order by the api_auth_url_user_key column
 * @method RemoteAppQuery orderByApiAuthUrlPwKey($order = Criteria::ASC) Order by the api_auth_url_pw_key column
 * @method RemoteAppQuery orderByCron($order = Criteria::ASC) Order by the cron column
 * @method RemoteAppQuery orderByCustomerId($order = Criteria::ASC) Order by the customer_id column
 * @method RemoteAppQuery orderByActivated($order = Criteria::ASC) Order by the activated column
 * @method RemoteAppQuery orderByNotes($order = Criteria::ASC) Order by the notes column
 * @method RemoteAppQuery orderByLastRun($order = Criteria::ASC) Order by the last_run column
 * @method RemoteAppQuery orderByIncludelog($order = Criteria::ASC) Order by the includeLog column
 * @method RemoteAppQuery orderByPublicKey($order = Criteria::ASC) Order by the public_key column
 * @method RemoteAppQuery orderByWebsiteHash($order = Criteria::ASC) Order by the website_hash column
 * @method RemoteAppQuery orderByNotificationRecipient($order = Criteria::ASC) Order by the notification_recipient column
 * @method RemoteAppQuery orderByNotificationSender($order = Criteria::ASC) Order by the notification_sender column
 * @method RemoteAppQuery orderByNotificationChange($order = Criteria::ASC) Order by the notification_change column
 * @method RemoteAppQuery orderByNotificationError($order = Criteria::ASC) Order by the notification_error column
 *
 * @method RemoteAppQuery groupById() Group by the id column
 * @method RemoteAppQuery groupByType() Group by the type column
 * @method RemoteAppQuery groupByName() Group by the name column
 * @method RemoteAppQuery groupByDomain() Group by the domain column
 * @method RemoteAppQuery groupByApiUrl() Group by the api_url column
 * @method RemoteAppQuery groupByApiAuthHttpUser() Group by the api_auth_http_user column
 * @method RemoteAppQuery groupByApiAuthHttpPassword() Group by the api_auth_http_password column
 * @method RemoteAppQuery groupByApiAuthType() Group by the api_auth_type column
 * @method RemoteAppQuery groupByApiAuthUser() Group by the api_auth_user column
 * @method RemoteAppQuery groupByApiAuthPassword() Group by the api_auth_password column
 * @method RemoteAppQuery groupByApiAuthToken() Group by the api_auth_token column
 * @method RemoteAppQuery groupByApiAuthUrlUserKey() Group by the api_auth_url_user_key column
 * @method RemoteAppQuery groupByApiAuthUrlPwKey() Group by the api_auth_url_pw_key column
 * @method RemoteAppQuery groupByCron() Group by the cron column
 * @method RemoteAppQuery groupByCustomerId() Group by the customer_id column
 * @method RemoteAppQuery groupByActivated() Group by the activated column
 * @method RemoteAppQuery groupByNotes() Group by the notes column
 * @method RemoteAppQuery groupByLastRun() Group by the last_run column
 * @method RemoteAppQuery groupByIncludelog() Group by the includeLog column
 * @method RemoteAppQuery groupByPublicKey() Group by the public_key column
 * @method RemoteAppQuery groupByWebsiteHash() Group by the website_hash column
 * @method RemoteAppQuery groupByNotificationRecipient() Group by the notification_recipient column
 * @method RemoteAppQuery groupByNotificationSender() Group by the notification_sender column
 * @method RemoteAppQuery groupByNotificationChange() Group by the notification_change column
 * @method RemoteAppQuery groupByNotificationError() Group by the notification_error column
 *
 * @method RemoteAppQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method RemoteAppQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method RemoteAppQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method RemoteAppQuery leftJoinCustomer($relationAlias = null) Adds a LEFT JOIN clause to the query using the Customer relation
 * @method RemoteAppQuery rightJoinCustomer($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Customer relation
 * @method RemoteAppQuery innerJoinCustomer($relationAlias = null) Adds a INNER JOIN clause to the query using the Customer relation
 *
 * @method RemoteAppQuery leftJoinApiLog($relationAlias = null) Adds a LEFT JOIN clause to the query using the ApiLog relation
 * @method RemoteAppQuery rightJoinApiLog($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ApiLog relation
 * @method RemoteAppQuery innerJoinApiLog($relationAlias = null) Adds a INNER JOIN clause to the query using the ApiLog relation
 *
 * @method RemoteAppQuery leftJoinRemoteHistoryContao($relationAlias = null) Adds a LEFT JOIN clause to the query using the RemoteHistoryContao relation
 * @method RemoteAppQuery rightJoinRemoteHistoryContao($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RemoteHistoryContao relation
 * @method RemoteAppQuery innerJoinRemoteHistoryContao($relationAlias = null) Adds a INNER JOIN clause to the query using the RemoteHistoryContao relation
 *
 * @method RemoteApp findOne(PropelPDO $con = null) Return the first RemoteApp matching the query
 * @method RemoteApp findOneOrCreate(PropelPDO $con = null) Return the first RemoteApp matching the query, or a new RemoteApp object populated from the query conditions when no match is found
 *
 * @method RemoteApp findOneByType(string $type) Return the first RemoteApp filtered by the type column
 * @method RemoteApp findOneByName(string $name) Return the first RemoteApp filtered by the name column
 * @method RemoteApp findOneByDomain(string $domain) Return the first RemoteApp filtered by the domain column
 * @method RemoteApp findOneByApiUrl(string $api_url) Return the first RemoteApp filtered by the api_url column
 * @method RemoteApp findOneByApiAuthHttpUser(string $api_auth_http_user) Return the first RemoteApp filtered by the api_auth_http_user column
 * @method RemoteApp findOneByApiAuthHttpPassword(string $api_auth_http_password) Return the first RemoteApp filtered by the api_auth_http_password column
 * @method RemoteApp findOneByApiAuthType(string $api_auth_type) Return the first RemoteApp filtered by the api_auth_type column
 * @method RemoteApp findOneByApiAuthUser(string $api_auth_user) Return the first RemoteApp filtered by the api_auth_user column
 * @method RemoteApp findOneByApiAuthPassword(string $api_auth_password) Return the first RemoteApp filtered by the api_auth_password column
 * @method RemoteApp findOneByApiAuthToken(string $api_auth_token) Return the first RemoteApp filtered by the api_auth_token column
 * @method RemoteApp findOneByApiAuthUrlUserKey(string $api_auth_url_user_key) Return the first RemoteApp filtered by the api_auth_url_user_key column
 * @method RemoteApp findOneByApiAuthUrlPwKey(string $api_auth_url_pw_key) Return the first RemoteApp filtered by the api_auth_url_pw_key column
 * @method RemoteApp findOneByCron(string $cron) Return the first RemoteApp filtered by the cron column
 * @method RemoteApp findOneByCustomerId(int $customer_id) Return the first RemoteApp filtered by the customer_id column
 * @method RemoteApp findOneByActivated(boolean $activated) Return the first RemoteApp filtered by the activated column
 * @method RemoteApp findOneByNotes(string $notes) Return the first RemoteApp filtered by the notes column
 * @method RemoteApp findOneByLastRun(string $last_run) Return the first RemoteApp filtered by the last_run column
 * @method RemoteApp findOneByIncludelog(boolean $includeLog) Return the first RemoteApp filtered by the includeLog column
 * @method RemoteApp findOneByPublicKey(string $public_key) Return the first RemoteApp filtered by the public_key column
 * @method RemoteApp findOneByWebsiteHash(string $website_hash) Return the first RemoteApp filtered by the website_hash column
 * @method RemoteApp findOneByNotificationRecipient(string $notification_recipient) Return the first RemoteApp filtered by the notification_recipient column
 * @method RemoteApp findOneByNotificationSender(string $notification_sender) Return the first RemoteApp filtered by the notification_sender column
 * @method RemoteApp findOneByNotificationChange(boolean $notification_change) Return the first RemoteApp filtered by the notification_change column
 * @method RemoteApp findOneByNotificationError(boolean $notification_error) Return the first RemoteApp filtered by the notification_error column
 *
 * @method array findById(int $id) Return RemoteApp objects filtered by the id column
 * @method array findByType(string $type) Return RemoteApp objects filtered by the type column
 * @method array findByName(string $name) Return RemoteApp objects filtered by the name column
 * @method array findByDomain(string $domain) Return RemoteApp objects filtered by the domain column
 * @method array findByApiUrl(string $api_url) Return RemoteApp objects filtered by the api_url column
 * @method array findByApiAuthHttpUser(string $api_auth_http_user) Return RemoteApp objects filtered by the api_auth_http_user column
 * @method array findByApiAuthHttpPassword(string $api_auth_http_password) Return RemoteApp objects filtered by the api_auth_http_password column
 * @method array findByApiAuthType(string $api_auth_type) Return RemoteApp objects filtered by the api_auth_type column
 * @method array findByApiAuthUser(string $api_auth_user) Return RemoteApp objects filtered by the api_auth_user column
 * @method array findByApiAuthPassword(string $api_auth_password) Return RemoteApp objects filtered by the api_auth_password column
 * @method array findByApiAuthToken(string $api_auth_token) Return RemoteApp objects filtered by the api_auth_token column
 * @method array findByApiAuthUrlUserKey(string $api_auth_url_user_key) Return RemoteApp objects filtered by the api_auth_url_user_key column
 * @method array findByApiAuthUrlPwKey(string $api_auth_url_pw_key) Return RemoteApp objects filtered by the api_auth_url_pw_key column
 * @method array findByCron(string $cron) Return RemoteApp objects filtered by the cron column
 * @method array findByCustomerId(int $customer_id) Return RemoteApp objects filtered by the customer_id column
 * @method array findByActivated(boolean $activated) Return RemoteApp objects filtered by the activated column
 * @method array findByNotes(string $notes) Return RemoteApp objects filtered by the notes column
 * @method array findByLastRun(string $last_run) Return RemoteApp objects filtered by the last_run column
 * @method array findByIncludelog(boolean $includeLog) Return RemoteApp objects filtered by the includeLog column
 * @method array findByPublicKey(string $public_key) Return RemoteApp objects filtered by the public_key column
 * @method array findByWebsiteHash(string $website_hash) Return RemoteApp objects filtered by the website_hash column
 * @method array findByNotificationRecipient(string $notification_recipient) Return RemoteApp objects filtered by the notification_recipient column
 * @method array findByNotificationSender(string $notification_sender) Return RemoteApp objects filtered by the notification_sender column
 * @method array findByNotificationChange(boolean $notification_change) Return RemoteApp objects filtered by the notification_change column
 * @method array findByNotificationError(boolean $notification_error) Return RemoteApp objects filtered by the notification_error column
 */
abstract class BaseRemoteAppQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseRemoteAppQuery object.
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
            $modelName = 'Slashworks\\AppBundle\\Model\\RemoteApp';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new RemoteAppQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   RemoteAppQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return RemoteAppQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof RemoteAppQuery) {
            return $criteria;
        }
        $query = new RemoteAppQuery(null, null, $modelAlias);

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
     * @return   RemoteApp|RemoteApp[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = RemoteAppPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(RemoteAppPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 RemoteApp A model object, or null if the key is not found
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
     * @return                 RemoteApp A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `type`, `name`, `domain`, `api_url`, `api_auth_http_user`, `api_auth_http_password`, `api_auth_type`, `api_auth_user`, `api_auth_password`, `api_auth_token`, `api_auth_url_user_key`, `api_auth_url_pw_key`, `cron`, `customer_id`, `activated`, `notes`, `last_run`, `includeLog`, `public_key`, `website_hash`, `notification_recipient`, `notification_sender`, `notification_change`, `notification_error` FROM `remote_app` WHERE `id` = :p0';
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
            $obj = new RemoteApp();
            $obj->hydrate($row);
            RemoteAppPeer::addInstanceToPool($obj, (string) $key);
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
     * @return RemoteApp|RemoteApp[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|RemoteApp[]|mixed the list of results, formatted by the current formatter
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
     * @return RemoteAppQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(RemoteAppPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return RemoteAppQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(RemoteAppPeer::ID, $keys, Criteria::IN);
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
     * @return RemoteAppQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(RemoteAppPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(RemoteAppPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RemoteAppPeer::ID, $id, $comparison);
    }

    /**
     * Filter the query on the type column
     *
     * Example usage:
     * <code>
     * $query->filterByType('fooValue');   // WHERE type = 'fooValue'
     * $query->filterByType('%fooValue%'); // WHERE type LIKE '%fooValue%'
     * </code>
     *
     * @param     string $type The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return RemoteAppQuery The current query, for fluid interface
     */
    public function filterByType($type = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($type)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $type)) {
                $type = str_replace('*', '%', $type);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(RemoteAppPeer::TYPE, $type, $comparison);
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
     * @return RemoteAppQuery The current query, for fluid interface
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

        return $this->addUsingAlias(RemoteAppPeer::NAME, $name, $comparison);
    }

    /**
     * Filter the query on the domain column
     *
     * Example usage:
     * <code>
     * $query->filterByDomain('fooValue');   // WHERE domain = 'fooValue'
     * $query->filterByDomain('%fooValue%'); // WHERE domain LIKE '%fooValue%'
     * </code>
     *
     * @param     string $domain The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return RemoteAppQuery The current query, for fluid interface
     */
    public function filterByDomain($domain = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($domain)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $domain)) {
                $domain = str_replace('*', '%', $domain);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(RemoteAppPeer::DOMAIN, $domain, $comparison);
    }

    /**
     * Filter the query on the api_url column
     *
     * Example usage:
     * <code>
     * $query->filterByApiUrl('fooValue');   // WHERE api_url = 'fooValue'
     * $query->filterByApiUrl('%fooValue%'); // WHERE api_url LIKE '%fooValue%'
     * </code>
     *
     * @param     string $apiUrl The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return RemoteAppQuery The current query, for fluid interface
     */
    public function filterByApiUrl($apiUrl = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($apiUrl)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $apiUrl)) {
                $apiUrl = str_replace('*', '%', $apiUrl);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(RemoteAppPeer::API_URL, $apiUrl, $comparison);
    }

    /**
     * Filter the query on the api_auth_http_user column
     *
     * Example usage:
     * <code>
     * $query->filterByApiAuthHttpUser('fooValue');   // WHERE api_auth_http_user = 'fooValue'
     * $query->filterByApiAuthHttpUser('%fooValue%'); // WHERE api_auth_http_user LIKE '%fooValue%'
     * </code>
     *
     * @param     string $apiAuthHttpUser The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return RemoteAppQuery The current query, for fluid interface
     */
    public function filterByApiAuthHttpUser($apiAuthHttpUser = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($apiAuthHttpUser)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $apiAuthHttpUser)) {
                $apiAuthHttpUser = str_replace('*', '%', $apiAuthHttpUser);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(RemoteAppPeer::API_AUTH_HTTP_USER, $apiAuthHttpUser, $comparison);
    }

    /**
     * Filter the query on the api_auth_http_password column
     *
     * Example usage:
     * <code>
     * $query->filterByApiAuthHttpPassword('fooValue');   // WHERE api_auth_http_password = 'fooValue'
     * $query->filterByApiAuthHttpPassword('%fooValue%'); // WHERE api_auth_http_password LIKE '%fooValue%'
     * </code>
     *
     * @param     string $apiAuthHttpPassword The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return RemoteAppQuery The current query, for fluid interface
     */
    public function filterByApiAuthHttpPassword($apiAuthHttpPassword = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($apiAuthHttpPassword)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $apiAuthHttpPassword)) {
                $apiAuthHttpPassword = str_replace('*', '%', $apiAuthHttpPassword);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(RemoteAppPeer::API_AUTH_HTTP_PASSWORD, $apiAuthHttpPassword, $comparison);
    }

    /**
     * Filter the query on the api_auth_type column
     *
     * Example usage:
     * <code>
     * $query->filterByApiAuthType('fooValue');   // WHERE api_auth_type = 'fooValue'
     * $query->filterByApiAuthType('%fooValue%'); // WHERE api_auth_type LIKE '%fooValue%'
     * </code>
     *
     * @param     string $apiAuthType The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return RemoteAppQuery The current query, for fluid interface
     */
    public function filterByApiAuthType($apiAuthType = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($apiAuthType)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $apiAuthType)) {
                $apiAuthType = str_replace('*', '%', $apiAuthType);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(RemoteAppPeer::API_AUTH_TYPE, $apiAuthType, $comparison);
    }

    /**
     * Filter the query on the api_auth_user column
     *
     * Example usage:
     * <code>
     * $query->filterByApiAuthUser('fooValue');   // WHERE api_auth_user = 'fooValue'
     * $query->filterByApiAuthUser('%fooValue%'); // WHERE api_auth_user LIKE '%fooValue%'
     * </code>
     *
     * @param     string $apiAuthUser The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return RemoteAppQuery The current query, for fluid interface
     */
    public function filterByApiAuthUser($apiAuthUser = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($apiAuthUser)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $apiAuthUser)) {
                $apiAuthUser = str_replace('*', '%', $apiAuthUser);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(RemoteAppPeer::API_AUTH_USER, $apiAuthUser, $comparison);
    }

    /**
     * Filter the query on the api_auth_password column
     *
     * Example usage:
     * <code>
     * $query->filterByApiAuthPassword('fooValue');   // WHERE api_auth_password = 'fooValue'
     * $query->filterByApiAuthPassword('%fooValue%'); // WHERE api_auth_password LIKE '%fooValue%'
     * </code>
     *
     * @param     string $apiAuthPassword The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return RemoteAppQuery The current query, for fluid interface
     */
    public function filterByApiAuthPassword($apiAuthPassword = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($apiAuthPassword)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $apiAuthPassword)) {
                $apiAuthPassword = str_replace('*', '%', $apiAuthPassword);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(RemoteAppPeer::API_AUTH_PASSWORD, $apiAuthPassword, $comparison);
    }

    /**
     * Filter the query on the api_auth_token column
     *
     * Example usage:
     * <code>
     * $query->filterByApiAuthToken('fooValue');   // WHERE api_auth_token = 'fooValue'
     * $query->filterByApiAuthToken('%fooValue%'); // WHERE api_auth_token LIKE '%fooValue%'
     * </code>
     *
     * @param     string $apiAuthToken The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return RemoteAppQuery The current query, for fluid interface
     */
    public function filterByApiAuthToken($apiAuthToken = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($apiAuthToken)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $apiAuthToken)) {
                $apiAuthToken = str_replace('*', '%', $apiAuthToken);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(RemoteAppPeer::API_AUTH_TOKEN, $apiAuthToken, $comparison);
    }

    /**
     * Filter the query on the api_auth_url_user_key column
     *
     * Example usage:
     * <code>
     * $query->filterByApiAuthUrlUserKey('fooValue');   // WHERE api_auth_url_user_key = 'fooValue'
     * $query->filterByApiAuthUrlUserKey('%fooValue%'); // WHERE api_auth_url_user_key LIKE '%fooValue%'
     * </code>
     *
     * @param     string $apiAuthUrlUserKey The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return RemoteAppQuery The current query, for fluid interface
     */
    public function filterByApiAuthUrlUserKey($apiAuthUrlUserKey = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($apiAuthUrlUserKey)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $apiAuthUrlUserKey)) {
                $apiAuthUrlUserKey = str_replace('*', '%', $apiAuthUrlUserKey);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(RemoteAppPeer::API_AUTH_URL_USER_KEY, $apiAuthUrlUserKey, $comparison);
    }

    /**
     * Filter the query on the api_auth_url_pw_key column
     *
     * Example usage:
     * <code>
     * $query->filterByApiAuthUrlPwKey('fooValue');   // WHERE api_auth_url_pw_key = 'fooValue'
     * $query->filterByApiAuthUrlPwKey('%fooValue%'); // WHERE api_auth_url_pw_key LIKE '%fooValue%'
     * </code>
     *
     * @param     string $apiAuthUrlPwKey The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return RemoteAppQuery The current query, for fluid interface
     */
    public function filterByApiAuthUrlPwKey($apiAuthUrlPwKey = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($apiAuthUrlPwKey)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $apiAuthUrlPwKey)) {
                $apiAuthUrlPwKey = str_replace('*', '%', $apiAuthUrlPwKey);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(RemoteAppPeer::API_AUTH_URL_PW_KEY, $apiAuthUrlPwKey, $comparison);
    }

    /**
     * Filter the query on the cron column
     *
     * Example usage:
     * <code>
     * $query->filterByCron('fooValue');   // WHERE cron = 'fooValue'
     * $query->filterByCron('%fooValue%'); // WHERE cron LIKE '%fooValue%'
     * </code>
     *
     * @param     string $cron The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return RemoteAppQuery The current query, for fluid interface
     */
    public function filterByCron($cron = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($cron)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $cron)) {
                $cron = str_replace('*', '%', $cron);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(RemoteAppPeer::CRON, $cron, $comparison);
    }

    /**
     * Filter the query on the customer_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCustomerId(1234); // WHERE customer_id = 1234
     * $query->filterByCustomerId(array(12, 34)); // WHERE customer_id IN (12, 34)
     * $query->filterByCustomerId(array('min' => 12)); // WHERE customer_id >= 12
     * $query->filterByCustomerId(array('max' => 12)); // WHERE customer_id <= 12
     * </code>
     *
     * @see       filterByCustomer()
     *
     * @param     mixed $customerId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return RemoteAppQuery The current query, for fluid interface
     */
    public function filterByCustomerId($customerId = null, $comparison = null)
    {
        if (is_array($customerId)) {
            $useMinMax = false;
            if (isset($customerId['min'])) {
                $this->addUsingAlias(RemoteAppPeer::CUSTOMER_ID, $customerId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($customerId['max'])) {
                $this->addUsingAlias(RemoteAppPeer::CUSTOMER_ID, $customerId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RemoteAppPeer::CUSTOMER_ID, $customerId, $comparison);
    }

    /**
     * Filter the query on the activated column
     *
     * Example usage:
     * <code>
     * $query->filterByActivated(true); // WHERE activated = true
     * $query->filterByActivated('yes'); // WHERE activated = true
     * </code>
     *
     * @param     boolean|string $activated The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return RemoteAppQuery The current query, for fluid interface
     */
    public function filterByActivated($activated = null, $comparison = null)
    {
        if (is_string($activated)) {
            $activated = in_array(strtolower($activated), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(RemoteAppPeer::ACTIVATED, $activated, $comparison);
    }

    /**
     * Filter the query on the notes column
     *
     * Example usage:
     * <code>
     * $query->filterByNotes('fooValue');   // WHERE notes = 'fooValue'
     * $query->filterByNotes('%fooValue%'); // WHERE notes LIKE '%fooValue%'
     * </code>
     *
     * @param     string $notes The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return RemoteAppQuery The current query, for fluid interface
     */
    public function filterByNotes($notes = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($notes)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $notes)) {
                $notes = str_replace('*', '%', $notes);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(RemoteAppPeer::NOTES, $notes, $comparison);
    }

    /**
     * Filter the query on the last_run column
     *
     * Example usage:
     * <code>
     * $query->filterByLastRun('2011-03-14'); // WHERE last_run = '2011-03-14'
     * $query->filterByLastRun('now'); // WHERE last_run = '2011-03-14'
     * $query->filterByLastRun(array('max' => 'yesterday')); // WHERE last_run < '2011-03-13'
     * </code>
     *
     * @param     mixed $lastRun The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return RemoteAppQuery The current query, for fluid interface
     */
    public function filterByLastRun($lastRun = null, $comparison = null)
    {
        if (is_array($lastRun)) {
            $useMinMax = false;
            if (isset($lastRun['min'])) {
                $this->addUsingAlias(RemoteAppPeer::LAST_RUN, $lastRun['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($lastRun['max'])) {
                $this->addUsingAlias(RemoteAppPeer::LAST_RUN, $lastRun['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RemoteAppPeer::LAST_RUN, $lastRun, $comparison);
    }

    /**
     * Filter the query on the includeLog column
     *
     * Example usage:
     * <code>
     * $query->filterByIncludelog(true); // WHERE includeLog = true
     * $query->filterByIncludelog('yes'); // WHERE includeLog = true
     * </code>
     *
     * @param     boolean|string $includelog The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return RemoteAppQuery The current query, for fluid interface
     */
    public function filterByIncludelog($includelog = null, $comparison = null)
    {
        if (is_string($includelog)) {
            $includelog = in_array(strtolower($includelog), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(RemoteAppPeer::INCLUDELOG, $includelog, $comparison);
    }

    /**
     * Filter the query on the public_key column
     *
     * Example usage:
     * <code>
     * $query->filterByPublicKey('fooValue');   // WHERE public_key = 'fooValue'
     * $query->filterByPublicKey('%fooValue%'); // WHERE public_key LIKE '%fooValue%'
     * </code>
     *
     * @param     string $publicKey The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return RemoteAppQuery The current query, for fluid interface
     */
    public function filterByPublicKey($publicKey = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($publicKey)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $publicKey)) {
                $publicKey = str_replace('*', '%', $publicKey);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(RemoteAppPeer::PUBLIC_KEY, $publicKey, $comparison);
    }

    /**
     * Filter the query on the website_hash column
     *
     * Example usage:
     * <code>
     * $query->filterByWebsiteHash('fooValue');   // WHERE website_hash = 'fooValue'
     * $query->filterByWebsiteHash('%fooValue%'); // WHERE website_hash LIKE '%fooValue%'
     * </code>
     *
     * @param     string $websiteHash The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return RemoteAppQuery The current query, for fluid interface
     */
    public function filterByWebsiteHash($websiteHash = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($websiteHash)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $websiteHash)) {
                $websiteHash = str_replace('*', '%', $websiteHash);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(RemoteAppPeer::WEBSITE_HASH, $websiteHash, $comparison);
    }

    /**
     * Filter the query on the notification_recipient column
     *
     * Example usage:
     * <code>
     * $query->filterByNotificationRecipient('fooValue');   // WHERE notification_recipient = 'fooValue'
     * $query->filterByNotificationRecipient('%fooValue%'); // WHERE notification_recipient LIKE '%fooValue%'
     * </code>
     *
     * @param     string $notificationRecipient The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return RemoteAppQuery The current query, for fluid interface
     */
    public function filterByNotificationRecipient($notificationRecipient = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($notificationRecipient)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $notificationRecipient)) {
                $notificationRecipient = str_replace('*', '%', $notificationRecipient);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(RemoteAppPeer::NOTIFICATION_RECIPIENT, $notificationRecipient, $comparison);
    }

    /**
     * Filter the query on the notification_sender column
     *
     * Example usage:
     * <code>
     * $query->filterByNotificationSender('fooValue');   // WHERE notification_sender = 'fooValue'
     * $query->filterByNotificationSender('%fooValue%'); // WHERE notification_sender LIKE '%fooValue%'
     * </code>
     *
     * @param     string $notificationSender The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return RemoteAppQuery The current query, for fluid interface
     */
    public function filterByNotificationSender($notificationSender = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($notificationSender)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $notificationSender)) {
                $notificationSender = str_replace('*', '%', $notificationSender);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(RemoteAppPeer::NOTIFICATION_SENDER, $notificationSender, $comparison);
    }

    /**
     * Filter the query on the notification_change column
     *
     * Example usage:
     * <code>
     * $query->filterByNotificationChange(true); // WHERE notification_change = true
     * $query->filterByNotificationChange('yes'); // WHERE notification_change = true
     * </code>
     *
     * @param     boolean|string $notificationChange The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return RemoteAppQuery The current query, for fluid interface
     */
    public function filterByNotificationChange($notificationChange = null, $comparison = null)
    {
        if (is_string($notificationChange)) {
            $notificationChange = in_array(strtolower($notificationChange), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(RemoteAppPeer::NOTIFICATION_CHANGE, $notificationChange, $comparison);
    }

    /**
     * Filter the query on the notification_error column
     *
     * Example usage:
     * <code>
     * $query->filterByNotificationError(true); // WHERE notification_error = true
     * $query->filterByNotificationError('yes'); // WHERE notification_error = true
     * </code>
     *
     * @param     boolean|string $notificationError The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return RemoteAppQuery The current query, for fluid interface
     */
    public function filterByNotificationError($notificationError = null, $comparison = null)
    {
        if (is_string($notificationError)) {
            $notificationError = in_array(strtolower($notificationError), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(RemoteAppPeer::NOTIFICATION_ERROR, $notificationError, $comparison);
    }

    /**
     * Filter the query by a related Customer object
     *
     * @param   Customer|PropelObjectCollection $customer The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 RemoteAppQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByCustomer($customer, $comparison = null)
    {
        if ($customer instanceof Customer) {
            return $this
                ->addUsingAlias(RemoteAppPeer::CUSTOMER_ID, $customer->getId(), $comparison);
        } elseif ($customer instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(RemoteAppPeer::CUSTOMER_ID, $customer->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByCustomer() only accepts arguments of type Customer or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Customer relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return RemoteAppQuery The current query, for fluid interface
     */
    public function joinCustomer($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Customer');

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
            $this->addJoinObject($join, 'Customer');
        }

        return $this;
    }

    /**
     * Use the Customer relation Customer object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Slashworks\AppBundle\Model\CustomerQuery A secondary query class using the current class as primary query
     */
    public function useCustomerQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinCustomer($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Customer', '\Slashworks\AppBundle\Model\CustomerQuery');
    }

    /**
     * Filter the query by a related ApiLog object
     *
     * @param   ApiLog|PropelObjectCollection $apiLog  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 RemoteAppQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByApiLog($apiLog, $comparison = null)
    {
        if ($apiLog instanceof ApiLog) {
            return $this
                ->addUsingAlias(RemoteAppPeer::ID, $apiLog->getRemoteAppId(), $comparison);
        } elseif ($apiLog instanceof PropelObjectCollection) {
            return $this
                ->useApiLogQuery()
                ->filterByPrimaryKeys($apiLog->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByApiLog() only accepts arguments of type ApiLog or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ApiLog relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return RemoteAppQuery The current query, for fluid interface
     */
    public function joinApiLog($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ApiLog');

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
            $this->addJoinObject($join, 'ApiLog');
        }

        return $this;
    }

    /**
     * Use the ApiLog relation ApiLog object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Slashworks\AppBundle\Model\ApiLogQuery A secondary query class using the current class as primary query
     */
    public function useApiLogQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinApiLog($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ApiLog', '\Slashworks\AppBundle\Model\ApiLogQuery');
    }

    /**
     * Filter the query by a related RemoteHistoryContao object
     *
     * @param   RemoteHistoryContao|PropelObjectCollection $remoteHistoryContao  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 RemoteAppQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByRemoteHistoryContao($remoteHistoryContao, $comparison = null)
    {
        if ($remoteHistoryContao instanceof RemoteHistoryContao) {
            return $this
                ->addUsingAlias(RemoteAppPeer::ID, $remoteHistoryContao->getRemoteAppId(), $comparison);
        } elseif ($remoteHistoryContao instanceof PropelObjectCollection) {
            return $this
                ->useRemoteHistoryContaoQuery()
                ->filterByPrimaryKeys($remoteHistoryContao->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByRemoteHistoryContao() only accepts arguments of type RemoteHistoryContao or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the RemoteHistoryContao relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return RemoteAppQuery The current query, for fluid interface
     */
    public function joinRemoteHistoryContao($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('RemoteHistoryContao');

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
            $this->addJoinObject($join, 'RemoteHistoryContao');
        }

        return $this;
    }

    /**
     * Use the RemoteHistoryContao relation RemoteHistoryContao object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Slashworks\AppBundle\Model\RemoteHistoryContaoQuery A secondary query class using the current class as primary query
     */
    public function useRemoteHistoryContaoQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinRemoteHistoryContao($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'RemoteHistoryContao', '\Slashworks\AppBundle\Model\RemoteHistoryContaoQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   RemoteApp $remoteApp Object to remove from the list of results
     *
     * @return RemoteAppQuery The current query, for fluid interface
     */
    public function prune($remoteApp = null)
    {
        if ($remoteApp) {
            $this->addUsingAlias(RemoteAppPeer::ID, $remoteApp->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}

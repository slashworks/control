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
use Slashworks\AppBundle\Model\ApiLogPeer;
use Slashworks\AppBundle\Model\ApiLogQuery;
use Slashworks\AppBundle\Model\RemoteApp;

/**
 * @method ApiLogQuery orderById($order = Criteria::ASC) Order by the id column
 * @method ApiLogQuery orderByDtCall($order = Criteria::ASC) Order by the dt_call column
 * @method ApiLogQuery orderByRemoteAppId($order = Criteria::ASC) Order by the remote_app_id column
 * @method ApiLogQuery orderByStatuscode($order = Criteria::ASC) Order by the statuscode column
 * @method ApiLogQuery orderByLastResponse($order = Criteria::ASC) Order by the last_response column
 *
 * @method ApiLogQuery groupById() Group by the id column
 * @method ApiLogQuery groupByDtCall() Group by the dt_call column
 * @method ApiLogQuery groupByRemoteAppId() Group by the remote_app_id column
 * @method ApiLogQuery groupByStatuscode() Group by the statuscode column
 * @method ApiLogQuery groupByLastResponse() Group by the last_response column
 *
 * @method ApiLogQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method ApiLogQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method ApiLogQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method ApiLogQuery leftJoinRemoteApp($relationAlias = null) Adds a LEFT JOIN clause to the query using the RemoteApp relation
 * @method ApiLogQuery rightJoinRemoteApp($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RemoteApp relation
 * @method ApiLogQuery innerJoinRemoteApp($relationAlias = null) Adds a INNER JOIN clause to the query using the RemoteApp relation
 *
 * @method ApiLog findOne(PropelPDO $con = null) Return the first ApiLog matching the query
 * @method ApiLog findOneOrCreate(PropelPDO $con = null) Return the first ApiLog matching the query, or a new ApiLog object populated from the query conditions when no match is found
 *
 * @method ApiLog findOneByDtCall(string $dt_call) Return the first ApiLog filtered by the dt_call column
 * @method ApiLog findOneByRemoteAppId(int $remote_app_id) Return the first ApiLog filtered by the remote_app_id column
 * @method ApiLog findOneByStatuscode(int $statuscode) Return the first ApiLog filtered by the statuscode column
 * @method ApiLog findOneByLastResponse(resource $last_response) Return the first ApiLog filtered by the last_response column
 *
 * @method array findById(int $id) Return ApiLog objects filtered by the id column
 * @method array findByDtCall(string $dt_call) Return ApiLog objects filtered by the dt_call column
 * @method array findByRemoteAppId(int $remote_app_id) Return ApiLog objects filtered by the remote_app_id column
 * @method array findByStatuscode(int $statuscode) Return ApiLog objects filtered by the statuscode column
 * @method array findByLastResponse(resource $last_response) Return ApiLog objects filtered by the last_response column
 */
abstract class BaseApiLogQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseApiLogQuery object.
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
            $modelName = 'Slashworks\\AppBundle\\Model\\ApiLog';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ApiLogQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   ApiLogQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return ApiLogQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof ApiLogQuery) {
            return $criteria;
        }
        $query = new ApiLogQuery(null, null, $modelAlias);

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
     * @return   ApiLog|ApiLog[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ApiLogPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(ApiLogPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 ApiLog A model object, or null if the key is not found
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
     * @return                 ApiLog A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `dt_call`, `remote_app_id`, `statuscode`, `last_response` FROM `api_log` WHERE `id` = :p0';
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
            $obj = new ApiLog();
            $obj->hydrate($row);
            ApiLogPeer::addInstanceToPool($obj, (string) $key);
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
     * @return ApiLog|ApiLog[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|ApiLog[]|mixed the list of results, formatted by the current formatter
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
     * @return ApiLogQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ApiLogPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ApiLogQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ApiLogPeer::ID, $keys, Criteria::IN);
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
     * @return ApiLogQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ApiLogPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ApiLogPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApiLogPeer::ID, $id, $comparison);
    }

    /**
     * Filter the query on the dt_call column
     *
     * Example usage:
     * <code>
     * $query->filterByDtCall('2011-03-14'); // WHERE dt_call = '2011-03-14'
     * $query->filterByDtCall('now'); // WHERE dt_call = '2011-03-14'
     * $query->filterByDtCall(array('max' => 'yesterday')); // WHERE dt_call < '2011-03-13'
     * </code>
     *
     * @param     mixed $dtCall The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ApiLogQuery The current query, for fluid interface
     */
    public function filterByDtCall($dtCall = null, $comparison = null)
    {
        if (is_array($dtCall)) {
            $useMinMax = false;
            if (isset($dtCall['min'])) {
                $this->addUsingAlias(ApiLogPeer::DT_CALL, $dtCall['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dtCall['max'])) {
                $this->addUsingAlias(ApiLogPeer::DT_CALL, $dtCall['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApiLogPeer::DT_CALL, $dtCall, $comparison);
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
     * @return ApiLogQuery The current query, for fluid interface
     */
    public function filterByRemoteAppId($remoteAppId = null, $comparison = null)
    {
        if (is_array($remoteAppId)) {
            $useMinMax = false;
            if (isset($remoteAppId['min'])) {
                $this->addUsingAlias(ApiLogPeer::REMOTE_APP_ID, $remoteAppId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($remoteAppId['max'])) {
                $this->addUsingAlias(ApiLogPeer::REMOTE_APP_ID, $remoteAppId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApiLogPeer::REMOTE_APP_ID, $remoteAppId, $comparison);
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
     * @return ApiLogQuery The current query, for fluid interface
     */
    public function filterByStatuscode($statuscode = null, $comparison = null)
    {
        if (is_array($statuscode)) {
            $useMinMax = false;
            if (isset($statuscode['min'])) {
                $this->addUsingAlias(ApiLogPeer::STATUSCODE, $statuscode['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($statuscode['max'])) {
                $this->addUsingAlias(ApiLogPeer::STATUSCODE, $statuscode['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApiLogPeer::STATUSCODE, $statuscode, $comparison);
    }

    /**
     * Filter the query on the last_response column
     *
     * @param     mixed $lastResponse The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ApiLogQuery The current query, for fluid interface
     */
    public function filterByLastResponse($lastResponse = null, $comparison = null)
    {

        return $this->addUsingAlias(ApiLogPeer::LAST_RESPONSE, $lastResponse, $comparison);
    }

    /**
     * Filter the query by a related RemoteApp object
     *
     * @param   RemoteApp|PropelObjectCollection $remoteApp The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ApiLogQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByRemoteApp($remoteApp, $comparison = null)
    {
        if ($remoteApp instanceof RemoteApp) {
            return $this
                ->addUsingAlias(ApiLogPeer::REMOTE_APP_ID, $remoteApp->getId(), $comparison);
        } elseif ($remoteApp instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ApiLogPeer::REMOTE_APP_ID, $remoteApp->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return ApiLogQuery The current query, for fluid interface
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
     * @param   ApiLog $apiLog Object to remove from the list of results
     *
     * @return ApiLogQuery The current query, for fluid interface
     */
    public function prune($apiLog = null)
    {
        if ($apiLog) {
            $this->addUsingAlias(ApiLogPeer::ID, $apiLog->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}

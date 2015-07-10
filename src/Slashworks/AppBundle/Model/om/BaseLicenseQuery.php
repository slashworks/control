<?php

namespace Slashworks\AppBundle\Model\om;

use \Criteria;
use \Exception;
use \ModelCriteria;
use \PDO;
use \Propel;
use \PropelException;
use \PropelObjectCollection;
use \PropelPDO;
use Slashworks\AppBundle\Model\License;
use Slashworks\AppBundle\Model\LicensePeer;
use Slashworks\AppBundle\Model\LicenseQuery;

/**
 * @method LicenseQuery orderById($order = Criteria::ASC) Order by the id column
 * @method LicenseQuery orderByMaxClients($order = Criteria::ASC) Order by the max_clients column
 * @method LicenseQuery orderByDomain($order = Criteria::ASC) Order by the domain column
 * @method LicenseQuery orderByValidUntil($order = Criteria::ASC) Order by the valid_until column
 * @method LicenseQuery orderBySerial($order = Criteria::ASC) Order by the serial column
 *
 * @method LicenseQuery groupById() Group by the id column
 * @method LicenseQuery groupByMaxClients() Group by the max_clients column
 * @method LicenseQuery groupByDomain() Group by the domain column
 * @method LicenseQuery groupByValidUntil() Group by the valid_until column
 * @method LicenseQuery groupBySerial() Group by the serial column
 *
 * @method LicenseQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method LicenseQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method LicenseQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method License findOne(PropelPDO $con = null) Return the first License matching the query
 * @method License findOneOrCreate(PropelPDO $con = null) Return the first License matching the query, or a new License object populated from the query conditions when no match is found
 *
 * @method License findOneByMaxClients(int $max_clients) Return the first License filtered by the max_clients column
 * @method License findOneByDomain(string $domain) Return the first License filtered by the domain column
 * @method License findOneByValidUntil(string $valid_until) Return the first License filtered by the valid_until column
 * @method License findOneBySerial(string $serial) Return the first License filtered by the serial column
 *
 * @method array findById(int $id) Return License objects filtered by the id column
 * @method array findByMaxClients(int $max_clients) Return License objects filtered by the max_clients column
 * @method array findByDomain(string $domain) Return License objects filtered by the domain column
 * @method array findByValidUntil(string $valid_until) Return License objects filtered by the valid_until column
 * @method array findBySerial(string $serial) Return License objects filtered by the serial column
 */
abstract class BaseLicenseQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseLicenseQuery object.
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
            $modelName = 'Slashworks\\AppBundle\\Model\\License';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new LicenseQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   LicenseQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return LicenseQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof LicenseQuery) {
            return $criteria;
        }
        $query = new LicenseQuery(null, null, $modelAlias);

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
     * @return   License|License[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = LicensePeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(LicensePeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 License A model object, or null if the key is not found
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
     * @return                 License A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `max_clients`, `domain`, `valid_until`, `serial` FROM `license` WHERE `id` = :p0';
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
            $obj = new License();
            $obj->hydrate($row);
            LicensePeer::addInstanceToPool($obj, (string) $key);
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
     * @return License|License[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|License[]|mixed the list of results, formatted by the current formatter
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
     * @return LicenseQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(LicensePeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return LicenseQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(LicensePeer::ID, $keys, Criteria::IN);
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
     * @return LicenseQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(LicensePeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(LicensePeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(LicensePeer::ID, $id, $comparison);
    }

    /**
     * Filter the query on the max_clients column
     *
     * Example usage:
     * <code>
     * $query->filterByMaxClients(1234); // WHERE max_clients = 1234
     * $query->filterByMaxClients(array(12, 34)); // WHERE max_clients IN (12, 34)
     * $query->filterByMaxClients(array('min' => 12)); // WHERE max_clients >= 12
     * $query->filterByMaxClients(array('max' => 12)); // WHERE max_clients <= 12
     * </code>
     *
     * @param     mixed $maxClients The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return LicenseQuery The current query, for fluid interface
     */
    public function filterByMaxClients($maxClients = null, $comparison = null)
    {
        if (is_array($maxClients)) {
            $useMinMax = false;
            if (isset($maxClients['min'])) {
                $this->addUsingAlias(LicensePeer::MAX_CLIENTS, $maxClients['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($maxClients['max'])) {
                $this->addUsingAlias(LicensePeer::MAX_CLIENTS, $maxClients['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(LicensePeer::MAX_CLIENTS, $maxClients, $comparison);
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
     * @return LicenseQuery The current query, for fluid interface
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

        return $this->addUsingAlias(LicensePeer::DOMAIN, $domain, $comparison);
    }

    /**
     * Filter the query on the valid_until column
     *
     * Example usage:
     * <code>
     * $query->filterByValidUntil('fooValue');   // WHERE valid_until = 'fooValue'
     * $query->filterByValidUntil('%fooValue%'); // WHERE valid_until LIKE '%fooValue%'
     * </code>
     *
     * @param     string $validUntil The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return LicenseQuery The current query, for fluid interface
     */
    public function filterByValidUntil($validUntil = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($validUntil)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $validUntil)) {
                $validUntil = str_replace('*', '%', $validUntil);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(LicensePeer::VALID_UNTIL, $validUntil, $comparison);
    }

    /**
     * Filter the query on the serial column
     *
     * Example usage:
     * <code>
     * $query->filterBySerial('fooValue');   // WHERE serial = 'fooValue'
     * $query->filterBySerial('%fooValue%'); // WHERE serial LIKE '%fooValue%'
     * </code>
     *
     * @param     string $serial The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return LicenseQuery The current query, for fluid interface
     */
    public function filterBySerial($serial = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($serial)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $serial)) {
                $serial = str_replace('*', '%', $serial);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(LicensePeer::SERIAL, $serial, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   License $license Object to remove from the list of results
     *
     * @return LicenseQuery The current query, for fluid interface
     */
    public function prune($license = null)
    {
        if ($license) {
            $this->addUsingAlias(LicensePeer::ID, $license->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}

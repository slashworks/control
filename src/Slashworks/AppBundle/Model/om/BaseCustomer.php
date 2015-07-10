<?php

namespace Slashworks\AppBundle\Model\om;

use \BaseObject;
use \BasePeer;
use \Criteria;
use \DateTime;
use \Exception;
use \PDO;
use \Persistent;
use \Propel;
use \PropelCollection;
use \PropelDateTime;
use \PropelException;
use \PropelObjectCollection;
use \PropelPDO;
use Slashworks\AppBundle\Model\Country;
use Slashworks\AppBundle\Model\CountryQuery;
use Slashworks\AppBundle\Model\Customer;
use Slashworks\AppBundle\Model\CustomerPeer;
use Slashworks\AppBundle\Model\CustomerQuery;
use Slashworks\AppBundle\Model\RemoteApp;
use Slashworks\AppBundle\Model\RemoteAppQuery;
use Slashworks\AppBundle\Model\UserCustomerRelation;
use Slashworks\AppBundle\Model\UserCustomerRelationQuery;

abstract class BaseCustomer extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'Slashworks\\AppBundle\\Model\\CustomerPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        CustomerPeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinite loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the id field.
     * @var        int
     */
    protected $id;

    /**
     * The value for the name field.
     * @var        string
     */
    protected $name;

    /**
     * The value for the street field.
     * @var        string
     */
    protected $street;

    /**
     * The value for the zip field.
     * @var        string
     */
    protected $zip;

    /**
     * The value for the city field.
     * @var        string
     */
    protected $city;

    /**
     * The value for the country_id field.
     * @var        int
     */
    protected $country_id;

    /**
     * The value for the phone field.
     * @var        string
     */
    protected $phone;

    /**
     * The value for the fax field.
     * @var        string
     */
    protected $fax;

    /**
     * The value for the email field.
     * @var        string
     */
    protected $email;

    /**
     * The value for the legalform field.
     * @var        string
     */
    protected $legalform;

    /**
     * The value for the logo field.
     * @var        string
     */
    protected $logo;

    /**
     * The value for the created field.
     * @var        string
     */
    protected $created;

    /**
     * The value for the notes field.
     * @var        string
     */
    protected $notes;

    /**
     * @var        Country
     */
    protected $aCountry;

    /**
     * @var        PropelObjectCollection|RemoteApp[] Collection to store aggregation of RemoteApp objects.
     */
    protected $collRemoteApps;
    protected $collRemoteAppsPartial;

    /**
     * @var        PropelObjectCollection|UserCustomerRelation[] Collection to store aggregation of UserCustomerRelation objects.
     */
    protected $collUserCustomerRelations;
    protected $collUserCustomerRelationsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     * @var        boolean
     */
    protected $alreadyInSave = false;

    /**
     * Flag to prevent endless validation loop, if this object is referenced
     * by another object which falls in this transaction.
     * @var        boolean
     */
    protected $alreadyInValidation = false;

    /**
     * Flag to prevent endless clearAllReferences($deep=true) loop, if this object is referenced
     * @var        boolean
     */
    protected $alreadyInClearAllReferencesDeep = false;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $remoteAppsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $userCustomerRelationsScheduledForDeletion = null;

    /**
     * Get the [id] column value.
     *
     * @return int
     */
    public function getId()
    {

        return $this->id;
    }

    /**
     * Get the [name] column value.
     *
     * @return string
     */
    public function getName()
    {

        return $this->name;
    }

    /**
     * Get the [street] column value.
     *
     * @return string
     */
    public function getStreet()
    {

        return $this->street;
    }

    /**
     * Get the [zip] column value.
     *
     * @return string
     */
    public function getZip()
    {

        return $this->zip;
    }

    /**
     * Get the [city] column value.
     *
     * @return string
     */
    public function getCity()
    {

        return $this->city;
    }

    /**
     * Get the [country_id] column value.
     *
     * @return int
     */
    public function getCountryId()
    {

        return $this->country_id;
    }

    /**
     * Get the [phone] column value.
     *
     * @return string
     */
    public function getPhone()
    {

        return $this->phone;
    }

    /**
     * Get the [fax] column value.
     *
     * @return string
     */
    public function getFax()
    {

        return $this->fax;
    }

    /**
     * Get the [email] column value.
     *
     * @return string
     */
    public function getEmail()
    {

        return $this->email;
    }

    /**
     * Get the [legalform] column value.
     *
     * @return string
     */
    public function getLegalform()
    {

        return $this->legalform;
    }

    /**
     * Get the [logo] column value.
     *
     * @return string
     */
    public function getLogo()
    {

        return $this->logo;
    }

    /**
     * Get the [optionally formatted] temporal [created] column value.
     *
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null, and 0 if column value is 0000-00-00 00:00:00
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getCreated($format = null)
    {
        if ($this->created === null) {
            return null;
        }

        if ($this->created === '0000-00-00 00:00:00') {
            // while technically this is not a default value of null,
            // this seems to be closest in meaning.
            return null;
        }

        try {
            $dt = new DateTime($this->created);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->created, true), $x);
        }

        if ($format === null) {
            // Because propel.useDateTimeClass is true, we return a DateTime object.
            return $dt;
        }

        if (strpos($format, '%') !== false) {
            return strftime($format, $dt->format('U'));
        }

        return $dt->format($format);

    }

    /**
     * Get the [notes] column value.
     *
     * @return string
     */
    public function getNotes()
    {

        return $this->notes;
    }

    /**
     * Set the value of [id] column.
     *
     * @param  int $v new value
     * @return Customer The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[] = CustomerPeer::ID;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [name] column.
     *
     * @param  string $v new value
     * @return Customer The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[] = CustomerPeer::NAME;
        }


        return $this;
    } // setName()

    /**
     * Set the value of [street] column.
     *
     * @param  string $v new value
     * @return Customer The current object (for fluent API support)
     */
    public function setStreet($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->street !== $v) {
            $this->street = $v;
            $this->modifiedColumns[] = CustomerPeer::STREET;
        }


        return $this;
    } // setStreet()

    /**
     * Set the value of [zip] column.
     *
     * @param  string $v new value
     * @return Customer The current object (for fluent API support)
     */
    public function setZip($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->zip !== $v) {
            $this->zip = $v;
            $this->modifiedColumns[] = CustomerPeer::ZIP;
        }


        return $this;
    } // setZip()

    /**
     * Set the value of [city] column.
     *
     * @param  string $v new value
     * @return Customer The current object (for fluent API support)
     */
    public function setCity($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->city !== $v) {
            $this->city = $v;
            $this->modifiedColumns[] = CustomerPeer::CITY;
        }


        return $this;
    } // setCity()

    /**
     * Set the value of [country_id] column.
     *
     * @param  int $v new value
     * @return Customer The current object (for fluent API support)
     */
    public function setCountryId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->country_id !== $v) {
            $this->country_id = $v;
            $this->modifiedColumns[] = CustomerPeer::COUNTRY_ID;
        }

        if ($this->aCountry !== null && $this->aCountry->getId() !== $v) {
            $this->aCountry = null;
        }


        return $this;
    } // setCountryId()

    /**
     * Set the value of [phone] column.
     *
     * @param  string $v new value
     * @return Customer The current object (for fluent API support)
     */
    public function setPhone($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->phone !== $v) {
            $this->phone = $v;
            $this->modifiedColumns[] = CustomerPeer::PHONE;
        }


        return $this;
    } // setPhone()

    /**
     * Set the value of [fax] column.
     *
     * @param  string $v new value
     * @return Customer The current object (for fluent API support)
     */
    public function setFax($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->fax !== $v) {
            $this->fax = $v;
            $this->modifiedColumns[] = CustomerPeer::FAX;
        }


        return $this;
    } // setFax()

    /**
     * Set the value of [email] column.
     *
     * @param  string $v new value
     * @return Customer The current object (for fluent API support)
     */
    public function setEmail($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->email !== $v) {
            $this->email = $v;
            $this->modifiedColumns[] = CustomerPeer::EMAIL;
        }


        return $this;
    } // setEmail()

    /**
     * Set the value of [legalform] column.
     *
     * @param  string $v new value
     * @return Customer The current object (for fluent API support)
     */
    public function setLegalform($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->legalform !== $v) {
            $this->legalform = $v;
            $this->modifiedColumns[] = CustomerPeer::LEGALFORM;
        }


        return $this;
    } // setLegalform()

    /**
     * Set the value of [logo] column.
     *
     * @param  string $v new value
     * @return Customer The current object (for fluent API support)
     */
    public function setLogo($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->logo !== $v) {
            $this->logo = $v;
            $this->modifiedColumns[] = CustomerPeer::LOGO;
        }


        return $this;
    } // setLogo()

    /**
     * Sets the value of [created] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Customer The current object (for fluent API support)
     */
    public function setCreated($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created !== null || $dt !== null) {
            $currentDateAsString = ($this->created !== null && $tmpDt = new DateTime($this->created)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->created = $newDateAsString;
                $this->modifiedColumns[] = CustomerPeer::CREATED;
            }
        } // if either are not null


        return $this;
    } // setCreated()

    /**
     * Set the value of [notes] column.
     *
     * @param  string $v new value
     * @return Customer The current object (for fluent API support)
     */
    public function setNotes($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->notes !== $v) {
            $this->notes = $v;
            $this->modifiedColumns[] = CustomerPeer::NOTES;
        }


        return $this;
    } // setNotes()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
        // otherwise, everything was equal, so return true
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array $row The row returned by PDOStatement->fetch(PDO::FETCH_NUM)
     * @param int $startcol 0-based offset column which indicates which resultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false)
    {
        try {

            $this->id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->name = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
            $this->street = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
            $this->zip = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
            $this->city = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
            $this->country_id = ($row[$startcol + 5] !== null) ? (int) $row[$startcol + 5] : null;
            $this->phone = ($row[$startcol + 6] !== null) ? (string) $row[$startcol + 6] : null;
            $this->fax = ($row[$startcol + 7] !== null) ? (string) $row[$startcol + 7] : null;
            $this->email = ($row[$startcol + 8] !== null) ? (string) $row[$startcol + 8] : null;
            $this->legalform = ($row[$startcol + 9] !== null) ? (string) $row[$startcol + 9] : null;
            $this->logo = ($row[$startcol + 10] !== null) ? (string) $row[$startcol + 10] : null;
            $this->created = ($row[$startcol + 11] !== null) ? (string) $row[$startcol + 11] : null;
            $this->notes = ($row[$startcol + 12] !== null) ? (string) $row[$startcol + 12] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);

            return $startcol + 13; // 13 = CustomerPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Customer object", $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {

        if ($this->aCountry !== null && $this->country_id !== $this->aCountry->getId()) {
            $this->aCountry = null;
        }
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param boolean $deep (optional) Whether to also de-associated any related objects.
     * @param PropelPDO $con (optional) The PropelPDO connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getConnection(CustomerPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = CustomerPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aCountry = null;
            $this->collRemoteApps = null;

            $this->collUserCustomerRelations = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param PropelPDO $con
     * @return void
     * @throws PropelException
     * @throws Exception
     * @see        BaseObject::setDeleted()
     * @see        BaseObject::isDeleted()
     */
    public function delete(PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getConnection(CustomerPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = CustomerQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $con->commit();
                $this->setDeleted(true);
            } else {
                $con->commit();
            }
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param PropelPDO $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @throws Exception
     * @see        doSave()
     */
    public function save(PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getConnection(CustomerPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        $isInsert = $this->isNew();
        try {
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                CustomerPeer::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param PropelPDO $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see        save()
     */
    protected function doSave(PropelPDO $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aCountry !== null) {
                if ($this->aCountry->isModified() || $this->aCountry->isNew()) {
                    $affectedRows += $this->aCountry->save($con);
                }
                $this->setCountry($this->aCountry);
            }

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                } else {
                    $this->doUpdate($con);
                }
                $affectedRows += 1;
                $this->resetModified();
            }

            if ($this->remoteAppsScheduledForDeletion !== null) {
                if (!$this->remoteAppsScheduledForDeletion->isEmpty()) {
                    foreach ($this->remoteAppsScheduledForDeletion as $remoteApp) {
                        // need to save related object because we set the relation to null
                        $remoteApp->save($con);
                    }
                    $this->remoteAppsScheduledForDeletion = null;
                }
            }

            if ($this->collRemoteApps !== null) {
                foreach ($this->collRemoteApps as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->userCustomerRelationsScheduledForDeletion !== null) {
                if (!$this->userCustomerRelationsScheduledForDeletion->isEmpty()) {
                    UserCustomerRelationQuery::create()
                        ->filterByPrimaryKeys($this->userCustomerRelationsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->userCustomerRelationsScheduledForDeletion = null;
                }
            }

            if ($this->collUserCustomerRelations !== null) {
                foreach ($this->collUserCustomerRelations as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param PropelPDO $con
     *
     * @throws PropelException
     * @see        doSave()
     */
    protected function doInsert(PropelPDO $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[] = CustomerPeer::ID;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . CustomerPeer::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(CustomerPeer::ID)) {
            $modifiedColumns[':p' . $index++]  = '`id`';
        }
        if ($this->isColumnModified(CustomerPeer::NAME)) {
            $modifiedColumns[':p' . $index++]  = '`name`';
        }
        if ($this->isColumnModified(CustomerPeer::STREET)) {
            $modifiedColumns[':p' . $index++]  = '`street`';
        }
        if ($this->isColumnModified(CustomerPeer::ZIP)) {
            $modifiedColumns[':p' . $index++]  = '`zip`';
        }
        if ($this->isColumnModified(CustomerPeer::CITY)) {
            $modifiedColumns[':p' . $index++]  = '`city`';
        }
        if ($this->isColumnModified(CustomerPeer::COUNTRY_ID)) {
            $modifiedColumns[':p' . $index++]  = '`country_id`';
        }
        if ($this->isColumnModified(CustomerPeer::PHONE)) {
            $modifiedColumns[':p' . $index++]  = '`phone`';
        }
        if ($this->isColumnModified(CustomerPeer::FAX)) {
            $modifiedColumns[':p' . $index++]  = '`fax`';
        }
        if ($this->isColumnModified(CustomerPeer::EMAIL)) {
            $modifiedColumns[':p' . $index++]  = '`email`';
        }
        if ($this->isColumnModified(CustomerPeer::LEGALFORM)) {
            $modifiedColumns[':p' . $index++]  = '`legalform`';
        }
        if ($this->isColumnModified(CustomerPeer::LOGO)) {
            $modifiedColumns[':p' . $index++]  = '`logo`';
        }
        if ($this->isColumnModified(CustomerPeer::CREATED)) {
            $modifiedColumns[':p' . $index++]  = '`created`';
        }
        if ($this->isColumnModified(CustomerPeer::NOTES)) {
            $modifiedColumns[':p' . $index++]  = '`notes`';
        }

        $sql = sprintf(
            'INSERT INTO `customer` (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '`id`':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case '`name`':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case '`street`':
                        $stmt->bindValue($identifier, $this->street, PDO::PARAM_STR);
                        break;
                    case '`zip`':
                        $stmt->bindValue($identifier, $this->zip, PDO::PARAM_STR);
                        break;
                    case '`city`':
                        $stmt->bindValue($identifier, $this->city, PDO::PARAM_STR);
                        break;
                    case '`country_id`':
                        $stmt->bindValue($identifier, $this->country_id, PDO::PARAM_INT);
                        break;
                    case '`phone`':
                        $stmt->bindValue($identifier, $this->phone, PDO::PARAM_STR);
                        break;
                    case '`fax`':
                        $stmt->bindValue($identifier, $this->fax, PDO::PARAM_STR);
                        break;
                    case '`email`':
                        $stmt->bindValue($identifier, $this->email, PDO::PARAM_STR);
                        break;
                    case '`legalform`':
                        $stmt->bindValue($identifier, $this->legalform, PDO::PARAM_STR);
                        break;
                    case '`logo`':
                        $stmt->bindValue($identifier, $this->logo, PDO::PARAM_STR);
                        break;
                    case '`created`':
                        $stmt->bindValue($identifier, $this->created, PDO::PARAM_STR);
                        break;
                    case '`notes`':
                        $stmt->bindValue($identifier, $this->notes, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', $e);
        }
        $this->setId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param PropelPDO $con
     *
     * @see        doSave()
     */
    protected function doUpdate(PropelPDO $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();
        BasePeer::doUpdate($selectCriteria, $valuesCriteria, $con);
    }

    /**
     * Array of ValidationFailed objects.
     * @var        array ValidationFailed[]
     */
    protected $validationFailures = array();

    /**
     * Gets any ValidationFailed objects that resulted from last call to validate().
     *
     *
     * @return array ValidationFailed[]
     * @see        validate()
     */
    public function getValidationFailures()
    {
        return $this->validationFailures;
    }

    /**
     * Validates the objects modified field values and all objects related to this table.
     *
     * If $columns is either a column name or an array of column names
     * only those columns are validated.
     *
     * @param mixed $columns Column name or an array of column names.
     * @return boolean Whether all columns pass validation.
     * @see        doValidate()
     * @see        getValidationFailures()
     */
    public function validate($columns = null)
    {
        $res = $this->doValidate($columns);
        if ($res === true) {
            $this->validationFailures = array();

            return true;
        }

        $this->validationFailures = $res;

        return false;
    }

    /**
     * This function performs the validation work for complex object models.
     *
     * In addition to checking the current object, all related objects will
     * also be validated.  If all pass then <code>true</code> is returned; otherwise
     * an aggregated array of ValidationFailed objects will be returned.
     *
     * @param array $columns Array of column names to validate.
     * @return mixed <code>true</code> if all validations pass; array of <code>ValidationFailed</code> objects otherwise.
     */
    protected function doValidate($columns = null)
    {
        if (!$this->alreadyInValidation) {
            $this->alreadyInValidation = true;
            $retval = null;

            $failureMap = array();


            // We call the validate method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aCountry !== null) {
                if (!$this->aCountry->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aCountry->getValidationFailures());
                }
            }


            if (($retval = CustomerPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }


                if ($this->collRemoteApps !== null) {
                    foreach ($this->collRemoteApps as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collUserCustomerRelations !== null) {
                    foreach ($this->collUserCustomerRelations as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }


            $this->alreadyInValidation = false;
        }

        return (!empty($failureMap) ? $failureMap : true);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param string $name name
     * @param string $type The type of fieldname the $name is of:
     *               one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *               BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *               Defaults to BasePeer::TYPE_PHPNAME
     * @return mixed Value of field.
     */
    public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = CustomerPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getName();
                break;
            case 2:
                return $this->getStreet();
                break;
            case 3:
                return $this->getZip();
                break;
            case 4:
                return $this->getCity();
                break;
            case 5:
                return $this->getCountryId();
                break;
            case 6:
                return $this->getPhone();
                break;
            case 7:
                return $this->getFax();
                break;
            case 8:
                return $this->getEmail();
                break;
            case 9:
                return $this->getLegalform();
                break;
            case 10:
                return $this->getLogo();
                break;
            case 11:
                return $this->getCreated();
                break;
            case 12:
                return $this->getNotes();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
     *                    BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *                    Defaults to BasePeer::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to true.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {
        if (isset($alreadyDumpedObjects['Customer'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Customer'][$this->getPrimaryKey()] = true;
        $keys = CustomerPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getName(),
            $keys[2] => $this->getStreet(),
            $keys[3] => $this->getZip(),
            $keys[4] => $this->getCity(),
            $keys[5] => $this->getCountryId(),
            $keys[6] => $this->getPhone(),
            $keys[7] => $this->getFax(),
            $keys[8] => $this->getEmail(),
            $keys[9] => $this->getLegalform(),
            $keys[10] => $this->getLogo(),
            $keys[11] => $this->getCreated(),
            $keys[12] => $this->getNotes(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aCountry) {
                $result['Country'] = $this->aCountry->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collRemoteApps) {
                $result['RemoteApps'] = $this->collRemoteApps->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collUserCustomerRelations) {
                $result['UserCustomerRelations'] = $this->collUserCustomerRelations->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param string $name peer name
     * @param mixed $value field value
     * @param string $type The type of fieldname the $name is of:
     *                     one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *                     BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *                     Defaults to BasePeer::TYPE_PHPNAME
     * @return void
     */
    public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = CustomerPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

        $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos position in xml schema
     * @param mixed $value field value
     * @return void
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setName($value);
                break;
            case 2:
                $this->setStreet($value);
                break;
            case 3:
                $this->setZip($value);
                break;
            case 4:
                $this->setCity($value);
                break;
            case 5:
                $this->setCountryId($value);
                break;
            case 6:
                $this->setPhone($value);
                break;
            case 7:
                $this->setFax($value);
                break;
            case 8:
                $this->setEmail($value);
                break;
            case 9:
                $this->setLegalform($value);
                break;
            case 10:
                $this->setLogo($value);
                break;
            case 11:
                $this->setCreated($value);
                break;
            case 12:
                $this->setNotes($value);
                break;
        } // switch()
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
     * BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     * The default key type is the column's BasePeer::TYPE_PHPNAME
     *
     * @param array  $arr     An array to populate the object from.
     * @param string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
    {
        $keys = CustomerPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setName($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setStreet($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setZip($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setCity($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setCountryId($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setPhone($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setFax($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setEmail($arr[$keys[8]]);
        if (array_key_exists($keys[9], $arr)) $this->setLegalform($arr[$keys[9]]);
        if (array_key_exists($keys[10], $arr)) $this->setLogo($arr[$keys[10]]);
        if (array_key_exists($keys[11], $arr)) $this->setCreated($arr[$keys[11]]);
        if (array_key_exists($keys[12], $arr)) $this->setNotes($arr[$keys[12]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(CustomerPeer::DATABASE_NAME);

        if ($this->isColumnModified(CustomerPeer::ID)) $criteria->add(CustomerPeer::ID, $this->id);
        if ($this->isColumnModified(CustomerPeer::NAME)) $criteria->add(CustomerPeer::NAME, $this->name);
        if ($this->isColumnModified(CustomerPeer::STREET)) $criteria->add(CustomerPeer::STREET, $this->street);
        if ($this->isColumnModified(CustomerPeer::ZIP)) $criteria->add(CustomerPeer::ZIP, $this->zip);
        if ($this->isColumnModified(CustomerPeer::CITY)) $criteria->add(CustomerPeer::CITY, $this->city);
        if ($this->isColumnModified(CustomerPeer::COUNTRY_ID)) $criteria->add(CustomerPeer::COUNTRY_ID, $this->country_id);
        if ($this->isColumnModified(CustomerPeer::PHONE)) $criteria->add(CustomerPeer::PHONE, $this->phone);
        if ($this->isColumnModified(CustomerPeer::FAX)) $criteria->add(CustomerPeer::FAX, $this->fax);
        if ($this->isColumnModified(CustomerPeer::EMAIL)) $criteria->add(CustomerPeer::EMAIL, $this->email);
        if ($this->isColumnModified(CustomerPeer::LEGALFORM)) $criteria->add(CustomerPeer::LEGALFORM, $this->legalform);
        if ($this->isColumnModified(CustomerPeer::LOGO)) $criteria->add(CustomerPeer::LOGO, $this->logo);
        if ($this->isColumnModified(CustomerPeer::CREATED)) $criteria->add(CustomerPeer::CREATED, $this->created);
        if ($this->isColumnModified(CustomerPeer::NOTES)) $criteria->add(CustomerPeer::NOTES, $this->notes);

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = new Criteria(CustomerPeer::DATABASE_NAME);
        $criteria->add(CustomerPeer::ID, $this->id);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param  int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of Customer (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setName($this->getName());
        $copyObj->setStreet($this->getStreet());
        $copyObj->setZip($this->getZip());
        $copyObj->setCity($this->getCity());
        $copyObj->setCountryId($this->getCountryId());
        $copyObj->setPhone($this->getPhone());
        $copyObj->setFax($this->getFax());
        $copyObj->setEmail($this->getEmail());
        $copyObj->setLegalform($this->getLegalform());
        $copyObj->setLogo($this->getLogo());
        $copyObj->setCreated($this->getCreated());
        $copyObj->setNotes($this->getNotes());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

            foreach ($this->getRemoteApps() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addRemoteApp($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getUserCustomerRelations() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addUserCustomerRelation($relObj->copy($deepCopy));
                }
            }

            //unflag object copy
            $this->startCopy = false;
        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return Customer Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Returns a peer instance associated with this om.
     *
     * Since Peer classes are not to have any instance attributes, this method returns the
     * same instance for all member of this class. The method could therefore
     * be static, but this would prevent one from overriding the behavior.
     *
     * @return CustomerPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new CustomerPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a Country object.
     *
     * @param                  Country $v
     * @return Customer The current object (for fluent API support)
     * @throws PropelException
     */
    public function setCountry(Country $v = null)
    {
        if ($v === null) {
            $this->setCountryId(NULL);
        } else {
            $this->setCountryId($v->getId());
        }

        $this->aCountry = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Country object, it will not be re-added.
        if ($v !== null) {
            $v->addCustomer($this);
        }


        return $this;
    }


    /**
     * Get the associated Country object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Country The associated Country object.
     * @throws PropelException
     */
    public function getCountry(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aCountry === null && ($this->country_id !== null) && $doQuery) {
            $this->aCountry = CountryQuery::create()->findPk($this->country_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aCountry->addCustomers($this);
             */
        }

        return $this->aCountry;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('RemoteApp' == $relationName) {
            $this->initRemoteApps();
        }
        if ('UserCustomerRelation' == $relationName) {
            $this->initUserCustomerRelations();
        }
    }

    /**
     * Clears out the collRemoteApps collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Customer The current object (for fluent API support)
     * @see        addRemoteApps()
     */
    public function clearRemoteApps()
    {
        $this->collRemoteApps = null; // important to set this to null since that means it is uninitialized
        $this->collRemoteAppsPartial = null;

        return $this;
    }

    /**
     * reset is the collRemoteApps collection loaded partially
     *
     * @return void
     */
    public function resetPartialRemoteApps($v = true)
    {
        $this->collRemoteAppsPartial = $v;
    }

    /**
     * Initializes the collRemoteApps collection.
     *
     * By default this just sets the collRemoteApps collection to an empty array (like clearcollRemoteApps());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initRemoteApps($overrideExisting = true)
    {
        if (null !== $this->collRemoteApps && !$overrideExisting) {
            return;
        }
        $this->collRemoteApps = new PropelObjectCollection();
        $this->collRemoteApps->setModel('RemoteApp');
    }

    /**
     * Gets an array of RemoteApp objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Customer is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|RemoteApp[] List of RemoteApp objects
     * @throws PropelException
     */
    public function getRemoteApps($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collRemoteAppsPartial && !$this->isNew();
        if (null === $this->collRemoteApps || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collRemoteApps) {
                // return empty collection
                $this->initRemoteApps();
            } else {
                $collRemoteApps = RemoteAppQuery::create(null, $criteria)
                    ->filterByCustomer($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collRemoteAppsPartial && count($collRemoteApps)) {
                      $this->initRemoteApps(false);

                      foreach ($collRemoteApps as $obj) {
                        if (false == $this->collRemoteApps->contains($obj)) {
                          $this->collRemoteApps->append($obj);
                        }
                      }

                      $this->collRemoteAppsPartial = true;
                    }

                    $collRemoteApps->getInternalIterator()->rewind();

                    return $collRemoteApps;
                }

                if ($partial && $this->collRemoteApps) {
                    foreach ($this->collRemoteApps as $obj) {
                        if ($obj->isNew()) {
                            $collRemoteApps[] = $obj;
                        }
                    }
                }

                $this->collRemoteApps = $collRemoteApps;
                $this->collRemoteAppsPartial = false;
            }
        }

        return $this->collRemoteApps;
    }

    /**
     * Sets a collection of RemoteApp objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $remoteApps A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Customer The current object (for fluent API support)
     */
    public function setRemoteApps(PropelCollection $remoteApps, PropelPDO $con = null)
    {
        $remoteAppsToDelete = $this->getRemoteApps(new Criteria(), $con)->diff($remoteApps);


        $this->remoteAppsScheduledForDeletion = $remoteAppsToDelete;

        foreach ($remoteAppsToDelete as $remoteAppRemoved) {
            $remoteAppRemoved->setCustomer(null);
        }

        $this->collRemoteApps = null;
        foreach ($remoteApps as $remoteApp) {
            $this->addRemoteApp($remoteApp);
        }

        $this->collRemoteApps = $remoteApps;
        $this->collRemoteAppsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related RemoteApp objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related RemoteApp objects.
     * @throws PropelException
     */
    public function countRemoteApps(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collRemoteAppsPartial && !$this->isNew();
        if (null === $this->collRemoteApps || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collRemoteApps) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getRemoteApps());
            }
            $query = RemoteAppQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCustomer($this)
                ->count($con);
        }

        return count($this->collRemoteApps);
    }

    /**
     * Method called to associate a RemoteApp object to this object
     * through the RemoteApp foreign key attribute.
     *
     * @param    RemoteApp $l RemoteApp
     * @return Customer The current object (for fluent API support)
     */
    public function addRemoteApp(RemoteApp $l)
    {
        if ($this->collRemoteApps === null) {
            $this->initRemoteApps();
            $this->collRemoteAppsPartial = true;
        }

        if (!in_array($l, $this->collRemoteApps->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddRemoteApp($l);

            if ($this->remoteAppsScheduledForDeletion and $this->remoteAppsScheduledForDeletion->contains($l)) {
                $this->remoteAppsScheduledForDeletion->remove($this->remoteAppsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	RemoteApp $remoteApp The remoteApp object to add.
     */
    protected function doAddRemoteApp($remoteApp)
    {
        $this->collRemoteApps[]= $remoteApp;
        $remoteApp->setCustomer($this);
    }

    /**
     * @param	RemoteApp $remoteApp The remoteApp object to remove.
     * @return Customer The current object (for fluent API support)
     */
    public function removeRemoteApp($remoteApp)
    {
        if ($this->getRemoteApps()->contains($remoteApp)) {
            $this->collRemoteApps->remove($this->collRemoteApps->search($remoteApp));
            if (null === $this->remoteAppsScheduledForDeletion) {
                $this->remoteAppsScheduledForDeletion = clone $this->collRemoteApps;
                $this->remoteAppsScheduledForDeletion->clear();
            }
            $this->remoteAppsScheduledForDeletion[]= $remoteApp;
            $remoteApp->setCustomer(null);
        }

        return $this;
    }

    /**
     * Clears out the collUserCustomerRelations collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Customer The current object (for fluent API support)
     * @see        addUserCustomerRelations()
     */
    public function clearUserCustomerRelations()
    {
        $this->collUserCustomerRelations = null; // important to set this to null since that means it is uninitialized
        $this->collUserCustomerRelationsPartial = null;

        return $this;
    }

    /**
     * reset is the collUserCustomerRelations collection loaded partially
     *
     * @return void
     */
    public function resetPartialUserCustomerRelations($v = true)
    {
        $this->collUserCustomerRelationsPartial = $v;
    }

    /**
     * Initializes the collUserCustomerRelations collection.
     *
     * By default this just sets the collUserCustomerRelations collection to an empty array (like clearcollUserCustomerRelations());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initUserCustomerRelations($overrideExisting = true)
    {
        if (null !== $this->collUserCustomerRelations && !$overrideExisting) {
            return;
        }
        $this->collUserCustomerRelations = new PropelObjectCollection();
        $this->collUserCustomerRelations->setModel('UserCustomerRelation');
    }

    /**
     * Gets an array of UserCustomerRelation objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Customer is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|UserCustomerRelation[] List of UserCustomerRelation objects
     * @throws PropelException
     */
    public function getUserCustomerRelations($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collUserCustomerRelationsPartial && !$this->isNew();
        if (null === $this->collUserCustomerRelations || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collUserCustomerRelations) {
                // return empty collection
                $this->initUserCustomerRelations();
            } else {
                $collUserCustomerRelations = UserCustomerRelationQuery::create(null, $criteria)
                    ->filterByCustomer($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collUserCustomerRelationsPartial && count($collUserCustomerRelations)) {
                      $this->initUserCustomerRelations(false);

                      foreach ($collUserCustomerRelations as $obj) {
                        if (false == $this->collUserCustomerRelations->contains($obj)) {
                          $this->collUserCustomerRelations->append($obj);
                        }
                      }

                      $this->collUserCustomerRelationsPartial = true;
                    }

                    $collUserCustomerRelations->getInternalIterator()->rewind();

                    return $collUserCustomerRelations;
                }

                if ($partial && $this->collUserCustomerRelations) {
                    foreach ($this->collUserCustomerRelations as $obj) {
                        if ($obj->isNew()) {
                            $collUserCustomerRelations[] = $obj;
                        }
                    }
                }

                $this->collUserCustomerRelations = $collUserCustomerRelations;
                $this->collUserCustomerRelationsPartial = false;
            }
        }

        return $this->collUserCustomerRelations;
    }

    /**
     * Sets a collection of UserCustomerRelation objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $userCustomerRelations A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Customer The current object (for fluent API support)
     */
    public function setUserCustomerRelations(PropelCollection $userCustomerRelations, PropelPDO $con = null)
    {
        $userCustomerRelationsToDelete = $this->getUserCustomerRelations(new Criteria(), $con)->diff($userCustomerRelations);


        $this->userCustomerRelationsScheduledForDeletion = $userCustomerRelationsToDelete;

        foreach ($userCustomerRelationsToDelete as $userCustomerRelationRemoved) {
            $userCustomerRelationRemoved->setCustomer(null);
        }

        $this->collUserCustomerRelations = null;
        foreach ($userCustomerRelations as $userCustomerRelation) {
            $this->addUserCustomerRelation($userCustomerRelation);
        }

        $this->collUserCustomerRelations = $userCustomerRelations;
        $this->collUserCustomerRelationsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related UserCustomerRelation objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related UserCustomerRelation objects.
     * @throws PropelException
     */
    public function countUserCustomerRelations(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collUserCustomerRelationsPartial && !$this->isNew();
        if (null === $this->collUserCustomerRelations || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collUserCustomerRelations) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getUserCustomerRelations());
            }
            $query = UserCustomerRelationQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCustomer($this)
                ->count($con);
        }

        return count($this->collUserCustomerRelations);
    }

    /**
     * Method called to associate a UserCustomerRelation object to this object
     * through the UserCustomerRelation foreign key attribute.
     *
     * @param    UserCustomerRelation $l UserCustomerRelation
     * @return Customer The current object (for fluent API support)
     */
    public function addUserCustomerRelation(UserCustomerRelation $l)
    {
        if ($this->collUserCustomerRelations === null) {
            $this->initUserCustomerRelations();
            $this->collUserCustomerRelationsPartial = true;
        }

        if (!in_array($l, $this->collUserCustomerRelations->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddUserCustomerRelation($l);

            if ($this->userCustomerRelationsScheduledForDeletion and $this->userCustomerRelationsScheduledForDeletion->contains($l)) {
                $this->userCustomerRelationsScheduledForDeletion->remove($this->userCustomerRelationsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	UserCustomerRelation $userCustomerRelation The userCustomerRelation object to add.
     */
    protected function doAddUserCustomerRelation($userCustomerRelation)
    {
        $this->collUserCustomerRelations[]= $userCustomerRelation;
        $userCustomerRelation->setCustomer($this);
    }

    /**
     * @param	UserCustomerRelation $userCustomerRelation The userCustomerRelation object to remove.
     * @return Customer The current object (for fluent API support)
     */
    public function removeUserCustomerRelation($userCustomerRelation)
    {
        if ($this->getUserCustomerRelations()->contains($userCustomerRelation)) {
            $this->collUserCustomerRelations->remove($this->collUserCustomerRelations->search($userCustomerRelation));
            if (null === $this->userCustomerRelationsScheduledForDeletion) {
                $this->userCustomerRelationsScheduledForDeletion = clone $this->collUserCustomerRelations;
                $this->userCustomerRelationsScheduledForDeletion->clear();
            }
            $this->userCustomerRelationsScheduledForDeletion[]= clone $userCustomerRelation;
            $userCustomerRelation->setCustomer(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Customer is new, it will return
     * an empty collection; or if this Customer has previously
     * been saved, it will retrieve related UserCustomerRelations from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Customer.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|UserCustomerRelation[] List of UserCustomerRelation objects
     */
    public function getUserCustomerRelationsJoinUser($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = UserCustomerRelationQuery::create(null, $criteria);
        $query->joinWith('User', $join_behavior);

        return $this->getUserCustomerRelations($query, $con);
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id = null;
        $this->name = null;
        $this->street = null;
        $this->zip = null;
        $this->city = null;
        $this->country_id = null;
        $this->phone = null;
        $this->fax = null;
        $this->email = null;
        $this->legalform = null;
        $this->logo = null;
        $this->created = null;
        $this->notes = null;
        $this->alreadyInSave = false;
        $this->alreadyInValidation = false;
        $this->alreadyInClearAllReferencesDeep = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references to other model objects or collections of model objects.
     *
     * This method is a user-space workaround for PHP's inability to garbage collect
     * objects with circular references (even in PHP 5.3). This is currently necessary
     * when using Propel in certain daemon or large-volume/high-memory operations.
     *
     * @param boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep && !$this->alreadyInClearAllReferencesDeep) {
            $this->alreadyInClearAllReferencesDeep = true;
            if ($this->collRemoteApps) {
                foreach ($this->collRemoteApps as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collUserCustomerRelations) {
                foreach ($this->collUserCustomerRelations as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->aCountry instanceof Persistent) {
              $this->aCountry->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        if ($this->collRemoteApps instanceof PropelCollection) {
            $this->collRemoteApps->clearIterator();
        }
        $this->collRemoteApps = null;
        if ($this->collUserCustomerRelations instanceof PropelCollection) {
            $this->collUserCustomerRelations->clearIterator();
        }
        $this->collUserCustomerRelations = null;
        $this->aCountry = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(CustomerPeer::DEFAULT_STRING_FORMAT);
    }

    /**
     * return true is the object is in saving state
     *
     * @return boolean
     */
    public function isAlreadyInSave()
    {
        return $this->alreadyInSave;
    }

}

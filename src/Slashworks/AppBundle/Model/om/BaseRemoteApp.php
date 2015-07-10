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
use Slashworks\AppBundle\Model\ApiLog;
use Slashworks\AppBundle\Model\ApiLogQuery;
use Slashworks\AppBundle\Model\Customer;
use Slashworks\AppBundle\Model\CustomerQuery;
use Slashworks\AppBundle\Model\RemoteApp;
use Slashworks\AppBundle\Model\RemoteAppPeer;
use Slashworks\AppBundle\Model\RemoteAppQuery;
use Slashworks\AppBundle\Model\RemoteHistoryContao;
use Slashworks\AppBundle\Model\RemoteHistoryContaoQuery;

abstract class BaseRemoteApp extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'Slashworks\\AppBundle\\Model\\RemoteAppPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        RemoteAppPeer
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
     * The value for the type field.
     * Note: this column has a database default value of: 'contao'
     * @var        string
     */
    protected $type;

    /**
     * The value for the name field.
     * @var        string
     */
    protected $name;

    /**
     * The value for the domain field.
     * @var        string
     */
    protected $domain;

    /**
     * The value for the api_url field.
     * @var        string
     */
    protected $api_url;

    /**
     * The value for the api_auth_http_user field.
     * @var        string
     */
    protected $api_auth_http_user;

    /**
     * The value for the api_auth_http_password field.
     * @var        string
     */
    protected $api_auth_http_password;

    /**
     * The value for the api_auth_type field.
     * Note: this column has a database default value of: 'none'
     * @var        string
     */
    protected $api_auth_type;

    /**
     * The value for the api_auth_user field.
     * @var        string
     */
    protected $api_auth_user;

    /**
     * The value for the api_auth_password field.
     * @var        string
     */
    protected $api_auth_password;

    /**
     * The value for the api_auth_token field.
     * @var        string
     */
    protected $api_auth_token;

    /**
     * The value for the api_auth_url_user_key field.
     * @var        string
     */
    protected $api_auth_url_user_key;

    /**
     * The value for the api_auth_url_pw_key field.
     * @var        string
     */
    protected $api_auth_url_pw_key;

    /**
     * The value for the cron field.
     * @var        string
     */
    protected $cron;

    /**
     * The value for the customer_id field.
     * @var        int
     */
    protected $customer_id;

    /**
     * The value for the activated field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $activated;

    /**
     * The value for the notes field.
     * @var        string
     */
    protected $notes;

    /**
     * The value for the last_run field.
     * @var        string
     */
    protected $last_run;

    /**
     * The value for the includelog field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $includelog;

    /**
     * The value for the public_key field.
     * @var        string
     */
    protected $public_key;

    /**
     * The value for the website_hash field.
     * Note: this column has a database default value of: ''
     * @var        string
     */
    protected $website_hash;

    /**
     * The value for the notification_recipient field.
     * Note: this column has a database default value of: ''
     * @var        string
     */
    protected $notification_recipient;

    /**
     * The value for the notification_sender field.
     * Note: this column has a database default value of: ''
     * @var        string
     */
    protected $notification_sender;

    /**
     * The value for the notification_change field.
     * Note: this column has a database default value of: true
     * @var        boolean
     */
    protected $notification_change;

    /**
     * The value for the notification_error field.
     * Note: this column has a database default value of: true
     * @var        boolean
     */
    protected $notification_error;

    /**
     * @var        Customer
     */
    protected $aCustomer;

    /**
     * @var        PropelObjectCollection|ApiLog[] Collection to store aggregation of ApiLog objects.
     */
    protected $collApiLogs;
    protected $collApiLogsPartial;

    /**
     * @var        PropelObjectCollection|RemoteHistoryContao[] Collection to store aggregation of RemoteHistoryContao objects.
     */
    protected $collRemoteHistoryContaos;
    protected $collRemoteHistoryContaosPartial;

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
    protected $apiLogsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $remoteHistoryContaosScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see        __construct()
     */
    public function applyDefaultValues()
    {
        $this->type = 'contao';
        $this->api_auth_type = 'none';
        $this->activated = false;
        $this->includelog = false;
        $this->website_hash = '';
        $this->notification_recipient = '';
        $this->notification_sender = '';
        $this->notification_change = true;
        $this->notification_error = true;
    }

    /**
     * Initializes internal state of BaseRemoteApp object.
     * @see        applyDefaults()
     */
    public function __construct()
    {
        parent::__construct();
        $this->applyDefaultValues();
    }

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
     * Get the [type] column value.
     *
     * @return string
     */
    public function getType()
    {

        return $this->type;
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
     * Get the [domain] column value.
     *
     * @return string
     */
    public function getDomain()
    {

        return $this->domain;
    }

    /**
     * Get the [api_url] column value.
     *
     * @return string
     */
    public function getApiUrl()
    {

        return $this->api_url;
    }

    /**
     * Get the [api_auth_http_user] column value.
     *
     * @return string
     */
    public function getApiAuthHttpUser()
    {

        return $this->api_auth_http_user;
    }

    /**
     * Get the [api_auth_http_password] column value.
     *
     * @return string
     */
    public function getApiAuthHttpPassword()
    {

        return $this->api_auth_http_password;
    }

    /**
     * Get the [api_auth_type] column value.
     *
     * @return string
     */
    public function getApiAuthType()
    {

        return $this->api_auth_type;
    }

    /**
     * Get the [api_auth_user] column value.
     *
     * @return string
     */
    public function getApiAuthUser()
    {

        return $this->api_auth_user;
    }

    /**
     * Get the [api_auth_password] column value.
     *
     * @return string
     */
    public function getApiAuthPassword()
    {

        return $this->api_auth_password;
    }

    /**
     * Get the [api_auth_token] column value.
     *
     * @return string
     */
    public function getApiAuthToken()
    {

        return $this->api_auth_token;
    }

    /**
     * Get the [api_auth_url_user_key] column value.
     *
     * @return string
     */
    public function getApiAuthUrlUserKey()
    {

        return $this->api_auth_url_user_key;
    }

    /**
     * Get the [api_auth_url_pw_key] column value.
     *
     * @return string
     */
    public function getApiAuthUrlPwKey()
    {

        return $this->api_auth_url_pw_key;
    }

    /**
     * Get the [cron] column value.
     *
     * @return string
     */
    public function getCron()
    {

        return $this->cron;
    }

    /**
     * Get the [customer_id] column value.
     *
     * @return int
     */
    public function getCustomerId()
    {

        return $this->customer_id;
    }

    /**
     * Get the [activated] column value.
     *
     * @return boolean
     */
    public function getActivated()
    {

        return $this->activated;
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
     * Get the [optionally formatted] temporal [last_run] column value.
     *
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null, and 0 if column value is 0000-00-00 00:00:00
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getLastRun($format = null)
    {
        if ($this->last_run === null) {
            return null;
        }

        if ($this->last_run === '0000-00-00 00:00:00') {
            // while technically this is not a default value of null,
            // this seems to be closest in meaning.
            return null;
        }

        try {
            $dt = new DateTime($this->last_run);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->last_run, true), $x);
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
     * Get the [includelog] column value.
     *
     * @return boolean
     */
    public function getIncludelog()
    {

        return $this->includelog;
    }

    /**
     * Get the [public_key] column value.
     *
     * @return string
     */
    public function getPublicKey()
    {

        return $this->public_key;
    }

    /**
     * Get the [website_hash] column value.
     *
     * @return string
     */
    public function getWebsiteHash()
    {

        return $this->website_hash;
    }

    /**
     * Get the [notification_recipient] column value.
     *
     * @return string
     */
    public function getNotificationRecipient()
    {

        return $this->notification_recipient;
    }

    /**
     * Get the [notification_sender] column value.
     *
     * @return string
     */
    public function getNotificationSender()
    {

        return $this->notification_sender;
    }

    /**
     * Get the [notification_change] column value.
     *
     * @return boolean
     */
    public function getNotificationChange()
    {

        return $this->notification_change;
    }

    /**
     * Get the [notification_error] column value.
     *
     * @return boolean
     */
    public function getNotificationError()
    {

        return $this->notification_error;
    }

    /**
     * Set the value of [id] column.
     *
     * @param  int $v new value
     * @return RemoteApp The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[] = RemoteAppPeer::ID;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [type] column.
     *
     * @param  string $v new value
     * @return RemoteApp The current object (for fluent API support)
     */
    public function setType($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->type !== $v) {
            $this->type = $v;
            $this->modifiedColumns[] = RemoteAppPeer::TYPE;
        }


        return $this;
    } // setType()

    /**
     * Set the value of [name] column.
     *
     * @param  string $v new value
     * @return RemoteApp The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[] = RemoteAppPeer::NAME;
        }


        return $this;
    } // setName()

    /**
     * Set the value of [domain] column.
     *
     * @param  string $v new value
     * @return RemoteApp The current object (for fluent API support)
     */
    public function setDomain($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->domain !== $v) {
            $this->domain = $v;
            $this->modifiedColumns[] = RemoteAppPeer::DOMAIN;
        }


        return $this;
    } // setDomain()

    /**
     * Set the value of [api_url] column.
     *
     * @param  string $v new value
     * @return RemoteApp The current object (for fluent API support)
     */
    public function setApiUrl($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->api_url !== $v) {
            $this->api_url = $v;
            $this->modifiedColumns[] = RemoteAppPeer::API_URL;
        }


        return $this;
    } // setApiUrl()

    /**
     * Set the value of [api_auth_http_user] column.
     *
     * @param  string $v new value
     * @return RemoteApp The current object (for fluent API support)
     */
    public function setApiAuthHttpUser($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->api_auth_http_user !== $v) {
            $this->api_auth_http_user = $v;
            $this->modifiedColumns[] = RemoteAppPeer::API_AUTH_HTTP_USER;
        }


        return $this;
    } // setApiAuthHttpUser()

    /**
     * Set the value of [api_auth_http_password] column.
     *
     * @param  string $v new value
     * @return RemoteApp The current object (for fluent API support)
     */
    public function setApiAuthHttpPassword($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->api_auth_http_password !== $v) {
            $this->api_auth_http_password = $v;
            $this->modifiedColumns[] = RemoteAppPeer::API_AUTH_HTTP_PASSWORD;
        }


        return $this;
    } // setApiAuthHttpPassword()

    /**
     * Set the value of [api_auth_type] column.
     *
     * @param  string $v new value
     * @return RemoteApp The current object (for fluent API support)
     */
    public function setApiAuthType($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->api_auth_type !== $v) {
            $this->api_auth_type = $v;
            $this->modifiedColumns[] = RemoteAppPeer::API_AUTH_TYPE;
        }


        return $this;
    } // setApiAuthType()

    /**
     * Set the value of [api_auth_user] column.
     *
     * @param  string $v new value
     * @return RemoteApp The current object (for fluent API support)
     */
    public function setApiAuthUser($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->api_auth_user !== $v) {
            $this->api_auth_user = $v;
            $this->modifiedColumns[] = RemoteAppPeer::API_AUTH_USER;
        }


        return $this;
    } // setApiAuthUser()

    /**
     * Set the value of [api_auth_password] column.
     *
     * @param  string $v new value
     * @return RemoteApp The current object (for fluent API support)
     */
    public function setApiAuthPassword($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->api_auth_password !== $v) {
            $this->api_auth_password = $v;
            $this->modifiedColumns[] = RemoteAppPeer::API_AUTH_PASSWORD;
        }


        return $this;
    } // setApiAuthPassword()

    /**
     * Set the value of [api_auth_token] column.
     *
     * @param  string $v new value
     * @return RemoteApp The current object (for fluent API support)
     */
    public function setApiAuthToken($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->api_auth_token !== $v) {
            $this->api_auth_token = $v;
            $this->modifiedColumns[] = RemoteAppPeer::API_AUTH_TOKEN;
        }


        return $this;
    } // setApiAuthToken()

    /**
     * Set the value of [api_auth_url_user_key] column.
     *
     * @param  string $v new value
     * @return RemoteApp The current object (for fluent API support)
     */
    public function setApiAuthUrlUserKey($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->api_auth_url_user_key !== $v) {
            $this->api_auth_url_user_key = $v;
            $this->modifiedColumns[] = RemoteAppPeer::API_AUTH_URL_USER_KEY;
        }


        return $this;
    } // setApiAuthUrlUserKey()

    /**
     * Set the value of [api_auth_url_pw_key] column.
     *
     * @param  string $v new value
     * @return RemoteApp The current object (for fluent API support)
     */
    public function setApiAuthUrlPwKey($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->api_auth_url_pw_key !== $v) {
            $this->api_auth_url_pw_key = $v;
            $this->modifiedColumns[] = RemoteAppPeer::API_AUTH_URL_PW_KEY;
        }


        return $this;
    } // setApiAuthUrlPwKey()

    /**
     * Set the value of [cron] column.
     *
     * @param  string $v new value
     * @return RemoteApp The current object (for fluent API support)
     */
    public function setCron($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->cron !== $v) {
            $this->cron = $v;
            $this->modifiedColumns[] = RemoteAppPeer::CRON;
        }


        return $this;
    } // setCron()

    /**
     * Set the value of [customer_id] column.
     *
     * @param  int $v new value
     * @return RemoteApp The current object (for fluent API support)
     */
    public function setCustomerId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->customer_id !== $v) {
            $this->customer_id = $v;
            $this->modifiedColumns[] = RemoteAppPeer::CUSTOMER_ID;
        }

        if ($this->aCustomer !== null && $this->aCustomer->getId() !== $v) {
            $this->aCustomer = null;
        }


        return $this;
    } // setCustomerId()

    /**
     * Sets the value of the [activated] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param boolean|integer|string $v The new value
     * @return RemoteApp The current object (for fluent API support)
     */
    public function setActivated($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->activated !== $v) {
            $this->activated = $v;
            $this->modifiedColumns[] = RemoteAppPeer::ACTIVATED;
        }


        return $this;
    } // setActivated()

    /**
     * Set the value of [notes] column.
     *
     * @param  string $v new value
     * @return RemoteApp The current object (for fluent API support)
     */
    public function setNotes($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->notes !== $v) {
            $this->notes = $v;
            $this->modifiedColumns[] = RemoteAppPeer::NOTES;
        }


        return $this;
    } // setNotes()

    /**
     * Sets the value of [last_run] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return RemoteApp The current object (for fluent API support)
     */
    public function setLastRun($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->last_run !== null || $dt !== null) {
            $currentDateAsString = ($this->last_run !== null && $tmpDt = new DateTime($this->last_run)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->last_run = $newDateAsString;
                $this->modifiedColumns[] = RemoteAppPeer::LAST_RUN;
            }
        } // if either are not null


        return $this;
    } // setLastRun()

    /**
     * Sets the value of the [includelog] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param boolean|integer|string $v The new value
     * @return RemoteApp The current object (for fluent API support)
     */
    public function setIncludelog($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->includelog !== $v) {
            $this->includelog = $v;
            $this->modifiedColumns[] = RemoteAppPeer::INCLUDELOG;
        }


        return $this;
    } // setIncludelog()

    /**
     * Set the value of [public_key] column.
     *
     * @param  string $v new value
     * @return RemoteApp The current object (for fluent API support)
     */
    public function setPublicKey($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->public_key !== $v) {
            $this->public_key = $v;
            $this->modifiedColumns[] = RemoteAppPeer::PUBLIC_KEY;
        }


        return $this;
    } // setPublicKey()

    /**
     * Set the value of [website_hash] column.
     *
     * @param  string $v new value
     * @return RemoteApp The current object (for fluent API support)
     */
    public function setWebsiteHash($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->website_hash !== $v) {
            $this->website_hash = $v;
            $this->modifiedColumns[] = RemoteAppPeer::WEBSITE_HASH;
        }


        return $this;
    } // setWebsiteHash()

    /**
     * Set the value of [notification_recipient] column.
     *
     * @param  string $v new value
     * @return RemoteApp The current object (for fluent API support)
     */
    public function setNotificationRecipient($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->notification_recipient !== $v) {
            $this->notification_recipient = $v;
            $this->modifiedColumns[] = RemoteAppPeer::NOTIFICATION_RECIPIENT;
        }


        return $this;
    } // setNotificationRecipient()

    /**
     * Set the value of [notification_sender] column.
     *
     * @param  string $v new value
     * @return RemoteApp The current object (for fluent API support)
     */
    public function setNotificationSender($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->notification_sender !== $v) {
            $this->notification_sender = $v;
            $this->modifiedColumns[] = RemoteAppPeer::NOTIFICATION_SENDER;
        }


        return $this;
    } // setNotificationSender()

    /**
     * Sets the value of the [notification_change] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param boolean|integer|string $v The new value
     * @return RemoteApp The current object (for fluent API support)
     */
    public function setNotificationChange($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->notification_change !== $v) {
            $this->notification_change = $v;
            $this->modifiedColumns[] = RemoteAppPeer::NOTIFICATION_CHANGE;
        }


        return $this;
    } // setNotificationChange()

    /**
     * Sets the value of the [notification_error] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param boolean|integer|string $v The new value
     * @return RemoteApp The current object (for fluent API support)
     */
    public function setNotificationError($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->notification_error !== $v) {
            $this->notification_error = $v;
            $this->modifiedColumns[] = RemoteAppPeer::NOTIFICATION_ERROR;
        }


        return $this;
    } // setNotificationError()

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
            if ($this->type !== 'contao') {
                return false;
            }

            if ($this->api_auth_type !== 'none') {
                return false;
            }

            if ($this->activated !== false) {
                return false;
            }

            if ($this->includelog !== false) {
                return false;
            }

            if ($this->website_hash !== '') {
                return false;
            }

            if ($this->notification_recipient !== '') {
                return false;
            }

            if ($this->notification_sender !== '') {
                return false;
            }

            if ($this->notification_change !== true) {
                return false;
            }

            if ($this->notification_error !== true) {
                return false;
            }

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
            $this->type = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
            $this->name = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
            $this->domain = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
            $this->api_url = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
            $this->api_auth_http_user = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
            $this->api_auth_http_password = ($row[$startcol + 6] !== null) ? (string) $row[$startcol + 6] : null;
            $this->api_auth_type = ($row[$startcol + 7] !== null) ? (string) $row[$startcol + 7] : null;
            $this->api_auth_user = ($row[$startcol + 8] !== null) ? (string) $row[$startcol + 8] : null;
            $this->api_auth_password = ($row[$startcol + 9] !== null) ? (string) $row[$startcol + 9] : null;
            $this->api_auth_token = ($row[$startcol + 10] !== null) ? (string) $row[$startcol + 10] : null;
            $this->api_auth_url_user_key = ($row[$startcol + 11] !== null) ? (string) $row[$startcol + 11] : null;
            $this->api_auth_url_pw_key = ($row[$startcol + 12] !== null) ? (string) $row[$startcol + 12] : null;
            $this->cron = ($row[$startcol + 13] !== null) ? (string) $row[$startcol + 13] : null;
            $this->customer_id = ($row[$startcol + 14] !== null) ? (int) $row[$startcol + 14] : null;
            $this->activated = ($row[$startcol + 15] !== null) ? (boolean) $row[$startcol + 15] : null;
            $this->notes = ($row[$startcol + 16] !== null) ? (string) $row[$startcol + 16] : null;
            $this->last_run = ($row[$startcol + 17] !== null) ? (string) $row[$startcol + 17] : null;
            $this->includelog = ($row[$startcol + 18] !== null) ? (boolean) $row[$startcol + 18] : null;
            $this->public_key = ($row[$startcol + 19] !== null) ? (string) $row[$startcol + 19] : null;
            $this->website_hash = ($row[$startcol + 20] !== null) ? (string) $row[$startcol + 20] : null;
            $this->notification_recipient = ($row[$startcol + 21] !== null) ? (string) $row[$startcol + 21] : null;
            $this->notification_sender = ($row[$startcol + 22] !== null) ? (string) $row[$startcol + 22] : null;
            $this->notification_change = ($row[$startcol + 23] !== null) ? (boolean) $row[$startcol + 23] : null;
            $this->notification_error = ($row[$startcol + 24] !== null) ? (boolean) $row[$startcol + 24] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);

            return $startcol + 25; // 25 = RemoteAppPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating RemoteApp object", $e);
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

        if ($this->aCustomer !== null && $this->customer_id !== $this->aCustomer->getId()) {
            $this->aCustomer = null;
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
            $con = Propel::getConnection(RemoteAppPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = RemoteAppPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aCustomer = null;
            $this->collApiLogs = null;

            $this->collRemoteHistoryContaos = null;

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
            $con = Propel::getConnection(RemoteAppPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = RemoteAppQuery::create()
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
            $con = Propel::getConnection(RemoteAppPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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
                RemoteAppPeer::addInstanceToPool($this);
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

            if ($this->aCustomer !== null) {
                if ($this->aCustomer->isModified() || $this->aCustomer->isNew()) {
                    $affectedRows += $this->aCustomer->save($con);
                }
                $this->setCustomer($this->aCustomer);
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

            if ($this->apiLogsScheduledForDeletion !== null) {
                if (!$this->apiLogsScheduledForDeletion->isEmpty()) {
                    ApiLogQuery::create()
                        ->filterByPrimaryKeys($this->apiLogsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->apiLogsScheduledForDeletion = null;
                }
            }

            if ($this->collApiLogs !== null) {
                foreach ($this->collApiLogs as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->remoteHistoryContaosScheduledForDeletion !== null) {
                if (!$this->remoteHistoryContaosScheduledForDeletion->isEmpty()) {
                    RemoteHistoryContaoQuery::create()
                        ->filterByPrimaryKeys($this->remoteHistoryContaosScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->remoteHistoryContaosScheduledForDeletion = null;
                }
            }

            if ($this->collRemoteHistoryContaos !== null) {
                foreach ($this->collRemoteHistoryContaos as $referrerFK) {
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

        $this->modifiedColumns[] = RemoteAppPeer::ID;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . RemoteAppPeer::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(RemoteAppPeer::ID)) {
            $modifiedColumns[':p' . $index++]  = '`id`';
        }
        if ($this->isColumnModified(RemoteAppPeer::TYPE)) {
            $modifiedColumns[':p' . $index++]  = '`type`';
        }
        if ($this->isColumnModified(RemoteAppPeer::NAME)) {
            $modifiedColumns[':p' . $index++]  = '`name`';
        }
        if ($this->isColumnModified(RemoteAppPeer::DOMAIN)) {
            $modifiedColumns[':p' . $index++]  = '`domain`';
        }
        if ($this->isColumnModified(RemoteAppPeer::API_URL)) {
            $modifiedColumns[':p' . $index++]  = '`api_url`';
        }
        if ($this->isColumnModified(RemoteAppPeer::API_AUTH_HTTP_USER)) {
            $modifiedColumns[':p' . $index++]  = '`api_auth_http_user`';
        }
        if ($this->isColumnModified(RemoteAppPeer::API_AUTH_HTTP_PASSWORD)) {
            $modifiedColumns[':p' . $index++]  = '`api_auth_http_password`';
        }
        if ($this->isColumnModified(RemoteAppPeer::API_AUTH_TYPE)) {
            $modifiedColumns[':p' . $index++]  = '`api_auth_type`';
        }
        if ($this->isColumnModified(RemoteAppPeer::API_AUTH_USER)) {
            $modifiedColumns[':p' . $index++]  = '`api_auth_user`';
        }
        if ($this->isColumnModified(RemoteAppPeer::API_AUTH_PASSWORD)) {
            $modifiedColumns[':p' . $index++]  = '`api_auth_password`';
        }
        if ($this->isColumnModified(RemoteAppPeer::API_AUTH_TOKEN)) {
            $modifiedColumns[':p' . $index++]  = '`api_auth_token`';
        }
        if ($this->isColumnModified(RemoteAppPeer::API_AUTH_URL_USER_KEY)) {
            $modifiedColumns[':p' . $index++]  = '`api_auth_url_user_key`';
        }
        if ($this->isColumnModified(RemoteAppPeer::API_AUTH_URL_PW_KEY)) {
            $modifiedColumns[':p' . $index++]  = '`api_auth_url_pw_key`';
        }
        if ($this->isColumnModified(RemoteAppPeer::CRON)) {
            $modifiedColumns[':p' . $index++]  = '`cron`';
        }
        if ($this->isColumnModified(RemoteAppPeer::CUSTOMER_ID)) {
            $modifiedColumns[':p' . $index++]  = '`customer_id`';
        }
        if ($this->isColumnModified(RemoteAppPeer::ACTIVATED)) {
            $modifiedColumns[':p' . $index++]  = '`activated`';
        }
        if ($this->isColumnModified(RemoteAppPeer::NOTES)) {
            $modifiedColumns[':p' . $index++]  = '`notes`';
        }
        if ($this->isColumnModified(RemoteAppPeer::LAST_RUN)) {
            $modifiedColumns[':p' . $index++]  = '`last_run`';
        }
        if ($this->isColumnModified(RemoteAppPeer::INCLUDELOG)) {
            $modifiedColumns[':p' . $index++]  = '`includeLog`';
        }
        if ($this->isColumnModified(RemoteAppPeer::PUBLIC_KEY)) {
            $modifiedColumns[':p' . $index++]  = '`public_key`';
        }
        if ($this->isColumnModified(RemoteAppPeer::WEBSITE_HASH)) {
            $modifiedColumns[':p' . $index++]  = '`website_hash`';
        }
        if ($this->isColumnModified(RemoteAppPeer::NOTIFICATION_RECIPIENT)) {
            $modifiedColumns[':p' . $index++]  = '`notification_recipient`';
        }
        if ($this->isColumnModified(RemoteAppPeer::NOTIFICATION_SENDER)) {
            $modifiedColumns[':p' . $index++]  = '`notification_sender`';
        }
        if ($this->isColumnModified(RemoteAppPeer::NOTIFICATION_CHANGE)) {
            $modifiedColumns[':p' . $index++]  = '`notification_change`';
        }
        if ($this->isColumnModified(RemoteAppPeer::NOTIFICATION_ERROR)) {
            $modifiedColumns[':p' . $index++]  = '`notification_error`';
        }

        $sql = sprintf(
            'INSERT INTO `remote_app` (%s) VALUES (%s)',
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
                    case '`type`':
                        $stmt->bindValue($identifier, $this->type, PDO::PARAM_STR);
                        break;
                    case '`name`':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case '`domain`':
                        $stmt->bindValue($identifier, $this->domain, PDO::PARAM_STR);
                        break;
                    case '`api_url`':
                        $stmt->bindValue($identifier, $this->api_url, PDO::PARAM_STR);
                        break;
                    case '`api_auth_http_user`':
                        $stmt->bindValue($identifier, $this->api_auth_http_user, PDO::PARAM_STR);
                        break;
                    case '`api_auth_http_password`':
                        $stmt->bindValue($identifier, $this->api_auth_http_password, PDO::PARAM_STR);
                        break;
                    case '`api_auth_type`':
                        $stmt->bindValue($identifier, $this->api_auth_type, PDO::PARAM_STR);
                        break;
                    case '`api_auth_user`':
                        $stmt->bindValue($identifier, $this->api_auth_user, PDO::PARAM_STR);
                        break;
                    case '`api_auth_password`':
                        $stmt->bindValue($identifier, $this->api_auth_password, PDO::PARAM_STR);
                        break;
                    case '`api_auth_token`':
                        $stmt->bindValue($identifier, $this->api_auth_token, PDO::PARAM_STR);
                        break;
                    case '`api_auth_url_user_key`':
                        $stmt->bindValue($identifier, $this->api_auth_url_user_key, PDO::PARAM_STR);
                        break;
                    case '`api_auth_url_pw_key`':
                        $stmt->bindValue($identifier, $this->api_auth_url_pw_key, PDO::PARAM_STR);
                        break;
                    case '`cron`':
                        $stmt->bindValue($identifier, $this->cron, PDO::PARAM_STR);
                        break;
                    case '`customer_id`':
                        $stmt->bindValue($identifier, $this->customer_id, PDO::PARAM_INT);
                        break;
                    case '`activated`':
                        $stmt->bindValue($identifier, (int) $this->activated, PDO::PARAM_INT);
                        break;
                    case '`notes`':
                        $stmt->bindValue($identifier, $this->notes, PDO::PARAM_STR);
                        break;
                    case '`last_run`':
                        $stmt->bindValue($identifier, $this->last_run, PDO::PARAM_STR);
                        break;
                    case '`includeLog`':
                        $stmt->bindValue($identifier, (int) $this->includelog, PDO::PARAM_INT);
                        break;
                    case '`public_key`':
                        $stmt->bindValue($identifier, $this->public_key, PDO::PARAM_STR);
                        break;
                    case '`website_hash`':
                        $stmt->bindValue($identifier, $this->website_hash, PDO::PARAM_STR);
                        break;
                    case '`notification_recipient`':
                        $stmt->bindValue($identifier, $this->notification_recipient, PDO::PARAM_STR);
                        break;
                    case '`notification_sender`':
                        $stmt->bindValue($identifier, $this->notification_sender, PDO::PARAM_STR);
                        break;
                    case '`notification_change`':
                        $stmt->bindValue($identifier, (int) $this->notification_change, PDO::PARAM_INT);
                        break;
                    case '`notification_error`':
                        $stmt->bindValue($identifier, (int) $this->notification_error, PDO::PARAM_INT);
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

            if ($this->aCustomer !== null) {
                if (!$this->aCustomer->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aCustomer->getValidationFailures());
                }
            }


            if (($retval = RemoteAppPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }


                if ($this->collApiLogs !== null) {
                    foreach ($this->collApiLogs as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collRemoteHistoryContaos !== null) {
                    foreach ($this->collRemoteHistoryContaos as $referrerFK) {
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
        $pos = RemoteAppPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
                return $this->getType();
                break;
            case 2:
                return $this->getName();
                break;
            case 3:
                return $this->getDomain();
                break;
            case 4:
                return $this->getApiUrl();
                break;
            case 5:
                return $this->getApiAuthHttpUser();
                break;
            case 6:
                return $this->getApiAuthHttpPassword();
                break;
            case 7:
                return $this->getApiAuthType();
                break;
            case 8:
                return $this->getApiAuthUser();
                break;
            case 9:
                return $this->getApiAuthPassword();
                break;
            case 10:
                return $this->getApiAuthToken();
                break;
            case 11:
                return $this->getApiAuthUrlUserKey();
                break;
            case 12:
                return $this->getApiAuthUrlPwKey();
                break;
            case 13:
                return $this->getCron();
                break;
            case 14:
                return $this->getCustomerId();
                break;
            case 15:
                return $this->getActivated();
                break;
            case 16:
                return $this->getNotes();
                break;
            case 17:
                return $this->getLastRun();
                break;
            case 18:
                return $this->getIncludelog();
                break;
            case 19:
                return $this->getPublicKey();
                break;
            case 20:
                return $this->getWebsiteHash();
                break;
            case 21:
                return $this->getNotificationRecipient();
                break;
            case 22:
                return $this->getNotificationSender();
                break;
            case 23:
                return $this->getNotificationChange();
                break;
            case 24:
                return $this->getNotificationError();
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
        if (isset($alreadyDumpedObjects['RemoteApp'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['RemoteApp'][$this->getPrimaryKey()] = true;
        $keys = RemoteAppPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getType(),
            $keys[2] => $this->getName(),
            $keys[3] => $this->getDomain(),
            $keys[4] => $this->getApiUrl(),
            $keys[5] => $this->getApiAuthHttpUser(),
            $keys[6] => $this->getApiAuthHttpPassword(),
            $keys[7] => $this->getApiAuthType(),
            $keys[8] => $this->getApiAuthUser(),
            $keys[9] => $this->getApiAuthPassword(),
            $keys[10] => $this->getApiAuthToken(),
            $keys[11] => $this->getApiAuthUrlUserKey(),
            $keys[12] => $this->getApiAuthUrlPwKey(),
            $keys[13] => $this->getCron(),
            $keys[14] => $this->getCustomerId(),
            $keys[15] => $this->getActivated(),
            $keys[16] => $this->getNotes(),
            $keys[17] => $this->getLastRun(),
            $keys[18] => $this->getIncludelog(),
            $keys[19] => $this->getPublicKey(),
            $keys[20] => $this->getWebsiteHash(),
            $keys[21] => $this->getNotificationRecipient(),
            $keys[22] => $this->getNotificationSender(),
            $keys[23] => $this->getNotificationChange(),
            $keys[24] => $this->getNotificationError(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aCustomer) {
                $result['Customer'] = $this->aCustomer->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collApiLogs) {
                $result['ApiLogs'] = $this->collApiLogs->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collRemoteHistoryContaos) {
                $result['RemoteHistoryContaos'] = $this->collRemoteHistoryContaos->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = RemoteAppPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

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
                $this->setType($value);
                break;
            case 2:
                $this->setName($value);
                break;
            case 3:
                $this->setDomain($value);
                break;
            case 4:
                $this->setApiUrl($value);
                break;
            case 5:
                $this->setApiAuthHttpUser($value);
                break;
            case 6:
                $this->setApiAuthHttpPassword($value);
                break;
            case 7:
                $this->setApiAuthType($value);
                break;
            case 8:
                $this->setApiAuthUser($value);
                break;
            case 9:
                $this->setApiAuthPassword($value);
                break;
            case 10:
                $this->setApiAuthToken($value);
                break;
            case 11:
                $this->setApiAuthUrlUserKey($value);
                break;
            case 12:
                $this->setApiAuthUrlPwKey($value);
                break;
            case 13:
                $this->setCron($value);
                break;
            case 14:
                $this->setCustomerId($value);
                break;
            case 15:
                $this->setActivated($value);
                break;
            case 16:
                $this->setNotes($value);
                break;
            case 17:
                $this->setLastRun($value);
                break;
            case 18:
                $this->setIncludelog($value);
                break;
            case 19:
                $this->setPublicKey($value);
                break;
            case 20:
                $this->setWebsiteHash($value);
                break;
            case 21:
                $this->setNotificationRecipient($value);
                break;
            case 22:
                $this->setNotificationSender($value);
                break;
            case 23:
                $this->setNotificationChange($value);
                break;
            case 24:
                $this->setNotificationError($value);
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
        $keys = RemoteAppPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setType($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setName($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setDomain($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setApiUrl($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setApiAuthHttpUser($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setApiAuthHttpPassword($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setApiAuthType($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setApiAuthUser($arr[$keys[8]]);
        if (array_key_exists($keys[9], $arr)) $this->setApiAuthPassword($arr[$keys[9]]);
        if (array_key_exists($keys[10], $arr)) $this->setApiAuthToken($arr[$keys[10]]);
        if (array_key_exists($keys[11], $arr)) $this->setApiAuthUrlUserKey($arr[$keys[11]]);
        if (array_key_exists($keys[12], $arr)) $this->setApiAuthUrlPwKey($arr[$keys[12]]);
        if (array_key_exists($keys[13], $arr)) $this->setCron($arr[$keys[13]]);
        if (array_key_exists($keys[14], $arr)) $this->setCustomerId($arr[$keys[14]]);
        if (array_key_exists($keys[15], $arr)) $this->setActivated($arr[$keys[15]]);
        if (array_key_exists($keys[16], $arr)) $this->setNotes($arr[$keys[16]]);
        if (array_key_exists($keys[17], $arr)) $this->setLastRun($arr[$keys[17]]);
        if (array_key_exists($keys[18], $arr)) $this->setIncludelog($arr[$keys[18]]);
        if (array_key_exists($keys[19], $arr)) $this->setPublicKey($arr[$keys[19]]);
        if (array_key_exists($keys[20], $arr)) $this->setWebsiteHash($arr[$keys[20]]);
        if (array_key_exists($keys[21], $arr)) $this->setNotificationRecipient($arr[$keys[21]]);
        if (array_key_exists($keys[22], $arr)) $this->setNotificationSender($arr[$keys[22]]);
        if (array_key_exists($keys[23], $arr)) $this->setNotificationChange($arr[$keys[23]]);
        if (array_key_exists($keys[24], $arr)) $this->setNotificationError($arr[$keys[24]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(RemoteAppPeer::DATABASE_NAME);

        if ($this->isColumnModified(RemoteAppPeer::ID)) $criteria->add(RemoteAppPeer::ID, $this->id);
        if ($this->isColumnModified(RemoteAppPeer::TYPE)) $criteria->add(RemoteAppPeer::TYPE, $this->type);
        if ($this->isColumnModified(RemoteAppPeer::NAME)) $criteria->add(RemoteAppPeer::NAME, $this->name);
        if ($this->isColumnModified(RemoteAppPeer::DOMAIN)) $criteria->add(RemoteAppPeer::DOMAIN, $this->domain);
        if ($this->isColumnModified(RemoteAppPeer::API_URL)) $criteria->add(RemoteAppPeer::API_URL, $this->api_url);
        if ($this->isColumnModified(RemoteAppPeer::API_AUTH_HTTP_USER)) $criteria->add(RemoteAppPeer::API_AUTH_HTTP_USER, $this->api_auth_http_user);
        if ($this->isColumnModified(RemoteAppPeer::API_AUTH_HTTP_PASSWORD)) $criteria->add(RemoteAppPeer::API_AUTH_HTTP_PASSWORD, $this->api_auth_http_password);
        if ($this->isColumnModified(RemoteAppPeer::API_AUTH_TYPE)) $criteria->add(RemoteAppPeer::API_AUTH_TYPE, $this->api_auth_type);
        if ($this->isColumnModified(RemoteAppPeer::API_AUTH_USER)) $criteria->add(RemoteAppPeer::API_AUTH_USER, $this->api_auth_user);
        if ($this->isColumnModified(RemoteAppPeer::API_AUTH_PASSWORD)) $criteria->add(RemoteAppPeer::API_AUTH_PASSWORD, $this->api_auth_password);
        if ($this->isColumnModified(RemoteAppPeer::API_AUTH_TOKEN)) $criteria->add(RemoteAppPeer::API_AUTH_TOKEN, $this->api_auth_token);
        if ($this->isColumnModified(RemoteAppPeer::API_AUTH_URL_USER_KEY)) $criteria->add(RemoteAppPeer::API_AUTH_URL_USER_KEY, $this->api_auth_url_user_key);
        if ($this->isColumnModified(RemoteAppPeer::API_AUTH_URL_PW_KEY)) $criteria->add(RemoteAppPeer::API_AUTH_URL_PW_KEY, $this->api_auth_url_pw_key);
        if ($this->isColumnModified(RemoteAppPeer::CRON)) $criteria->add(RemoteAppPeer::CRON, $this->cron);
        if ($this->isColumnModified(RemoteAppPeer::CUSTOMER_ID)) $criteria->add(RemoteAppPeer::CUSTOMER_ID, $this->customer_id);
        if ($this->isColumnModified(RemoteAppPeer::ACTIVATED)) $criteria->add(RemoteAppPeer::ACTIVATED, $this->activated);
        if ($this->isColumnModified(RemoteAppPeer::NOTES)) $criteria->add(RemoteAppPeer::NOTES, $this->notes);
        if ($this->isColumnModified(RemoteAppPeer::LAST_RUN)) $criteria->add(RemoteAppPeer::LAST_RUN, $this->last_run);
        if ($this->isColumnModified(RemoteAppPeer::INCLUDELOG)) $criteria->add(RemoteAppPeer::INCLUDELOG, $this->includelog);
        if ($this->isColumnModified(RemoteAppPeer::PUBLIC_KEY)) $criteria->add(RemoteAppPeer::PUBLIC_KEY, $this->public_key);
        if ($this->isColumnModified(RemoteAppPeer::WEBSITE_HASH)) $criteria->add(RemoteAppPeer::WEBSITE_HASH, $this->website_hash);
        if ($this->isColumnModified(RemoteAppPeer::NOTIFICATION_RECIPIENT)) $criteria->add(RemoteAppPeer::NOTIFICATION_RECIPIENT, $this->notification_recipient);
        if ($this->isColumnModified(RemoteAppPeer::NOTIFICATION_SENDER)) $criteria->add(RemoteAppPeer::NOTIFICATION_SENDER, $this->notification_sender);
        if ($this->isColumnModified(RemoteAppPeer::NOTIFICATION_CHANGE)) $criteria->add(RemoteAppPeer::NOTIFICATION_CHANGE, $this->notification_change);
        if ($this->isColumnModified(RemoteAppPeer::NOTIFICATION_ERROR)) $criteria->add(RemoteAppPeer::NOTIFICATION_ERROR, $this->notification_error);

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
        $criteria = new Criteria(RemoteAppPeer::DATABASE_NAME);
        $criteria->add(RemoteAppPeer::ID, $this->id);

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
     * @param object $copyObj An object of RemoteApp (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setType($this->getType());
        $copyObj->setName($this->getName());
        $copyObj->setDomain($this->getDomain());
        $copyObj->setApiUrl($this->getApiUrl());
        $copyObj->setApiAuthHttpUser($this->getApiAuthHttpUser());
        $copyObj->setApiAuthHttpPassword($this->getApiAuthHttpPassword());
        $copyObj->setApiAuthType($this->getApiAuthType());
        $copyObj->setApiAuthUser($this->getApiAuthUser());
        $copyObj->setApiAuthPassword($this->getApiAuthPassword());
        $copyObj->setApiAuthToken($this->getApiAuthToken());
        $copyObj->setApiAuthUrlUserKey($this->getApiAuthUrlUserKey());
        $copyObj->setApiAuthUrlPwKey($this->getApiAuthUrlPwKey());
        $copyObj->setCron($this->getCron());
        $copyObj->setCustomerId($this->getCustomerId());
        $copyObj->setActivated($this->getActivated());
        $copyObj->setNotes($this->getNotes());
        $copyObj->setLastRun($this->getLastRun());
        $copyObj->setIncludelog($this->getIncludelog());
        $copyObj->setPublicKey($this->getPublicKey());
        $copyObj->setWebsiteHash($this->getWebsiteHash());
        $copyObj->setNotificationRecipient($this->getNotificationRecipient());
        $copyObj->setNotificationSender($this->getNotificationSender());
        $copyObj->setNotificationChange($this->getNotificationChange());
        $copyObj->setNotificationError($this->getNotificationError());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

            foreach ($this->getApiLogs() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addApiLog($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getRemoteHistoryContaos() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addRemoteHistoryContao($relObj->copy($deepCopy));
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
     * @return RemoteApp Clone of current object.
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
     * @return RemoteAppPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new RemoteAppPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a Customer object.
     *
     * @param                  Customer $v
     * @return RemoteApp The current object (for fluent API support)
     * @throws PropelException
     */
    public function setCustomer(Customer $v = null)
    {
        if ($v === null) {
            $this->setCustomerId(NULL);
        } else {
            $this->setCustomerId($v->getId());
        }

        $this->aCustomer = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Customer object, it will not be re-added.
        if ($v !== null) {
            $v->addRemoteApp($this);
        }


        return $this;
    }


    /**
     * Get the associated Customer object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Customer The associated Customer object.
     * @throws PropelException
     */
    public function getCustomer(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aCustomer === null && ($this->customer_id !== null) && $doQuery) {
            $this->aCustomer = CustomerQuery::create()->findPk($this->customer_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aCustomer->addRemoteApps($this);
             */
        }

        return $this->aCustomer;
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
        if ('ApiLog' == $relationName) {
            $this->initApiLogs();
        }
        if ('RemoteHistoryContao' == $relationName) {
            $this->initRemoteHistoryContaos();
        }
    }

    /**
     * Clears out the collApiLogs collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return RemoteApp The current object (for fluent API support)
     * @see        addApiLogs()
     */
    public function clearApiLogs()
    {
        $this->collApiLogs = null; // important to set this to null since that means it is uninitialized
        $this->collApiLogsPartial = null;

        return $this;
    }

    /**
     * reset is the collApiLogs collection loaded partially
     *
     * @return void
     */
    public function resetPartialApiLogs($v = true)
    {
        $this->collApiLogsPartial = $v;
    }

    /**
     * Initializes the collApiLogs collection.
     *
     * By default this just sets the collApiLogs collection to an empty array (like clearcollApiLogs());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initApiLogs($overrideExisting = true)
    {
        if (null !== $this->collApiLogs && !$overrideExisting) {
            return;
        }
        $this->collApiLogs = new PropelObjectCollection();
        $this->collApiLogs->setModel('ApiLog');
    }

    /**
     * Gets an array of ApiLog objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this RemoteApp is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|ApiLog[] List of ApiLog objects
     * @throws PropelException
     */
    public function getApiLogs($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collApiLogsPartial && !$this->isNew();
        if (null === $this->collApiLogs || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collApiLogs) {
                // return empty collection
                $this->initApiLogs();
            } else {
                $collApiLogs = ApiLogQuery::create(null, $criteria)
                    ->filterByRemoteApp($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collApiLogsPartial && count($collApiLogs)) {
                      $this->initApiLogs(false);

                      foreach ($collApiLogs as $obj) {
                        if (false == $this->collApiLogs->contains($obj)) {
                          $this->collApiLogs->append($obj);
                        }
                      }

                      $this->collApiLogsPartial = true;
                    }

                    $collApiLogs->getInternalIterator()->rewind();

                    return $collApiLogs;
                }

                if ($partial && $this->collApiLogs) {
                    foreach ($this->collApiLogs as $obj) {
                        if ($obj->isNew()) {
                            $collApiLogs[] = $obj;
                        }
                    }
                }

                $this->collApiLogs = $collApiLogs;
                $this->collApiLogsPartial = false;
            }
        }

        return $this->collApiLogs;
    }

    /**
     * Sets a collection of ApiLog objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $apiLogs A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return RemoteApp The current object (for fluent API support)
     */
    public function setApiLogs(PropelCollection $apiLogs, PropelPDO $con = null)
    {
        $apiLogsToDelete = $this->getApiLogs(new Criteria(), $con)->diff($apiLogs);


        $this->apiLogsScheduledForDeletion = $apiLogsToDelete;

        foreach ($apiLogsToDelete as $apiLogRemoved) {
            $apiLogRemoved->setRemoteApp(null);
        }

        $this->collApiLogs = null;
        foreach ($apiLogs as $apiLog) {
            $this->addApiLog($apiLog);
        }

        $this->collApiLogs = $apiLogs;
        $this->collApiLogsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ApiLog objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related ApiLog objects.
     * @throws PropelException
     */
    public function countApiLogs(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collApiLogsPartial && !$this->isNew();
        if (null === $this->collApiLogs || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collApiLogs) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getApiLogs());
            }
            $query = ApiLogQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByRemoteApp($this)
                ->count($con);
        }

        return count($this->collApiLogs);
    }

    /**
     * Method called to associate a ApiLog object to this object
     * through the ApiLog foreign key attribute.
     *
     * @param    ApiLog $l ApiLog
     * @return RemoteApp The current object (for fluent API support)
     */
    public function addApiLog(ApiLog $l)
    {
        if ($this->collApiLogs === null) {
            $this->initApiLogs();
            $this->collApiLogsPartial = true;
        }

        if (!in_array($l, $this->collApiLogs->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddApiLog($l);

            if ($this->apiLogsScheduledForDeletion and $this->apiLogsScheduledForDeletion->contains($l)) {
                $this->apiLogsScheduledForDeletion->remove($this->apiLogsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	ApiLog $apiLog The apiLog object to add.
     */
    protected function doAddApiLog($apiLog)
    {
        $this->collApiLogs[]= $apiLog;
        $apiLog->setRemoteApp($this);
    }

    /**
     * @param	ApiLog $apiLog The apiLog object to remove.
     * @return RemoteApp The current object (for fluent API support)
     */
    public function removeApiLog($apiLog)
    {
        if ($this->getApiLogs()->contains($apiLog)) {
            $this->collApiLogs->remove($this->collApiLogs->search($apiLog));
            if (null === $this->apiLogsScheduledForDeletion) {
                $this->apiLogsScheduledForDeletion = clone $this->collApiLogs;
                $this->apiLogsScheduledForDeletion->clear();
            }
            $this->apiLogsScheduledForDeletion[]= clone $apiLog;
            $apiLog->setRemoteApp(null);
        }

        return $this;
    }

    /**
     * Clears out the collRemoteHistoryContaos collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return RemoteApp The current object (for fluent API support)
     * @see        addRemoteHistoryContaos()
     */
    public function clearRemoteHistoryContaos()
    {
        $this->collRemoteHistoryContaos = null; // important to set this to null since that means it is uninitialized
        $this->collRemoteHistoryContaosPartial = null;

        return $this;
    }

    /**
     * reset is the collRemoteHistoryContaos collection loaded partially
     *
     * @return void
     */
    public function resetPartialRemoteHistoryContaos($v = true)
    {
        $this->collRemoteHistoryContaosPartial = $v;
    }

    /**
     * Initializes the collRemoteHistoryContaos collection.
     *
     * By default this just sets the collRemoteHistoryContaos collection to an empty array (like clearcollRemoteHistoryContaos());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initRemoteHistoryContaos($overrideExisting = true)
    {
        if (null !== $this->collRemoteHistoryContaos && !$overrideExisting) {
            return;
        }
        $this->collRemoteHistoryContaos = new PropelObjectCollection();
        $this->collRemoteHistoryContaos->setModel('RemoteHistoryContao');
    }

    /**
     * Gets an array of RemoteHistoryContao objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this RemoteApp is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|RemoteHistoryContao[] List of RemoteHistoryContao objects
     * @throws PropelException
     */
    public function getRemoteHistoryContaos($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collRemoteHistoryContaosPartial && !$this->isNew();
        if (null === $this->collRemoteHistoryContaos || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collRemoteHistoryContaos) {
                // return empty collection
                $this->initRemoteHistoryContaos();
            } else {
                $collRemoteHistoryContaos = RemoteHistoryContaoQuery::create(null, $criteria)
                    ->filterByRemoteApp($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collRemoteHistoryContaosPartial && count($collRemoteHistoryContaos)) {
                      $this->initRemoteHistoryContaos(false);

                      foreach ($collRemoteHistoryContaos as $obj) {
                        if (false == $this->collRemoteHistoryContaos->contains($obj)) {
                          $this->collRemoteHistoryContaos->append($obj);
                        }
                      }

                      $this->collRemoteHistoryContaosPartial = true;
                    }

                    $collRemoteHistoryContaos->getInternalIterator()->rewind();

                    return $collRemoteHistoryContaos;
                }

                if ($partial && $this->collRemoteHistoryContaos) {
                    foreach ($this->collRemoteHistoryContaos as $obj) {
                        if ($obj->isNew()) {
                            $collRemoteHistoryContaos[] = $obj;
                        }
                    }
                }

                $this->collRemoteHistoryContaos = $collRemoteHistoryContaos;
                $this->collRemoteHistoryContaosPartial = false;
            }
        }

        return $this->collRemoteHistoryContaos;
    }

    /**
     * Sets a collection of RemoteHistoryContao objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $remoteHistoryContaos A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return RemoteApp The current object (for fluent API support)
     */
    public function setRemoteHistoryContaos(PropelCollection $remoteHistoryContaos, PropelPDO $con = null)
    {
        $remoteHistoryContaosToDelete = $this->getRemoteHistoryContaos(new Criteria(), $con)->diff($remoteHistoryContaos);


        $this->remoteHistoryContaosScheduledForDeletion = $remoteHistoryContaosToDelete;

        foreach ($remoteHistoryContaosToDelete as $remoteHistoryContaoRemoved) {
            $remoteHistoryContaoRemoved->setRemoteApp(null);
        }

        $this->collRemoteHistoryContaos = null;
        foreach ($remoteHistoryContaos as $remoteHistoryContao) {
            $this->addRemoteHistoryContao($remoteHistoryContao);
        }

        $this->collRemoteHistoryContaos = $remoteHistoryContaos;
        $this->collRemoteHistoryContaosPartial = false;

        return $this;
    }

    /**
     * Returns the number of related RemoteHistoryContao objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related RemoteHistoryContao objects.
     * @throws PropelException
     */
    public function countRemoteHistoryContaos(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collRemoteHistoryContaosPartial && !$this->isNew();
        if (null === $this->collRemoteHistoryContaos || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collRemoteHistoryContaos) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getRemoteHistoryContaos());
            }
            $query = RemoteHistoryContaoQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByRemoteApp($this)
                ->count($con);
        }

        return count($this->collRemoteHistoryContaos);
    }

    /**
     * Method called to associate a RemoteHistoryContao object to this object
     * through the RemoteHistoryContao foreign key attribute.
     *
     * @param    RemoteHistoryContao $l RemoteHistoryContao
     * @return RemoteApp The current object (for fluent API support)
     */
    public function addRemoteHistoryContao(RemoteHistoryContao $l)
    {
        if ($this->collRemoteHistoryContaos === null) {
            $this->initRemoteHistoryContaos();
            $this->collRemoteHistoryContaosPartial = true;
        }

        if (!in_array($l, $this->collRemoteHistoryContaos->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddRemoteHistoryContao($l);

            if ($this->remoteHistoryContaosScheduledForDeletion and $this->remoteHistoryContaosScheduledForDeletion->contains($l)) {
                $this->remoteHistoryContaosScheduledForDeletion->remove($this->remoteHistoryContaosScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	RemoteHistoryContao $remoteHistoryContao The remoteHistoryContao object to add.
     */
    protected function doAddRemoteHistoryContao($remoteHistoryContao)
    {
        $this->collRemoteHistoryContaos[]= $remoteHistoryContao;
        $remoteHistoryContao->setRemoteApp($this);
    }

    /**
     * @param	RemoteHistoryContao $remoteHistoryContao The remoteHistoryContao object to remove.
     * @return RemoteApp The current object (for fluent API support)
     */
    public function removeRemoteHistoryContao($remoteHistoryContao)
    {
        if ($this->getRemoteHistoryContaos()->contains($remoteHistoryContao)) {
            $this->collRemoteHistoryContaos->remove($this->collRemoteHistoryContaos->search($remoteHistoryContao));
            if (null === $this->remoteHistoryContaosScheduledForDeletion) {
                $this->remoteHistoryContaosScheduledForDeletion = clone $this->collRemoteHistoryContaos;
                $this->remoteHistoryContaosScheduledForDeletion->clear();
            }
            $this->remoteHistoryContaosScheduledForDeletion[]= clone $remoteHistoryContao;
            $remoteHistoryContao->setRemoteApp(null);
        }

        return $this;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id = null;
        $this->type = null;
        $this->name = null;
        $this->domain = null;
        $this->api_url = null;
        $this->api_auth_http_user = null;
        $this->api_auth_http_password = null;
        $this->api_auth_type = null;
        $this->api_auth_user = null;
        $this->api_auth_password = null;
        $this->api_auth_token = null;
        $this->api_auth_url_user_key = null;
        $this->api_auth_url_pw_key = null;
        $this->cron = null;
        $this->customer_id = null;
        $this->activated = null;
        $this->notes = null;
        $this->last_run = null;
        $this->includelog = null;
        $this->public_key = null;
        $this->website_hash = null;
        $this->notification_recipient = null;
        $this->notification_sender = null;
        $this->notification_change = null;
        $this->notification_error = null;
        $this->alreadyInSave = false;
        $this->alreadyInValidation = false;
        $this->alreadyInClearAllReferencesDeep = false;
        $this->clearAllReferences();
        $this->applyDefaultValues();
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
            if ($this->collApiLogs) {
                foreach ($this->collApiLogs as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collRemoteHistoryContaos) {
                foreach ($this->collRemoteHistoryContaos as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->aCustomer instanceof Persistent) {
              $this->aCustomer->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        if ($this->collApiLogs instanceof PropelCollection) {
            $this->collApiLogs->clearIterator();
        }
        $this->collApiLogs = null;
        if ($this->collRemoteHistoryContaos instanceof PropelCollection) {
            $this->collRemoteHistoryContaos->clearIterator();
        }
        $this->collRemoteHistoryContaos = null;
        $this->aCustomer = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(RemoteAppPeer::DEFAULT_STRING_FORMAT);
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

<?php
/**
 * Simple Database Model
 */

namespace Blink\Db\Adapter;

/**
 * Database adapter
 *
 * This is a basic PDO wrapper.  The purpose of this class is just to simplify
 * performing queries and returning results.
 *
 * @package Blink\Db
 */
class Pdo
{
    /**
     * @var \PDO
     */
    protected $_db;


    /**
     * Class constructor
     * @param \PDO $Connection
     */
    public function __construct(\PDO $Connection)
    {
        $this->_db = $Connection;
    }

    /**
     * Get connection object
     * @return \PDO
     */
    public function getConnection()
    {
        return $this->_db;
    }


    /**
     * Query the database
     * @param string $sql
     * @param array $bind
     * @return \PDOStatement
     */
    public function query($sql, $bind = array())
    {
        $Statement = $this->_db->prepare($sql);
        $Statement->execute($bind);
        return $Statement;
    }

    /**
     * Fetch one column
     * @param string $sql
     * @param array $bind
     * @return string
     */
    public function fetchOne($sql, $bind = array())
    {
        $Statement = $this->query($sql, $bind);
        return $Statement->fetchColumn();
    }

    /**
     * Fetch all rows
     * @param string $sql
     * @param array $bind
     * @return array
     */
    public function fetchAll($sql, $bind = array())
    {
        $Statement = $this->query($sql, $bind);
        return $Statement->fetchAll();
    }

    /**
     * Fetch one row
     * @param string $sql
     * @param array $bind
     * @return mixed
     */
    public function fetchRow($sql, $bind = array())
    {
        $Statement = $this->query($sql, $bind);
        return $Statement->fetch();
    }

    /**
     * Get error info
     * @return array
     */
    public function getErrorInfo()
    {
        return $this->_db->errorInfo();
    }

    /**
     * Get error code
     * @return mixed
     */
    public function getErrorCode()
    {
        return $this->_db->errorCode();
    }
}
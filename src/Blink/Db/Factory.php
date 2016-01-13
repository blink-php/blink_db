<?php
/**
 * Simple Database Model
 */

namespace Blink\Db;

/**
 * Database Factory
 *
 * This class allows you to create a new PDO connection and pass it to the DB
 * adapter.
 *
 * @package Blink\Db
 */
class Factory
{
    /**
     * @var array Cache of named connections
     */
    static protected $_connections = array();

    static public $defaultConnectionOptions = [
        \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
    ];

    /**
     * Get a new PDO connection
     *
     * This is the simplest way to get a new PDO connection and handler.  It's
     * is a light wrapper around the core PDO class which returns a Blink DB
     * adapter.
     *
     * @param string $pdoDsn
     * @param string $userName
     * @param string $password
     * @param array $options
     * @return Adapter\Pdo
     */
    static public function getConnection($pdoDsn, $userName = "", $password = "", array $options = [])
    {
        if (!$pdoDsn) {
            throw new \InvalidArgumentException("Connection DSN required.");
        }

        return new Adapter\Pdo(
            new \PDO(
                $pdoDsn,
                $userName,
                $password,
                ($options == []) ? self::$defaultConnectionOptions : $options
            )
        );
    }

    /**
     * Get connection
     *
     * @param string $connectionName
     * @param string $pdoDsn
     * @param string $userName
     * @param string $password
     * @param array $options
     * @return Adapter\Pdo
     */
    static public function getConnectionSingleton($connectionName, $pdoDsn = "", $userName = "", $password = "", array $options = [])
    {
        // Check if connection cached
        if (self::_isCached($connectionName)) {
            return self::$_connections[$connectionName];
        }

        // Get a new connection and add to cache
        return self::_setCachedConnection(
            $connectionName,
            self::getConnection(
                $pdoDsn,
                $userName,
                $password,
                $options
            )
        );
    }


    static protected function _isCached($connectionName)
    {
        return (
            isset(self::$_connections[$connectionName])
            && self::$_connections[$connectionName] instanceof Adapter\Pdo
        );
    }


    static protected function _setCachedConnection($connectionName, Adapter\Pdo $Connection)
    {
        self::$_connections[$connectionName] = $Connection;

        return self::$_connections[$connectionName];
    }
}
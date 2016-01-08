<?php
/**
 * Simple Database Model
 */

namespace Blink\Db;

/**
 * Database Factory
 *
 * PDO Connections only.
 *
 * @todo Add named connection look ups based on config.
 * @package Blink\Db
 */
class Factory
{
    static protected $_connections = array();

    /**
     * Get connection
     * @param string $pdoDsn
     * @param string $userName
     * @param string $password
     * @return \Blink\Db\Adapter\Pdo
     */
    static public function getConnection($pdoDsn, $userName, $password)
    {
        // Check if connection cached
        $dsnKey = md5($pdoDsn);
        if (isset(self::$_connections[$dsnKey])) {
            return self::$_connections[$dsnKey];
        }

        $PdoConnection = new \PDO(
            $pdoDsn,
            $userName,
            $password,
            array(
                \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
            )
        );

        $Db = new Adapter\Pdo($PdoConnection);

        self::$_connections[$dsnKey] = $Db;

        return self::$_connections[$dsnKey];
    }
}
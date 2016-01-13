<?php


class PdoTest extends PHPUnit_Framework_TestCase
{
    protected function _getDsn()
    {
        $dbFile = __DIR__ . '/../../../../fixture/test_db.sq3';

        if (!is_file($dbFile)) {
            $this->fail("Cannot find test DB.");
        }

        return 'sqlite:/' . realpath($dbFile);
    }

    protected function _getPdoConneciton()
    {
        return new \PDO(
            $this->_getDsn()
        );
    }

    public function testGetConnection()
    {
        $PDO = $this->_getPdoConneciton();

        $Adapter = new Blink\Db\Adapter\Pdo($PDO);

        $this->assertTrue($PDO === $Adapter->getConnection(), "Got raw PDO connection.");
    }
}

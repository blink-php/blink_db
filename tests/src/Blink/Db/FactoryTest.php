<?php


class FactoryTest extends PHPUnit_Framework_TestCase
{
    protected function _getTestDsn()
    {
        $dbFile = __DIR__ . '/../../../fixture/test_db.sq3';

        if (!is_file($dbFile)) {
            $this->fail("Cannot find test DB.");
        }

        return 'sqlite:/' . realpath($dbFile);
    }


    public function testFactory()
    {
        $DB = Blink\Db\Factory::getConnection($this->_getTestDsn());

        $this->assertInstanceOf('Blink\\Db\\Adapter\\Pdo', $DB, "Got a valid adapter.");
    }

    public function testNamedConnection()
    {
        $DB1 = Blink\Db\Factory::getConnectionSingleton('TEST_A', $this->_getTestDsn());
        $DB2 = Blink\Db\Factory::getConnectionSingleton('TEST_B', $this->_getTestDsn());

        $this->assertTrue($DB1 !== $DB2, "Different named connections are not the same instance.");
        $this->assertTrue($DB1 === Blink\Db\Factory::getConnectionSingleton('TEST_A'), "Calling a second time retrieves the correct instance.");
        $this->assertTrue($DB2 === Blink\Db\Factory::getConnectionSingleton('TEST_B'), "Calling a second time retrieves the correct instance.");
    }

    public function testBadDsn()
    {
        try {
            Blink\Db\Factory::getConnection(null);
            $this->fail("Expected exception to be throw for missing DSN");
        }
        catch (\Exception $e) {
            $this->assertTrue($e instanceof \InvalidArgumentException);
        }
    }
}

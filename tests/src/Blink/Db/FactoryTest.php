<?php


class FactoryTest extends PHPUnit_Framework_TestCase
{
    protected function _readConnectionSetting()
    {
        $settings = file_get_contents(__DIR__ . '/../../../fixture/connection-string.json');
        return json_decode($settings, true);
    }

    public function testFactory()
    {
        $settings = $this->_readConnectionSetting();

        $DB = Blink\Db\Factory::getConnection(
            $settings['dsn'],
            $settings['user'],
            $settings['password']
        );

        $this->assertInstanceOf('Blink\\Db\\Adapter\\Pdo', $DB, "Got a valid adapter.");
    }
}

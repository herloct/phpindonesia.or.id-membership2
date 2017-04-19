<?php
namespace Membership\Models;

class RegionalsTest extends \Codeception\Test\Unit
{
    const TABLE = 'regionals';

    /**
     * @var \Membership\IntegrationTester
     */
    protected $tester;

    /**
     * @var Regionals
     */
    private $model;

    protected function _before()
    {
        $this->model = new Regionals($this->tester->getSlimDatabase());
    }

    protected function _after()
    {
    }

    // tests
    public function testGetProvinces()
    {
        $provinces = $this->model->getProvinces();

        $this->assertInternalType('array', $provinces);
        $this->assertContainsOnly('array', $provinces);

        $count = $this->tester->grabNumRecords(self::TABLE, ['parent_id' => null]);
        $this->assertCount($count, $provinces);

        $province = $provinces[0];
        $this->assertArrayHasKey('id', $province);
        $this->assertArrayHasKey('regional_name', $province);
        $this->assertInternalType('int', $province['id']);
        $this->assertInternalType('string', $province['regional_name']);

        $id = $this->tester->grabFromDatabase(
            self::TABLE,
            'id',
            ['id' => $province['id']]
        );
        $this->assertEquals($id, $province['id']);

        $regionalName = $this->tester->grabFromDatabase(
            self::TABLE,
            'regional_name',
            ['id' => $province['id']]
        );
        $this->assertEquals($regionalName, $province['regional_name']);
    }

    public function testGetCities()
    {
        $provinces = $this->model->getProvinces();
        $province = $provinces[mt_rand(0, count($provinces) - 1)];

        $cities = $this->model->getCities($province['id']);

        $this->assertInternalType('array', $cities);
        $this->assertContainsOnly('array', $cities);

        $count = $this->tester->grabNumRecords(self::TABLE, ['parent_id' => $province['id']]);
        $this->assertCount($count, $cities);

        $city = $cities[0];
        $this->assertArrayHasKey('id', $city);
        $this->assertArrayHasKey('regional_name', $city);
        $this->assertInternalType('int', $city['id']);
        $this->assertInternalType('string', $city['regional_name']);

        $id = $this->tester->grabFromDatabase(
            self::TABLE,
            'id',
            ['id' => $city['id']]
        );
        $this->assertEquals($id, $city['id']);

        $regionalName = $this->tester->grabFromDatabase(
            self::TABLE,
            'regional_name',
            ['id' => $city['id']]
        );
        $this->assertEquals($regionalName, $city['regional_name']);
    }
}

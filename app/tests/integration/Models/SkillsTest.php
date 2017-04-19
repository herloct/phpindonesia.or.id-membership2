<?php
namespace Membership\Models;


class SkillsTest extends \Codeception\Test\Unit
{
    const TABLE = 'skills';

    /**
     * @var \Membership\IntegrationTester
     */
    protected $tester;

    /**
     * @var Skills
     */
    private $model;

    protected function _before()
    {
        $this->model = new Skills($this->tester->getSlimDatabase());
    }

    protected function _after()
    {
    }

    // tests
    public function testGetParents()
    {
        $parents = $this->model->getParents();

        $this->assertInternalType('array', $parents);
        $this->assertContainsOnly('array', $parents);

        $count = $this->tester->grabNumRecords(self::TABLE, ['parent_id' => null]);
        $this->assertCount($count, $parents);

        $parent = $parents[0];
        $this->assertArrayHasKey('skill_id', $parent);
        $this->assertArrayHasKey('skill_name', $parent);
        $this->assertInternalType('int', $parent['skill_id']);
        $this->assertInternalType('string', $parent['skill_name']);

        $id = $this->tester->grabFromDatabase(
            self::TABLE,
            'skill_id',
            ['skill_id' => $parent['skill_id']]
        );
        $this->assertEquals($id, $parent['skill_id']);

        $name = $this->tester->grabFromDatabase(
            self::TABLE,
            'skill_name',
            ['skill_id' => $parent['skill_id']]
        );
        $this->assertEquals($name, $parent['skill_name']);
    }

    public function testGetChilds()
    {
        $parents = $this->model->getParents();
        $parent = $parents[1];

        $childs = $this->model->getChilds($parent['skill_id']);

        $this->assertInternalType('array', $childs);
        $this->assertContainsOnly('array', $childs);

        $count = $this->tester->grabNumRecords(self::TABLE, ['parent_id' => $parent['skill_id']]);
        $this->assertCount($count, $childs);

        $child = $childs[0];
        $this->assertArrayHasKey('skill_id', $child);
        $this->assertArrayHasKey('skill_name', $child);
        $this->assertInternalType('int', $child['skill_id']);
        $this->assertInternalType('string', $child['skill_name']);

        $id = $this->tester->grabFromDatabase(
            self::TABLE,
            'skill_id',
            ['skill_id' => $child['skill_id']]
        );
        $this->assertEquals($id, $child['skill_id']);

        $name = $this->tester->grabFromDatabase(
            self::TABLE,
            'skill_name',
            ['skill_id' => $child['skill_id']]
        );
        $this->assertEquals($name, $child['skill_name']);
    }

    public function testGetChildsWithNullParent()
    {
        $childs = $this->model->getChilds(null);

        $this->assertInternalType('array', $childs);
        $this->assertCount(0, $childs);
    }
}

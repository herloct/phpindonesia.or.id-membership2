<?php
namespace Membership\Models;

class CareersTest extends \Codeception\Test\Unit
{
    const LEVELS_TABLE = 'career_levels';
    const INDUSTRIES_TABLE = 'industries';
    const JOBS_TABLE = 'jobs';

    /**
     * @var \Membership\IntegrationTester
     */
    protected $tester;

    /**
     * @var Careers
     */
    private $model;

    protected function _before()
    {
        $this->model = new Careers($this->tester->getSlimDatabase());
    }

    protected function _after()
    {
    }

    // tests
    public function testGetLevels()
    {
        $levels = $this->model->getLevels();

        $this->assertInternalType('array', $levels);
        $this->assertContainsOnly('array', $levels);

        $count = $this->tester->grabNumRecords(self::LEVELS_TABLE);
        $this->assertCount($count, $levels);

        $level = $levels[0];
        $this->assertArrayHasKey('career_level_id', $level);
        $this->assertArrayHasKey('order_by', $level);
        $this->assertInternalType('string', $level['career_level_id']);
        $this->assertInternalType('int', $level['order_by']);

        $id = $this->tester->grabFromDatabase(
            self::LEVELS_TABLE,
            'career_level_id',
            ['career_level_id' => $level['career_level_id']]
        );
        $this->assertEquals($id, $level['career_level_id']);

        $orderBy = $this->tester->grabFromDatabase(
            self::LEVELS_TABLE,
            'order_by',
            ['career_level_id' => $level['career_level_id']]
        );
        $this->assertEquals($orderBy, $level['order_by']);
    }

    public function testGetIndustries()
    {
        $industries = $this->model->getIndustries();

        $this->assertInternalType('array', $industries);
        $this->assertContainsOnly('array', $industries);

        $count = $this->tester->grabNumRecords(self::INDUSTRIES_TABLE);
        $this->assertCount($count, $industries);

        $industry = $industries[0];
        $this->assertArrayHasKey('industry_id', $industry);
        $this->assertArrayHasKey('industry_name', $industry);
        $this->assertInternalType('int', $industry['industry_id']);
        $this->assertInternalType('string', $industry['industry_name']);

        $id = $this->tester->grabFromDatabase(
            self::INDUSTRIES_TABLE,
            'industry_id',
            ['industry_id' => $industry['industry_id']]
        );
        $this->assertEquals($id, $industry['industry_id']);

        $name = $this->tester->grabFromDatabase(
            self::INDUSTRIES_TABLE,
            'industry_name',
            ['industry_name' => $industry['industry_name']]
        );
        $this->assertEquals($name, $industry['industry_name']);
    }

    public function testGetJobs()
    {
        $jobs = $this->model->getJobs();

        $this->assertInternalType('array', $jobs);
        $this->assertContainsOnly('array', $jobs);

        $count = $this->tester->grabNumRecords(self::JOBS_TABLE);
        $this->assertCount($count, $jobs);

        $job = $jobs[0];
        $this->assertArrayHasKey('job_id', $job);
        $this->assertInternalType('string', $job['job_id']);

        $id = $this->tester->grabFromDatabase(
            self::JOBS_TABLE,
            'job_id',
            ['job_id' => $job['job_id']]
        );
        $this->assertEquals($id, $job['job_id']);
    }
}

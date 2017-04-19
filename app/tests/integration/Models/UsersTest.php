<?php
namespace Membership\Models;

use Faker\Factory;

class UsersTest extends \Codeception\Test\Unit
{
    const USERS_TABLE = 'users';
    const ROLES_TABLE = 'users_roles';
    const ACTIVATIONS_TABLE = 'users_activations';
    const PROFILES_TABLE = 'members_profiles';

    /**
     * @var \Membership\IntegrationTester
     */
    protected $tester;

    /**
     * @var Factory
     */
    private $faker;

    /**
     * @var Users
     */
    private $model;

    /**
     * @var Regionals
     */
    private $regionalsModel;

    /**
     * @var Careers
     */
    private $careersModel;

    /**
     * @var array
     */
    private $provinces;

    /**
     * @var array
     */
    private $jobs;

    protected function _before()
    {
        $this->faker = Factory::create('id_ID');

        $database = $this->tester->getSlimDatabase();
        $this->model = new Users($database);

        $this->regionalsModel = new Regionals($database);
        $this->provinces = $this->regionalsModel->getProvinces();

        $this->careersModel = new Careers($database);
        $this->jobs = $this->careersModel->getJobs();
    }

    protected function _after()
    {
    }

    // tests

    private function getCities($province)
    {
        return $this->regionalsModel->getCities($province['id']);
    }

    public function testCreate()
    {
        $province = $this->faker->randomElement($this->provinces);
        $city = $this->faker->randomElement($this->getCities($province));
        $gender = $this->faker->randomElement(['male', 'female']);
        $job = $this->faker->randomElement($this->jobs);
        $expiredDate = $this->faker->dateTimeBetween('now', '+2 days');
        $pairs = [
            'username' => $this->faker->userName,
            'password' => $this->faker->password,
            'email' => $this->faker->email,
            'province_id' => $province['id'],
            'city_id' => $city['id'],
            'area' => $this->faker->city,

            'fullname' => $this->faker->name($gender),
            'gender_id' => $gender,
            'job_id'=> $job['job_id'],

            'activation_key' => $this->faker->md5,
            'expired_date' => $expiredDate->format('Y-m-d H:i:s'),
        ];

        $id = $this->model->create($pairs);

        $this->assertInternalType('int', $id);

        $this->tester->seeNumRecords(1, self::USERS_TABLE, ['user_id' => $id]);
        $this->tester->seeNumRecords(1, self::ROLES_TABLE, ['user_id' => $id]);
        $this->tester->seeNumRecords(1, self::PROFILES_TABLE, ['user_id' => $id]);
        $this->tester->seeNumRecords(1, self::ACTIVATIONS_TABLE, ['user_id' => $id]);

        $this->tester->seeInDatabase(self::USERS_TABLE, [
            'user_id' => $id,
            'username' => $pairs['username'],
            'password' => $pairs['password'],
            'email' => $pairs['email'],
            'province_id' => $pairs['province_id'],
            'city_id' => 0,
            'area' => $pairs['area'],
            'created_by' => 0,
        ]);

        $this->tester->seeInDatabase(self::ROLES_TABLE, [
            'user_id' => $id,
            'role_id' => 'member',
            'created_by' => 0,
        ]);

        $this->tester->seeInDatabase(self::PROFILES_TABLE, [
            'user_id' => $id,
            'fullname' => $pairs['fullname'],
            'gender' => $pairs['gender_id'],
            'province_id' => $pairs['province_id'],
            'city_id' => 0,
            'area' => $pairs['area'],
            'job_id' => $pairs['job_id'],
            'created_by' => 0,
        ]);

        $this->tester->seeInDatabase(self::ACTIVATIONS_TABLE, [
            'user_id' => $id,
            'activation_key' => $pairs['activation_key'],
            'expired_date' => $pairs['expired_date'],
            'deleted' => 'N',
        ]);
    }
}

<?php
namespace Membership\Helper;

use Slim\PDO\Database;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class Db extends \Codeception\Module\Db
{
    public function getSlimDatabase()
    {
        return new Database(
            $this->config['dsn'],
            $this->config['user'],
            $this->config['password']
        );
    }
}

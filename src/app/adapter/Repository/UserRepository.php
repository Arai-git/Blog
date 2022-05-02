<?php

namespace App\Adapter\Repository;
require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Infrastructure\Dao\UserDao;
use App\Domain\ValueObject\User\NewUser;

/**
 * 書き込み処理
 *  CRUDの”R"以外の処理が対象
 */
final class UserRepository
{
    /**
     * @var UserDao
     */
    private $userDao;

    public function __construct()
    {
        $this->userDao = new UserDao();
    }

    public function insert(NewUser $user): void
    {
        $this->userDao->create($user);
    }
}

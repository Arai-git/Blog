<?php

namespace App\Infrastructure\Dao;
require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Domain\ValueObject\User\NewUser;
use App\Domain\ValueObject\Email;
use \PDO;

/**
 * ユーザー情報を操作するDAO
 * 
 * UserDaoが子クラス。
 * Daoクラスが親クラスでデータベースを操作するDAO継承する。
 * 
 * 子クラスでは、ユーザーの登録機能とログイン機能の処理を行う。
 */
final class UserDao extends Dao
{
    /**
     * DBのテーブル名
     */
    const TABLE_NAME = 'users';

    /**
     * ユーザーを追加する
     * @param  NewUser $user
     */
    public function create(NewUser $user): void
    {
        $hashedPassword = $user->password()->hash();

        $sql = sprintf(
            'INSERT INTO %s (name, email, password) VALUES (:name, :email, :password)',
            self::TABLE_NAME
        );
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':name', $user->name()->value(), PDO::PARAM_STR);
        $statement->bindValue(
            ':email',
            $user->email()->value(),
            PDO::PARAM_STR
        );
        $statement->bindValue(
            ':password',
            $hashedPassword->value(),
            PDO::PARAM_STR
        );
        $statement->execute();
    }

    /**
     * ユーザーを検索する
     * @param  Email $email
     * @return array | null
     */
    public function findByEmail(Email $email): ?array
    {
        $sql = sprintf(
            'SELECT * FROM %s WHERE email = :email',
            self::TABLE_NAME
        );
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':email', $email->value(), PDO::PARAM_STR);
        $statement->execute();
        $user = $statement->fetch(PDO::FETCH_ASSOC);

        return $user === false ? null : $user;
    }
}

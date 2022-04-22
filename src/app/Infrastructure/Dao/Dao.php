<?php
namespace App\Infrastructure\Dao;

use PDO;

/**
 * SQL文をコンストラクトにセットし、データベース名のブログにアクセスしている。
 * 
 * Daoが親クラスで、UserDaoが子クラス。
 * 子クラスの処理が行われる前の共通ソースコードとなるため、Daoから継承化させている。
 * 抽象クラスは、その特徴としてクラス自身はオブジェクトの実体、インスタンスを生成することができない。
 * 親クラスを抽象クラスとした場合、子クラスが継承する前提で作製される。
 * 基本クラスの抽象クラスを作った段階では実装や機能は決定せず、派生クラスができた段階で初めて機能を持つ。
 */
abstract class Dao
{
    const DB_USER = 'root';
    const DB_PASSWORD = 'password';
    const DB_HOST = 'mysql';
    const DB_NAME = 'blog';

    protected $pdo;

    public function __construct()
    {
        $pdoSetting = sprintf(
            'mysql:host=%s; dbname=%s; charset=utf8mb4',
            self::DB_HOST,
            self::DB_NAME
        );
        $this->pdo = new PDO($pdoSetting, self::DB_USER, self::DB_PASSWORD);
    }
}
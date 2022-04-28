<?php
namespace App\Usecase\UseCaseInteractor;

use App\Domain\Entity\User;
use App\Domain\ValueObject\User\UserId;
use App\Domain\ValueObject\User\UserName;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\HashedPassword;
use App\Usecase\UseCaseInput\SignInInput;
use App\Usecase\UseCaseOutput\SignInOutput;
use App\Infrastructure\Dao\UserDao;
/**
 * 最初にUserDaoにアクセスし、データを取得。
 * $this->inputには、メールアドレスとパスワードが引数から格納されてくる。
 * findUserでメールアドレスを照合し、問題がなければ、セッションにユーザー情報が登録される。
 * メールアドレスかパスワードにエラーがあれば、ガード節でエラー文がreturnされる。
 */
final class SignInInteractor
{
    /**
     * ログイン失敗時のエラーメッセージ
     */
    const FAILED_MESSAGE = 'メールアドレスまたは<br />パスワードが間違っています';

    /**
     * ログイン成功時のメッセージ
     */
    const SUCCESS_MESSAGE = 'ログインしました';

     /**
     * @var UserDao
     */
    private $userDao;

    /**
     * @var SignInInput
     */
    private $input;

    public function __construct(SignInInput $input)
    {
        $this->userDao = new UserDao();
        $this->input = $input;
    }

    /**
     * ログイン処理
     * セッションへのユーザー情報の保存も行う
     * 
     * @return SignInOutput
     */
    public function handler(): SignInOutput
    {
        $userMapper = $this->findUser();

        if ($this->notExistsUser($userMapper)) {
            return new SignInOutput(false, self::FAILED_MESSAGE);
        }

        $user = $this->buildUserEntity($userMapper);

        if ($this->isInvalidPassword($user->password()->value())) {
            return new SignInOutput(false, self::FAILED_MESSAGE);
        }

        $this->saveSession($user);

        return new SignInOutput(true, self::SUCCESS_MESSAGE);
    }

    /**
     * ユーザーを入力されたメールアドレスで検索する
     * 
     * @return array | null
     */
    private function findUser(): ?array
    {
        return $this->userDao->findByEmail($this->input->email()->value());
    }

    /**
     * ユーザーが存在しない場合
     *
     * @param array|null $userMapper
     * @return boolean
     */
    private function notExistsUser(?array $userMapper): bool
    {
        return is_null($userMapper);
    }

    /**
     *　ユーザーの識別できる値が代入されている
     *　UserMapperは、
     */
    private function buildUserEntity(array $userMapper): User
    {
        return new User(
            new UserId($userMapper['id']), 
            new UserName($userMapper['name']),
            new Email($userMapper['email']),
            new HashedPassword($userMapper['password']));
    }

    /**
     * パスワードが正しいかどうか
     *
     * @param HashedPassword $hashedPassword
     * @return boolean
     */
    private function isInvalidPassword(string $password): bool
    {
        return !password_verify($this->input->password()->value(), $password);
    }

    /**
     * セッションの保存処理
     *
     * @param User $user
     * @return void
     */
    private function saveSession(User $user): void
    {
        $_SESSION['user']['id'] = $user->id();
        $_SESSION['user']['name'] = $user->name();
    }
}
<?php
namespace App\Usecase\UseCaseInteractor;

use App\Usecase\UseCaseInput\SignUpInput;
use App\Usecase\UseCaseOutput\SignUpOutput;
use App\Infrastructure\Dao\UserDao;

final class SignUpInteractor
{
    const ALLREADY_EXISTS_MESSAGE = 'すでに登録済みのメールアドレスです';
    const COMPLETED_MESSAGE = '登録が完了しました';

    private $useCaseInput;

    public function __construct(SignUpInput $useCaseInput)
    {
        $this->useCaseInput = $useCaseInput;
    }

    /**
     * 既にメールアドレスが登録されていないか、入力されたメールアドレスとデータベースを照合。
     * データベースに入力されたメールアドレスがあれば、エラー文をreturn。
     * nullが返されていれば、新規登録を行い、登録しましたという文を返す。
     */
    public function handler(): SignUpOutput
    {
        $userDao = new UserDao();
        $user = $userDao->findByEmail($this->useCaseInput->email());

        if (!is_null($user)) {
            return new SignUpOutput(false, self::ALLREADY_EXISTS_MESSAGE);
        }

        $userDao->create(
            $this->useCaseInput->name(),
            $this->useCaseInput->email(),
            $this->useCaseInput->password()
        );
        return new SignUpOutput(true, self::COMPLETED_MESSAGE);
    }
}
<?php
//use:このクラスをこのファイルで使う宣言
use app\Lib\SessionKey;

/**
 * セッション情報($_SESSION)をカプセル化したシングルトンクラス
 */
final class Session
{
	private static $instance;

	// シングルトンクラスはnewさせないのでprivateにする
	private function __construct()
	{
	}

	public static function getInstance(): self
	{
		if (!isset(self::$instance)) {
			self::$instance = new self();
		}

		// まだセッションスタートしてなければスタートする
		self::start();

		return self::$instance;
	}

  /**
   * セッションがスタートしていなかったら、セッションをスタートさせる
   */
	private static function start(): void
	{
		if (!isset($_SESSION)) {
			session_start();
		}
	}

	public function appendError(string $errorMessage): void
	{
		$_SESSION[SessionKey::ERROR_KEY][] = $errorMessage;
	}


  /**
   * エラーメッセージを変数に変換した後、セッションキーをclear
   */
	public function popAllErrors(): array
	{
		$errors = $_SESSION[SessionKey::ERROR_KEY] ?? [];
		$erorrKey = new SessionKey(SessionKey::ERROR_KEY);
		$this->clear($erorrKey);
		return $errors;
	}


  /**
   * セッションエラーキーが入っていたら、セッションキーエラーをそのまま返す
   */
	public function existsErrors(): bool
	{
		return !empty($_SESSION[SessionKey::ERROR_KEY]);
	}

	/**
	 * 以下のクラスから、$SessionKeyをSessionKeyクラスから
	 * 指定できるようにカプセル化する
	 */
	public function clear(SessionKey $sessionKey): void
	{
		unset($_SESSION[$sessionKey->value()]);
	}

  /**
   *	'formInputs'がキーとなる多次元配列、ユーザーIDとユーザーネーム代入
   */
	public function setFormInputs(SessionKey $sessionKey, $value): void
	{
		$_SESSION[$sessionKey->value()] = $value;
	}

	public function getFormInputs(): array
	{
		return $_SESSION[SessionKey::FORM_INPUTS_KEY] ?? [];
	}

  /**
   * キーが'message'へエラーメッセージを代入
   */
	public function setMessage(SessionKey $sessionKey, $message): void
	{
		$_SESSION[$sessionKey->value()] = $message;
	}

  /**
   * メッセージを$messageに格納後、メッセージキーを削除
	 * メッセージを返り値に指定
   */
	public function getMessage(): string
	{
		$message = $_SESSION[SessionKey::MESSAGE_KEY] ?? "";
		$messageKey = new SessionKey(SessionKey::MESSAGE_KEY);
		$this->clear($messageKey);
		return $message;
	}
}
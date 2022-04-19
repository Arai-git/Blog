<?php
//namespace:このクラスはこのディレクトリに存在する
namespace app\Lib;
//use:このクラスをこのファイルで使う宣言
use FFI\Exception;

/**
 * Sessionで扱うことができるキーの一覧
 */
final class SessionKey
{
	public const ERROR_KEY = 'errors';
	public const FORM_INPUTS_KEY = 'formInputs';
	public const MESSAGE_KEY = 'message';

	const KEYS = [
		self::ERROR_KEY,
		self::FORM_INPUTS_KEY,
		self::MESSAGE_KEY
	];

	private $value;

	/**
	 * valueにKEYSが含まれているかどうかの確認
	 */
	public function __construct(string $value)
	{
		if (!in_array($value, self::KEYS)) {
			throw new Exception('使用不可能なキーです');
		}
		$this->value = $value;
	}

	/**
	 * valueには、上記constの文字列がreturnされる
	 */
	public function value(): string
	{
		return $this->value;
	}
}
<?php

namespace core;

class Validator
{
	public function check($field, $value)
	{
		$error = $this->validateRequired($value);

		if (!$error) {
			switch ($field) {
				case 'login' :
					$error = $this->validateLogin($value);
					break;
				case 'password' :
					$error = $this->validatePassword($value);
					break;
				case 'name' :
					$error = $this->validateName($value);
					break;
				case 'email' :
					$error = $this->validateEmail($value);
					break;
			}
		}

		return $error;
	}

	private function validateRequired($str)
	{
		return strlen($str) ? '' : 'That field is required.';
	}

	private function validateLength($str, $min, $max)
	{
		$strlen = mb_strlen($str);
		return $strlen >= $min && $strlen <= $max ? '' : 'Field value length can be between ' . $min . ' and ' . $max . '.';
	}

	private function regexStr($str, $regex)
	{
		return preg_match($regex, $str) ? '' : 'This field contains an invalid character(s).';
	}

	private function validateLogin($str)
	{
		return $this->validateLength($str, 2, 50) ?: $this->regexStr($str, "/^([a-zA-Z0-9]+)$/");
	}

	private function validatePassword($str)
	{
		return $this->validateLength($str, 2, 72);
	}

	private function validateName($str)
	{
		return $this->validateLength($str, 2, 50) ?: $this->regexStr($str, "/^([a-zA-Zа-яА-Я' ]+)$/");
	}

	private function validateEmail($str)
	{
		return filter_var($str, FILTER_VALIDATE_EMAIL) ? '' : 'The Email You have input is not valid';
	}

}
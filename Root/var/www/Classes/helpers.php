<?php

	class Helpers{

		function __construct($_GeniSys)
		{
			$this->_GeniSys = $_GeniSys;
		}

		function decrypt($data) {
			$encryption_key = base64_decode($this->_GeniSys->_key);
			$method = "aes-" . strlen($encryption_key) * 8 . "-cbc";
			$iv = substr(base64_decode($data), 0, 16);
			$decoded = openssl_decrypt(substr(base64_decode($data), 16), $method, $encryption_key, TRUE, $iv);
			return $decoded;
		}

		public function oDecrypt($encrypted)
		{
			$encryption_key = base64_decode($this->_GeniSys->_key);
			list($encrypted_data, $iv) = explode("::", base64_decode($encrypted), 2);
			return openssl_decrypt($encrypted_data, "aes-256-cbc", $encryption_key, 0, $iv);
		}

		public function oEncrypt($value)
		{
			$encryption_key = base64_decode($this->_GeniSys->_key);
			$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length("aes-256-cbc"));
			$encrypted = openssl_encrypt($value, "aes-256-cbc", $encryption_key, 0, $iv);
			return base64_encode($encrypted . "::" . $iv);
		}

		public function getUserIP()
		{
			if(array_key_exists("HTTP_X_FORWARDED_FOR", $_SERVER) && !empty($_SERVER["HTTP_X_FORWARDED_FOR"])):
				if (strpos($_SERVER["HTTP_X_FORWARDED_FOR"], ",") > 0):
					$addr = explode(",", $_SERVER["HTTP_X_FORWARDED_FOR"]);
					return trim($addr[0]);
				else:
					return $_SERVER["HTTP_X_FORWARDED_FOR"];
				endif;
			else:
				return $_SERVER["REMOTE_ADDR"];
			endif;
		}

		public static function verifyPassword($password, $hash)
		{
			return password_verify(
				$password,
				$hash);
		}

		public static function createPasswordHash($password)
		{
			return password_hash(
				$password,
				PASSWORD_DEFAULT);
		}

		public	function generateKey($length = 10){
			$characters="0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0987654321".time();
			$charactersLength = strlen($characters);
			$randomString = "";
			for ($i = $length; $i > 0; $i--)
			{
				$randomString .= $characters[rand(0, $charactersLength - 1)];
			}
			return $randomString;
		}
	}
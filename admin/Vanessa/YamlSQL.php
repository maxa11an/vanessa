<?php
/**
 * Created by PhpStorm.
 * User: maxallan
 * Date: 2019-02-24
 * Time: 23:00
 */

namespace Vanessa;


use Symfony\Component\Yaml\Yaml;

class YamlSQL
{
	const RESULT_NONE = NULL;
	private $parsedData;
	private $storageFile;
	private $encrypted;

	public function __construct($filename, $encrypted = false)
	{
		$this->encrypted = $encrypted;
		$this->storageFile = $filename;

		$this->openFile();
	}

	private function openFile(){

		$dbContent = file_get_contents($this->storageFile);
		if($this->encrypted !== false && $dbContent !== "") {
			$c = base64_decode($dbContent);
			$ivlen = openssl_cipher_iv_length($cipher = "AES-128-CBC");
			$iv = substr($c, 0, $ivlen);
			$hmac = substr($c, $ivlen, $sha2len = 32);
			$ciphertext_raw = substr($c, $ivlen + $sha2len);
			$dbContent = openssl_decrypt($ciphertext_raw, $cipher, getenv('VANESSA_SECRET'), $options = OPENSSL_RAW_DATA, $iv);
			$calcmac = hash_hmac('sha256', $ciphertext_raw, getenv('VANESSA_SECRET'), $as_binary = true);

			if (!hash_equals($hmac, $calcmac))//PHP 5.6+ timing attack safe comparison
			{
				throw new \Exception("Damaged encrypted storage file");
			}
		}
		$this->parsedData = Yaml::parse($dbContent, YAML::PARSE_DATETIME);
	}

	public final function getFromPrimaryKey($value){
		$value = trim($value);
		return @$this->parsedData[$value] ?: null;
	}

	public function updateWithPrimaryKey($primaryKey, $newValue){
		if($oldValue = $this->getFromPrimaryKey($primaryKey) !== null){
			$newValue = array_merge($oldValue, $newValue);
		}
		$this->parsedData[$primaryKey] = $newValue;

		$this->save();
	}

	public function addNewWithPrimaryKey($primaryKey, $value){
		if($oldValue = $this->getFromPrimaryKey($primaryKey) !== null) throw new \Exception("Not unique value");

		$this->parsedData[$primaryKey] = $value;
		$this->save();
	}

	public function deleteWithPrimaryKey($primaryKey){
		if($oldValue = $this->getFromPrimaryKey($primaryKey) !== null) return;

		unset($this->parsedData[$primaryKey]);
		$this->save();
	}

	private function save(){
		$dbContent = Yaml::dump($this->parsedData, 2,4, YAML::DUMP_EMPTY_ARRAY_AS_SEQUENCE);
		if($this->encrypted !== false){
			$ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
			$iv = openssl_random_pseudo_bytes($ivlen);
			$ciphertext_raw = openssl_encrypt($dbContent, $cipher, getenv('VANESSA_SECRET'), $options=OPENSSL_RAW_DATA, $iv);
			$hmac = hash_hmac('sha256', $ciphertext_raw, getenv('VANESSA_SECRET'), $as_binary=true);
			$dbContent = base64_encode( $iv.$hmac.$ciphertext_raw );
		}

		file_put_contents($this->storageFile, $dbContent);
	}


}
<?php
/**
 * Created by PhpStorm.
 * User: maxallan
 * Date: 2019-02-24
 * Time: 23:00
 */

namespace Vanessa\Core;


use Symfony\Component\Yaml\Yaml;

class YamlSQL
{
	const RESULT_NONE = NULL;
	private $parsedData;
	protected $storageFile;
	private $encrypted;

	const DIR = __DIR__.'/../../../.vanessa/';

	public function __construct($filename, $encrypted = false, $optionalPath = null)
	{
		$this->encrypted = $encrypted;
		if($optionalPath !== null){
			$this->storageFile = $optionalPath.$filename;
		}else{
			$this->storageFile = self::DIR.$filename;
		}


		$this->openFile();
	}

	private function openFile(){
		if(!file_exists($this->storageFile)) file_put_contents($this->storageFile, "");
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

	public function get($value){
		$value = trim($value);
		return @$this->parsedData[$value] ?: null;
	}

	public function getAll():array {
		return $this->parsedData ?: [];
	}

	public function update($primaryKey, $newValue){
		if($oldValue = $this->get($primaryKey) !== null){
			$newValue = array_merge($oldValue, $newValue);
		}
		$this->parsedData[$primaryKey] = $newValue;

		$this->save();
		return $this;
	}

	public function add($primaryKey, $value){
		if($oldValue = $this->get($primaryKey) !== null) throw new \Exception("Not unique value");

		$this->parsedData[$primaryKey] = $value;
		$this->save();
		return $this;
	}

	public function addOrUpdate($primaryKey, $value){
		$this->parsedData[$primaryKey] = $value;
		$this->save();
		return $this;
	}

	public function delete($primaryKey){
		if($oldValue = $this->get($primaryKey) !== null) return;

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
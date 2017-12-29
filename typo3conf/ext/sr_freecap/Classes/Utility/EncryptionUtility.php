<?php
namespace SJBR\SrFreecap\Utility;

/*
 *  Copyright notice
 *
 *  (c) 2012-2017 Stanislas Rolland <typo3(arobas)sjbr.ca>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *  A copy is found in the textfile GPL.txt and important notices to the license
 *  from the author is found in LICENSE.txt distributed with these scripts.
 *
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 */
/**
 * Encryption utility
 */
class EncryptionUtility
{
	/**
	 * Salt
	 *
	 * @var string
	 */
	private $salt = 'cH!swe!retReGu7W6bEDRup7usuDUh9THeD2CHeGE*ewr4n39=E@rAsp7c-Ph@pH';

	/**
	 * Encrypts a string
	 *
	 * @param array $string: the string to be encrypted
	 * @return array an array with the string as the first element and the initialization vector as the second element
	 */
	public static function encrypt($string)
	{
		if (in_array('openssl', get_loaded_extensions())) {
			$encryptionAlgorithm = $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['sr_freecap']['encryptionAlgorithm'];
			$availableAlgorithms = openssl_get_cipher_methods();
			if (in_array($encryptionAlgorithm, $availableAlgorithms)) {
				$key = md5($GLOBALS['TYPO3_CONF_VARS']['SYS']['encryptionKey'], true);
				$iv_size = openssl_cipher_iv_length($encryptionAlgorithm);
				$salt = isset($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['sr_freecap']['salt']) ? trim($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['sr_freecap']['salt']) : $this->salt;
				$hash = hash('sha256', $salt . $key . $salt);
				$iv = substr($hash, strlen($hash) - $iv_size);
				$key = substr($hash, 0, 32);
				$string = openssl_encrypt($string, $encryptionAlgorithm, $key, OPENSSL_RAW_DATA, $iv);
				$cypher = array(base64_encode($string), base64_encode($iv));
			} else {
				$cypher = array(base64_encode($string));
			}
		} else {
			$cypher = array(base64_encode($string));			
		}
		return $cypher;
	}

	/**
	 * Decrypts a string
	 *
	 * @param array $cypher: an array as returned by encrypt()
	 * @return string the decrypted string
	 */
	public static function decrypt($cypher)
	{
		if (in_array('openssl', get_loaded_extensions())) {
			$encryptionAlgorithm = $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['sr_freecap']['encryptionAlgorithm'];
			$key = md5($GLOBALS['TYPO3_CONF_VARS']['SYS']['encryptionKey'], true);
			$salt = isset($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['sr_freecap']['salt']) ? trim($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['sr_freecap']['salt']) : $this->salt;
			$hash = hash('sha256', $salt . $key . $salt);
			$key = substr($hash, 0, 32);
			$string = trim(openssl_decrypt(base64_decode($cypher[0]), $encryptionAlgorithm, $key, OPENSSL_RAW_DATA, base64_decode($cypher[1])));
		} else {
			$string = base64_decode($cypher[0]);
		}
		return $string;
	}
}
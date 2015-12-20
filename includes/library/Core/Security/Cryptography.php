<?php

namespace Core\Security
{
	class Cryptography extends \Core\Object
	{
		const Salt_Charset_Blowfish = 1;
		
		public static function GenerateRandomSalt($length, $char_set)
		{
			$chars = self::GetSaltCharset($char_set);
			$ret = '';
			
			for( $i=0; $i<$length; $i++ )
				$ret .= $chars[rand(0,strlen($chars))];
				
			return $ret;
		}
		
		public static function GetSaltCharset($char_set)
		{
			switch($char_set)
			{
				case self::Salt_Charset_Blowfish:
					return \Core\Security\Cryptography\Blowfish::GetSaltCharset();
			}
		}
	}
}
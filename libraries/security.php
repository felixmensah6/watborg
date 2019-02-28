<?php

/*
 |-----------------------------------------------------------------
 | Security Library
 |-----------------------------------------------------------------
 |
 | Reusable security functions
 |
 */

class Security
{
    /**
	 * Encryption key
     * --------------------------------------------
	 *
	 * @var string
	 */
	protected $_key;

    /**
	 * Encryption IV
     * --------------------------------------------
	 *
	 * @var string
	 */
	protected $_iv = "8@bBi8Rs4,~#'6%{";

    /**
	 * Encryption method
     * --------------------------------------------
	 *
	 * @var string
	 */
	protected $_method = "AES-256-CBC";

    /*
    * Constructor
    * --------------------------------------------
	*
    * @return void
    */
    public function __construct()
	{
        $this->_key = env('ENCRYPTION_KEY');
    }

    /**
	 * Generate Unique String
	 * --------------------------------------------
	 *
	 * Generates a unique random lowercase alphanumeric string
	 * @param int $limit The length of the generated string
	 * @return string
	 */
    public function generate_unique_string($limit)
	{
    	return substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $limit);
    }

    /**
	 * Generate Unique Numbers
	 * --------------------------------------------
	 *
	 * Generates a unique random integer
	 * NOTE: Min Limit is 10 and Max Limit is 16 and the higher the
	 * limit, the more unique it becomes.
	 * @param int $limit The length of the generated integer
	 * @return string
	 */
    public function generate_unique_int($limit = 10)
	{
		$rand = random_int(10, 99);
        $time = str_replace(['0.', ' '], '', microtime());

		if($limit >= 10 && $limit <= 16)
		{
			return substr($time, 0, 6) . substr($time, (8 - $limit)) . $rand;
		}
		else
		{
			trigger_error('The length range must be from 10 to 16.');
		}
    }

	/**
	 * Generate Random Characters
	 * --------------------------------------------
	 *
	 * Generates a string with random uppercase and lowercase alphanumeric string
	 * @param int $limit The length of the generated string
	 * @param bool $random_case Include uppercase alphabet caracters randomly
	 * @param bool $include_digits Include digits randomly
	 * @return string
	 */
	public function random_characters($limit = 10, $random_case = false, $include_digits = false)
	{
		$lower = 'abcdefghjkmnpqrstuvwxyz';
		$upper = 'ABCDEFGHJKMNPQRSTUVWXYZ';
		$digits = '0123456789';
		$chars = $lower . ($random_case ? $upper : '') . ($include_digits ? $digits : '');
		$str = '';
		$last_index = strlen($chars) - 1;

		for($i = 0; $i < $limit; $i++)
		{
			$chars = str_shuffle($chars);
			$str .= $chars[mt_rand(0, $last_index)];
		}

		return $str;
	}

    /**
	 * Encrypt ID
	 * --------------------------------------------
	 *
	 * Encrypts integers only
	 * @param int $data The number to encrypt
	 * @return string
	 */
	public function encrypt_id($data)
	{
		$data = (double) $data * 4452.81;
		$data = base64_encode($data);
		$data = rtrim(strtr($data, '+/', '-_'), '=');
		return $data;
	}


	/**
	 * Decrypt ID
	 * --------------------------------------------
	 *
	 * Decrypts encrypted integers only
	 * @param string $data The encrypted integer to decrypt
	 * @return int
	 */
	public function decrypt_id($data)
	{
		$data = str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT);
		$data = base64_decode($data);
		$data = (double) $data / 4452.81;
		return $data;
	}


    /**
	 * Encrypt
	 * --------------------------------------------
	 *
	 * @param string $plaintext The string to encrypt
	 * @param bool $clean Set to true to trim special characters from string
	 * @return string
	 */
    public function encrypt($plaintext, $clean = false)
	{
        //$this->_iv = random_bytes(16);
        $this->_key = hash('sha256', $this->_key);
		$this->_iv = substr(hash('sha256', $this->_iv), 0, 16);
		$crypttext = openssl_encrypt($plaintext, $this->_method, $this->_key, 0, $this->_iv);
		$crypttext = base64_encode($crypttext);

        if($clean === true)
		{
			return rtrim(strtr($crypttext, '+/', '-_'), '=');
		}
		else
		{
			return trim($crypttext);
		}
	}


	/**
	 * Decrypt
	 * --------------------------------------------
	 *
	 * @param string $crypttext The encrypted string to decrypt
	 * @param bool $clean Should have the same value as the encrypt() function
	 * @return string
	 */
    public function decrypt($crypttext, $clean = false)
	{
        if($clean === true)
		{
			$crypttext = str_pad(strtr($crypttext, '-_', '+/'), strlen($crypttext) % 4, '=', STR_PAD_RIGHT);
			$crypttext = base64_decode($crypttext);
		}
		else
		{
			$crypttext = base64_decode($crypttext);
		}

        $plaintext = openssl_decrypt($crypttext, $this->_method, $this->_key, 0, $this->_iv);
        return trim($plaintext);
    }

    /**
	 * Hash Password
	 * --------------------------------------------
	 *
	 * @param string $password The password to hash
	 * @return string
	 * NOTE: It is recommended to store the result in a database
	 * column that can expand beyond 60 characters (255 characters
	 * would be a good choice).
	 */
	public function password_hash($password)
	{
		return password_hash($password, PASSWORD_DEFAULT);
	}

	/**
	 * Verify Hashed Password
	 * --------------------------------------------
	 *
	 * @param string $password The raw password to compare with hash
	 * @param string $hash The hashed password to verify
	 * @return bool
	 */
	public function password_verify($password, $hash)
	{
		return password_verify($password, $hash);
	}

    /**
	 * Unique Bytes Generator
	 * --------------------------------------------
	 *
	 * @param int $length The length of the byte
	 * @return string
	 */
	public function unique_bytes(int $length = 0)
	{
		return bin2hex(openssl_random_pseudo_bytes($length));
	}


    /**
	 * Token Generator
	 * --------------------------------------------
	 *
	 * @param string $key The token id/value
	 * @return mixed
	 */
	public function token($key = null)
	{
        // If token is not available, set it else return value
        if(isset($_SESSION['token_id']) && isset($_SESSION['token_value']))
		{
            $token = [
                'id' => $_SESSION['token_id'],
                'value' => $_SESSION['token_value']
            ];

            return ($key === null) ? $token : $token[$key];
        }
		else
		{
            $_SESSION['token_id'] = $this->unique_bytes(8);
            $_SESSION['token_value'] = hash('sha256', $this->unique_bytes(16));
        }
	}

    /**
	 * Verify Token
	 * --------------------------------------------
	 *
	 * @param string $id The token id
	 * @param string $value The token value
	 * @return bool
	 */
	public function verify_token($id, $value)
	{
        // Check if session token matches provided token
        if(isset($_SESSION['token_id']) && isset($_SESSION['token_value']))
		{
            // If token matches, return true or false
            if($_SESSION['token_id'] === $id && $_SESSION['token_value'] === $value)
			{
                return true;
            }
			else
			{
                return false;
            }
        }
		else
		{
            // Return false if token session is not available
            return false;
        }
	}

	/**
	 * Base64 URL Encode
	 * --------------------------------------------
	 *
	 * @param string $data The string to encode
	 * @return string
	 */
	function base64_url_encode($data)
	{
		return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
	}

	/**
	 * Base64 URL Decode
	 * --------------------------------------------
	 *
	 * @param string $data The string to decode
	 * @return string
	 */
	function base64_url_decode($data)
	{
		return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
	}
}

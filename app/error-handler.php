<?php

/*
 |-----------------------------------------------------------------
 | Error Handler Class
 |-----------------------------------------------------------------
 |
 | Displays a custom error page instead of the default
 |
 */

class Error_Handler
{
    /**
	 * Layout
	 * --------------------------------------------
	 * Builds the layout for display
     *
	 * @param string $message The error message
	 * @param string $code The error code
	 * @param integer $line The error line number
	 * @param string $filename The file containing the error
	 * @param integer $type The error code
	 * @return void
	 */
	private static function layout($message, $code, $line, $filename, $type = 1)
    {
		$page_title = 'Ooops! Something went wrong';
		$header_title = 'A PHP Error was encountered!';
		$time = date('Y-m-d h:i:s a',time());
		$path_length = strlen(__DIR__) - 11;
		$filename = ucfirst(substr($filename, $path_length));
		$filename = str_replace('\\', '/', $filename);
		$view_path = '';

		$security = [
			1 => 'Exception',
			2 => 'Warning',
			8 => 'Notice',
			256 => 'User Error',
			512 => 'User Warning',
			1024 => 'User Notice',
			4096 => 'Recoverable Error',
			8191 => 'All',
			8192 => 'Deprecated'
		];

		// Use custom error file in views folder if it exists
		// else revert to the default custom error
		if(file_exists($view_path))
        {
			include $view_path;
			die();
		}
        else
        {
			die('<script type="text/javascript">document.write(\'<div style="position:fixed;width:100%;background-color:#fff;z-index:100000;top:0;left:0;right:0;bottom:0;font-family:Times New Roman, Times, serif !important;font-size:16px;line-height:18px;text-align:left;"><div style="color:#333;padding:15px 20px;margin:10%;border:1px solid #cdcdcd;transform:translate(0%,5%);border-radius:5px;"><h2 style="margin:0 0 5px 0;border-bottom:1px solid #ddd;padding-bottom:15px;font-size:24px;font-weight: 600;">'.$header_title.'</h2><p style="margin:16px 0"><strong>Severity : </strong> '.$security[$type].'</p><p style="margin:16px 0"><strong>Message : </strong> '.$message.'</p><p style="margin:16px 0"><strong>Error Code : </strong> '.$code.'</p><p style="margin:16px 0"><strong>Line Number : </strong> '.$line.'</p><p style="margin:16px 0"><strong>Filename : </strong> '.$filename.'</p><p style="border-top:1px solid #ddd;padding-top:15px;margin-bottom:0;font-size:14px"> Error Time : <em>'.$time.'</em></p></div></div>\');</script>');
		}
	}

	/**
	 * Exception
	 * --------------------------------------------
     *
	 * @param object $e Exception object
	 * @param string $code the error code
	 * @param integer $line the error line number
	 * @param string $filename the file containing the error
	 * @return void
	 */
	public static function exception($e)
    {
		self::layout($e->getMessage(), $e->getCode(), $e->getLine(), $e->getFile());
	}

	/**
	 * Error
	 * --------------------------------------------
     *
	 * @param string $message the error message
	 * @param string $code the error code
	 * @param integer $line the error line number
	 * @param string $filename the file containing the error
	 * @return void
	 */
	public static function error($code, $message, $filename, $line)
    {
		self::layout($message, $code, $line, $filename, $code);
	}
}

<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Jasper_report Class
 * Library to make PHP-Jasper Connection
 * -----------------------------------------------------------------------------
 * Copyright (C) 2009  Adhilaras Putro P. (SMARTI Media)
 * -----------------------------------------------------------------------------
 *This library is free software; you can redistribute it and/or
 *modify it under the terms of the GNU Lesser General Public
 *License as published by the Free Software Foundation; either
 *version 2.1 of the License, or (at your option) any later version.
 *
 *This library is distributed in the hope that it will be useful,
 *but WITHOUT ANY WARRANTY; without even the implied warranty of
 *MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 *Lesser General Public License for more details.
 *
 *You should have received a copy of the GNU Lesser General Public
 *License along with this library; if not, write to the Free Software
 *Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *------------------------------------------------------------------------------
 * @package     Jasper_report
 * @subpackage  Libraries
 * @category    Report
 * @author      Adhilaras Putro P. (dhiliusition) 
 * @copyright   Copyright (c) 2009, SMARTI Media
 * @license		http://www.gnu.org/licenses/lgpl.html
 * @link 		http://smarti.web.id
 * @version 	0.5
 *
 */

// ------------------------------------------------------------------------

/**
 * Jasper_report manages blah blah blah..
 */
class Jasper_report
{
    // --------------------------------------------------------------------
    
    /**
	* initialize Jasper report class
	*
	*/
    function Jasper_report()
    {
        $this->CI=& get_instance();
		
        log_message('debug', "Jasper_report Class Initialized");
		
        $this->checkJavaExtension();
    }
	
	// --------------------------------------------------------------------
    
	/**
	 * return the database connection configuration from the CI's database config
	 */
	function getDBConn()
	{
		$this->CI=& get_instance();
		
		/* Creating the Database Connection! */
		$this->CI->load->config('database');
		$hostname = $this->CI->config->item('hostname');
		$port 	  = $this->CI->config->item('port');
		$database = $this->CI->config->item('database');
		$username = $this->CI->config->item('username');
		$password = $this->CI->config->item('password');
		$jdbc_driver = $this->CI->config->item('jdbc_driver');
		$connection_string = $this->CI->config->item('jdbc_connection_string');
		
		$Conn = new Java("smarti.util.JdbcConnection"); // calls the altic file
		$Conn->setDriver($jdbc_driver);
		$Conn->setConnectString($connection_string);
		$Conn->setUser($username);
		$Conn->setPassword($password);
		
		
		
		
					
		return $Conn;
	}	
	
	
	// --------------------------------------------------------------------
    
	/**
	 * see if the java extension was loaded.
	 */
	function checkJavaExtension()
	{
		if(!extension_loaded('java'))
		{
			$sapi_type = php_sapi_name();
			$host = $this->CI->config->item('tomcat_host');
			$port = $this->CI->config->item('tomcat_port');
			if ($sapi_type == "cgi" || $sapi_type == "cgi-fcgi" || $sapi_type == "cli") 
			{
				if(!(PHP_SHLIB_SUFFIX=="so" && @dl('java.so'))&&!(PHP_SHLIB_SUFFIX=="dll" && @dl('php_java.dll'))&&!(@include_once("java/Java.inc"))&&!(require_once("http://127.0.0.1:$port/java/Java.inc"))) 
				{
					return "java extension not installed.";
				}
			} 
			else
			{
				if(!(@include_once("java/Java.inc")))
				{
					require_once("http://$host:$port/JavaBridge/java/Java.inc");
				}
			}
		}
		if(!function_exists("java_get_server_name")) 
		{
			return "The loaded java extension is not the PHP/Java Bridge";
		}

		return true;
	}
	
	// --------------------------------------------------------------------
	
	/** 
	 * convert a php value to a java one... 
	 * @param string $value 
	 * @param string $className 
	 * @returns boolean success 
	 */  
	function convertValue($value, $className)  
	{  
		// if we are a string, just use the normal conversion  
		// methods from the java extension...  
		try   
		{  
			if ($className == 'java.lang.String')  
			{  
				$temp = new Java('java.lang.String', $value);  
				return $temp;  
			}  
			else if ($className == 'java.lang.Boolean' ||  
				$className == 'java.lang.Integer' ||  
				$className == 'java.lang.Long' ||  
				$className == 'java.lang.Short' ||  
				$className == 'java.lang.Double' ||  
				$className == 'java.math.BigDecimal')  
			{  
				$temp = new Java($className, $value);  
				return $temp;  
			}  
			else if ($className == 'java.sql.Timestamp' ||  
				$className == 'java.sql.Time')  
			{  
				$temp = new Java($className);  
				$javaObject = $temp->valueOf($value);  
				return $javaObject;  
			}  
		}  
		catch (Exception $err)  
		{  
			echo (  'unable to convert value, ' . $value .  
					' could not be converted to ' . $className);  
			return false;  
		}
	  
		echo (  'unable to convert value, class name '.$className.  
				' not recognised');  
		return false;  
	}



}    
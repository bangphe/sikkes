<?php

/**
 * Wick Library
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package   Wick
 * @copyright 2007-2008 Zacharias Knudsen
 * @license   http://www.gnu.org/licenses/lgpl.html
 * @version   $Id: Wick.php 21 2008-06-09 11:58:23Z zdknudsen $
 */

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Provides a method for loading uris
 *
 * @package   Wick
 * @copyright 2007-2008 Zacharias Knudsen
 * @license   http://www.gnu.org/licenses/lgpl.html
 */
class Wick
{

    /**
     * The methodname
     *
     * @var    string
     * @access private
     */
    var $_method = 'uri';

    /**
     * Assigns a method for loading uris
     *
     * @return void
     * @access public
     */
    function Wick()
    {
        $ci = &get_instance();
        eval('

class Wick_loader extends ' . get_class($ci->load) . '
{
    function ' . $this->_method . '()
    {
        $args = func_get_args();
        $args = array_merge(array(&$this), $args);
        call_user_func_array(array("Wick", "load"), $args);
    }

}

        ');
        $load = &new Wick_loader();

        foreach (array_keys(get_object_vars($ci->load)) as $attribute) {
            $load->$attribute = &$ci->load->$attribute;
        }

        $ci->load = &$load;
    }

    /**
     * Loads uris
     *
     * @param  mixed
     * @return void
     * @access public
     */
    function load($load, $uri = array())
    {
        if (!is_array($uri)) {
	 		$uri = explode('/', $uri);
	 	}

        $router = &load_class('Router');
        $uricla = &load_class('URI');
        $router->_set_request($uri);

        $class     = $router->fetch_class();
        $directory = $router->fetch_directory();
        $method    = $router->fetch_method();
        $path      = APPPATH . 'controllers/' . $directory . $class . EXT;

        if (!file_exists($path)) {
        	show_error('Unable to load your default controller.  Please make sure the controller specified in your Routes.php file is valid.');
        }

        include_once($path);

        if (!class_exists($class) || $method == 'controller' || strncmp($method, '_', 1) == 0 || in_array($method, get_class_methods('Controller'), true)) {
        	show_404($class . '/' . $method);
        }

        $controller       = new $class();
        $controller->load = &$load;

        if (method_exists($controller, '_remap')) {
            $controller->_remap($method);
        } else {
            if (!in_array(strtolower($method), array_map('strtolower', get_class_methods($controller)))) {
                show_404($class . '/' . $method);
            }

            call_user_func_array(array(&$controller, $method), array_slice($uricla->rsegments, 2));
    	}
    }

}

/* End of file Wick.php */
/* Location: ./system/application/libraries/Wick.php */
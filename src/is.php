<?php
/**
 * flyandi:is library for PHP
 * @version: v1.0.1
 * @author: Andy Schwarz
 *
 * Created by Andy Schwarz. Please report any bug at http://github.com/flyandi/php-is
 *
 * Copyright (c) 2015 Andy Schwarz http://github.com/flyandi
 *
 * The MIT License (http://www.opensource.org/licenses/mit-license.php)
 *
 * Permission is hereby granted, free of charge, to any person
 * obtaining a copy of this software and associated documentation
 * files (the "Software"), to deal in the Software without
 * restriction, including without limitation the rights to use,
 * copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following
 * conditions:
 *
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
 * OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
 * HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
 * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
 * OTHER DEALINGS IN THE SOFTWARE.
 */


/**
  * ::is
  */

class Is
{

    const version = '1.0.1';

    const undefined = 'undefined';


    /*	__toString: function() {
		return Object.prototype.toString.call(arguments[0]);
	},*/

    /**
     * __static call method
     */

    public static function __callstatic($name, $arguments)
    {

        $methods = [

            /** (iterable) */
            'iterable' => function ($o) {
                return is_object($o) || is_array($o);
            },

            /** (fn) */
            'fn' => function ($o) {
                return is_callable($o);
            },

            /** (object) => _object */
            '_object' => function ($o) {
                return is_object($o);
            },

            /** (array) => _array */
            '_array' => function ($o) {
                return is_array($o);
            },

            /** (date) */
            'date' => function ($o) {
                return DateTime::createFromFormat('Y-m-d', $o) !== false;
            },

            /** (string) */
            'string' => function ($o) {
                return is_string($o);
            },

            /** (number) */
            'number' => function ($o) {
                return is_numeric($o);
            },

            /** (boolean) */
            'boolean' => function ($o) {
                return is_bool($o);
            },

            /** (defined) */
            'defined' => function ($o) {
                return isset($o);
            },

            /** (element) Not supported in PHP */
            /*'element'=> function() {
				return typeof(HTMLElement) !== Is.undefined ? (arguments[0] instanceof HTMLElement) : (arguments[0] && arguments[0].nodeType === 1);
			},*/

            /** (empty) */
            'empty' => function ($o) {
                return empty($o);
            },

            /** (same) */
            'same' => function ($a, $b) {
                return $a === $b;
            },

            /** (associated) */
            'associated' => function ($o) {
                return is_array($o) ? (bool)count(array_filter(array_keys($o), 'is_string')) : false;
            },

            /** (sequential) */
            'sequential' => function ($o) {
                return is_array($o) ? !self::associated($o) : false;
            },

        ]; /** __methods **/

        // prepare
        $name = strtolower($name);

        // invoke method
        if (isset($methods[$name])) {
            return call_user_func_array($methods[$name], $arguments);
        }

        // invoke filters
        return self::__invokeFilters($name, $arguments);
    }



    /**
     * __regfilters
     */

    private static function __invokeFilters($name, $arguments)
    {

        $filters = array(
            "url" => "/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/",
            "email" => "/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))$/i",
            "creditcard" => "/^(?:(4[0-9]{12}(?:[0-9]{3})?)|(5[1-5][0-9]{14})|(6(?:011|5[0-9]{2})[0-9]{12})|(3[47][0-9]{13})|(3(?:0[0-5]|[68][0-9])[0-9]{11})|((?:2131|1800|35[0-9]{3})[0-9]{11}))$/",
            "alphanumeric" => "/^[A-Za-z0-9]+$/",
            "time" => "/^(2[0-3]|[01]?[0-9]):([0-5]?[0-9]):([0-5]?[0-9])$/",
            "datestring" => "/^(1[0-2]|0?[1-9])\/(3[01]|[12][0-9]|0?[1-9])\/(?:[0-9]{2})?[0-9]{2}$/",
            "zip" => "/^[0-9]{5}(?:-[0-9]{4})?$/",
            "phone" => "/^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/",
            "ssn" => "/^(?!000|666)[0-8][0-9]{2}-(?!00)[0-9]{2}-(?!0000)[0-9]{4}$/",
            "affirmative" => "/^(?:1|t(?:rue)?|y(?:es)?|ok(?:ay)?)$/",
            "hexadecimal" => "/^[0-9a-fA-F]+$/",
            "hexcolor" => "/^#?([0-9a-fA-F]{3}|[0-9a-fA-F]{6})$/",
        );

        return isset($filters[$name]) ? (preg_match($filters[$name], @$arguments[0]) == 1) : false;

    }
}
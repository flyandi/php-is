Php Is
======

Is for PHP is a small library that provides some handy methods to quickly check or validate the contents of a variable.

## Install it

Install the library via composer:

```composer install flyandi/is```


## How to use it

Pretty straightforward. The library exposes the static class `Is` that contains all the evaluating methods, e.g.:

```php

$AnArray = ['red', 'blue', green];

$AnColor = '#00FF00';

if(Is::_array($AnArray)) echo "Yes, it's an array!";

if(Is::hexcolor($AnColor)) echo "This is a valid color code.";
```

## Methods

The Is library implements the following methods currently:

Method 			|	Description
---				|	---
`iterable`		|	Checks if an object can be iterated, e.g. `forEach`
`fn`			|	Returns true if the argument is an function
`object`		|	Returns true if the argument is an object
`array`			|	Returns true if the argument is an array
`string`		|	Returns true if the argument is an string
`number`		|	Returns true if the argument is an number
`boolean`		|	Returns true if the argument is an "true" boolean, e.g. `TRUE` or `FALSE`
`defined`		|	Returns true if the argument is defined, e.g. not `undefined`
`empty`			|	Returns true if the argument is really empty
`same`			|	Returns true if two arguments are equal, e.g. ```Is.same('1', '1');```
`associated`  	|	Returns true if the argument is an associated array
`sequential`	| 	Returns true if the argument is an sequential array

Additionally the library also provides some basic validation expression filters:

Method 			|	Description
---				|	---
`url`			|	Returns true if the argument contains a URL
`email`			|	Returns true if the argument contains an E-Mail
`creditcard`	|	Returns true if the argument contains an Credit Card Number
`alphanumeric`	|	Returns true if the argument contains an Alpha Numeric string
`time`			|	Returns true if the argument contains an time
`datestring`	|	Returns true if the argument contains an date string
`zip`			|	Returns true if the argument contains an ZIP Code
`phone`			|	Returns true if the argument contains a US Phone Number
`ssn`			|	Returns true if the argument contains a Social Security Number
`affirmative`	|	Returns true if the argument contains True, Yes or Ok
`hexadecimal`	|	Returns true if the argument contains a hexadecimal string
`hexcolor`		|	Returns true if the argument contains an HTML color



## Other Implementations

This library was originally written in JavaScript for Meteor (http://github.com/flyandi/meteor-is) and implements the same methods and filters.
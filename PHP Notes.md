### Program With Gio Series (PHP 8 Tutorial)
https://www.youtube.com/watch?v=sVbEyFZKgqk&list=PLr3d3QYzkw2xabQRUpcZ_IBk9W50M9pe-&index=1&t=2s

- When writing a PHP file, any PHP portion with `<?php`, if the whole file is only about php, then you won't need the `?>` closing tag
- `echo` is marginally faster than `print`, however, `print` returns a value of 1, so could be used for error checking or what not if something isnt printing properly

#### Echo
- Shorter form of `<?php echo Hello World?>` is `<?= Hello World?>`

#### Constants
```php
define('name', 'value');

# Example
define('STATUS_PAID', 'paid');

echo STATUS_PAID;

#Redefining constants is not possible later, e.g.,
define('STATUS_PAID', 1); #this gives an error

#Checking if a constant is defined using `defined()` function, returns boolean true or false which are printed as 1 or blank respectively
echo defined('STATUS_PAID')

#Alternative to define() is the const keyword
const STATUS_PAID = 'paid';
```
- The first parameter is the name and it follows same conventions as variables, e.g., cannot start with number, have special characters. Can start with underline
- When referencing constants, you do NOT need the `$` that you use for variables
- `define()` is done at run-time, `const` is done at compile time
	- specifically, `define()` can be used within control structures like loops
![[Pasted image 20240307180214.png]]
- E.g. const does NOT work here as seen by the underlines, while define does!

#### Variable Variables
- Uses double dollar sign `$$`
- Treats the value of the original variable as the name of the new variable
```php
$foo = 'bar';

$$foo = 'baz'; #Equivalence is shown below
# $bar = 'baz';

//So this would actually work without $bar being explicitly defined
echo $foo , $bar;
//Less confusing by just using the variable variable directly
echo $foo , $$foo;
```
![[Pasted image 20240307181113.png|500]]
- The IDE may suggest that `$bar` is not defined, however, it is actually implicitly defined using variable variables
- Main point of variable variables is to create your variables **dynamically** (for arrays or objects)


## PHP Data Types
- PHP is dynamically or weakly typed (not required to define the type of your variable)
	- Type of variable can change after it has been defined
	- Type checking happens at run time
![[Pasted image 20240307181919.png]]

##### Checking types
- Either use `var_dump()` or `gettype()`
```php
$score = 75;
$completed = true;

echo gettype($score); //prints integer to the screen
var_dump($completed); //prints bool(true) <= basically prints what the variable holds, and its data type
var_dump($score); //prints int(75)
```
![[Pasted image 20240307182332.png|700]]

#### Compound Types
- Arrays, can put anything in it (even if its different data types). Simply a list of items as shown here
```php
#array
$companies = [1, 2, 3, 0.5, -1, 'A', 'B', true];
echo $companies; // This would give you an error, it would only print "Array" to the screen, doesn't know how to convert the array to a string properly
print_r($companies) // Refer to picture below
```
![[Pasted image 20240307182813.png|1000]]

#### Strict Mode in PHP
- Basically makes it more type strict like other languages we know (C, C++, Java, etc.), and not like python, where if we try to pass another type in when it requests a specific type (e.g., requests int, but pass in string), then it will give an error)
Done via:
```php
declare(strict_types=1);
```

#### Booleans
```php
//Integers 0 or -0 = false
//Floats 0.0  -0.0 = false
// '' or '0' (empty string or 0) = false 
// [] = false
// null = false
```
- We can check via `var_dump()` like before but for booleans specifically, we can do: `is_bool()`

#### Integers
Check the max and min values of integer of your system via:
```php
PHP_INT_MAX
PHP_INT_MIN
PHP_INT_SIZE
```
- Integers include hexadecimal, octo etc. `$x = 0x2A //This is 42`
- When an integer goes out of bounds (e.g. `PHP_INT_MAX + 1`), its type gets changed to a float
- Type casting a float number to integer will floor it, e.g., `5.98` is floored to 5
```php
$x = (int)"87dasdsa"; //simply returns x as 87
$x = (int)"test"; //can't be resolved as integer so simply returns 0

//Can check if its int via
is_int($x);

//With PHP 8.0+, we can make integers more readable by having underscores, e.g.,
$x = 200_000;
var_dump($x); //Returns int(200000)
```

#### Floats
```php
echo PHP_FLOAT_MAX;
echo PHP_FLOAT_MIN;

$x = 13.5e3; //shows 13500
$y = 13.5e-3; //shows 0.0135

//Can use the same underscore trick as integers for readability
```
- As with other languages, don't rely on floats to make accurate precision or calculations (e.g., flooring floats if you're adding them together)
- `INF` is infinity (out of bounds, etc.), e.g. from (`echo PHP_FLOAT_MAX * 2;)

#### Strings
- Single quotes cannot use variables, while double quotes can
![[Pasted image 20240307192623.png|900]]
##### Heredoc and Nowdoc
![[Pasted image 20240307192911.png|900]]
- Basically Heredoc is double quotes, while Nowdoc is treated as single quotes
	- Aka if you wanna use variables, you Heredoc, while Nowdoc, you dont want to have variables in there
- Advantage of Heredoc and Nowdoc is the readability of your strings. Specifically, you can include double and single quotes within the Heredoc/Nowdoc itself and they won't cause complications and is read as is
	- Aka won't need to use escape lines, and stuff or those things specifically
![[Pasted image 20240307193103.png|900]]

### Arrays
- Unlike strings, you cannot access the elements from the back of the array using negative numbers
- Can use `isset()` to see if that array value is set
`vardump(isset($programmingLanguages[3]));`

Nice way to print Arrays is using the html `<pre>` tags
![[Pasted image 20240307195408.png|1000]]

For length of array we use **`count()`** in PHP
`$programmingLanguages[] = 'C++'` <= this adds C++ element to the end of the array (aka a push operation)
- Alternatively, we can do **`array_push($programmingLanguages, 'C++', 'C', 'GO');`**

##### Assigning Array Keys and Values
![[Pasted image 20240307200536.png]]
- Here the key is assigned before the value, so the keys are the ones on the left, and values are the things on the right

- Below we show about adding on a new key and value `'go'`
![[Pasted image 20240307200808.png]]

##### Removing elements from arrays
`array_pop()` => Pops last element from array, and also returns that value
`array_shift()` => Removes first element from an array
- Note! When you remove from the beginning, the array actually gets reindexed!
`unset()` => Removes the specified indexed element from the array
- If you don't pass an index, it will simply destroy the entire array
- NOTE: unset unlike array_shift, does NOT re-index arrays, or remove those previous index keys (they are retained)
- Therefore unsetting a whole array, then pushing to it using our `$array[] = 1;` syntax, it actually pushes to the highest index number
![[Pasted image 20240307202908.png|800]]

```php
$array = ['a' => 1, 'b' => null];
var_dump(array_key_exists('a', $array)); //returns bool(true)

var_dump(isset($array['a'])); //returns bool(true)
```
- Major difference between array_key_exists, is that it tells you if the key exists at all!
	- Comparatively, isset tells you if the key exists, and **IF IT IS SET** (aka not NULL)
![[Pasted image 20240307203215.png|800]]

## PHP Operators
**Exponentiation** denoted by `**`, e.g.
```PHP
$x = 5;
$y = 2;
var_dump($x ** $y); // This returns 25
```
- **Division** returns both integers and floats, depending on the values provided. If you provide two integers that divide cleanly (e.g. 10/2) then it will return the integer 5
- However, if you provide two integers that have a remainder like 10/3, then it will return the float 3.33333 
	- If you mix integer and floats, then it will return a float (e.g. 10/2.0)

To not get an error when dividing by 0, we can use the `fdiv()` function to return the float(INF) (infinity) if you so desire

**Modulus**: When using modulus, it will cast the two values provided into integers, e.g. (10.5%2.9) will return 0, since its the same as if you did 10%2
- `fmod()` is the function you want to use where you pass in two arguments to do a floating modulus)

##### String Concatenation Operator `.` or `.=`
```php
$x = 'Hello';
$x = $x . ' World';

//Equivalent as above
$x .= ' World';
```

### Comparison Operators
Spaceship operator (recall C++) `<=>`
```php
//<=>
var_dump($x <=> $y);
# Returns -1 if x is less than y, 0 if x is equal to y, and +1 if x is larger than y
```

`??` operator
```php
$x = null;
$y = $x ?? 'Hello'; //If x is null, then y becomes the value after ??, otherwise if x is not null, y is assigned the value of x
```

## Logical Operators `&& || ! and or xor`
- `and` and `or` are the same as their counterparts, except in regards to **precedence**
- Good rule of thumb, just don't use the `and` and `or` word operators. Their precedence is VERY low.

## Array Operators `+ == === != <> !===` 
(note <> is the same as inequality operator apparently)
```php
$x = ['a', 'b', 'c'];
$y = ['d', 'e', 'f', 'g', 'h'];

$z = $x + $y; // This $z = ['a', 'b', 'c', 'g', 'h']. It is simply a union (adds to the array if there are not things at those indexes

// == (comparison), compares if the arrays have the same (key, value) pairs

// === (strict comparison), checks the data types, and also if the (key,value) pairs are in the same order!
$x = ['a' => 1, 'b' => 2, 'c' => 3];
$y = ['a' => 1, 'b' => '2', 'c' => 3]; //Strict comparison (===) returns false here

$x = ['a' => 1, 'b' => 2, 'c' => 3];
$y = ['a' => 1, 'c' => 3, 'b' => 2]; //Strict comparison (===) returns false here as its not in the same order!
```

## Precedence
refer to https://www.php.net/manual/en/language.operators.precedence.php
- Items at the top of the table have higher precedence then the ones on the bottom. Left side is associativity
- Associativity is when operators have the same level of precedence, the associativity describes which direction the operators are handled (e.g. left or right)

##### `elseif` vs `else if`
- Better to use the first version without the space basically for html 
Sample if/elseif statement in PHP imbedded in HTML for readability
```html
<html>
	<head>
		
	</head>
	<body>
		<?php $score = 55; ?>
		
		<?php if ($score >= 90): ?>  #Notice the : here
			<strong style = "color: green;">A</strong>
		<?php elseif ($score >=80): ?> #notice the : again, also if you do else if (with space) you get error
			<strong>A</strong>
		<?php elseif ($score >=70): ?> 
			<strong>B</strong>
		<?php elseif ($score >=60): ?>
			<strong>C</strong>
		<?php elseif ($score >=50): ?>
			<strong>D</strong>
		<?php else: ?>
			<strong>E</strong>
		<?php endif ?> #important endif here
	</body>
</html>
```
- Much more readable in this format above

## Loops
You can do `break 2` which will actually break out of multiple nested loops
Alternative syntax for php for while loops
```php
<?php

while (true):
...
endwhile;

```
`foreach` used to iterate over arrays or objects
```php
<?php
$proglang = ['php', 'java', 'c++', 'go', 'rust'];

foreach($proglang as $key => $language){
	echo $key . ': ' . $language . '<br />';
}

# If we want to modify the elements of the original array, use by reference aka &
foreach($proglang as $key => &$language){
	$language = 'php';
}
print_r($proglang); //All the languages are php now
```
- Note! The variable aka `$language` actually remains after the loop
- Usually just general good practice to do **`unset($language)`** after the loops

Iterating over **associative arrays**
- use the **`json_encode()`** or **`implode()`**
  - If using `implode()`, make sure to check if its an array
```php
<?php
$user = [
	'name' => 'Thomshu',
	'email' => 'thomson@email.com',
	'skills' => ['php', 'java', 'python'],
];

foreach($user as $key => $value){
	echo $key . ': ' . json_encode($value) . '<br />';
}

#implode variant
foreach($user as $key => $value){
	if (is_array($value)){
		$value = implode(', ', $value);
	}
	
	echo $key . ': ' . json_encode($value) . '<br />';
}

#Alternative syntax foreach
foreach():

endforeach;
```

### Switch statements
- Switch statements do loose comparison (does not check datatypes, so `1` and `'1'` will be treated the same if it was say `case 1:`)
- Switch statements are better than if elseif as the expression in the switch() is checked only once as opposed to the conditional statements

### Match expression (PHP 8)
`match()` keyword
```php
<?php
$paymentStatus = 1;
$payStatusDisplay = match($paymentStatus){
	1 => 'Paid',
	2 => 'Payment Declined',
	0 => 'Pending Payment',
	default => 'Unknown Payment Status',
};

echo $payStatusDisplay
```
- Difference compared to switch statements
- `match()` expression itself will evaluate to a value, thus we can assign it to a variable
- Much cleaner syntax, and no fall through that we experience with switch
- Match does **strict comparison** while switch does loose comparison
- **Cannot** do multiple lines as opposed to the multiple lines under each `case` seen in switch
	- Possible way of doing this is to make the result of each match be a function call if you want multi line

### Declare Statements
**Ticks**
```php
#ticks
register_tick_function('functionName');
declare(ticks=1); <= ticks after each line
```
Strict Types
`declare(strict_types=1);`
- Only applied to the file its in and only to the lines under it

## Include Files in PHP
`require`, `require_once`, `include`, `include_once`
- Include gives a **warning** and require gives an **error** is the main big difference
- the `..._once` will include or require the file only once, specifically if its already been included/introduced 
```php

include 'file.php';
```
https://www.youtube.com/watch?v=pQLO6l5lp-Y&list=PLr3d3QYzkw2xabQRUpcZ_IBk9W50M9pe-&index=21
- Last portion of the video is pretty cool and probably able to implement

## Functions
syntax
```php
function foo(): int{
	return 1;
}
```

- Special to PHP
```php
function foo(): ?int{
	return null;
}
```
- The `?int` here means that null type is also acceptable as the return value

Similarly, accepting multiple return types, can be done using `mixed` keyword as well
```php
function foo(): int|float|array{
	return 1;
	//return 1.5;
	//return [];
}

#Alternative 
function foo(): mixed{
	return 1;
	//return 1.5;
	//return [];
}
```

##### Function Parameters
- Similar to expected return data type, we can do Union types for the parameters
- As well as setting default values for parameters
  - Note for this, these default values must be put at the end of the parameter list (e.g. can't have no default, default, no default)
```php
function foo(int|float $x, int|float $y = 10)}{ //Note here, by equating y to 10, this is the DEFAULT value if no parameter is passed in
	return $x * $y
}

echo foo(5.0); //Here it assigns 5 to x, and uses the default value of 10 for y
```
- Splat operator (`...` operator)
```php
function sum(...$numbers): int|float{
	$sum = 0;
	
	foreach($numbers as $number){
		$sum += $number;
	}
	return $sum;
}

echo sum(10, 15, 20, 30, 1, 5, 6) . '<br />';


#Combination of regular parameters with variadic parameters
function sum(int|float $x, int|float $y, ...$numbers): int|float{
	return $x + $y + array_sum($numbers);
}
```
- This splat operator can also be used to unpack an array into separate arguments
```php

$a = 6.0;
$b = 7;
$numbers = [50, 100, 25.90, 9, 8];

echo sum($a, $b, ...$numbers) . '<br />';
```

### Named Arguments (PHP 8)
- Basically allows you to pass in arguments out of order, by naming them specifically when calling the function
```php
function foo(int $x, int $y): int{
	if ($x % $y === 0){
		return $x/$y;
	}
	
	return $x;
}

#This is the named arguments part
$x = 6;
$y = 3;
echo foo(y: $y, x: $x); //See that we're passing in the parameters in a different order (x is supposed to be first, y supposed to be second)
```
- Main point: Makes it **easier** to change and adjust your functions parameters/orders, without searching and changing the rest of the code that uses said function
- For specific functions (e.g. built in ones like `setcookie()), there are a lot of parameters that have default values
  - By using named arguments, we can pass in values that are NON default that we want, without typing or passing in the default values for the others
  - E.g. if the arguments we're passing are the first, second and say last (10th) parameter of the function
```php
setcookie(name: 'foo', value: 'bar', httponly: true);
```
- You can also do a mix of named arguments and regular arguments, e.g.
```php
echo foo($x, y: $x);
```
- Associative arrays keys are actually counted as the named arguments
Example:
```php
function foo(int $x, int $y): int{
	var_dump($x, $y); //Important for us to see what happens
	if ($x % $y === 0){
		return $x/$y;
	}
	
	return $x;
}

$arr = ['y' => 2, 'x' => 1]; //Associative array
echo foo(...$arr);
//var_dump would return int(1)int(2) <= aka the x is assigned to $x, while y is assigned to $y despite being out of order. Its because like we mentioned
// the keys themselves are used as the named arguments when passed
```

### Variable Scope
##### Global Variables
- For variables outside of functions, to access them in functions, aside from the normal ways of passing it in as an argument, we can use the `global` keyword
- By using the `global` keyword, the function also can access and modify that variable as global gives a reference of that variable
  - Therefore if we adjust in the function, it will be adjusted as if we adjusted the original variable as well
```php
$x = 5;

function foo(){
	global $x;
	
	echo $x;
}

foo();
```
- Global variables are stored, and we can access them using the `$GLOBALS` keyword along with the variable name, e.g.,
```php
$x = 5;

function foo(){
	echo $GLOBALS['x'];
}

foo();
```

##### Static Variables
- Essentially, static variables using the `static` keyword will ONLY be assigned/called once, and on repeat requests, it will not be ran or called again
- This is good for saving processing time

## Different variations/types of Functions (Variable/Anonymous/Callable/Closure/Arrow)

#### Variable Functions
```php
function sum(int|float ...$numbers): int|float{
	return array_sum($numbers);
};

#Alternative way to call functions
$x = 'sum';
echo $x(1,2,3,4); //This will call the sum function and echo its result
```
- In PHP, when it detects **parenthesis** next to a variable, it will look for a function with the same name as whatever the variable evaluates to, which in this case was `sum`
  - If `sum` function does not exist, it would simply throw an error
  - To avoid this error, we can use the function `is_callable()`
```php
function sum(int|float ...$numbers): int|float{
	return array_sum($numbers);
};

$x = 'sum';
if (is_callable($x)){
	echo $x(1,2,3,4); //This will call the sum function and echo its result
}
else{
	echo 'Not Callable';
}
```

#### Anonymous Functions aka **LAMBDA** functions
```php
$sum = function (int|float ...$numbers): int|float{ // No name function aka Lambda as we know it, we can assign it to variable called sum
	return array_sum($numbers);
};

echo $sum(1,2,3,4);
```

##### Accessing variables from parent scope in say anonymous functions via `use` keyword
- `use` keyword followed by variables trying to access in parenthesis
```php
$x = 1; //variable we are trying to access in function
$sum = function (int|float ...$numbers) use ($x): int|float{ // No name function aka Lambda as we know it, we can assign it to variable called sum
	echo $x;
	return array_sum($numbers);
};

echo $sum(1,2,3,4);
```
- As always, we can access those variables by reference by adding ampersand
```php
$sum = function (int|float ...$numbers) use (&$x): int|float{ // No name function aka Lambda as we know it, we can assign it to variable called sum
	$x = 15; //adjusting it since we passed it by reference
	echo $x;
	return array_sum($numbers);
};

echo $sum(1,2,3,4);
```

#### Callable data type and Callback functions
- Example, `array_map()` first argument it accepts is a so called **callback** function of data type callable
- One way to pass this in is via an anonymous function
```php
$array = [1,2,3,4];

$array2 = array_map(function($element){
	return $element * 2;
}, $array);

echo '<pre>';
print_r($array);

print_r($array2);
echo '</pre>';

//$array2 = array_map('foo', $array); third way
```
- Second way is to assign anonymous function to variable then pass it in
- And third way is obviously having a function defined properly as a name and pass it in as a string

Example used in video
```php
$sum = function (callable $callback, int|float ...$numbers) use ($x): int|float{ 
	return $callback(array_sum($numbers)); //This callback is calling the function we passed into it below in the echo statement
};

function foo($element){
	return $element * 2;
}

echo $sum('foo', 1,2,3,4);

//Passing as anonymous function
echo $sum(function($element){
	return $element * 2;
}, 1,2,3,4);
```
- "**closure**" vs "**callable**" functions
  - Closure function MUST be a lambda function while callable functions can be both lambda and named functions
  - Basically where callable is used in the above example, the keyword `closure` could have been used instead if we were using anonymous functions

##### Arrow Functions
- Cleaner syntax of anonymous functions, good for inline callback functions, using 
`fn(parameter defition) => expression`
```php
#As before, we did
$array = [1,2,3,4];
$array2 = array_map(function($element){
	return $element * $element;
}, $array);

echo '<pre>';
print_r($array2); //Would get 1,4,9,16
echo '</pre>';

#Replacing it with an ARROW function for cleaner syntax
$array2 = array_map(fn($element) => $element * $element, $array);
```
- Differences, can always access variables from parent scope WITHOUT the need to use the `use` keyword like we did before for functions
- Arrow functions can only have a single expression and it returns the value of that expression
  - Cannot have multi-line expressions

## Date & Time
https://www.php.net/manual/en/datetime.format.php
https://www.php.net/manual/en/timezones.php
https://www.php.net/manual/en/datetime.formats.php#datetime.formats.relative
`time()` function
`echo time()` //Prints large integer of Unix timestamp. It's the timestamp from 1970 jan 1st

```php
$currentTime = time();
$5daysTime = $currentTime + 5*24*60*60;
$YesterdayTime = $currentTime - 60*60*24;
```

#### **Date**
```php
echo date('m/d/Y g:ia') . '<br />'; #refer to datetime.format.php //e.g. 03/15/2024 11:00pm
// g is 12-hour format without leading zeros
// i gives minutes without leading zeros
//a gives Lowercase am or pm
```

#### Timezone
`date_default_timezone_set('UTC')` //Pass in valid timezone using the timezones.php doc

**Converting** String dates to unix timestamp (parsing dates)
Use `strtotime()` function
`strtotime('2021-01-18 07:00:00');`
- `strtotime()` also works with common/relevant keywords
- E.g. `strtotime('tomorrow');` or `strtotime('first day of february)`

`date_parse`
- Pass in a date and you will return an array containing the dates information
  - E.g. year, month, day, hour, minute, second, fraction, etc.

`date_pase_from_format()` parses a date from a specific format that you have to pass in
`print_r(date_parse_from_format('m/d/Y g:ia', $date));`

### Array Functions
https://www.php.net/manual/en/ref.array.php
`array_chunk(array $array, int $length, bool $preserveKeys = False): array`
- First two arguments are important, third one is optional if you want to preserve the keys or not
- Simply breaks the array down into smaller chunks

`array_combine(array $keys, array $values): array`
- Combines two arrays, using the first array's values as the new array's keys, and the second arrays values as the new array's values
- Error occurs if number of elements do not match in the two arrays

`array_filter(array $array, callable|null $callback = null, int $mode=0): array`
- Last argument is to specify what the callback function uses (e.g. the key or values of the array)
- if we use `array_filter($array)` with no additional arguments, the array_filter function will simply just clean the array from all false/null values, e.g. `false, [], 0.0, etc.)

`array_keys(array $keys, mixed $search_value, bool $strict = false): array`
`$keys = array_keys($array);` <= Returns the keys as values of the new array

`array_map(callable|null $callback, array $array, array ...$arrays): array`
- Example is wanting to multiply an array by 3
`$newarray = array_map(fn($number) => $number * 3, $array);`
- `$newarray = array_map(fn($number1, $number2) => $number1 * $number2, $array1, $array2);`

`array_merge(array ...$arrays): array`
- Merges arrays by appending them to the end of each array
- **Numeric** keys will be reindexed starting from 0
- However, if you have repeat **string** keys, then the values will be overwritten by repeat keys and their corresponding values

`array_reduce(array $array, callable $callback, mixed $initialValue = null): mixed`
```php
$invoiceItems = [
    ['price' => 99.9, 'qty' => 3, 'desc' => 'Item 1'],
    ['price' => 29.99, 'qty' => 1, 'desc' => 'Item 2'],
    ['price' => 149, 'qty' => 1, 'desc' => 'Item 3'],
    ['price' => 14.99, 'qty' => 2, 'desc' => 'Item 4'],
    ['price' => 4.99, 'qty' => 4, 'desc' => 'Item 5'],
];

$total = array_reduce(
    $invoiceItems,
    fn($sum, $item) => $item['qty'] * $item['price']
    #, 500 <= this additional parameter after the one before is the **initial value**, so it would start off at 500 here + the total 258.9 seen below
);

echo $total; # This would print 258.9
```

`array_search(mixed $needle, array $haystack, bool $strict = false); int|string|false`
```php
$array = ['a', 'b', 'c', 'D', 'E', 'ab', 'bc', 'cd', 'b', 'd'];

$key = array_search('b', $array); // Last comparison is if you want to do loose or strict comparison
// This would return int(1)
// Only returns the key of the first matching value
```

#### Finding difference between arrays
`array_diff($array1, $array2, $array3);`
- Returns the **values** of the first array not present in the other arrays
- `array_diff_key()` does the same but for keys instead

If we also want to check for the keys we use:
`array_diff_assoc($array1, $array2, $array3);`
- Displays all the (key,value) pairs that DON'T appear in the other arrays

#### Sorting Arrays
**`asort()`**
- Sorts arrays by their values

**`ksort()`**
- Sorts arrays by their keys

`usort()`, takes a callback as its second argument
```php
usort($array, fn($a, $b) => $a <=> $b);
```
- Sort will remove custom keys and use numeric keys instead

#### Array Destructuring
```php
$array = [1,2,3,4];

[$a, $b, $c, $d] = $array; #Alternative syntax is list($a, $b, $c, $d)

echo $a . ', ' . $b . ', ' . $c . ', ' . $d . '<br />';

# Can also destructure only some of them if you want
[$a, , $c, ] = $array; 

echo $a . ', ' . $c . '<br />';

#Can also do this out of order if you want
# Can also destructure only some of them if you want
$array = [1,2,3];
[1 => $a, 0 => $b, 2 => $c ] = $array; 

echo $a . ', ' . $b . ', ' . $c . '<br />';
```

## PHP Configuration File
**PHP.INI**
- For XAMPP, can be found via the Apache => Config => php.ini
- Text enclosed in `[]` is ignored
- Text with ; (semicolon) are comments

Possibly important settings
- `error_reporting`
- `error_log` combined with `display_errors`

### Error Handling and Error Handlers
#### Error Handler
- Creating our own function
```php
//Error Handling
function errorHandler(int $type, string $msg, ?string $file = null, ?int $line = null) //First argument is error type, second is error message
{
    #Bad line of code, simply for demonstration purposes
    echo $type . ': ' . $msg . ' in ' . $file . ' on line ' . $line;
    exit;
}

#Registering it at the errorHandler
set_error_handler('errorHandler', E_ALL); //Custom errorhandler first argument, error level as second argument
```

Skipped 1.29: Basic Apache Webserver Config/Virtual Hosts

## Working with Filesystem in PHP
```php

$dir =  scandir(__DIR__); 
var_dump($dir); //Run this in index.php and you'll see the results. Leads to current directory. It returns an array that you could loop through and use
#$dir[2] would return the current file in the directory aka index.php

#Creating new directory
mkdir('foo');

#Deleting directory
rmdir('foo'); //Deleting directory has to be an empty directory otherwise warning

#Making directory recursively (this makes both foo and bar
mkdir('foo/bar', recursive: true);

rmdir('foo/bar')
```

**`file_exists('foo.txt')`** function

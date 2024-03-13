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

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









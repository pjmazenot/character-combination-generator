# Character Combination Generator

*Character Combination Generator is a PHP script generating all available combinations for a given charset and length. 
It may also be useful for password bruteforcing exercises*


## Table of Contents

  1. [Documentation](#documentation)  
    a. [Usage](#usage)  
    b. [Options](#options)  
    c. [Examples](#examples)  
  2. [Changelog](#changelog)
  3. [Contact](#contact)
  4. [License](#license)


## Documentation

### Usage

Default generation process

```php
<?php
// Include the lib file
require_once 'character-combination-generator.php';

// Create the CharCombinationGenerator instance with the required parameters
$generator = new CharCombinationGenerator($maxLength, $alphabet);

// Run the generation process
$generator->run(function ($combination) {
    // Callback function executed for each new combination generated
});
?>
```

"Manual" generation process

```php
<?php
// Include the lib file
require_once 'character-combination-generator.php';

// Create the CharCombinationGenerator instance with the required parameters
$generator = new CharCombinationGenerator($maxLength, $alphabet);

// Run the generation process
for($i = 0 ; $i < 10 ; $i++) {
	
	$combination = $generator->generateNextCombination();
	
	// Perform test or any operation on the combination
	// ...
	
}
?>
```
  
### Options

* ***[required]*** `$maxLength`  
Maximum length of the generated combinations. 

* ***[required]*** `$alphabet`  
Charset to use for the generation.   

### Examples

1. Display all combinations for the **abcd** charset with a max length of 3

```php
<?php
$generator = new CharCombinationGenerator(3, ['a', 'b', 'c', 'd']);
$generator->run(function ($combination) {
    echo $combination . PHP_EOL;
});
?>
```

2. Display the first 10 combinations for the **abcd** charset with a max length of 2

```php
<?php
$generator = new CharCombinationGenerator(2, ['a', 'b', 'c', 'd']);
for($i = 0 ; $i < 10 ; $i++) {
	$combination = $generator->generateNextCombination();
	if(empty($combination)) {
 		break;
 	} else {
 		echo  $combination . PHP_EOL;
 	}
}
?>
 ```

## Changelog

```

2018-01-05
* Add documentation
* Add README

2017-11-18
* Create the main script
* Support callback function to process each combination
* Support manual generation

```

## Contact

For any suggestion or request, please send a message at pj.mazenot@gmail.com

## License

© 2017 Pierre-Julien Mazenot

[MIT](https://github.com/pjmazenot/character-combination-generator/blob/master/LICENSE)
# Ordered map accepting arbitrary keys for PHP[ ![Travis Build Status](https://travis-ci.org/mfn/php-util-simpleorderedmap.svg?branch=master)](https://travis-ci.org/mfn/php-util-simpleorderedmap)

Homepage: https://github.com/mfn/php-util-simpleorderedmap

## Basic usage:

```PHP
$map = new \Mfn\Util\Map\SimpleOrderedMap;
$map->add(new \stdClass, "value");
foreach ($map->keys() as $key) {
  echo $map->get($key), PHP_EOL;
}
```
Outputs: `value`

## Common usage
Add and set keys/values:
```PHP
use \Mfn\Util\Map\SimpleOrderedMap;
$map = SimpleOrderedMap;
$map->add($key, $val); # throws exception if key already exists
$map->set($key, $val); # replaces value if key already exists
```
Retrieve:
```PHP
$val = $map->get($key); # throws exception if key does not exist
if ($map->exists($key)) {
  # ...
}
```
Remove:
```PHP
$map->del($key); # throws exception if key does not exist
```
The keys are always kept in their order when removing, this position index are available:
```PHP
$index = $map->getKeyPosition($key);
$key = $map->getKayAt($index);
$val = $map->getValueAt($index);
```
Create from existing hashes or arrays:
```PHP
use \Mfn\Util\Map\SimpleOrderedMap;
$map = SimpleOrderedMap::fromHash(['a'=>true,10=>NULL]);
$map->keys(); # ['a',10]
$map->values(): # [true,NULL]

# The same with separate arrays. Note: arrays length must match
$map = SimpleOrderedMap::fromArrays(
  ['a',10],
  [true,NULL]
);
$map->keys(); # ['a',10]
$map->values(): # [true,NULL]
```
Many more methods, please see [the source of SimpleOrderedMap](lib/SimpleOrderedMap.php)

## Using with key/value validation

If you feel like you need some kind of validation, you can use
SimpleOrderedValidatingMap which provides callbacks for checking new added key
and values:

```PHP
use Mfn\Util\Map\SimpleOrderedValidatingMap as Map;

$map = new Map(
              function($key) {
                if ($key instanceof \stdClass) {
                  return;
                }
                throw new \Mfn\Util\Map\SimpleOrderedValidatingMapException(
                  'Only keys of type stdClass are allowed'
                );
              },
              function($value) {
                if ($value instanceof \stdClass) {
                  return;
                }
                throw new \Mfn\Util\Map\SimpleOrderedValidatingMapException(
                  'Only values of type stdClass are allowed'
                );
              }
           );
# Throws an exception
$map->add(1,2);
```

# Install

Using composer: `composer.phar require mfn/util-simpleorderedmap 0.0.2`

# Contribute
Fork it, hack on a feature branch, create a pull request

© Markus Fischer <markus@fischer.name>

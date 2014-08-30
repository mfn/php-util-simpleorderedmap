# Ordered map accepting arbitrary keys

Master: [![Build Status](https://travis-ci.org/mfn/php-util-simpleorderedmap.svg?branch=master)](https://travis-ci.org/mfn/php-util-simpleorderedmap)

Homepage: https://github.com/mfn/php-util-simpleorderedmap

## Basic usage:

```PHP
$map = new \Mfn\Util\SimpleOrderedMap;
$map->add(new \stdClass, "value");
foreach ($map->keys() as $key) {
  echo $map->get($key), PHP_EOL;
}
```
Outputs: `value`

## Common usage
Add and set keys/values:
```PHP
use \Mfn\Util\SimpleOrderedMap;
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
Create from existing hashes or arrays:
```PHP
use \Mfn\Util\SimpleOrderedMap;
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

# Contribute
Fork it, hack on a feature branch, create a pull request

© Markus Fischer <markus@fischer.name>

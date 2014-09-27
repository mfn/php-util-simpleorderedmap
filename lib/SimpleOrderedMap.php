<?php
/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2014 Markus Fischer <markus@fischer.name>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */
namespace Mfn\Util\Map;

/**
 * Provide a key/value mapping support almost any data structure as keys.
 *
 * - relative order of keys is kept but not their absolute index position during
 *   deletions.
 * - index positions start at 0
 * - add() adds key/value will error out if the key already exists
 * - set() will overwrite any possible existing keys
 *
 * All key comparison are made with strict equality comparison.
 *
 * @author Markus Fischer <markus@fischer.name>
 */
class SimpleOrderedMap {
  private $keys = [];
  private $values = [];

  /**
   * Keys/Values of the hash will be set as keys/values in the map
   * @param array $hash
   * @return SimpleOrderedMap
   */
  static public function fromHash(array $hash) {
    $map = new SimpleOrderedMap();
    $map->keys = array_keys($hash);
    $map->values = array_values($hash);
    return $map;
  }

  /**
   * Fill map form two different arrays, one acting as keys, the other as values
   * Note: the keys of either arrays are not considered.
   * @param array $keys
   * @param array $values
   * @return SimpleOrderedMap
   * @throws SimpleOrderedMapException
   */
  static public function fromArrays(array $keys, array $values) {
    if (count($keys) !== count($values)) {
      throw new SimpleOrderedMapException(
        'Length of keys and values does not match');
    }
    $map = new SimpleOrderedMap();
    $map->keys = array_values($keys);
    $map->values = array_values($values);
    return $map;
  }

  /**
   * @return $this
   */
  public function clear() {
    $this->keys = $this->values = [];
    return $this;
  }

  /**
   * @return int
   */
  public function count() {
    return count($this->keys);
  }

  /**
   * @param $key
   * @return SimpleOrderedMap
   * @throws SimpleOrderedMapException
   */
  public function del($key) {
    $index = array_search($key, $this->keys, true);
    if (false === $index) {
      throw new SimpleOrderedMapException('Key does not exist');
    }
    return $this->delAt($index);
  }

  /**
   * @param integer $index
   * @throws SimpleOrderedMapException
   * @return $this
   */
  public function delAt($index) {
    if (!isset($this->keys[$index])) {
      throw new SimpleOrderedMapException("No key at index $index found");
    }
    $this->keys = array_merge(
      array_slice($this->keys, 0, $index),
      array_slice($this->keys, $index + 1)
    );
    $this->values = array_merge(
      array_slice($this->values, 0, $index),
      array_slice($this->values, $index + 1)
    );
    return $this;
  }

  /**
   * @param integer $index
   * @return bool
   */
  public function existsAt($index) {
    return isset($this->keys[$index]);
  }

  /**
   * @param $key
   * @return mixed
   * @throws SimpleOrderedMapException
   */
  public function get($key) {
    $index = array_search($key, $this->keys, true);
    if (false === $index) {
      throw new SimpleOrderedMapException('Key does not exist');
    }
    return $this->values[$index];
  }

  /**
   * @param integer $index
   * @return mixed
   * @throws SimpleOrderedMapException
   */
  public function getKeyAt($index) {
    if (!isset($this->keys[$index])) {
      throw new SimpleOrderedMapException("No key at index $index found");
    }
    return $this->keys[$index];
  }

  /**
   * @param integer $index
   * @return mixed
   * @throws SimpleOrderedMapException
   */
  public function getValueAt($index) {
    if (!isset($this->values[$index])) {
      throw new SimpleOrderedMapException("No value at index $index found");
    }
    return $this->values[$index];
  }

  /**
   * @return bool
   */
  public function isEmpty() {
    return count($this->keys) === 0;
  }

  /**
   * @return array
   */
  public function keys() {
    return $this->keys;
  }

  /**
   * Adds a new key/value pair at the list of keys; overwrites existing key
   * Note: if the key already exists, only the value is updated
   * @param mixed $key
   * @param mixed $value
   * @throws SimpleOrderedMapException
   * @return $this
   */
  public function set($key, $value) {
    if ($this->exists($key)) {
      $index = $this->getKeyPosition($key);
      $this->values[$index] = $value;
      return $this;
    }
    return $this->add($key, $value);
  }

  /**
   * @param $key
   * @return bool
   */
  public function exists($key) {
    return in_array($key, $this->keys, true);
  }

  public function getKeyPosition($key) {
    $index = array_search($key, $this->keys, true);
    if (false === $index) {
      throw new SimpleOrderedMapException('Key does not exist');
    }
    return $index;
  }

  /**
   * Adds a new key/value pair at the list of keys, error on duplicate key.
   * @param mixed $key
   * @param mixed $value
   * @throws SimpleOrderedMapException
   * @return $this
   */
  public function add($key, $value) {
    if ($this->exists($key)) {
      throw new SimpleOrderedMapException('Key already exists');
    }
    $this->keys[] = $key;
    $this->values[] = $value;
    return $this;
  }

  /**
   * @return array
   */
  public function values() {
    return $this->values;
  }
}

class SimpleOrderedMapException extends \Exception {
}

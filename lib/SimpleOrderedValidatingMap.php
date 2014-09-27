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
 * On top of SimpleOrderedMap, provide callbacks for validation of newly added
 * key/values.
 *
 * Each callback receives the key/value and is expected to throw a
 * SimpleOrderedValidatingMapException if validation fails.
 *
 * Design decisions:
 * - validations cannot be changed after constructing the class
 * - Does not work together with the static from* method; i.e. you cannot
 *   get a SimpleOrderedValidatingMap class by calling fromArray()
 *
 * @author Markus Fischer <markus@fischer.name>
 */
class SimpleOrderedValidatingMap extends SimpleOrderedMap {
  /** @var NULL|callable */
  private $keyValidation = NULL;
  /** @var NULL|callable */
  private $valueValidation = NULL;

  /**
   * @param NULL|callable $keyValidation Invoked for every new key added
   * @param NULL|callable $valueValidation Invoked for every new value added
   */
  public function __construct(callable $keyValidation = NULL,
                              callable $valueValidation = NULL) {
    $this->keyValidation = $keyValidation;
    $this->valueValidation = $valueValidation;
  }

  public function set($key, $value) {
    $this->validate($key, $value);
    return parent::set($key, $value);
  }

  /**
   * Tests key/value against validation callbacks, if present. The callbacks
   * are expected to throw a
   * @param mixed $key
   * @param mixed $value
   * @throws SimpleOrderedValidatingMapException
   */
  private function validate($key, $value) {
    if ($this->keyValidation) {
      $cb = $this->keyValidation;
      $cb($key);
    }
    if ($this->valueValidation) {
      $cb = $this->valueValidation;
      $cb($value);
    }
  }

  public function add($key, $value) {
    $this->validate($key, $value);
    return parent::add($key, $value);
  }
}

class SimpleOrderedValidatingMapException extends SimpleOrderedMapException {
}

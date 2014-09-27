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

class SimpleOrderedValidatingMapTest extends \PHPUnit_Framework_TestCase {

  public function testNoValidation() {
    $map = new SimpleOrderedValidatingMap();
    $map->add(1, 2);
    $this->assertSame([1], $map->keys());
    $this->assertSame([2], $map->values());
  }

  /**
   * @expectedException \Mfn\Util\Map\SimpleOrderedValidatingMapException
   * @expectedExceptionMessage key of type stdClass expected
   */
  public function testValidateKeyFail() {
    $map = new SimpleOrderedValidatingMap(
      function ($key) {
        if (!($key instanceof \stdClass)) {
          throw new SimpleOrderedValidatingMapException(
            'key of type stdClass expected'
          );
        }
      }
    );
    $map->add(1, 2);
  }

  public function testValidateKeySucceed() {
    $map = new SimpleOrderedValidatingMap(
      function ($key) {
        if (!($key instanceof \stdClass)) {
          throw new SimpleOrderedValidatingMapException(
            'key of type stdClass expected'
          );
        }
      }
    );
    $obj = new \stdClass();
    $map->add($obj, 2);
    $this->assertSame([$obj], $map->keys());
    $this->assertSame([2], $map->values());
  }

  /**
   * @expectedException \Mfn\Util\Map\SimpleOrderedValidatingMapException
   * @expectedExceptionMessage value of type stdClass expected
   */
  public function testValidateValueFail() {
    $map = new SimpleOrderedValidatingMap(
      NULL,
      function ($key) {
        if (!($key instanceof \stdClass)) {
          throw new SimpleOrderedValidatingMapException(
            'value of type stdClass expected'
          );
        }
      }
    );
    $map->add(1, 2);
  }

  public function testValidateValueSucceed() {
    $map = new SimpleOrderedValidatingMap(
      NULL,
      function ($value) {
        if (!($value instanceof \stdClass)) {
          throw new SimpleOrderedValidatingMapException(
            'value of type stdClass expected'
          );
        }
      }
    );
    $obj = new \stdClass();
    $map->add(1, $obj);
    $this->assertSame([1], $map->keys());
    $this->assertSame([$obj], $map->values());
  }
}

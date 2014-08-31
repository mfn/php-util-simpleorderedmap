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
/**
 * @author Markus Fischer <markus@fischer.name>
 */
namespace Mfn\Util;
class SimpleMapTest extends \PHPUnit_Framework_TestCase
{
  /**
   * @var SimpleOrderedMap
   */
  private $map = NULL;

  protected function setUp() {
    $this->map = new SimpleOrderedMap();
  }

  public function testEmptyMap() {
    $this->assertSame([], $this->map->keys());
    $this->assertSame([], $this->map->values());
    $this->assertSame(true, $this->map->isEmpty());
  }

  /**
   * @expectedException \Mfn\Util\SimpleOrderedMapException
   * @expectedExceptionMessage Key does not exist
   */
  public function testNonExistingKey() {
    $this->map->get('iDoNotExist');
  }

  public function testAddNULL() {
    $this->map->add(NULL, NULL);
    $this->assertSame([NULL], $this->map->keys());
    $this->assertSame([NULL], $this->map->values());
    $this->assertSame(NULL, $this->map->get(NULL));
    $this->assertSame(false, $this->map->isEmpty());
  }

  public function testAddFalse() {
    $this->map->add(false, false);
    $this->assertSame([false], $this->map->keys());
    $this->assertSame([false], $this->map->values());
    $this->assertSame(false, $this->map->get(false));
    $this->assertSame(false, $this->map->isEmpty());
  }

  public function testAddTrue() {
    $this->map->add(true, true);
    $this->assertSame([true], $this->map->keys());
    $this->assertSame([true], $this->map->values());
    $this->assertSame(true, $this->map->get(true));
    $this->assertSame(false, $this->map->isEmpty());
  }

  public function testAddObject() {
    $obj = new \stdClass();
    $this->map->add($obj, 'obj');
    $this->assertSame([$obj], $this->map->keys());
    $this->assertSame(['obj'], $this->map->values());
    $this->assertSame('obj', $this->map->get($obj));
    $this->assertSame(false, $this->map->isEmpty());
  }

  public function testObjectIsNotObject() {
    $obj1 = new \stdClass();
    $obj2 = new \stdClass();
    $this->map->add($obj1, 'obj');
    # TODO: why does assertSame([$obj], $this->map->keys()) not work?
    $this->assertSame(false, [$obj2] === $this->map->keys());
  }

  public function testAddObjectKeyVal() {
    $obj = new \stdClass();
    $this->map->add($obj, $obj);
    $this->assertSame([$obj], $this->map->keys());
    $this->assertSame([$obj], $this->map->values());
    $this->assertSame($obj, $this->map->get($obj));
  }

  public function testDelSimple() {
    $this->map->add(1, 1);
    $this->map->del(1);
    $this->assertSame(true, $this->map->isEmpty());
  }

  public function testDelBeginningTwo() {
    $this->map->add(1, 1);
    $this->map->add(2, 2);
    $this->map->del(1);
    $this->assertSame([2], $this->map->keys());
    $this->assertSame([2], $this->map->values());
    $this->assertSame(false, $this->map->isEmpty());
  }

  public function testDelEndTwo() {
    $this->map->add(1, 1);
    $this->map->add(2, 2);
    $this->map->del(2);
    $this->assertSame([1], $this->map->keys());
    $this->assertSame([1], $this->map->values());
    $this->assertSame(false, $this->map->isEmpty());
  }

  public function testDelBeginningThree() {
    $this->map->add(1, 1);
    $this->map->add(2, 2);
    $this->map->add(3, 3);
    $this->map->del(1);
    $this->assertSame([2, 3], $this->map->keys());
    $this->assertSame([2, 3], $this->map->values());
    $this->assertSame(false, $this->map->isEmpty());
  }

  public function testDelMiddleThree() {
    $this->map->add(1, 1);
    $this->map->add(2, 2);
    $this->map->add(3, 3);
    $this->map->del(2);
    $this->assertSame([1, 3], $this->map->keys());
    $this->assertSame([1, 3], $this->map->values());
    $this->assertSame(false, $this->map->isEmpty());
  }

  public function testDelEndThree() {
    $this->map->add(1, 1);
    $this->map->add(2, 2);
    $this->map->add(3, 3);
    $this->map->del(3);
    $this->assertSame([1, 2], $this->map->keys());
    $this->assertSame([1, 2], $this->map->values());
    $this->assertSame(false, $this->map->isEmpty());
  }

  public function testDelAtSimple() {
    $this->map->add(1, 1);
    $this->map->delAt(0);
    $this->assertSame(true, $this->map->isEmpty());
  }

  public function testDelAtBeginningTwo() {
    $this->map->add(1, 1);
    $this->map->add(2, 2);
    $this->map->delAt(0);
    $this->assertSame([2], $this->map->keys());
    $this->assertSame([2], $this->map->values());
    $this->assertSame(false, $this->map->isEmpty());
  }

  public function testDelAtEndTwo() {
    $this->map->add(1, 1);
    $this->map->add(2, 2);
    $this->map->delAt(1);
    $this->assertSame([1], $this->map->keys());
    $this->assertSame([1], $this->map->values());
    $this->assertSame(false, $this->map->isEmpty());
  }

  public function testDelAtBeginningThree() {
    $this->map->add(1, 1);
    $this->map->add(2, 2);
    $this->map->add(3, 3);
    $this->map->delAt(0);
    $this->assertSame([2, 3], $this->map->keys());
    $this->assertSame([2, 3], $this->map->values());
    $this->assertSame(false, $this->map->isEmpty());
  }

  public function testDelAtMiddleThree() {
    $this->map->add(1, 1);
    $this->map->add(2, 2);
    $this->map->add(3, 3);
    $this->map->delAt(1);
    $this->assertSame([1, 3], $this->map->keys());
    $this->assertSame([1, 3], $this->map->values());
    $this->assertSame(false, $this->map->isEmpty());
  }

  public function testDelAtEndThree() {
    $this->map->add(1, 1);
    $this->map->add(2, 2);
    $this->map->add(3, 3);
    $this->map->delAt(2);
    $this->assertSame([1, 2], $this->map->keys());
    $this->assertSame([1, 2], $this->map->values());
    $this->assertSame(false, $this->map->isEmpty());
  }

  public function testCreateFromHash() {
    $this->map = SimpleOrderedMap::fromHash([
      'a' => true,
      2 => NULL,
      NULL => false,
    ]);
    # NULL keys get converted to an empty string
    $this->assertSame(['a', 2, ''], $this->map->keys());
    $this->assertSame([true, NULL, false], $this->map->values());
  }

  public function testCreateFromArrays() {
    $this->map = SimpleOrderedMap::fromArrays(
      ['a', 2, NULL],
      [true, NULL, false]
    );
    $this->assertSame(['a', 2, NULL], $this->map->keys());
    $this->assertSame([true, NULL, false], $this->map->values());
  }

  /**
   * @expectedException \Mfn\Util\SimpleOrderedMapException
   * @expectedExceptionMessage Key already exists
   */
  public function testMultipleAdd() {
    $obj = new \stdClass();
    $this->map->add($obj, 'obj');
    $this->map->add($obj, 'obj');
  }
  public function testMultipleSet() {
    $obj = new \stdClass();
    $this->map->set($obj, 'obj1');
    $this->map->set($obj, 'obj2');
    $this->assertSame([$obj], $this->map->keys());
    $this->assertSame(['obj2'], $this->map->values());
    $this->assertSame(1, $this->map->count());
  }
}

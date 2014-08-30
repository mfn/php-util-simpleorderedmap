<?php
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
    $this->assertEquals([], $this->map->keys());
    $this->assertEquals([], $this->map->values());
    $this->assertEquals(true, $this->map->isEmpty());
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
    $this->assertEquals([NULL], $this->map->keys());
    $this->assertEquals([NULL], $this->map->values());
    $this->assertEquals(NULL, $this->map->get(NULL));
    $this->assertEquals(false, $this->map->isEmpty());
  }

  public function testAddFalse() {
    $this->map->add(false, false);
    $this->assertEquals([false], $this->map->keys());
    $this->assertEquals([false], $this->map->values());
    $this->assertEquals(false, $this->map->get(false));
    $this->assertEquals(false, $this->map->isEmpty());
  }

  public function testAddTrue() {
    $this->map->add(true, true);
    $this->assertEquals([true], $this->map->keys());
    $this->assertEquals([true], $this->map->values());
    $this->assertEquals(true, $this->map->get(true));
    $this->assertEquals(false, $this->map->isEmpty());
  }

  public function testAddObject() {
    $obj = new \stdClass();
    $this->map->add($obj, 'obj');
    $this->assertEquals([$obj], $this->map->keys());
    $this->assertEquals(['obj'], $this->map->values());
    $this->assertEquals('obj', $this->map->get($obj));
    $this->assertEquals(false, $this->map->isEmpty());
  }

  public function testObjectIsNotObject() {
    $obj1 = new \stdClass();
    $obj2 = new \stdClass();
    $this->map->add($obj1, 'obj');
    # TODO: why does assertEquals([$obj], $this->map->keys()) not work?
    $this->assertEquals(false, [$obj2] === $this->map->keys());
  }

  public function testAddObjectKeyVal() {
    $obj = new \stdClass();
    $this->map->add($obj, $obj);
    $this->assertEquals([$obj], $this->map->keys());
    $this->assertEquals([$obj], $this->map->values());
    $this->assertEquals($obj, $this->map->get($obj));
  }

  public function testDelSimple() {
    $this->map->add(1, 1);
    $this->map->del(1);
    $this->assertEquals(true, $this->map->isEmpty());
  }

  public function testDelBeginningTwo() {
    $this->map->add(1, 1);
    $this->map->add(2, 2);
    $this->map->del(1);
    $this->assertEquals([2], $this->map->keys());
    $this->assertEquals([2], $this->map->values());
    $this->assertEquals(false, $this->map->isEmpty());
  }

  public function testDelEndTwo() {
    $this->map->add(1, 1);
    $this->map->add(2, 2);
    $this->map->del(2);
    $this->assertEquals([1], $this->map->keys());
    $this->assertEquals([1], $this->map->values());
    $this->assertEquals(false, $this->map->isEmpty());
  }

  public function testDelBeginningThree() {
    $this->map->add(1, 1);
    $this->map->add(2, 2);
    $this->map->add(3, 3);
    $this->map->del(1);
    $this->assertEquals([2, 3], $this->map->keys());
    $this->assertEquals([2, 3], $this->map->values());
    $this->assertEquals(false, $this->map->isEmpty());
  }

  public function testDelMiddleThree() {
    $this->map->add(1, 1);
    $this->map->add(2, 2);
    $this->map->add(3, 3);
    $this->map->del(2);
    $this->assertEquals([1, 3], $this->map->keys());
    $this->assertEquals([1, 3], $this->map->values());
    $this->assertEquals(false, $this->map->isEmpty());
  }

  public function testDelEndThree() {
    $this->map->add(1, 1);
    $this->map->add(2, 2);
    $this->map->add(3, 3);
    $this->map->del(3);
    $this->assertEquals([1, 2], $this->map->keys());
    $this->assertEquals([1, 2], $this->map->values());
    $this->assertEquals(false, $this->map->isEmpty());
  }

  public function testDelAtSimple() {
    $this->map->add(1, 1);
    $this->map->delAt(0);
    $this->assertEquals(true, $this->map->isEmpty());
  }

  public function testDelAtBeginningTwo() {
    $this->map->add(1, 1);
    $this->map->add(2, 2);
    $this->map->delAt(0);
    $this->assertEquals([2], $this->map->keys());
    $this->assertEquals([2], $this->map->values());
    $this->assertEquals(false, $this->map->isEmpty());
  }

  public function testDelAtEndTwo() {
    $this->map->add(1, 1);
    $this->map->add(2, 2);
    $this->map->delAt(1);
    $this->assertEquals([1], $this->map->keys());
    $this->assertEquals([1], $this->map->values());
    $this->assertEquals(false, $this->map->isEmpty());
  }

  public function testDelAtBeginningThree() {
    $this->map->add(1, 1);
    $this->map->add(2, 2);
    $this->map->add(3, 3);
    $this->map->delAt(0);
    $this->assertEquals([2, 3], $this->map->keys());
    $this->assertEquals([2, 3], $this->map->values());
    $this->assertEquals(false, $this->map->isEmpty());
  }

  public function testDelAtMiddleThree() {
    $this->map->add(1, 1);
    $this->map->add(2, 2);
    $this->map->add(3, 3);
    $this->map->delAt(1);
    $this->assertEquals([1, 3], $this->map->keys());
    $this->assertEquals([1, 3], $this->map->values());
    $this->assertEquals(false, $this->map->isEmpty());
  }

  public function testDelAtEndThree() {
    $this->map->add(1, 1);
    $this->map->add(2, 2);
    $this->map->add(3, 3);
    $this->map->delAt(2);
    $this->assertEquals([1, 2], $this->map->keys());
    $this->assertEquals([1, 2], $this->map->values());
    $this->assertEquals(false, $this->map->isEmpty());
  }

  public function testCreateFromHash() {
    $this->map = SimpleOrderedMap::fromHash([
      'a' => true,
      2 => NULL,
      NULL => false,
    ]);
    $this->assertEquals(['a', 2, NULL], $this->map->keys());
    $this->assertEquals([true, NULL, false], $this->map->values());
  }

  public function testCreateFromArrays() {
    $this->map = SimpleOrderedMap::fromArrays(
      ['a', 2, NULL],
      [true, NULL, false]
    );
    $this->assertEquals(['a', 2, NULL], $this->map->keys());
    $this->assertEquals([true, NULL, false], $this->map->values());
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
    $this->assertEquals(true, [$obj] === $this->map->keys());
    $this->assertEquals(['obj2'], $this->map->values());
    $this->assertEquals(1, $this->map->count());
  }
}

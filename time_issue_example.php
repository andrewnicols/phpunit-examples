<?php

class Foo {
    public function update($someObject) {
        sleep(1);
        $someObject->timemodified = time();
        $someObject->newlyAddedValue = 'Yay';
        return $this->mockedFunction($someObject);
    }

    public function mockedFunction($someObject) {
        // Doesn't matter what we return here - we're just testing what we were passed.
        return $someObject;
    }
}

class FooTest extends PHPUnit_Framework_TestCase {
    public function testIdenticalObjectPassed() {
        $mock = $this->getMockBuilder('Foo')
                    ->setMethods(array('mockedFunction'))
                    ->getMock();

        $oldValue = new stdClass();
        $oldValue->timemodified     = 0;
        $oldValue->timecreated      = time();
        $oldValue->someOtherItem    = 'Huzzah';

        $newValue = clone $oldValue;
        $newValue->timemodified     = time();
        $newValue->newlyAddedValue = 'Yay';

        $mock->expects($this->once())
            ->method('mockedFunction')
            ->with($newValue);

        $mock->update($oldValue);
    }
}

<?php
    namespace unique\eventsunit\tests\traits;

    use PHPUnit\Framework\TestCase;
    use unique\eventsunit\data\events\TestEvent;

    class EventObjectTraitTest extends TestCase {

        /**
         * @covers \unique\events\traits\EventObjectTrait
         */
        public function testHandled() {

            $event = new TestEvent();
            $this->assertSame( false, $event->getHandled() );

            $event->setHandled( true );
            $this->assertSame( true, $event->getHandled() );

            $event->setHandled( false );
            $this->assertSame( false, $event->getHandled() );
        }
    }
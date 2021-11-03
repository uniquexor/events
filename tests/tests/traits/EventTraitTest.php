<?php
    namespace unique\eventsunit\tests\traits;

    use PHPUnit\Framework\TestCase;
    use unique\eventsunit\data\events\TestEvent;
    use unique\eventsunit\data\traits\EventTrait;

    class EventTraitTest extends TestCase {

        /**
         * @covers \unique\events\traits\EventTrait
         */
        public function testOnAndTrigger() {

            $obj = new EventTrait();
            $handler1 = function ( TestEvent $event ) {

                $event->result .= 'a';
            };

            $this->assertFalse( $obj->hasHandlers( 'event1' ) );

            $obj->on( 'event1', $handler1 );
            $this->assertTrue( $obj->hasHandlers( 'event1' ) );

            $event = new TestEvent();
            $event->result = '';
            $obj->trigger( 'event1', $event );
            $this->assertSame( 'a', $event->result );

            // Second handler is called:
            $handler2 = function ( TestEvent $event ) {

                $event->result .= 'b';
            };
            $obj->on( 'event1', $handler2 );
            $this->assertTrue( $obj->hasHandlers( 'event1' ) );
            $event->result = '';
            $obj->trigger( 'event1', $event );
            $this->assertSame( 'ab', $event->result );

            // Event type does not exist:

            $event->result = '';
            $obj->trigger( 'event2', $event );
            $this->assertSame( '', $event->result );

            // Two types of events:
            $handler3 = function ( TestEvent $event ) {

                $event->result .= 'c';
                $event->setHandled( true );
            };
            $this->assertFalse( $obj->hasHandlers( 'event2' ) );
            $obj->on( 'event2', $handler3 );
            $this->assertTrue( $obj->hasHandlers( 'event2' ) );
            $obj->trigger( 'event2', $event );
            $this->assertSame( 'c', $event->result );

            // When first handler sets handled, second is never called:

            $obj->on( 'event2', function ( TestEvent $event ) {

                $event->result .= 'd';
            } );

            $event->result = '';
            $obj->trigger( 'event2', $event );
            $this->assertSame( 'c', $event->result );

            // First event still works:
            $event->result = '';
            $obj->trigger( 'event1', $event );
            $this->assertSame( 'ab', $event->result );

            // Try to turn off handler that does not exist:
            $obj->off( 'event1', $handler3 );
            $this->assertTrue( $obj->hasHandlers( 'event1' ) );
            $event->result = '';
            $obj->trigger( 'event1', $event );
            $this->assertSame( 'ab', $event->result );

            // Turn off first handler:
            $obj->off( 'event1', $handler1 );
            $this->assertTrue( $obj->hasHandlers( 'event1' ) );
            $event->result = '';
            $obj->trigger( 'event1', $event );
            $this->assertSame( 'b', $event->result );

            // Second event still working:
            $event->result = '';
            $this->assertTrue( $obj->hasHandlers( 'event2' ) );
            $obj->trigger( 'event2', $event );
            $this->assertSame( 'c', $event->result );

            // Turn off all handlers:
            $obj->off( 'event2' );
            $this->assertFalse( $obj->hasHandlers( 'event2' ) );
            $event->result = '';
            $obj->trigger( 'event2', $event );
            $this->assertSame( '', $event->result );
        }
    }
<?php
    namespace unique\eventsunit\data\events;

    use unique\events\interfaces\EventObjectInterface;
    use unique\events\traits\EventObjectTrait;

    class TestEvent implements EventObjectInterface {

        use EventObjectTrait;

        public $result;
    }
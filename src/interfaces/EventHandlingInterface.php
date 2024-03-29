<?php
    namespace unique\events\interfaces;

    /**
     * Interface EventHandlingInterface.
     *
     * Provides a simple event system. Allows setting and removing of event handlers as well as triggering specified events.
     *
     * @package unique\events\interfaces
     */
    interface EventHandlingInterface {

        /**
         * Assigns an event handler.
         * @param string $event - Event name
         * @param array|\Closure $callback - Handler
         */
        public function on( string $event, $callback );

        /**
         * Triggers the specified event.
         * The first assigned handler will be called first. If it does not set {@see EventObjectInterface::setHandled()} the second handler will be called
         * and so on, until all the handlers have been called.
         *
         * @param string $event_name - Event name
         * @param EventObjectInterface $event - Event data
         */
        public function trigger( string $event_name, EventObjectInterface $event );

        /**
         * Removes an event handler from the object.
         * If no handler is provided all handlers will be removed.
         *
         * @param string $event - Event name
         * @param array|\Closure|null $callback - Event handler.
         */
        public function off( string $event, $callback = null );

        /**
         * Returns true if the specified Event name has at least a single handler.
         * @param string $event
         * @return bool
         */
        public function hasHandlers( string $event );
    }
<?php
    namespace unique\events\interfaces;

    /**
     * Interface EventObjectInterface.
     *
     * An interface for an Event object class.
     *
     * @package unique\events\interfaces
     */
    interface EventObjectInterface {

        /**
         * Sets if the event has been handled and should not be processed any further.
         * @param bool $value
         */
        public function setHandled( bool $value );

        /**
         * Returns if the event has been handled and should not be processed any further.
         * @return bool
         */
        public function getHandled(): bool;
    }
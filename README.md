# Events

This package provides a very basic events system.

## Installation
This component requires php >= 7.4. To install it, you can use composer:
```
composer require unique/events
```

## Usage
Let's say you want to create a file loader, which will load the file and throw an event with file's content.  
In that case you first have to created a simple event object. Let's call it `FileLoadEvent`.
```php
    class FileLoadEvent implements \unique\events\interfaces\EventObjectInterface {
        
        use \unique\events\traits\EventObjectTrait;
        
        public ? string $contents = null;
    }
```

Now let's write a simple file loader class:
```php
    class FileLoader implements \unique\events\interfaces\EventHandlingInterface {
        
        const EVENT_AFTER_LOAD = 'after_load';
        
        use \unique\events\traits\EventTrait;
        
        public function load() {
            
            // ...some logic to load the file and set $contents value
            $event_object = new FileLoadEvent();
            $event_object->contents = $contents;
            
            $this->trigger( self::EVENT_AFTER_LOAD, $event_object );
            return $event_object->getHandled();
        }
    } 
```

Now you can use your defined event functionality by adding an event handler:
```php
    $obj = new FileLoader();
    $obj->on( FileLoader::EVENT_AFTER_LOAD, function ( FileLoadEvent $event_object ) {
        
        if ( $event_object->contents !== '' ) {
            
            // do something...
            $event_object->setHandled( true );
        }
    } );
    $obj->getContents();
```

What this does is it defines an event handler for `EVENT_AFTER_LOAD` event. The handler does some logic and marks the event as handled.  
If you were to have more than one handler defined for the same event, events would propagate up until all handlers have been called or until one of the handlers sets `handled` attribute to `true`.

## Documentation

#### `on( string $event, $callback )`
Sets a new handler for the specified event type.
- `string $event` - Event name. It is a good idea to define these events as constants on the triggering class.
- `\Closure|array $callback` - Handler of the event. Will receive one parameter: `( EventObjectInterface $event )`

#### `trigger( string $event_name, EventObjectInterface $event )`
Triggers the specified event.
The first assigned handler will be called first. If it does not set `EventObjectInterface::setHandled()` the second handler will be called
and so on, until all the handlers have been called or `setHandled( true )` has been set.
- `string $event_name` - Event name. It is a good idea to define these events as constants on the triggering class.
- `EventObjectInterface $event` - Event object

#### `off( string $event, $callback = null )`
Removes an event handler from the object.
If no handler is provided all handlers will be removed.
- `string $event` - Event name. It is a good idea to define these events as constants on the triggering class.
- `\Closure|array|null $callback` - Handler of the event that was previously assigned using `on()`.
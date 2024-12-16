<?php 

namespace App\EventSubscriber;

use CalendarBundle\Entity\Event;
use CalendarBundle\Event\SetDataEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CalendarSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            SetDataEvent::class => 'onCalendarSetData',
        ];
    }

    public function onCalendarSetData(SetDataEvent $setDataEvent)
    {
        $start = $setDataEvent->getStart();
        $end = $setDataEvent->getEnd();
        $filters = $setDataEvent->getFilters();

        // Example: Adding a sample event
        $setDataEvent->addEvent(new Event(
            'Sample Event',
            new \DateTime('2024-12-20 10:00:00'),
            new \DateTime('2024-12-20 12:00:00')
        ));

        // Add more events as needed
    }
}

<?php
namespace App\EventSubscriber;

use App\Repository\ReservationsRepository;
use CalendarBundle\Entity\Event;
use CalendarBundle\Event\CalendarEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CalendarSubscriber implements EventSubscriberInterface
{
    private $reservationRepository;

    public function __construct(ReservationsRepository $reservationRepository)
    {
        $this->reservationRepository = $reservationRepository;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            CalendarEvent::class => 'onCalendarEventSetData',
        ];
    }

    public function onCalendarEventSetData(CalendarEvent $calendarEvent): void
    {
        $start = $calendarEvent->getStart();
        $end = $calendarEvent->getEnd();
        $filters = $calendarEvent->getFilters();

        $reservations = $this->reservationRepository->findByDates($start, $end);

        foreach ($reservations as $reservation) {
            $event = new Event(

                $reservation->getStartTime(),
                $reservation->getEndTime()
            );

            $calendarEvent->addEvent($event);
        }
    }
}

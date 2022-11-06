<?php
use Monolog\DateTimeImmutable;

trait DateHelpers{
    public function getMonthNumberDays(){
        return (int) $this ->format('t');
    }
    public function getCurrentDayNumber(){
        return (int) $this ->format('j');
    }
    public function getMonthNumber(){
        return (int) $this -> format('n');
    }
    public function getMonthName(){
        return $this->format('M');
    }
}


class CurrentDate extends DateTimeImmutable{
    use DateHelpers;
    public function __construct(){
        parent::__construct();
    }

}

class CalendarDate extends DateTime{
    use DateHelpers;
    public function __construct(){
        parent::__construct();
        $this->modify('first day of this month');
    }
    public function getMonthStartDayOfWeek(){
        return (int) $this->format('N');
    }
}
class Calendar {
    protected $currentDate;
    protected $calendarDate;

    protected $dayLabels = [
        'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'
    ];
    protected $monthLabels = [
        'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'
    ];



    public function __construct( CurrentDate $currentDate, CalendarDate $calendarDate){
        $this-> currentDate = $currentDate;
        $this-> calendarDate = clone $calendarDate;
        $this-> calendarDate-> modify('first day of this month');
    }
}

?>
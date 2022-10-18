<?php
namespace App\Modules;

class Calendar {

    private $active_year, $active_month, $active_day;
    public $events = [];
    private $description = [];
    private $holidays;

    public function __construct($date = null, $description = []) {
        $this->active_year = $date != null ? date('Y', strtotime($date)) : date('Y');
        $this->active_month = $date != null ? date('m', strtotime($date)) : date('m');
        $this->active_day = $date != null ? date('d', strtotime($date)) : date('d');

        $this->description = $description;

        $this->add_event(null,'0-0-0');
    }

    public function add_event($txt, $date, $days = 1, $color = '') {
        $color = $color ? ' ' . $color : $color;
        $this->events[] = [$txt, $date, $days, $color];
    }

    public function __toString() {
        $num_days = date('t', strtotime($this->active_day . '-' . $this->active_month . '-' . $this->active_year));
        $num_days_last_month = date('j', strtotime('last day of previous month', strtotime($this->active_day . '-' . $this->active_month . '-' . $this->active_year)));
        $days = [0 => 'Mon', 1 => 'Tue', 2 => 'Wed', 3 => 'Thu', 4 => 'Fri', 5 => 'Sat', 6 => 'Sun'];
        $first_day_of_week = array_search(date('D', strtotime($this->active_year . '-' . $this->active_month . '-1')), $days);
        $html = '<div class="calendar">';
        $html .= '<div class="header">';
        $html .= '<div class="month-year">';
        $html .= __('holidayCalendar.'.date('F', strtotime($this->active_year . '-' . $this->active_month . '-' . $this->active_day))).' '.date('Y', strtotime($this->active_year . '-' . $this->active_month . '-' . $this->active_day));
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<div class="days">';
        foreach ($days as $day) {
            $html .= '
                <div class="day_name">
                    ' . __('holidayCalendar.'.$day) . '
                </div>
            ';
        }
        for ($i = $first_day_of_week; $i > 0; $i--) {
            $html .= '
                <div class="day_num ignore">
                    ' . ($num_days_last_month-$i+1) . '
                </div>
            ';
        }
        for ($i = 1; $i <= $num_days; $i++) {
            $dayClass=[$i];
            $dayTitle=[$i];
            foreach ($this->events as $event) {
                for ($d = 0; $d <= 0; $d++) {

                    $day = date('w', strtotime($this->active_year . '-' . $this->active_month . '-' . $i . ' -' . $d . ' day'));
                        if($day == 0 || $day == 6){
                            if(!isset($this->holidays[$this->active_month.'-'.$i])){
                                $dayTitle[$i]='';
                                $dayClass[$i]="calendar-day-holiday gray";
                            }
                        }else{
                            if(!isset($dayClass[$i])){
                                $dayClass[$i]="";
                                $dayTitle[$i]="";
                            }
                        }


                    if (date('y-m-d', strtotime($this->active_year . '-' . $this->active_month . '-' . $i . ' -' . $d)) == date('y-m-d', strtotime($event[1]))) {
                        $dayClass[$i]="calendar-day-holiday ".$event[3];
                        $dayTitle[$i]=$event[0];
                        $this->holidays[$this->active_month.'-'.$i]=true;
                    }
                }
            }

            $html .= '<div title="'.$dayTitle[$i].'" class="day_num '.$dayClass[$i].'">';

            $html .= '<span>' . $i . '</span>';
            
            $html .= '</div>';
        }
        for ($i = 1; $i <= (42-$num_days-max($first_day_of_week, 0)); $i++) {
            $html .= '
                <div class="day_num ignore">
                    ' . $i . '
                </div>
            ';
        }
        $html .= '</div>';
        $html .= '</div>';

        foreach($this->description as $value){
            $html .= '<div>'.$value.'</div>';
        }

        foreach($this->events as $event){
            if($event[0]!=null){
                $html .= '<div class="calendar-month-holiday">'.date('d.m.Y', strtotime($event[1])).' - '.$event[0].'</div>';
            }
        }
        
        $html .= '<br>';

        return $html;
    }

}
?>
<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Modules\Calendar;

class HolidayCalendarController extends Controller
{
    public function index($lang, $year)
    {
        if($year == 2022){
            $calendarJan = new Calendar('2022-01-01', [
                trans_choice('holidayCalendar.:count working days',1 , ['count' => 21]),
                trans_choice('holidayCalendar.:count working hours',5 , ['count' => 168]),
            ]);
            $calendarJan->add_event(__('holidayCalendar.New Year\'s Day'), '2022-01-01', 1, 'green');

            $calendarFeb = new Calendar('2022-02-01', [
                trans_choice('holidayCalendar.:count working days',0 , ['count' => 20]),
                trans_choice('holidayCalendar.:count working hours',0 , ['count' => 160]),
            ]);
            $calendarMar = new Calendar('2022-03-01', [
                trans_choice('holidayCalendar.:count working days',3 , ['count' => 23]),
                trans_choice('holidayCalendar.:count working hours',4 , ['count' => 184]),
            ]);
            $calendarApr = new Calendar('2022-04-01', [
                trans_choice('holidayCalendar.:count working days',9 , ['count' => 19]),
                trans_choice('holidayCalendar.:count working hours',1 , ['count' => 151]),
            ]);
            $calendarApr->add_event(__('holidayCalendar.Pre-holiday day -7 hours working day'), '2022-04-14', 1, 'orange');
            $calendarApr->add_event(__('holidayCalendar.Big Friday'), '2022-04-15', 1, 'green');
            $calendarApr->add_event(__('holidayCalendar.The first Easter'), '2022-04-17', 1, 'green');
            $calendarApr->add_event(__('holidayCalendar.The second Easter'), '2022-04-18', 1, 'green');

            $calendarMay = new Calendar('2022-05-01', [
                trans_choice('holidayCalendar.:count working days',1 , ['count' => 21]),
                trans_choice('holidayCalendar.:count working hours',7 , ['count' => 167]),
            ]);
            $calendarMay->add_event(__('holidayCalendar.1st of May'), '2022-05-01', 1, 'green');
            $calendarMay->add_event(__('holidayCalendar.Pre-holiday day -7 hours working day'), '2022-05-03', 1, 'orange');
            $calendarMay->add_event(__('holidayCalendar.The day of the proclamation of the Declaration of Independence of the Republic of Latvia'), '2022-05-04', 1, 'green');
            $calendarMay->add_event(__('holidayCalendar.Mothers Day'), '2022-05-08', 1, 'green');
            
            $calendarJun = new Calendar('2022-06-01', [
                trans_choice('holidayCalendar.:count working days',0 , ['count' => 20]),
                trans_choice('holidayCalendar.:count working hours',9 , ['count' => 159]),
            ]);
            $calendarJun->add_event(__('holidayCalendar.Pentecost'),'2022-06-05', 1, 'green');
            $calendarJun->add_event(__('holidayCalendar.Pre-holiday day -7 hours working day'), '2022-06-22', 1, 'orange');
            $calendarJun->add_event(__('holidayCalendar.Ligo'), '2022-06-23', 1, 'green');
            $calendarJun->add_event(__('holidayCalendar.Ligo2'), '2022-06-24', 1, 'green');

            $calendarJul = new Calendar('2022-07-01', [
                trans_choice('holidayCalendar.:count working days',1 , ['count' => 21]),
                trans_choice('holidayCalendar.:count working hours',8 , ['count' => 168]),
            ]);
            $calendarAug = new Calendar('2022-08-01', [
                trans_choice('holidayCalendar.:count working days',3 , ['count' => 23]),
                trans_choice('holidayCalendar.:count working hours',4 , ['count' => 184]),
            ]);
            $calendarSep = new Calendar('2022-09-01', [
                trans_choice('holidayCalendar.:count working days',2 , ['count' => 22]),
                trans_choice('holidayCalendar.:count working hours',6 , ['count' => 176]),
            ]);
            $calendarOct = new Calendar('2022-10-01', [
                trans_choice('holidayCalendar.:count working days',1 , ['count' => 21]),
                trans_choice('holidayCalendar.:count working hours',8 , ['count' => 168]),
            ]);
            $calendarNov = new Calendar('2022-11-01', [
                trans_choice('holidayCalendar.:count working days',1 , ['count' => 21]),
                trans_choice('holidayCalendar.:count working hours',7 , ['count' => 167]),
            ]);
            $calendarNov->add_event(__('holidayCalendar.Pre-holiday day -7 hours working day'), '2022-11-17', 1, 'orange');
            $calendarNov->add_event(__('holidayCalendar.The day of the proclamation of the Republic of Latvia'), '2022-11-18', 1, 'green');

            $calendarDec = new Calendar('2022-12-01', [
                trans_choice('holidayCalendar.:count working days',1 , ['count' => 21]),
                trans_choice('holidayCalendar.:count working hours',6 , ['count' => 166]),
            ]);
            $calendarDec->add_event(__('holidayCalendar.Pre-holiday day -7 hours working day'), '2022-12-23', 1, 'orange');
            $calendarDec->add_event(__('holidayCalendar.Christmas Eve'), '2022-12-24', 1, 'green');
            $calendarDec->add_event(__('holidayCalendar.Christmas Day'), '2022-12-25', 1, 'green');
            $calendarDec->add_event(__('holidayCalendar.Christmas Day2'), '2022-12-26', 1, 'green');
            $calendarDec->add_event(__('holidayCalendar.Pre-holiday day -7 hours working day'), '2022-12-30', 1, 'orange');
            $calendarDec->add_event(__('holidayCalendar.New Year\'s Eve'), '2022-12-31', 1, 'green');

        }elseif($year == 2023){
            $calendarJan = new Calendar('2023-01-01', [
                trans_choice('holidayCalendar.:count working days',2 , ['count' => 22]),
                trans_choice('holidayCalendar.:count working hours',6 , ['count' => 176]),
            ]);
            $calendarJan->add_event(__('holidayCalendar.New Year\'s Day'), '2023-01-01', 1, 'green');

            $calendarFeb = new Calendar('2023-02-01', [
                trans_choice('holidayCalendar.:count working days',0 , ['count' => 20]),
                trans_choice('holidayCalendar.:count working hours',0 , ['count' => 160]),
            ]);
            $calendarMar = new Calendar('2023-03-01', [
                trans_choice('holidayCalendar.:count working days',3 , ['count' => 23]),
                trans_choice('holidayCalendar.:count working hours',4 , ['count' => 184]),
            ]);
            $calendarApr = new Calendar('2023-04-01', [
                trans_choice('holidayCalendar.:count working days',8 , ['count' => 18]),
                trans_choice('holidayCalendar.:count working hours',3 , ['count' => 143]),
            ]);
            $calendarApr->add_event(__('holidayCalendar.Pre-holiday day -7 hours working day'), '2023-04-06', 1, 'orange');
            $calendarApr->add_event(__('holidayCalendar.Big Friday'), '2023-04-07', 1, 'green');
            $calendarApr->add_event(__('holidayCalendar.The first Easter'), '2023-04-09', 1, 'green');
            $calendarApr->add_event(__('holidayCalendar.The second Easter'), '2023-04-10', 1, 'green');

            $calendarMay = new Calendar('2023-05-01', [
                trans_choice('holidayCalendar.:count working days',1 , ['count' => 21]),
                trans_choice('holidayCalendar.:count working hours',7 , ['count' => 167]),
            ]);
            $calendarMay->add_event(__('holidayCalendar.1st of May'), '2023-05-01', 1, 'green');
            $calendarMay->add_event(__('holidayCalendar.Pre-holiday day -7 hours working day'), '2023-05-03', 1, 'orange');
            $calendarMay->add_event(__('holidayCalendar.The day of the proclamation of the Declaration of Independence of the Republic of Latvia'), '2023-05-04', 1, 'green');
            $calendarMay->add_event(__('holidayCalendar.The working day has been moved to :date', ['date' => '20.05.2023']), '2023-05-05', 1, 'green');
            $calendarMay->add_event(__('holidayCalendar.Mothers Day'), '2023-05-14', 1, 'green');
            $calendarMay->add_event(__('holidayCalendar.Working day, transferred from :date', ['date' => '05.05.2023']), '2023-05-20', 1, 'orange');
            $calendarMay->add_event(__('holidayCalendar.Pentecost'), '2023-05-28', 1, 'green');

            $calendarJun = new Calendar('2023-06-01', [
                trans_choice('holidayCalendar.:count working days',1 , ['count' => 21]),
                trans_choice('holidayCalendar.:count working hours',7 , ['count' => 167]),
            ]);
            $calendarJun->add_event(__('holidayCalendar.Pre-holiday day -7 hours working day'), '2023-06-22', 1, 'orange');
            $calendarJun->add_event(__('holidayCalendar.Ligo'), '2023-06-23', 1, 'green');
            $calendarJun->add_event(__('holidayCalendar.Ligo2'), '2023-06-24', 1, 'green');

            $calendarJul = new Calendar('2023-07-01', [
                trans_choice('holidayCalendar.:count working days',0 , ['count' => 20]),
                trans_choice('holidayCalendar.:count working hours',0 , ['count' => 160]),
            ]);
            $calendarJul->add_event(__('holidayCalendar.Closing day of the General Latvian Song and Dance Festival'),'2023-07-09', 1, 'green');
            $calendarJul->add_event(__('holidayCalendar.The day after the conclusion of the General Latvian Song and Dance Festival is a holiday'),'2023-07-10', 1, 'green');

            $calendarAug = new Calendar('2023-08-01', [
                trans_choice('holidayCalendar.:count working days',3 , ['count' => 23]),
                trans_choice('holidayCalendar.:count working hours',4 , ['count' => 184]),
            ]);

            $calendarSep = new Calendar('2023-09-01', [
                trans_choice('holidayCalendar.:count working days',1 , ['count' => 21]),
                trans_choice('holidayCalendar.:count working hours',8 , ['count' => 168]),
            ]);

            $calendarOct = new Calendar('2023-10-01', [
                trans_choice('holidayCalendar.:count working days',2 , ['count' => 22]),
                trans_choice('holidayCalendar.:count working hours',6 , ['count' => 176]),
            ]);

            $calendarNov = new Calendar('2023-11-01', [
                trans_choice('holidayCalendar.:count working days',1 , ['count' => 21]),
                trans_choice('holidayCalendar.:count working hours',7 , ['count' => 167]),
            ]);
            $calendarNov->add_event(__('holidayCalendar.Pre-holiday day -7 hours working day'), '2023-11-17', 1, 'orange');
            $calendarNov->add_event(__('holidayCalendar.The day of the proclamation of the Republic of Latvia'), '2023-11-18', 1, 'green');
            $calendarNov->add_event(__('holidayCalendar.Rescheduled holiday from :from',['from' => '18.11.2023']), '2023-11-20', 1, 'green');

            $calendarDec = new Calendar('2023-12-01', [
                trans_choice('holidayCalendar.:count working days',9 , ['count' => 19]),
                trans_choice('holidayCalendar.:count working hours',2 , ['count' => 152]),
            ]);
            $calendarDec->add_event(__('holidayCalendar.Christmas Eve'), '2023-12-24', 1, 'green');
            $calendarDec->add_event(__('holidayCalendar.Christmas Day'), '2023-12-25', 1, 'green');
            $calendarDec->add_event(__('holidayCalendar.Christmas Day2'), '2023-12-26', 1, 'green');
            $calendarDec->add_event(__('holidayCalendar.New Year\'s Eve'), '2023-12-31', 1, 'green');
        }elseif($year == 2024){

            //Январь
            $calendarJan = new Calendar('2024-01-01', [
                trans_choice('holidayCalendar.:count working days',2 , ['count' => 22]),
                trans_choice('holidayCalendar.:count working hours',6 , ['count' => 176]),
            ]);
            $calendarJan->add_event(__('holidayCalendar.New Year\'s Day'), '2024-01-01', 1, 'green');

            //Февраль
            $calendarFeb = new Calendar('2024-02-01', [
                trans_choice('holidayCalendar.:count working days',1 , ['count' => 21]),
                trans_choice('holidayCalendar.:count working hours',8 , ['count' => 168]),
            ]);

            //Март
            $calendarMar = new Calendar('2024-03-01', [
                trans_choice('holidayCalendar.:count working days',0 , ['count' => 20]),
                trans_choice('holidayCalendar.:count working hours',9 , ['count' => 159]),
            ]);
            $calendarMar->add_event(__('holidayCalendar.Pre-holiday day -7 hours working day'), '2024-03-28', 1, 'orange');
            $calendarMar->add_event(__('holidayCalendar.Lielā piektdiena'), '2024-03-29', 1, 'green');
            $calendarMar->add_event(__('holidayCalendar.Pirmās Lieldienas'), '2024-03-31', 1, 'green');

            //Апрель
            $calendarApr = new Calendar('2024-04-01', [
                trans_choice('holidayCalendar.:count working days',8 , ['count' => 21]),
                trans_choice('holidayCalendar.:count working hours',3 , ['count' => 167]),
            ]);
            $calendarApr->add_event(__('holidayCalendar.Otrās Lieldienas'), '2024-04-01', 1, 'green');
            $calendarApr->add_event(__('holidayCalendar.Pre-holiday day -7 hours working day'), '2024-04-30', 1, 'orange');

            //Май
            $calendarMay = new Calendar('2024-05-01', [
                trans_choice('holidayCalendar.:count working days',1 , ['count' => 21]),
                trans_choice('holidayCalendar.:count working hours',7 , ['count' => 167]),
            ]);
            $calendarMay->add_event(__('holidayCalendar.Darba svētki, Latvijas Republikas Satversmes sapulces sasaukšanas diena'), '2024-05-01', 1, 'green');
            $calendarMay->add_event(__('holidayCalendar.Pre-holiday day -7 hours working day'), '2024-05-03', 1, 'orange');
            $calendarMay->add_event(__('holidayCalendar.Latvijas Republikas Neatkarības deklarācijas pasludināšanas diena'), '2024-05-04', 1, 'green');
            $calendarMay->add_event(__('holidayCalendar.Pārceltā brīvdiena no :date', ['date' => '04.05.2024']), '2024-05-06', 1, 'green');
            $calendarMay->add_event(__('holidayCalendar.Mātes diena'), '2024-05-12', 1, 'green');
            $calendarMay->add_event(__('holidayCalendar.Vasarsvētki'), '2024-05-19', 1, 'green');

            //Июнь
            $calendarJun = new Calendar('2024-06-01', [
                trans_choice('holidayCalendar.:count working days',1 , ['count' => 19]),
                trans_choice('holidayCalendar.:count working hours',2 , ['count' => 152]),
            ]);
            $calendarJun->add_event(__('holidayCalendar.Līgo'), '2024-06-23', 1, 'green');
            $calendarJun->add_event(__('holidayCalendar.Jāņu diena'), '2024-06-24', 1, 'green');

            //Июль
            $calendarJul = new Calendar('2024-07-01', [
                trans_choice('holidayCalendar.:count working days',3 , ['count' => 23]),
                trans_choice('holidayCalendar.:count working hours',4 , ['count' => 184]),
            ]);

            //Август
            $calendarAug = new Calendar('2024-08-01', [
                trans_choice('holidayCalendar.:count working days',2 , ['count' => 22]),
                trans_choice('holidayCalendar.:count working hours',6 , ['count' => 176]),
            ]);

            //Сентябрь
            $calendarSep = new Calendar('2024-09-01', [
                trans_choice('holidayCalendar.:count working days',1 , ['count' => 21]),
                trans_choice('holidayCalendar.:count working hours',8 , ['count' => 168]),
            ]);

            //Октябрь
            $calendarOct = new Calendar('2024-10-01', [
                trans_choice('holidayCalendar.:count working days',3 , ['count' => 23]),
                trans_choice('holidayCalendar.:count working hours',4 , ['count' => 184]),
            ]);

            //Ноябрь
            $calendarNov = new Calendar('2024-11-01', [
                trans_choice('holidayCalendar.:count working days',0 , ['count' => 20]),
                trans_choice('holidayCalendar.:count working hours',0 , ['count' => 160]),
            ]);
            $calendarNov->add_event(__('holidayCalendar.Latvijas Republikas proklamēšanas diena'), '2024-11-18', 1, 'green');

            //Декабрь
            $calendarDec = new Calendar('2024-12-01', [
                trans_choice('holidayCalendar.:count working days',8 , ['count' => 18]),
                trans_choice('holidayCalendar.:count working hours',142 , ['count' => 142]),
            ]);
            $calendarDec->add_event(__('holidayCalendar.Valsts un pašvaldības iestādes pārceļ darba dienu no :date',['date' => '23.12.2024']), '2024-12-14',1 ,'orange');
            $calendarDec->add_event(__('holidayCalendar.Pirmssvētku diena. 7 darba stundas. Valsts un pašvaldības iestādes pārceļ darba dienu uz :date', ['date' => '14.12.2024']), '2024-12-23', 1, 'orange');
            $calendarDec->add_event(__('holidayCalendar.Ziemassvētku vakars'), '2024-12-24', 1, 'green');
            $calendarDec->add_event(__('holidayCalendar.Pirmie Ziemassvētki'), '2024-12-25', 1, 'green');
            $calendarDec->add_event(__('holidayCalendar.Otrie Ziemassvētki'), '2024-12-26', 1, 'green');
            $calendarDec->add_event(__('holidayCalendar.Valsts un pašvaldības iestādes pārceļ darba dienu no :date',['date' => '30.12.2024']), '2024-12-28', 1, 'orange');
            $calendarDec->add_event(__('holidayCalendar.Pirmssvētku diena. 7 darba stundas. Valsts un pašvaldības iestādes pārceļ darba dienu uz :date',['date'=>'28.12.2024']), '2024-12-30', 1, 'orange');
            $calendarDec->add_event(__('holidayCalendar.Gada noslēguma diena'), '2024-12-31', 1, 'green');
        }else{
            return abort(404);
        }

        return view('holidayCalendar/holidayCalendar', compact(['lang','year','calendarJan','calendarFeb','calendarMar','calendarApr','calendarMay','calendarJun','calendarJul','calendarAug','calendarSep','calendarOct','calendarNov','calendarDec']));
    }
}

<?php
///01505e03685089e8594f72f9edb34260-d010bdaf-b1412989 api key
// d010bdaf-b1412989 mail gun api key
namespace App\Filament\Personal\Widgets;

use App\Models\Holiday;
use App\Models\Timesheet;
use App\Models\User;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class PersonalWidgetStats extends BaseWidget
{
    protected function getStats(): array
    {

        //El aquí crear dos una funcion para hacer esto 
        // yo no le veo el sentido ya es algo mu puntual y especifico
        $userHoliday = Holiday::where('user_id', Auth::user()->id)->where('type', 'approved')->count();
        $horas = $this->getTotalWorkHours(Auth::user());
     
        return [

            Stat::make('Vaciones Aprobadas', $userHoliday),
            Stat::make('Bounce rate', '21%'),
            
            Stat::make('Total Horas Trabajadas:',$horas['work']),
            Stat::make('Total Horas Pausadas', $horas['pause']),
        ];
    }

    /*Esta función recoge las horas de un empleado trabajadas 
    no valemos de la clase Carbon de php y de gmdate para que sea más sencillo */
    protected function getTotalWorkHours(User $user):array
    {
        //$timesheets = Timesheet::where('user_id', $user->id)->where('type', 'work')->get();
        $timesheets = Timesheet::where('user_id', $user->id)->get();
        $totalWorkSecond = 0;
        $totalPauseSecond = 0;
        foreach ($timesheets as $timesheet) {
          
            if ($timesheet->type == 'work') {
               
                $starIn = Carbon::parse($timesheet->day_in);
                $startOut = Carbon::parse($timesheet->day_out);
                $totalWork = $startOut->diffInSeconds($starIn);
                $totalWorkSecond = $totalWorkSecond + $totalWork;
            }else{
                $starIn = Carbon::parse($timesheet->day_in);
                $startOut = Carbon::parse($timesheet->day_out);
                $totalPause = $startOut->diffInSeconds($starIn);
                $totalPauseSecond = $totalWorkSecond + $totalPause;
            }
        }

        $workHours = gmdate("H:i:s", $totalWorkSecond);
        $pauseHours = gmdate("H:i:s", $totalPauseSecond);
        $totalHours = [
            'work' => $workHours,
            'pause' => $pauseHours
        ];
    
        return $totalHours; 
    }


}

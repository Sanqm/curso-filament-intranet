<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\HolidayResource\Pages\ListHolidays;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;
use App\Models\Holiday;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {

        $totalEmployees = DB::table('users')->get()->count();
        $totalTimesheets = DB::table('timesheets')->get()->count();
        $totalHolidays = Holiday::where('type', 'approved')->count(); 
        // las dos opciones son válidas pero usaremos la primera de  ellas 
        //cuando no accedamos a datos con modelo relaciondo y la segunda cuando 
        //tengamos modelos relacionales 
       
        return [
            Stat::make('Total Empleados', $totalEmployees),
            //->description('32k increase')
            //->descriptionIcon('heroicon-m-arrow-trending-up'),
            Stat::make('Total Horarios', $totalTimesheets),
            Stat::make('Vaciones', $totalHolidays),
        ];
    }
}

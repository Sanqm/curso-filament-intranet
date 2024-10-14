<?php

namespace App\Filament\Personal\Resources\TimesheetResource\Pages;

use App\Filament\Personal\Resources\TimesheetResource;
use App\Models\Timesheet;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Notifications\Notification as NotificationsNotification;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Type\Time;

class ListTimesheets extends ListRecords
{

    protected static string $resource = TimesheetResource::class;


    protected function getHeaderActions(): array
    {

        $lastTimesheet = Timesheet::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->first();
        if ($lastTimesheet == null) {
            return [
                Action::make('inWork')
                    ->label('Entrar a trabajar')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(function () use ($lastTimesheet) {
                        $user = Auth::user();
                        $timesheet = new Timesheet();
                        $timesheet->calendar_id = 2;
                        $timesheet->user_id = $user->id;
                        $timesheet->day_in = Carbon::now();
                        $timesheet->day_out = '';
                        $timesheet->type = 'work';
                        $timesheet->save();
                    }),

                Actions\CreateAction::make(),


            ];
        }
        return [
            Actions\CreateAction::make(),
            Action::make('inWork')
                ->label('Entrar a trabajar')
                ->color('info')
                ->keyBindings(['command+s', 'ctrl+s']) // esta opción permite configuar teclas de acceso rápido
                ->requiresConfirmation() // esto indica que hay que confirmar la accion seleccionada 
                ->action(function () use ($lastTimesheet) { // el use con el puntero permite que podamos usar la variable dentro de la funcion de la accion
                    $user = Auth::user(); //recogemos el usuario
                    $timesheet = new Timesheet(); //creamos un calendario nuevo para ese usuario
                    $timesheet->calendar_id = 2;
                    $timesheet->user_id = $user->id;
                    $timesheet->type = 'work';
                    $timesheet->day_in = $lastTimesheet->day_in;
                    $timesheet->day_out = '';
                    $timesheet->save();
                    Notification::make() // debe estar asociada dentro de una accion por eso no pueden estar a la misma altura que las misma
                    //esto se refiere a las notificaciones correspondientes a la
                        ->title('Entrando a trabajar')
                        ->success()
                        ->send();
                }),

            Action::make('stopWork')
                ->label('Parar de trabajar')
                ->keyBindings(['command+o', 'ctrl+o'])
                ->color('success')
                ->visible($lastTimesheet->day_out == null && $lastTimesheet->type != 'pause') // esto permite hacer el boton visible o invisible 
                ->disabled(!$lastTimesheet->day_out == null) // dependidnedo de ciertas condiciones
                ->requiresConfirmation()
                ->action(function () use ($lastTimesheet) {
                    $lastTimesheet->day_out = Carbon::now();
                    $lastTimesheet->save();
                    Notification::make()
                        ->title('Has parado de trabajar')
                        ->success()
                        ->color('success')
                        ->send();
                }),
            Action::make('inPause')
                ->label('Pausar')
                ->color('warning')
                ->visible($lastTimesheet->day_out == null && $lastTimesheet->type != 'pause')
                ->disabled(!$lastTimesheet->day_out == null)
                ->action(function () use ($lastTimesheet) {
                    $lastTimesheet->day_out = Carbon::now();
                    $lastTimesheet->save();
                    $timesheet = new Timesheet();
                    $timesheet->calendar_id = 2;
                    $timesheet->user_id = Auth::user()->id;
                    $timesheet->type = 'pause';
                    $timesheet->day_in = Carbon::now();
                    $timesheet->day_out = '';
                    $timesheet->save();
                })
                ->requiresConfirmation(),
            Action::make('stopPause')
                ->label('Parar Pausa')
                ->color('info')
                ->visible($lastTimesheet->day_out == null && $lastTimesheet->type == 'pause')
                ->disabled(!$lastTimesheet->day_out == null)
                ->requiresConfirmation()
                ->action(function () use ($lastTimesheet) {
                    $lastTimesheet->day_out = Carbon::now();
                    $lastTimesheet->save();
                    $timesheet = new Timesheet();
                    $timesheet->calendar_id = 2;
                    $timesheet->user_id = Auth::user()->id;
                    $timesheet->day_in = Carbon::now();
                    $timesheet->day_out = $lastTimesheet->day_out;
                    $timesheet->type = 'work';
                    $timesheet->save();
                    Notification::make()
                        ->title('Comienzas de nuevo a trabajar')
                        ->color('info')
                        ->info()
                        ->send();
                }),

        ];
    }
}

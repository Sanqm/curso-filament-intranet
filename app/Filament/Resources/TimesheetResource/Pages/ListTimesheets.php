<?php

namespace App\Filament\Resources\TimesheetResource\Pages;

use App\Filament\Resources\TimesheetResource;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;

class ListTimesheets extends ListRecords
{
    protected static string $resource = TimesheetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Action::make('CreatePDF')
            ->label('Crear PDF')
            ->color('warning')
            ->requiresConfirmation()
            ->url(fn ():string => route('pdf.invoice', ['user' =>Auth::user()]),
            shouldOpenInNewTab: true
        ),
        ];
    }
}

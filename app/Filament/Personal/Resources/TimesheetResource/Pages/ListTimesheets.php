<?php

namespace App\Filament\Personal\Resources\TimesheetResource\Pages;

use App\Filament\Personal\Resources\TimesheetResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;

class ListTimesheets extends ListRecords
{
     
    protected static string $resource = TimesheetResource::class;
    
    
    protected function getHeaderActions(): array
    {
        $pp = false;
        $pepito = $this->isChecked($pp);
        
        return [
            Actions\CreateAction::make(),
            
            Action::make('work')
            ->label('trabajar')
            ->hidden(!$pepito)
            ->action(fn()=>$this->isChecked($pepito)),

            Action::make('pause')
            ->label('pausar')
            ->hidden($pepito)
            ->action(fn()=>$this->isChecked($pepito)),
                    
        ];
    }
    protected function isChecked($p){
        
        if($p){
            $p=false;
        }else{
            $p= true;
        }
        return $p;
    }
    
}

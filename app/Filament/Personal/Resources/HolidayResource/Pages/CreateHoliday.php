<?php

namespace App\Filament\Personal\Resources\HolidayResource\Pages;

use App\Filament\Personal\Resources\HolidayResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateHoliday extends CreateRecord
{
    protected static string $resource = HolidayResource::class;


     /// este método doc filameten, permite que prerellenes los campos que sean neceario en filamen 
     //que el usuario no tenga que rellenar por ejemplo porque se refieren a ellos mismo   
    protected function mutateFormDataBeforeCreate(array $user): array
    {
        $user['user_id'] = auth()->id();
        $user['type'] = 'pending';
        return $user;
    }
}

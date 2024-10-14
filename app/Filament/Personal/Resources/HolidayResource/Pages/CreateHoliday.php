<?php

namespace App\Filament\Personal\Resources\HolidayResource\Pages;

use App\Filament\Personal\Resources\HolidayResource;
use App\Mail\HolidayPending;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Filament\Notifications\Notification;

class CreateHoliday extends CreateRecord
{
    protected static string $resource = HolidayResource::class;


    /// este método doc filameten, permite que prerellenes los campos que sean neceario en filamen 
    //que el usuario no tenga que rellenar por ejemplo porque se refieren a ellos mismo   

    // envio de mails : ojo acuerdate que en el emisor es en el panel persoanl pero en la de confirmacion es en el panel de administración 
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::user()->id;
        $data['type'] = 'pending';
        $userAdmin = User::find(1);

        $dataMail = array(
            'day' => $data['day'],
            'email' => User::find($data['user_id'])->email,
            'name' => User::find($data['user_id'])->name,
            //estaba usando los datos del admin por lo que no encontrba
            //acuerdate de buscar en el que envia la solicitud 
        );
        Mail::to($userAdmin)->send(new HolidayPending($dataMail));
        // esta es la que mandamos a la vista del mail

        /// notificaciones en el panel (osease que te salga un iconito con la noti)
      $recipient = auth()->user();
        

        Notification::make()
            ->title('Saved successfully')
            ->body('Solicitud envidada, ' .$data['day'])
            ->sendToDatabase($recipient);

        return $data;
    }
}

<?php

namespace App\Filament\Resources\HolidayResource\Pages;

use App\Filament\Resources\HolidayResource;
use App\Mail\HolidayApproved;
use App\Models\User;
use Filament\Actions;

use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notification as NotificationsNotification;
use Illuminate\Support\Facades\Mail;
use Filament\Notifications\Notification;

class EditHoliday extends EditRecord
{
    protected static string $resource = HolidayResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $record->update($data); //donde el record es el registro con los datos actualizados pasados en el formulario

        if ($record->type == 'approved') {
            $user = User::find($record->user_id);
            $dataToSend = [
                'name' => $user->name,
                'email' => $user->email,
                'day' => $record->day
            ];
            Mail::to($user)->send(new HolidayApproved($dataToSend)); // lo mismo que en pending esta es la variable que mandamos a la vista del mail

            /// en tiempo real, estas son las buenas las ue salen en el panel acordase de que le puse la caractristica databaseNotifications en el panel
            $recipient = $user;
          
            Notification::make()
                ->title('Notificación Enviada')
                ->body('Solicitud de vaciones aprobadas '.$dataToSend['day'])
                ->sendToDatabase($recipient);
        }

        return $record; // esta es la variale que mandamos al panel de filamente que edita el usuario 
    }
}

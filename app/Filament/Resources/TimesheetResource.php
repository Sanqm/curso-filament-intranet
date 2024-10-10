<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TimesheetResource\Pages;
use App\Filament\Resources\TimesheetResource\RelationManagers;
use App\Models\Timesheet;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\SelectFilter;


class TimesheetResource extends Resource
{
    protected static ?string $model = Timesheet::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $modelLabel = 'Horario';
    protected static ?string $navigationGroup = 'Employees Managament';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('calendar_id')
                    ->relationship(name: 'calendar', titleAttribute: 'name') // esto lo empleamos para establecer la relación entre un campo que se cargará de forma automática en nuestro selector
                    // campo de la relación y titleAtribute el nombre que mostra en el selector // 'calendar' este nombre coincide conel dado a la funcion 
                    //donde establecimos la relación en el modelo 
                    ->required(),

                Forms\Components\Select::make('user_id')
                    ->relationship(name: 'user', titleAttribute: 'name')
                    ->required(),

                Forms\Components\Select::make('type')
                    ->options([
                        'work' => 'Work',
                        'pause' => 'Pause',
                        // donde los campos dentro de las opciones serań las diferentes selecciones del select
                    ]),

                Forms\Components\DateTimePicker::make('day_in')

                    ->native(false)
                    ->required(),
                Forms\Components\DateTimePicker::make('day_out')
                    ->native(false)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('calendar.name') // (calendar_id) podemos hacer la relación 
                    // commo lo especificamos ahora llamando a tabla.campodelatabla  
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->searchable(), // hace que un campo sea buscable 
                Tables\Columns\TextColumn::make('day_in')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('day_out')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([ // como veiamos en esta seccion podremos crear filtros para nuestra aapp
                SelectFilter::make('type')
                    ->options([
                        'work' => 'Working',
                        'pause' => 'In Pause',

                    ]),
                    Filter::make('calendar_id'),
                    Filter::make('user.name'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTimesheets::route('/'),
            'create' => Pages\CreateTimesheet::route('/create'),
            'edit' => Pages\EditTimesheet::route('/{record}/edit'),
        ];
    }
}

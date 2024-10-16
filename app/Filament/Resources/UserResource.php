<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\City;
use App\Models\State;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Section;
use Filament\Forms\FormsComponent;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Support\Collection;
use SebastianBergmann\Type\NullType;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;


class UserResource extends Resource
{
    protected static ?string $model = User::class;
    //protected static ?string $navigationLabel = "Employees"; // esta linea permite cambiar el nombre dado al recurso 
    //insertado en la barra de aside iquierada
    protected static ?string $navigationIcon = 'heroicon-o-user-group'; // personalizacion de icono del aside ojo es o no cero

    protected static ?string $navigationGroup = 'Employees Managament'; // como vimos en el recurso de ciudades, estado, country
    // que metimos en su propio arbol harems los mismo con los empleados y aquellas fuciones que vayamos añadiendo

    protected static ?int $navigationSort = 1; // esto permite establecer el orden de aparicion de los recursos teniendo 
    //en cuenta que esta variable a de aparecer en cada uno de ellos y se le deberá dar el valor númerico del mismo

    // acordemosnos que en los recursos será deonde se montarán las vistas de cada uno de los creados
    protected static ?string $modelLabel = 'Empleados';



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informacion Personal')->columns(2)
                    ->schema([

                        Forms\Components\TextInput::make('name')
                            ->required(),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required(),
                        //Forms\Components\DateTimePicker::make('email_verified_at'),

                        Forms\Components\TextInput::make('password')
                            ->password()
                            ->hiddenOn('edit') // ojo tenes el solo hidden que lo oculta en hiddeon lo puedes 
                            //configurar para que lo oculte en la opción que establezcas
                            ->required(),
                    ]),

                Section::make('Dirreccion')->columns(2)
                    ->schema([
                        Forms\Components\Select::make('country_id')
                            ->relationship(name: 'country', titleAttribute: 'name') // donde el primer name hará referencia al nombre de la relación
                            ->searchable() // buscable
                            ->preload() // autorecargable
                            ->live() // actulizable en tiempo real 
                            ->afterStateUpdated(function (Set $set) {
                                $set('state_id', null);
                                $set('city_id', null);
                            })  // esto hace que si elimamos alguna de las opciones 
                            //de los combos estos se eliminen
                            ->required(), // requerido
                        Forms\Components\Select::make('state_id')
                            ->options(fn(Get $get): Collection => State::query()
                                ->where('country_id', $get('country_id'))
                                ->pluck('name', 'id')) // pluck nos indica los campos que queremos que nos devuelva
                            ->searchable()
                            ->preload()
                            ->live()
                            ->afterStateUpdated(function (Set $set) {

                                $set('city_id', null);
                            })
                            ->required(),
                        Forms\Components\Select::make('city_id')
                            ->options(fn(Get $get): Collection => City::query()
                                ->where('state_id', $get('state_id'))
                                ->pluck('name', 'id'))
                            ->searchable()
                            ->preload()
                            ->live()
                            ->required(),
                        Forms\Components\TextInput::make('addres')
                            ->required(),
                        Forms\Components\TextInput::make('postal_code')
                            ->required(),
                    ]),
                //con el options aqui estamos concatenando el campo anterior por lo que debemos tener cuidadado 
                //ya que si no se carga uno no se podrá cargar el sigueiente
                Forms\Components\Select::make('roles')
                    ->relationship('roles', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable()
            ]);
    }

    public static function table(Table $table): Table
    {
        //Recordemos que lo  que se añade aquí será la parte visual que veamos en la vista
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable() // buscable
                    ->sortable()  // ordeneable
                    ->label(__('Nombre')),

                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('addres')
                    ->sortable()
                    ->label(__('Direccion'))
                    ->toggleable(isToggledHiddenByDefault: false), // esto permite que esta opción se pueda mostrar o no 
                //dependiendo de si lo selecciona el usuario
                Tables\Columns\TextColumn::make('postal_code')
                    ->sortable()
                    ->searchable()
                    ->label(__('Codigo Postal'))
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->dateTime() // estable la hora acutal del sistema en dicho campo 
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([ // configuracion para filtros 
                //
            ])
            ->actions([  // configuracion de los botones de acción, es decir de loq eu al pular optienes una accion
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ViewAction::make(),

            ])
            ->bulkActions([ // esto se para acciones que atañan a más de un registro, ten cuidado no lo estaba viendo
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    ExportBulkAction::make(),
                ])
               
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}

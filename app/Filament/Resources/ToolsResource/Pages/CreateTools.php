<?php

namespace App\Filament\Resources\ToolsResource\Pages;

use App\Filament\Resources\OwnerResource;
use App\Filament\Resources\ToolsResource;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Filament\Actions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CreateTools extends CreateRecord
{
    protected static string $resource = ToolsResource::class;

    // 1. Custom sebelum simpan data maka akan menyimpan sebuah id dari user yang sedang login saat ini
    // protected function mutateFormDataBeforeCreate(array $data): array
    // {
    //     $data['user_id'] = auth()->id();
    //
    //     return $data;
    // }
    //

    // 2. Custom sebelum simpan data akan me-rename sebuah value Renamed Tool
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['name'] = 'Renamed Tool';

        return $data;
    }

    // 3. Setelah create data Tools, bisa menambahkan data ke table lain
    protected function handleRecordCreation(array $data): Model
    {
        // Menambah data user ke table lain
        // OwnerResource::getModel()::create([
        //     'email' => 'test123@gmail.com',
        //     'name' => 'test123',
        //     'phone' => '123123123',
        // ]);
        return static::getModel()::create($data);
    }

    // 4. Custom redirect setelah create data, return ke halaman Tool index
    protected function getRedirectUrl(): string
    {
        // return ke halaman Tool Index
        return $this->getResource()::getUrl('index');

        // return ke halaman Owner Index
        // return OwnerResource::getUrl('index');
    }

    // 5. Custom Notifikasi
    // protected function getCreatedNotificationTitle(): ?string
    // {
    //     return 'Data berhasil disimpan!';
    // }

    // 6. Custom Notifikasi Advanced
    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Succes!')
            ->body('Data berhasil disimpan!');
    }

    // 7. Custom Lifecycle Hooks
    protected function beforeCreate(): void
    {
        $currentUser = Auth::user();

        if ($currentUser->id == 2) {
            Notification::make()
                ->warning()
                ->title("You don't have an access!")
                ->body('Please contact admin!')
                ->persistent()
                ->actions([
                    Action::make('Back!')
                        ->button()
                        ->url(ToolsResource::getUrl('index'), shouldOpenInNewTab: true),
                ])
                ->send();

            $this->halt();
        }
    }
}

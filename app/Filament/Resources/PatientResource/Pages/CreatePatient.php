<?php

namespace App\Filament\Resources\PatientResource\Pages;

use App\Filament\Resources\PatientResource;
use Filament\Forms\Components\Wizard\Step;
use Filament\Resources\Pages\CreateRecord;

class CreatePatient extends CreateRecord
{
    protected static string $resource = PatientResource::class;

    use CreateRecord\Concerns\HasWizard;

    protected function getSteps(): array
    {
        return [
            Step::make('Name')
                ->description('Give your patient a name.')
                ->schema([
                    PatientResource::getNameFormField(),
                ]),
            Step::make('Type')
                ->description('Please select your pet type.')
                ->schema([
                    PatientResource::getTypeFormField(),
                ]),
            Step::make('Date of Birth')
                ->description('Please select your date birth')
                ->schema([
                    PatientResource::getDOBFormField(),
                ]),
            Step::make('Owner')
                ->description('Please select your owner')
                ->schema([
                    PatientResource::getOwnerFormField(),
                ]),
        ];
    }
}

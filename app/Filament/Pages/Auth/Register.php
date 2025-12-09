<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Components\TextInput;
use Filament\Auth\Pages\Register as BaseRegister;
use Illuminate\Validation\Rules\Password;

class Register extends BaseRegister
{
    protected function getEmailFormComponent(): TextInput
    {
        return TextInput::make('email')
            ->label(__('Email'))
            ->email()
            ->required()
            ->live(onBlur: true)
            ->rules([
                'required',
                'email',
                'ends_with:@gov.bc.ca',
            ])
            ->validationMessages([
                'ends_with' => 'You must use your government email (@gov.bc.ca).',
            ])
            ->placeholder('your.name@gov.bc.ca');
    }

    protected function getPasswordFormComponent(): TextInput
    {
        return TextInput::make('password')
            ->label(__('Password'))
            ->password()
            ->required()
            ->rule(Password::default());
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (! str_ends_with($data['email'], '@gov.bc.ca')) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'email' => 'You must register using a valid @gov.bc.ca email.',
            ]);
        }

        return $data;
    }
}

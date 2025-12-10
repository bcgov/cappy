<?php

namespace App\Filament\Pages\Auth;

use Filament\Auth\Pages\EditProfile as BaseEditProfile;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Actions\Action;
use Filament\Notifications\Notification;

class EditProfile extends BaseEditProfile
{
    public ?string $api_token = null;

    public function regenerateApiToken(): void
    {
        $user = $this->getUser();
        $user->tokens()->delete();
        $token = $user->createToken('default');
        $this->data['api_token'] = $token->plainTextToken;
        Notification::make()
            ->title("Token generated successfully!")
            ->success()
            ->send();
    }

    public function deleteApiToken(): void
    {
        $user = $this->getUser();
        $user->tokens()->delete();
        $this->data['api_token'] = null;
        Notification::make()
            ->title("Token deleted successfully!")
            ->success()
            ->send();
    }

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            $this->getNameFormComponent(),
            $this->getEmailFormComponent(),
            $this->getPasswordFormComponent(),
            TextInput::make('api_token')
                ->label('API Token')
                ->disabled()
                ->live()
                ->reactive()
                ->copyable()
                ->suffixActions([
                    Action::make('regenerate')
                        ->label('Regenerate')
                        ->action('regenerateApiToken')
                        ->icon('heroicon-o-arrow-path'),
                    Action::make('delete')
                        ->label('Delete')
                        ->action('deleteApiToken')
                        ->icon('heroicon-o-trash')
                ]),
        ]);
    }
}

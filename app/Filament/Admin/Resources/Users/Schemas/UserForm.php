<?php

namespace App\Filament\Admin\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('User Details')
                    ->description('Create and manage user accounts for both admins and fans. Admins have full access to the admin dashboard (managingteam.info/admin) and can manage all celebrities, users, events, and settings. Fans are regular community members who access their celebrity portal and have limited permissions (manage their own profile, view their memberships, events, and messages). Assign the correct role carefully — admin privileges are powerful and should only be granted to trusted staff members. New users receive a welcome email after creation if email notifications are configured.')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->helperText('Full display name of the user. This is shown in the admin panel, user dashboard, and any public-facing profiles (if applicable). Use the user\'s real full name for admins; for fans, any name they provide is acceptable. Max 255 characters.'),
                        TextInput::make('email')
                            ->label('Email address')
                            ->email()
                            ->required()
                            ->helperText('The user\'s email address used for logging into the system and receiving system notifications (e.g. membership approvals, event reminders, payment confirmations). Must be a valid email format. Each email must be unique in the system — duplicate email addresses are not allowed. For fans, this is also the primary contact for their account-related communications.'),
                        DateTimePicker::make('email_verified_at'),
                        TextInput::make('password')
                            ->password()
                            ->required(fn ($operation) => $operation === 'create')
                            ->dehydrated(fn ($state) => filled($state))
                            ->helperText('Set the user\'s password. Minimum 8 characters — use a mix of letters, numbers, and special characters for security. When creating a new user, this field is required. When editing, leave empty to keep the current password unchanged. The password is stored securely using Laravel\'s hashing. Do not use a password you use elsewhere; generate a strong random password and share it securely with the user.'),
                        TextInput::make('phone')
                            ->tel()
                            ->helperText('Optional contact phone number for the user. Can be used for SMS notifications in the future (feature not yet active). Enter in international format if possible, e.g. +1-555-123-4567. This is not displayed publicly.'),
                        TextInput::make('avatar')
                            ->helperText('URL to the user\'s profile picture/avatar. For admins, this appears in the admin panel header and user management screens. For fans, this appears on their profile and in messaging conversations. Recommended: square image, at least 200x200px, JPEG or PNG format. Leave empty to use a default avatar based on the user\'s initials.'),
                        TextInput::make('role')
                            ->required()
                            ->default('fan')
                            ->helperText('The user\'s system role. "admin" grants full access to the admin dashboard (managingteam.info/admin) — can manage all celebrities, users, payment methods, events, and system settings. "fan" is a regular community member who can only access their assigned celebrity portal, manage their own profile, view/purchase memberships, register for events, and use messaging. Choose "admin" only for trusted staff. Once set, review periodically to ensure least-privilege access.'),
                        Toggle::make('is_verified')
                            ->required()
                            ->helperText('Mark the user as verified. Verified status indicates the user has confirmed their identity (e.g. through email verification or manual ID check). Verified users can access all features without restrictions. Unverified users may have limited access (e.g. cannot message, purchase tickets, or apply for membership) depending on your portal configuration. For fans, verify after they complete the application process or confirm their email. For admins, should always be verified.'),
                    ]),
            ]);
    }
}

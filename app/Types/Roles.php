<?php

namespace App\Types;

enum Roles
{
    case ADMIN;
    case BRANCH_ADMIN;
    case DIRECTOR;
    case MANAGER;
    case AGENT;
    case PLANHOLDER;
    case OFFICE_USERS;
    case CLIENT_USERS;

    public function label(): string
    {
        return match ($this) {
            self::CLIENT_USERS,
            self::OFFICE_USERS,
            self::ADMIN => 'Admin',
            self::BRANCH_ADMIN => 'Branch Admin',
            self::DIRECTOR => 'Director',
            self::MANAGER => 'Manager',
            self::AGENT => 'Agent',
            self::PLANHOLDER => 'Planholder',
        };
    }

    public function displayOptions(): array
    {
        switch ($this) {
            case self::OFFICE_USERS:
                return [
                    self::ADMIN->label(),
                    self::BRANCH_ADMIN->label(),
                ];
            case self::CLIENT_USERS:
                return [
                    self::DIRECTOR->label() => self::DIRECTOR->label(),
                    self::MANAGER->label() => self::MANAGER->label(),
                    self::AGENT->label() => self::AGENT->label(),
                    self::PLANHOLDER->label() => self::PLANHOLDER->label(),
                ];
            case self::OFFICE_USERS:
            case self::CLIENT_USERS:
            default:
                return [];
        }
    }

    public static function officeUsersOptions(): array
    {
        return self::OFFICE_USERS->displayOptions();
    }

    public static function clientUsersOptions(): array
    {
        return self::CLIENT_USERS->displayOptions();
    }
}

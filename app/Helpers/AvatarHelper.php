<?php

namespace App\Helpers;

use App\Models\User;


class AvatarHelper
{
    public static function getAvatarUrl(?User $user): string
    {
        if (!$user || !$user->avatar) {
            return '';
        }

        // Jika avatar URL (dari Google), gunakan langsung
        if (str_starts_with($user->avatar, 'http')) {
            return $user->avatar;
        }

        // Jika avatar file lokal
        return asset('storage/' . $user->avatar);
    }

    public static function hasAvatar(?User $user): bool
    {
        return $user && !empty($user->avatar);
    }

    public static function getInitials(?User $user): string
    {
        if (!$user || empty($user->name)) {
            return 'U';
        }

        $names = explode(' ', $user->name);
        $initials = '';

        foreach (array_slice($names, 0, 2) as $name) {
            $initials .= strtoupper($name[0] ?? '');
        }

        return $initials ?: 'U';
    }
}

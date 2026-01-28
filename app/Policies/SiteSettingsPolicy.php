<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\SiteSettings;
use Illuminate\Auth\Access\HandlesAuthorization;

class SiteSettingsPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('view_any_site_settings');
    }

    public function view(AuthUser $authUser, SiteSettings $siteSettings): bool
    {
        return $authUser->can('view_site_settings');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('create_site_settings');
    }

    public function update(AuthUser $authUser, SiteSettings $siteSettings): bool
    {
        return $authUser->can('update_site_settings');
    }

    public function delete(AuthUser $authUser, SiteSettings $siteSettings): bool
    {
        return $authUser->can('delete_site_settings');
    }

    public function restore(AuthUser $authUser, SiteSettings $siteSettings): bool
    {
        return $authUser->can('restore_site_settings');
    }

    public function forceDelete(AuthUser $authUser, SiteSettings $siteSettings): bool
    {
        return $authUser->can('force_delete_site_settings');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('force_delete_any_site_settings');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('restore_any_site_settings');
    }

    public function replicate(AuthUser $authUser, SiteSettings $siteSettings): bool
    {
        return $authUser->can('replicate_site_settings');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('reorder_site_settings');
    }

}
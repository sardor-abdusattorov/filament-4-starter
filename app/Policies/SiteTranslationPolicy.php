<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\SiteTranslation;
use Illuminate\Auth\Access\HandlesAuthorization;

class SiteTranslationPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('view_any_site_translation');
    }

    public function view(AuthUser $authUser, SiteTranslation $siteTranslation): bool
    {
        return $authUser->can('view_site_translation');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('create_site_translation');
    }

    public function update(AuthUser $authUser, SiteTranslation $siteTranslation): bool
    {
        return $authUser->can('update_site_translation');
    }

    public function delete(AuthUser $authUser, SiteTranslation $siteTranslation): bool
    {
        return $authUser->can('delete_site_translation');
    }

    public function restore(AuthUser $authUser, SiteTranslation $siteTranslation): bool
    {
        return $authUser->can('restore_site_translation');
    }

    public function forceDelete(AuthUser $authUser, SiteTranslation $siteTranslation): bool
    {
        return $authUser->can('force_delete_site_translation');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('force_delete_any_site_translation');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('restore_any_site_translation');
    }

    public function replicate(AuthUser $authUser, SiteTranslation $siteTranslation): bool
    {
        return $authUser->can('replicate_site_translation');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('reorder_site_translation');
    }

}
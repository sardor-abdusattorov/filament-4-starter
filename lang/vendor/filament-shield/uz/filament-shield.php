<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Table Columns
    |--------------------------------------------------------------------------
    */

    'column.name' => 'Ism',
    'column.guard_name' => 'Guard nomi',
    'column.roles' => 'Rollar',
    'column.permissions' => 'Ruxsatlar',
    'column.updated_at' => 'Yangilangan vaqti',

    /*
    |--------------------------------------------------------------------------
    | Form Fields
    |--------------------------------------------------------------------------
    */

    'field.name' => 'Ism',
    'field.guard_name' => 'Guard nomi',
    'field.permissions' => 'Ruxsatlar',
    'field.select_all.name' => 'Hammasini tanlash',
    'field.select_all.message' => 'Joriy vaqtda ushbu rol uchun <span class="text-primary font-medium">faollashtirilgan</span> barcha ruxsatlarni yoqish',

    /*
    |--------------------------------------------------------------------------
    | Navigation & Resource
    |--------------------------------------------------------------------------
    */

    'nav.group' => 'Administratsiya',
    'nav.role.label' => 'Rollar',
    'nav.role.icon' => 'heroicon-o-shield-check',
    'resource.label.role' => 'Rol',
    'resource.label.roles' => 'Rollar',

    /*
    |--------------------------------------------------------------------------
    | Section & Tabs
    |--------------------------------------------------------------------------
    */

    'section' => 'Obyektlar',
    'resources' => 'Resurslar',
    'widgets' => 'Vidjetlar',
    'pages' => 'Sahifalar',
    'custom' => 'Maxsus ruxsatlar',

    /*
    |--------------------------------------------------------------------------
    | Messages
    |--------------------------------------------------------------------------
    */

    'forbidden' => 'Sizda kirish ruxsati yo‘q',

    /*
    |--------------------------------------------------------------------------
    | Resource Permissions' Labels
    |--------------------------------------------------------------------------
    */

    'resource_permission_prefixes_labels' => [
        'view' => 'Ko‘rish',
        'view_any' => 'Hammasini ko‘rish',
        'create' => 'Yaratish',
        'update' => 'Yangilash',
        'delete' => 'O‘chirish',
        'delete_any' => 'Hammasini o‘chirish',
        'force_delete' => 'Majburiy o‘chirish',
        'force_delete_any' => 'Hammasini majburiy o‘chirish',
        'restore' => 'Tiklash',
        'reorder' => 'Tartibini o‘zgartirish',
        'restore_any' => 'Hammasini tiklash',
        'replicate' => 'Nusxalash',
    ],
];

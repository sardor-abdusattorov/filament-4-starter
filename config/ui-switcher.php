<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Available Colors
    |--------------------------------------------------------------------------
    */
    'colors' => [
        'slate', 'gray', 'zinc', 'neutral', 'stone',
        'red', 'orange', 'amber', 'yellow', 'lime',
        'green', 'emerald', 'teal', 'cyan', 'sky',
        'blue', 'indigo', 'violet', 'purple', 'fuchsia',
        'pink', 'rose',
    ],

    /*
    |--------------------------------------------------------------------------
    | Available Fonts
    |--------------------------------------------------------------------------
    */
    'fonts' => [
        'Inter',
        'Poppins',
        'Public Sans',
        'DM Sans',
        'Nunito Sans',
        'Roboto',
    ],

    /*
    |--------------------------------------------------------------------------
    | Available Layouts
    |--------------------------------------------------------------------------
    | sidebar - default sidebar
    | sidebar_collapsible - collapsible to icons
    | sidebar_hidden - fully collapsible (can be hidden)
    | topbar - top navigation
    */
    'layouts' => [
        'sidebar',
        'sidebar_collapsible',
        'sidebar_hidden',
        'topbar',
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Settings
    |--------------------------------------------------------------------------
    */
    'defaults' => [
        'theme' => 'system', // light, dark, system
        'primary_color' => 'blue',
        'layout' => 'sidebar',
        'font_family' => 'Inter',
        'font_size' => 16,
    ],

    /*
    |--------------------------------------------------------------------------
    | Font Size Range
    |--------------------------------------------------------------------------
    */
    'font_size' => [
        'min' => 12,
        'max' => 20,
    ],
];

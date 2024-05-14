<?php
return [
    'links' => [

        /*
         * '{TEXT}' => [
         *      '_icon'   => '{ICON}',
         *      '_url'    => '{URL}',    # Optional if _links is present
         *      '_target' => '{TARGET}',
         *      '_links'  => [           # Optional if _url is present
         *          '{TEXT}' => [
         *              '_url'    => '{URL}',
         *              '_target' => '{TARGET}',
         *          ]
         *          '{TEXT}' => [
         *              '_url'    => '{URL}',
         *              '_target' => '{TARGET}',
         *          ]
         *      ]
         * ]
         */

        'Admins' => [
            '_can'    => 'navigation.admins',
            '_icon'   => '',
            '_url'    => env('APP_URL').'users/resources/admins',
            '_links' => [
                'Add New' => [
                    '_can'    => 'navigation.admins.add',
                    '_icon'   => '',
                    '_url'    => env('APP_URL').'users/resources/admins/new',
                ],
                'View All' => [
                    '_can'    => 'navigation.admins.all',
                    '_icon'   => '',
                    '_url'    => env('APP_URL').'users/resources/admins',
                ],
            ]
        ],

        'Clients' => [
            '_can'    => 'navigation.clients',
            '_icon'   => '',
            '_url'    => env('APP_URL').'users/resources/clients',
            '_links' => [
                'Add New' => [
                    '_can'    => 'navigation.clients.add',
                    '_icon'   => '',
                    '_url'    => env('APP_URL').'users/resources/clients/new',
                ],
                'View All' => [
                    '_can'    => 'navigation.clients.all',
                    '_icon'   => '',
                    '_url'    => env('APP_URL').'users/resources/clients',
                ],
            ],
        ],

        'Projects' => [
            '_can'    => 'navigation.projects',
            '_url'    => env('APP_URL').'users/resources/projects',
            '_links' => [
                'Add New' => [
                    '_can'    => 'navigation.projects.add',
                    '_icon'   => '',
                    '_url'    => env('APP_URL').'users/resources/projects/new',
                ],
                'View All' => [
                    '_can'    => 'navigation.projects.all',
                    '_icon'   => '',
                    '_url'    => env('APP_URL').'users/resources/projects',
                ],
                'Viewed' => [
                    '_can'    => 'navigation.projects.viewed',
                    '_icon'   => '',
                    '_url'    => env('APP_URL').'users/resources/project-views',
                ],
                'Favorited' => [
                    '_can'    => 'navigation.projects.favorited',
                    '_icon'   => '',
                    '_url'    => env('APP_URL').'users/resources/project-favorites',
                ],
                'Search Preferences' => [
                    '_can'    => 'navigation.projects.searchPreferences',
                    '_icon'   => '',
                    '_url'    => env('APP_URL').'users/resources/search-preferences',
                ],
                'Project Logs' => [
                    '_can'    => 'navigation.projects.logs',
                    '_icon'   => '',
                    '_url'    => env('APP_URL').'users/resources/project-logs',
                    '_can'    => ['superadmin', 'admin'],
                ],
            ]
        ],

        'Vendors' => [
            '_can'    => 'navigation.vendor',
            '_links' => [
                'View All' => [
                    '_can'    => 'navigation.vendor.all',
                    '_icon'   => '',
                    '_url'    => env('APP_URL').'users/resources/vendors',
                ],
                'Project Views' => [
                    '_can'    => 'navigation.vendor.projectViews',
                    '_icon'   => '',
                    '_url'    => env('APP_URL').'users/resources/project-views',
                ],
                'Project Favorites' => [
                    '_can'    => 'navigation.vendor.projectFavorites',
                    '_icon'   => '',
                    '_url'    => env('APP_URL').'users/resources/project-favorites',
                ],
                'Search Preferences' => [
                    '_can'    => 'navigation.vendor.searchPreferences',
                    '_icon'   => '',
                    '_url'    => env('APP_URL').'users/resources/search-preferences',
                ],
            ]
        ],

        'Settings' => [
            '_icon'   => '',
            '_links' => [
                'My Profile' => [
                    '_icon'   => '',
                    '_url'    => env('APP_URL').'users/myprofile',
                ],
                'Reset Password' => [
                    '_icon'   => '',
                    '_url'    => env('APP_URL').'users/reset-password',
                ],
            ],
        ],

    ]
];

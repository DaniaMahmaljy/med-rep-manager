<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;



class SidebarService extends Service
{

     public $sidebarItems;

    public function generate()
    {

        $sidebarItems = collect([
            [
                'name' => __('local.Dashboard'),
                'icon' => 'grid-fill',
                'url' => route('dashboard'),
                'isTitle' => false,
                'submenu' => [],
                'key' => 'dashboard',
            ],

            [
                'name' => __('local.Users'),
                'key' => 'Users',
                'icon' => 'people-fill',
                'permission' => 'user_management_access',
                'submenu' => [
                    [
                        'name' => __('local.Add New'),
                        'key' => 'Add User',
                        'url' => route('user.create'),
                        'permission' => 'view_add_user',
                    ],
                ]
            ],

            [
                'name' => __('local.Visits'),
                'key' => 'Visits',
                'icon' => 'calendar-check-fill',
                'submenu' => [
                    [
                        'name' => __('local.View All'),
                        'url' => route('visits.index')
                    ],
                    [
                        'name' => __('local.Add New'),
                        'url' => route('visits.create')
                    ],
                ]
            ],

             [
                'name' => __('local.Representatives'),
                'key' => 'Representatives',
                'icon' => 'briefcase-fill',
                'submenu' => [
                    [
                        'name' => __('local.View All'),
                        'url' => route('representatives.index')
                    ],
                ]
            ],
             [
                'name' => __('local.Tickets'),
                'key' => 'Tickets',
                'icon' => 'calendar-check-fill',
                'submenu' => [
                    [
                        'name' => __('local.View All'),
                        'url' => route('tickets.index')
                    ],
                ]
            ],
            [
                'name' => __('local.Logout'),
                'key' => 'logout',
                'icon' => 'power',
                'url' => route('logout'),
                'isForm' => true,
            ]
        ]);

        return $sidebarItems->filter(function ($item) {
            $user = Auth::user();

            if (isset($item['permission']) && !$user->can($item['permission'])) {
                return false;
            }

            if (!empty($item['submenu'])) {
                $item['submenu'] = array_filter($item['submenu'], function ($sub) use ($user) {
                    return !isset($sub['permission']) || $user->can($sub['permission']);
                });

                if (empty($item['submenu'])) {
                    return false;

                }
            }

            return true;
        });
}

}

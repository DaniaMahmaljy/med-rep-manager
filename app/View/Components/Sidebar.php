<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Sidebar extends Component
{
    /**
     * Create a new component instance.
     */

     public $sidebarItems;

    public function __construct()
    {
        $this->sidebarItems = collect([
            [
                'name' => 'Dashboard',
                'icon' => 'grid-fill',
                'url' => route('dashboard'),
                'isTitle' => false,
                'submenu' => [],
                'key' => 'dashboard',
            ],

            [
                'name' => 'Users',
                'key' => 'Users',
                'icon' => 'people-fill',
                'submenu' => [
                    [
                        'name' => 'Add User',
                        'key' => 'Add User',
                        'url' => route('user.create'),
                    ],
                ]
            ],
            [
                'name' => 'Another Menu',
                'key' => 'Another  Menu',
                'icon' => 'three-dots',
                'submenu' => [
                    [
                        'name' => 'Second Level Menu',
                        'url' => route('dashboard')
                    ],
                ]
            ],
        ]);
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.sidebar');
    }
}

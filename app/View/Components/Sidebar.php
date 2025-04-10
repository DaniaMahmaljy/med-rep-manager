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
                'icon' => 'house',
                'url' => route('dashboard'),
                'isTitle' => false,
                'submenu' => [],
                'key' => 'dashboard',
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

<?php

namespace App\View\Components;

use App\Services\SidebarService;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Sidebar extends Component
{
    /**
     * Create a new component instance.
     */

     public $sidebarItems;

    public function __construct(protected SidebarService $sidebarService)
    {

        $this->sidebarItems = $sidebarService->generate();

    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.sidebar');
    }
}

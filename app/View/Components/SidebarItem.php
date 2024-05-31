<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SidebarItem extends Component
{

    public $routes;
    public $icon;
    public $title;
    /**
     * Create a new component instance.
     */
    public function __construct(array $routes,$icon,$title)
    {
        $this->routes = $routes;
        $this->icon = $icon;
        $this->title = $title;
    }

    public function isActive()
    {
        foreach ($this->routes as $route) {
            if (request()->routeIs($route)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.sidebar-item');
    }
}

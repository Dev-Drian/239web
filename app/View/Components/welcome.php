<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class welcome extends Component
{
    public $clients, $blogs, $tasks;

    public function __construct($clients, $blogs, $tasks)
    {
        $this->clients = $clients;
        $this->blogs = $blogs;
        $this->tasks = $tasks;
    }

    public function render()
    {
        return view('components.welcome');
    }
}

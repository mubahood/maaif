<?php

namespace App\Admin\Extensions\Nav;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Auth;

class Dropdown implements Renderable
{
  public function render()
  {

    return view('widgets/dropdown', [
      'links' => [
        [
          'url' => '#',
          'icon' => 'book',
          'title' => 'E-Diary',
        ],
        [
          'url' => '#',
          'icon' => 'user-md',
          'title' => 'GRM',
        ],
        [
          'url' => '#',
          'icon' => 'map-pin',
          'title' => 'Profiling',
        ],
        [
          'url' => '#',
          'icon' => 'users',
          'title' => 'Advisory',
        ],
      ]
    ]);
  }
}

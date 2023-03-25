<?php
$dpYear = 'Change Year';
foreach ($years as $key => $y) {
    if ($y->active == 1) {
        $dpYear = $y->name;
        break;
    }
}
?><li class="dropdown">
    <a href="#" class="dropdown-toggle auto-refresh" data-toggle="dropdown" title="Academic Year - Display"
        aria-expanded="true">
        <i class="fa fa-play"></i>&nbsp;&nbsp;
        <span class="interval-text">{{ $dpYear }}</span>
    </a>
    <ul class="dropdown-menu" style="width: 30px !important;">
        @foreach ($years as $year)
            <li><a href="{{ admin_url('?change_dpy_to=' . $year->id) }}"
                    title='Change display academic year to {{ $year->name }}'
                    data-interval="2">{{ $year->name }}</a></li>
        @endforeach
    </ul>
</li>

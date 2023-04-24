<?php
use App\Models\Utils;
?><style>
    .ext-icon {
        color: rgba(0, 0, 0, 0.5);
        margin-left: 10px;
    }

    .installed {
        color: #00a65a;
        margin-right: 10px;
    }

    .card {
        border-radius: 5px;
    }

    .case-item:hover {
        background-color: rgb(254, 254, 254);
    }
</style>
<div class="card  mb-4 mb-md-5 border-0">
    <!--begin::Header-->
    <div class="d-flex justify-content-between px-2 px-md-4 border-bottom ">
        <p class="h4  text-bold mb-2 mb-md-3 ">My recent daily activities</p> 
        <div>
            <a href="{{ admin_url('/events') }}" class="btn btn-sm btn-success mt-2">
                View All
            </a>
        </div>
    </div>
    <div class="card-body py-2 py-md-3 ">
        @foreach ($items as $i)
            <div class="d-flex align-items-center mb-2 case-item bg-light">
                <a href="{{ url('/dinner') }}" title="{{ $i->topic_text }}" style="border-left: solid rgb(44, 132, 3) 5px!important;"
                    class="flex-grow-1 pl-2 pl-md-3 border-primary text-primary">
                    <b>{{ Utils::my_date($i->date) }}</b> - <b
                        class="text-success">{{ Str::limit($i->topic_text, 30) }}</b>
                    <span class="text-dark d-block">
                        {{ Str::limit($i->notes, 50) }},
                    </span>
                </a>
            </div>
        @endforeach
    </div>
</div>

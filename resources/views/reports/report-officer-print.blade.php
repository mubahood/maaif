<?php

$q1 = 0;
$q2 = 0;
$q3 = 0;
$q4 = 0;

$activities = $items['activities'];
$metrix = $items['metrix'];
$q1 += $metrix[1]['budget'];
$q2 += $metrix[2]['budget'];
$q3 += $metrix[3]['budget'];
$q4 += $metrix[4]['budget'];

$data = $items['data'];

$p1 = ((int) ($q1 / 1000));
$p2 = ((int) ($q2 / 1000));
$p3 = ((int) ($q3 / 1000));
$p4 = ((int) ($q4 / 1000));

$url = "https://chart.googleapis.com/chart?cht=p3&chs=400x200&chl=1st|2nd|3rd|4th&chd=t:$p1,$p2,$p3,$p4&chco=FF0000,00FF00,0000FF,FFFF00";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{ url('/assets/images/coat_of_arms-min.png') }}">
    <link rel="stylesheet" href="<?php echo e(public_path('css/bootstrap-print.css'), false); ?>">
    <link type="text/css" href="<?php echo e(public_path('css/print.css'), false); ?>" rel="stylesheet" />

</head>

<body>

    <table style="width: 100%">
        <tr>
            <td style="width: 25%;" class="">
            </td>
            <td class="text-center pb-2" style="width: 24%;">
                <img style="width: 110px" src="<?= public_path('assets/images/coat_of_arms-min.png') ?>">
            </td>
            <td style="width: 25%;" class="">
            </td>
        </tr>

        <tr>
            <td colspan="3" class="text-center">
                <p class="text-center mt-12" style="font-size: 20px"><b>MINISTRY OF AGRICULTURE, ANIMAL INDUSTRY AND
                        FISHERIES</b></p>
                <p class="mb-0" class="text-center" style="font-size: 12px"><b>P.O. Box 513, ENTEBBE, UGANDA</b>.
                    <span class="mb-0" class="text-center" style="font-size: 12px"><b>E-MAIL:</b>
                        animalhealth@agriculture.co.ug</span>
                </p>
                <p class="mb-0" class="text-center" style="font-size: 12px;"><b>TELEPHONE:</b> +256 0414 320 627,
                    320166, 320376</p>
            </td>
        </tr>
    </table>
    <hr style="background-color: black; height: 3px; margin-bottom: 0px;">
    <hr style="background-color: yellow; height: 3px; margin: 0px; padding: 0px;">
    <hr style="background-color: red; height: 3px; margin: 0px; padding: 0px;">

    <p class="text-center mt-4 mb-4" style="font-size: 20px"><b><u>{{ $m->title }}</u></b></p>



    @if ($m->type == 'officer')
        <p class="text-left mt-4 mb-1" style="font-size: 16px">EXTENSION OFFICER: <b>
                <u>{{ strtoupper($m->officer->name) }}</u></b></p>
        </p>
        <br> 
        <br>
    @endif
    {{ $m->comment }}



    <hr style="background-color: black; height: 1px; margin: 0px; padding: 0px;">

    <table class="w-100 table">
        <tr>
            <td>
                <p class="mt-3" style="font-size: 16px">FINANCIAL YEAR</p>
                <p><span class=" ">{{ $m->year->name }}</span></p>
            </td>

            <td>
                <p class="mt-3" style="font-size: 16px">TOTAL ACTIVITIES</p>
                <p><span class=" ">{{ number_format(22) }} Activities</span></p>
            </td>



            <td>
                <p class="mt-3 " style="font-size: 16px">TOTAL BUDGET</p>
                <p><span class="h5">UGX {{ number_format($data['total_budget']) }}</span></p>
            </td>
        </tr>
    </table>

    <p class="text-center mt-3 mb-3" style="font-size: 22px"><b><u>BUDGET BY QUARTERS</u></b></p>

    <table class="w-100">
        <tr>
            <td class=" w-50" style="font-size: 20px">
                <table class="table table-striped table-sm table-bordered w-100">
                    <thead class="table-dark">
                        <tr>
                            <th>QUARTER</th>
                            <th class="text-center">BUDGET</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1st Quarter</td>
                            <th>UGX <?= number_format($q1) ?></th>
                        </tr>
                        <tr>
                            <td>2nd Quarter</td>
                            <th>UGX <?= number_format($q2) ?></th>
                        </tr>
                        <tr>
                            <td>3rd Quarter</td>
                            <th>UGX <?= number_format($q3) ?></th>
                        </tr>
                        <tr>
                            <td>4th Quarter</td>
                            <th>UGX <?= number_format($q4) ?></th>
                        </tr>
                    </tbody>
                </table>
            </td>
            {{--             <td class="">
                <img style="width: 400px" class="imf-fluid" src="<?= $url ?>" alt="My Daily Activities Pie Chart" />
            </td>  --}}
        </tr>
    </table>

    <p class="text-center mt-3 mb-3 " style="font-size: 24px"><b><u>ACTIVITIES</u></b></p>

    <table class="table table-striped table-sm table-bordered w-100">
        <thead class="table-dark">
            <tr class="h6 py-1">
                <th>S/n</th>
                <th>Activity</th>
                <th>Target</th>
                @if ($m->is_entry_year)
                    <th>Planned</th>
                @else
                    <th>Reached</th>
                @endif
                <th class="text-center">Budget (UGX)</th>
            </tr>
        </thead>
        <tbody>

            <?php
            $j = 0;
            $tot = 0;
            $num_target_ben = 0;
            $num_planned = 0;
            ?>
            @foreach ($activities as $item)
                @php
                    $j++;
                    $tot += $item->budget;
                    $num_target_ben += $item->num_target_ben;
                    $num_planned += $item->num_planned;
                @endphp
                <tr>
                    <td><?= $j ?>.</td>
                    <td> <?= $item->name ?></td>
                    <td>
                        <h2 class="text-center"><?= $item->num_target_ben ?></h2>
                    </td>
                    <td>
                        <h2 class="text-center"><?= $item->num_planned ?></h2>
                    </td>
                    <td class="text-right"> <?= '<b>' . number_format($item->budget) . '</b>' ?></td>
                </tr>
            @endforeach
            <tr>
                <th colspan="2">TOTAL</th>
                <td class="text-center">{{ $num_target_ben }}</td>
                <td class="text-center">{{ $num_planned }}</td>
                <th class="text-right">{{ number_format($tot) }}</th>
            </tr>

        </tbody>
    </table>

</body>

</html>

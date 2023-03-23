<?php
$q1 = $m->getBugetByQuater(1);
$q2 = $m->getBugetByQuater(2);
$q3 = $m->getBugetByQuater(3);
$q4 = $m->getBugetByQuater(4);

$p1 = $q1 / 100000000;
$p2 = $q2 / 100000000;
$p3 = $q3 / 100000000;
$p4 = $q4 / 100000000;

$url = "https://chart.googleapis.com/chart?cht=p3&chs=400x200&chl=1st|2nd|3rd|4th&chd=t:$p1,$p2,$p3,$p4&chco=FF0000,00FF00,0000FF,FFFF00";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="<?php echo e(public_path('css/bootstrap-print.css'), false); ?>">
    <link type="text/css" href="<?php echo e(public_path('css/print.css'), false); ?>" rel="stylesheet" />

</head>

<body>

    <table style="width: 100%">
        <tr>
            <td style="width: 25%;" class="">
            </td>
            <td class="text-center" style="width: 20%;">
                <img style="width: 100px" src="<?php echo e(public_path('assets/images/coat_of_arms-min.png'), false); ?>">
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
    <hr>

    <p class="text-center mt-4 mb-4" style="font-size: 20px"><b><u>ANNUAL WORKPLAN REPORT FOR THE YEAR -
                {{ $m->name }}</u></b></p>

    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos deserunt architecto amet doloribus quas
        perspiciatis inventore adipisci quasi voluptatum quisquam. Repellat delectus saepe blanditiis, aut iure
        exercitationem laudantium? Maxime, fuga.</p>

    <table class="w-100">
        <tr>
            <td>
                <p class="mt-3" style="font-size: 16px">FINANCIAL YEAR</p>
                <p><span class=" ">{{ $m->year }}</span></p>
            </td>
            <td>
                <p class="mt-3" style="font-size: 16px">ANNUAL OUTPUTS</p>
                <p><span class=" ">{{ number_format(count($m->annual_outputs)) }} Outputs</span></p>
            </td>
            <td>
                <p class="mt-3" style="font-size: 16px">QUARTERLY ACTIVITIES</p>
                <p><span class=" ">{{ number_format(count($m->quaterly_outputs)) }} Activities</span></p>
            </td>
            <td>
                <p class="mt-3 " style="font-size: 16px">TOTAL BUDGET</p>
                <p><span class="h5">UGX {{ number_format($m->buget_text) }}</span></p>
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
            <td class="">
                <img style="width: 400px" class="imf-fluid" src="<?= $url ?>" alt="My Daily Activities Pie Chart" />
            </td>
        </tr>
    </table>

    <p class="text-center mt-3 mb-3 " style="font-size: 24px"><b><u>Quaterly Output</u></b></p>
    {{-- 
    (
 [id] => 2
 [created_at] => 2023-03-05 18:33:01
 [updated_at] => 2023-03-14 22:12:59
 [topic] => 119
 [entreprizes] => 223
 [num_planned] => 1
 [num_target_ben] => 20
 [num_carried_out] =>
 [num_reached_ben] =>
 [remarks] =>
 [lessons] =>
 [recommendations] =>
 [budget] => 225000
 [annual_id] => 1
 [quarter] => 1
 [user_id] => 160
 [key_output_id] => 182
 [activities] => 


 

        $grid->column('budget', __('Budget'))
            ->display(function ($x) {
                return '<b>UGX ' . number_format($x) . '</b>';
            })->totalRow(function ($x) {
                return '<b>UGX ' . number_format($x) . '</b>';
            })->sortable();

   
     
        $grid->column('user_id', __('Officer'))->display(function ($x) {
            if ($this->user == null) {
                return $x;
            }
            return $this->user->name;
        })->sortable();
        
    --}}


    @for ($i = 1; $i < 5; $i++)
        <?php
        $name = "$i";
        if ($i == 1) {
            $name = '1<sup>st</sup>';
        } elseif ($i == 2) {
            $name = '2<sup>nd</sup>';
        } elseif ($i == 3) {
            $name = '3<sup>rd</sup>';
        } elseif ($i == 4) {
            $name = '4<sup>th</sup>';
        }
        ?>
        <h4 class="h3 py-1 text-center"><?= $name ?> Quarter - <?= $m->year ?></h4>
        <table class="table table-striped table-sm table-bordered w-100">
            <thead class="table-dark">
                <tr class="h6 py-1">
                    <th>S/n</th>
                    <th>Topic</th>
                    <th>No. Planned</th>
                    <th>No. Reached</th>
                    <th>Officer</th>
                    <th class="text-center">Budget (UGX)</th>
                </tr>
            </thead>
            <tbody>

                <?php $j = 0; ?>
                @foreach ($m->getQuaterlyActivities($i) as $item)
                    @php
                        
                        if ($j > 20) {
                            break;
                        }
                        if (strlen($item->topic) < 10) {
                            continue;
                        }
                        $j++;
                    @endphp
                    <tr>
                        <td><?= $j ?>.</td>
                        <td> <?= $item->topic ?></td>
                        <td>
                            <h2 class="text-center"><?= $item->num_planned ?></h2>
                        </td>
                        <td>
                            <h2 class="text-center"><?= (int) $item->num_reached_ben ?></h2>
                        </td>
                        <td class="text-left"> <?php if ($item->user == null) {
                            echo $item->user_id;
                        } else {
                            echo $item->user->name;
                        } ?></td>
                        <td class="text-right"> <?= '<b>' . number_format($item->budget) . '</b>' ?></td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    @endfor


</body>

</html>
<?php /**PATH C:\xampp\htdocs\extension\admin\resources\views/reports/report-annual-workplans-print.blade.php ENDPATH**/ ?>

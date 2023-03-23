<?php
use App\Models\Location;

$sub = Location::find($m->sub_county_from);
$sub_county_from = '-';
if ($sub != null) {
    $sub_county_from = $sub->name . " ($sub->code)";
    if ($sub->district != null) {
        $district_from = $sub->district->name;
    }
}
$sub = Location::find($m->sub_county_to);
$sub_county_to = '-';
if ($sub != null) {
    $sub_county_to = $sub->name . " ($sub->code)";
    if ($sub->district != null) {
        $district_to = $sub->district->name;
    }
}
$district_to = '-';
$sub = Location::find($m->sub_county_to);
$sub_county_to = '-';

if ($sub != null) {
    $sub_county_to = $sub->name . " ($sub->code)";
    if ($sub->district != null) {
        $district_to = $sub->district->name;
    }
}

$district_from = '-';

$d = Location::find($m->district_to);
$district_to = '-';

$sub = Location::find($m->sub_county_from);
$sub_county_from = '-';
if ($sub != null) {
    $sub_county_from = $sub->name . " ($sub->code)";
    if ($sub->district != null) {
        $district_from = $sub->district->name;
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="{{ public_path('css/bootstrap-print.css') }}">
    <link type="text/css" href="{{ public_path('css/print.css') }}" rel="stylesheet" />

</head>

<body>

    <table style="width: 100%">
        <tr>
            <td colspan="3" class="text-center">
                <p class="text-center" style="font-size: 18px"><b>MINISTRY OF AGRICULTURE, ANIMAL INDUSTRY AND
                        FISHERIES.</b></p>
                <p class="mb-1" class="text-center" style="font-size: 18px"><b>DEPARTMENT OF ANIMAL HEALTH</b></p>
                <p class="mb-0" class="text-center" style="font-size: 12px"><b>P.O. Box 513, ENTEBBE, UGANDA</b></p>
                <p class="mb-0" class="text-center" style="font-size: 12px"><b>E-MAIL:</b>
                    animalhealth@agriculture.co.ug</p>
                <p class="mb-0" class="text-center" style="font-size: 12px;"><b>TELEPHONE:</b> +256 0414 320 627,
                    320166, 320376</p>
            </td>
        </tr>
    </table>
</body>

</html>

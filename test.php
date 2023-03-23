<?php

// Sample data for the pie chart
$data = array(
  ['Task', 'Hours per Day'],
  ['Work',     11],
  ['Eat',      2],
  ['Commute',  2],
  ['Watch TV', 2],
  ['Sleep',    7]
);

// Encode the data in JSON format
$json_data = json_encode($data);

// Set the chart options
$options = array(
    'title' => 'My Daily Activities',
    'pieHole' => 0.4,
);

// Encode the options in JSON format
$json_options = json_encode($options);

// Set the chart URL
$url = 'https://chart.googleapis.com/chart?cht=p&chs=500x250&chl=Work|Eat|Sleep|TV|Exercise&chd=t:11,2,7,4,2';

// Generate the chart HTML
echo '<img src="' . $url . '" alt="My Daily Activities Pie Chart" />';

?>

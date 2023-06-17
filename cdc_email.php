<?php

$url = 'https://data.cdc.gov/resource/akn2-qxic.json?state=Florida&county=Alachua%20County&$order=report_date%20DESC&$limit=1';
$to_addresses=$argv[1];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$output = curl_exec($ch);
curl_close($ch);

$decoded = json_decode($output, null, 512, JSON_THROW_ON_ERROR);
if (!$decoded) {
	echo 'Failed to fetch/decode CDC result.';
	exit(1);
}
$latest_result = $decoded[0];

$message = <<<EOT
Hi,

The current COVID-19 hospital admission level for Alachua County is: $latest_result->total_adm_all_covid_confirmed_level.

It was last updated on: $latest_result->report_date.

<3,
David's Script
EOT;

mail($to_addresses, 'Current COVID-19 Level', $message);


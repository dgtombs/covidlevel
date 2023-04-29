<?php

$url = 'https://data.cdc.gov/resource/3nnm-4jni.json?state=Florida&county=Alachua%20County&$order=date_updated%20DESC&$limit=1';
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

The current CDC community level for Alachua County is: $latest_result->covid_19_community_level.

It was last updated on: $latest_result->date_updated.

<3,
David's Script
EOT;

mail($to_addresses, 'Current Community Level', $message);


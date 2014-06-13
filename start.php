<?php

include('Parser.php');
include('File.php');
include('Analyzer.php');

if($argc < 2)die("You need to specify the name of the file to parse.\n");

$file = new File($argv[1]);
$fileContent = $file->read();

$parser = new Parser();
if(!$parser->parse($fileContent, $data))die("The file is not valid.\n");

$analyzer = new Analyzer($parser);

$onlyRealCustomers = $analyzer->filterBots($data);
$orderByPage = $analyzer->orderByPage($onlyRealCustomers);

print_r($orderByPage);
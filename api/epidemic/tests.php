<?php

include_once '../source.php';

if (($handle = fopen($epidemicTotalTestsUrl, "r")) !== FALSE) {
    $csvs = [];
    while(! feof($handle)) {
       $csvs[] = fgetcsv($handle);
    }
    $testData = array();
    foreach ($csvs as $key => $csv) {
        if ($key === 0) {
            continue;
        }
        $testDataItem = array(
            "date" => $csv[0],
            "rtk-ag" => $csv[1],
            "rt-pcr" => $csv[2],
            "total" => $csv[1] + $csv[2]
        );
        // Push the data item into the test data
        array_push($testData, $testDataItem);
    }
    $json = json_encode($testData);
    fclose($handle);
    print_r($json);
}

?>
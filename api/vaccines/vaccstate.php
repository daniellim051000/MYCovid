<?php

include_once '../source.php';

if (($handle = fopen($vaccineStateUrl, "r")) !== FALSE) {
    $csvs = [];
    while(! feof($handle)) {
       $csvs[] = fgetcsv($handle);
    }
    foreach ($csvs[0] as $single_csv) {
        $column_names[] = $single_csv;
    }
    $masterData = array();
    foreach ($csvs as $key => $csv) {
        if ($key === 0) continue;
        if ($key % 16 === 1) {
            // Create a new array for stateData on a new date
            $stateMasterData = array();
        }
        foreach ($column_names as $column_key => $column_name) {
            if ($column_key === 0) continue;
            $stateDataItem[$column_name] = $csv[$column_key];
        }
        array_push($stateMasterData, $stateDataItem);
        if ($key % 16 === 0) {
            // Add the date entry into the master data
            $dateDataItem = array(
                "date" => $csv[0],
                "data" => $stateMasterData
            );
            // Push the data item into the master data
            array_push($masterData, $dateDataItem);
        }
    }
    $json = json_encode($masterData);
    fclose($handle);
    print_r($json);
}

?>
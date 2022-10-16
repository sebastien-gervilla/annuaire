<?php

function filterArrayList(array $list, string $key) {
    return array_map(function(array $array) use($key) { 
        return $array[$key]; 
    }, $list);
}

function splitArrayByKeys(array $array, array $keys): array {
    $firstArray = array();
    $secondArray = array();
    foreach ($array as $key => $value)
        in_array($key, $keys) ?
            $secondArray += [$key => $value] :
            $firstArray += [$key => $value];

    return array(
        "first" => $firstArray,
        "second" => $secondArray
    );
}

function groupRowsById(array $table): array {
    $newTable = array();
    foreach ($table as $row) {
        $id = strval($row['_id']);
        array_key_exists($id, $newTable) ?
            array_push($newTable[$id], $row) :
            $newTable += [$id => [$row]];
    }
    return $newTable;
}

function groupRowsByKeys(array|null $table, array $keys) {
    if (!$table && count($table) <= 0) return $table;

    $newTable = groupRowsById($table);
    foreach ($newTable as $strId => $rows) {
        $singleRow = $rows[0];
        foreach ($keys as $key) {
            $singleRow[$key] = [];
            foreach ($rows as $row)
                if ($row[$key] && !in_array($row[$key], $singleRow[$key]))
                    array_push($singleRow[$key], $row[$key]);
        }

        $newTable[$strId] = $singleRow;
    }

    return array_values($newTable);
}
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
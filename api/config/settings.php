<?php

function getSettings(string $env = 'developpement')
{
    $settingsJson = file_get_contents(__DIR__ . './settings.json');
    $settings = json_decode($settingsJson, true);
    $envSettings = $settings[$env];
    return $envSettings;
}

function getRouteEndpoints(string $url)
{
    $routesURL = getSettings()['routesURL'];
    $endpoints = str_replace($routesURL, '', $url);
    return $endpoints;
}
<?php

function getSettings(string $env = 'developpement')
{
    $settingsJson = file_get_contents(__DIR__ . './settings.json');
    $settings = json_decode($settingsJson, true);
    $envSettings = $settings[$env];
    return $envSettings;
}
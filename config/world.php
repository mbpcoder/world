<?php

return [
    'table_name' => 'locations',
    'data_url' => 'https://github.com/dr5hn/countries-states-cities-database/releases/latest/download/countries+states+cities.json',
    'cache' => [
        'enabled' => true,
        'prefix' => 'thecoder-world-',
        'tag' => 'thecoder-world',
        'ttl' => null,  // Cache forever
    ],
];
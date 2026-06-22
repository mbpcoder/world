<?php

return [
    'table_name' => 'locations',
    'data_url' => 'https://raw.githubusercontent.com/dr5hn/countries-states-cities-database/master/json/countries+states+cities.json',
    'cache' => [
        'enabled' => true,
        'prefix' => 'thecoder-world-',
        'tag' => 'thecoder-world',
        'ttl' => null,  // Cache forever
    ],
];
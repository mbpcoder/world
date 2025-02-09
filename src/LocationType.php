<?php

namespace TheCoder\World;

enum LocationType: string
{
    case CONTINENT = 'continent';
    case COUNTRY = 'country';
    case REGION = 'region';
    case PROVINCE = 'province';
    case CITY = 'city';
}
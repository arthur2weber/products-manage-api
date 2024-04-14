<?php

namespace App\Enums;

enum CacheTtlEnum: int
{
    case TTL_1_MINUTE = 60;
    case TTL_15_MINUTES = 900;
    case TTL_30_MINUTES = 1800;
    case TTL_1_HOUR = 3600;
    case TTL_6_HOURS = 21600;
    case TTL_12_HOURS = 43200;
    case TTL_1_DAY = 86400;
    case TTL_1_WEEK = 604800;
    case TTL_1_MONTH = 2592000;
    case TTL_3_MONTHS = 7776000;
    /**
     * Default: 1 year
     */
    case TTL_MAX = 31536000;
}

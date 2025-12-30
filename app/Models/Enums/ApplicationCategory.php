<?php

namespace App\Models\Enums;

enum ApplicationCategory: string
{
    case Business = 'business';
    case Support  = 'support';
    case Data     = 'data';
    case Network  = 'network';
    case Hosting  = 'hosting';
    case Security = 'security';
    case Other    = 'other';
}
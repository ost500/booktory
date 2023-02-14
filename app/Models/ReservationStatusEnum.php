<?php

namespace App\Models;

enum ReservationStatusEnum: string
{
    case Pending = 'pending';
    case Active = 'active';
    case Rejected = 'rejected';
}

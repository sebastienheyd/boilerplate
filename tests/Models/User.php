<?php

namespace Sebastienheyd\Boilerplate\Tests\Models;

use Sebastienheyd\Boilerplate\Models\User as BaseUser;

class User extends BaseUser
{
    public function scopeFirstLastName($query, $q)
    {
        $query->selectRaw('id as select2_id, first_name || " " || last_name as select2_text')
            ->where('first_name', 'like', "$q%")
            ->orWhere('last_name', 'like', "$q%")
            ->orderBy('select2_text', 'desc');
    }
}

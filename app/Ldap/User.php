<?php

namespace App\Ldap;

use LdapRecord\Models\Model;
use App\Ldap\Scopes\OnlySiege;

class User extends Model
{
    /**
     * The object classes of the LDAP model.
     *
     * @var array
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new OnlySiege);
    } 
    public static $objectClasses = [
        'top',
        'name',
        'person',
        'organizationalperson',
        'user',
    ];
}

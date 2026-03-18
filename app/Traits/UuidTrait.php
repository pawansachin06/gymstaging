<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

trait UuidTrait
{
    use HasUuids;

    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }

    public function newUniqueId()
    {
        return (string) Str::uuid7()->toString();
    }

    public function uniqueIds()
    {
        return [$this->getKeyName()]; // defaults to 'id'
    }
}

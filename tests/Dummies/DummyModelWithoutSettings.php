<?php

namespace Tests\Dummies;

use MwakalingaJohn\LaraSettings\HasConfig;
use Illuminate\Database\Eloquent\Model;

class DummyModelWithoutSettings extends Model
{
    protected $table = 'users';
}

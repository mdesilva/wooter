<?php

namespace Wooter;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    const ENGLISH = 1;
    const SPANISH = 2;
    const RUSSIAN = 3;
    const ROMANIAN = 4;

    const ENGLISH_NAME = 'English';
    const SPANISH_NAME = 'Spanish';
    const RUSSIAN_NAME = 'Russian';
    const ROMANIAN_NAME = 'Romanian';

    const ENGLISH_NAME_LOCATED = 'languages.english';
    const SPANISH_NAME_LOCATED = 'languages.spanish';
    const RUSSIAN_NAME_LOCATED = 'languages.russian';
    const ROMANIAN_NAME_LOCATED = 'languages.romanian';

    protected $table = 'languages';
}

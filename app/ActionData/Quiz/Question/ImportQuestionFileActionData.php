<?php

namespace App\ActionData\Quiz\Question;

use Akbarali\ActionData\ActionDataBase;
use Illuminate\Http\UploadedFile;

class ImportQuestionFileActionData extends ActionDataBase
{

    public ?int $type;
    public ?string $lang;
    public UploadedFile $file;

    protected array $rules = [
        'type' => 'required|int|in:1,2,3',
        'file' => 'required|file',
        'lang' => 'required|in:uz,ru'
    ];
}

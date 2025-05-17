<?php

namespace App\Services;

use App\Enums\NoteTypeEnum;
use App\Models\Visit;

class NoteService extends Service
{

    public function createForVisit(Visit $visit, $data)
    {
         $visit = Visit::findOrFail($data['visit_id']);

        return $visit->notes()->create([
            'user_id' => $data['user_id'],
            'content' => $data['content'],
            'type'    => $data['type'] ??  NoteTypeEnum::INSTRUCTION->value,

        ]);
    }
}

<?php

namespace Modules\Setting\Http\Resources\Fq;

use Illuminate\Http\Resources\Json\JsonResource;

class FqResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'question' => $this->question,
            'answer' => $this->answer,
        ];
    }
}

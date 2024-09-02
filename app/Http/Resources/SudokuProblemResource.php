<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SudokuProblemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'problem' => $this->problem,
            'unique_hash' => $this->unique_hash,
            'max_value' => $this->max_value,
            'date' => $this->date,
        ];
    }
}

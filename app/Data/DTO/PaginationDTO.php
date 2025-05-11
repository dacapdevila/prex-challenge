<?php

namespace App\Data\DTO;

use JsonSerializable;

final readonly class PaginationDTO implements JsonSerializable
{
    public function __construct(
        public int $total,
        public int $count,
        public int $offset,
    ) {}

    public function jsonSerialize(): array
    {
        return [
            'total_count' => $this->total,
            'count' => $this->count,
            'offset' => $this->offset,
        ];
    }
}

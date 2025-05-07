<?php

namespace App\Data\DTO;

final readonly class PaginationDTO
{
    public function __construct(
        public int $total,
        public int $count,
        public int $offset,
    ) {}

    public function jsonSerialize(): array
    {
        return [
            'total_count' => $this->total_count,
            'count' => $this->count,
            'offset' => $this->offset,
        ];
    }
}

<?php

namespace App\Data\DTO;

final readonly class GifDTO
{
    public function __construct(
        public string $id,
        public string $url,
        public string $title,
        public string $preview
    ) {}

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'url' => $this->url,
            'title' => $this->title,
            'preview' => $this->preview,
        ];
    }
}

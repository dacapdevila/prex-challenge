<?php

namespace App\Data\DTO;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use JsonSerializable;
use Symfony\Component\HttpFoundation\Response;

final readonly class GifDTO implements JsonSerializable, Responsable
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

    public function toResponse($request): JsonResponse|Response
    {
        return response()->json($this->jsonSerialize());
    }
}

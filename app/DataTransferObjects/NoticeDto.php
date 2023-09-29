<?php

namespace App\DataTransferObjects;

use Illuminate\Http\Request;

class NoticeDto
{
    public function __construct(
        public string $title,
        public string $content
    )
    {

    }

    public function fromRequest(Request $request)
    {
        return new self(
            title: $request->validated('title'),
            content: $request->validated('content')
        );
    }

}

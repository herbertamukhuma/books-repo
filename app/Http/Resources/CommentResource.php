<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $book_isbn
 * @property mixed $id
 * @property mixed $comment_text
 * @property mixed $commenter_ip
 * @property mixed $created_at
 */
class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'type' => 'Comment',
            'attributes' => [
                'book_isbn' => $this->book_isbn,
                'comment_text' => substr($this->comment_text,0,500),
                'commenter_ip' => $this->commenter_ip,
                'created_at' => gmdate('d/m/Y H:i', strtotime($this->created_at))
            ]
        ];
    }
}

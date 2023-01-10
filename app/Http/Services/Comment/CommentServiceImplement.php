<?php

namespace App\Http\Services\Comment;

use LaravelEasyRepository\Service;
use App\Http\Repositories\Comment\CommentRepository;

class CommentServiceImplement extends Service implements CommentService
{

    /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
    protected $mainRepository;

    public function __construct(CommentRepository $mainRepository)
    {
        $this->mainRepository = $mainRepository;
    }

    public function create($data)
    {
        $data['user_id'] = auth()->user()->id;
        return $this->mainRepository->create($data);
    }
}

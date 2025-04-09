<?php

namespace App\Services;

use App\Helpers\Api;
use App\Interfaces\CommentInterface;
use App\Http\Resources\CommentResource;
use Symfony\Component\HttpFoundation\Response;

class CommentService{
    private CommentInterface $commentRepository;

    public function __construct(CommentInterface $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function create(array $data)
    {
        return $this->commentRepository->create($data);
    }

    public function delete(int $id)
    {
        $this->commentRepository->delete($id);
    }

    public function deleteByPost(int $id)
    {
        $this->commentRepository->deleteByPost($id);
    }

    public function update(int $id,array $data)
    {
        return $this->commentRepository->update($id, $data);
    }

    // API
    public function createCommentApi(array $data)
    {
        $data = $this->commentRepository->create($data);
        return Api::response(
            CommentResource::make($data), 
            'Comment created successfully', 
            Response::HTTP_CREATED);
    }
    
    public function updateCommentApi(int $id, array $data)
    {
        $data = $this->commentRepository->update($id, $data);
        return Api::response(
            CommentResource::make($data), 
            'Comment updated successfully', 
        );
    }

    public function deleteCommentApi(int $id)
    {
        $this->commentRepository->delete($id);
        return Api::response(
            null,
            'Comment deleted successfully',
            Response::HTTP_NO_CONTENT);
    }
}
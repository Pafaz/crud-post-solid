<?php

namespace App\Services;

use App\Helpers\ApiResponse;
use Illuminate\Support\Facades\Log;
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
        try {
            $data = $this->commentRepository->create($data);
            return $data;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw $e;
        }
    }

    public function delete(int $id)
    {
        try {
            $this->commentRepository->delete($id);
            
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            throw $th;
        }
    }

    public function deleteByPost(int $id)
    {
        try {
            $this->commentRepository->deleteByPost($id);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            throw $th;
        }
    }

    public function update(int $id,array $data)
    {
        try {
            $comment = $this->commentRepository->update($id,$data);
            return $comment;
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            throw $th;
        }
    }

    // API
    public function createCommentApi(array $data)
    {
        try {
            $data = $this->commentRepository->create($data);
            return ApiResponse::success(CommentResource::make($data), 'Comment created successfully', Response::HTTP_CREATED);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error('Ups! Something went wrong', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    
    public function updateCommentApi(int $id, array $data)
    {
        try {
            $this->commentRepository->update($id, $data);
            $comment = $this->commentRepository->find($id);
            if (!$comment){
                return ApiResponse::error('Ups! Comment Not Found', Response::HTTP_NOT_FOUND);
            }
            return ApiResponse::success(CommentResource::make($comment), 'Comment updated successfully', Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error('Ups! Something went wrong', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function deleteCommentApi(int $id)
    {
        try {
            $comment = $this->commentRepository->find($id);
            if (!$comment){
                return ApiResponse::error('Ups! Comment Not Found', Response::HTTP_NOT_FOUND);
            }
            $this->commentRepository->delete($id);
            return ApiResponse::success(null, 'Comment deleted successfully', Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error('Ups! Something went wrong', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
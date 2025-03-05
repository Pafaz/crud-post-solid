<?php

namespace App\Services;

use App\Interfaces\CommentInterface;
use Illuminate\Support\Facades\Log;
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
            return [
                'status' => 'success',
                'statusCode' => Response::HTTP_CREATED,
                'message' => 'Comment created successfully',
                'data' => $data,
            ];
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return[
                'status' => 'error',
                'statusCode' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Something went wrong',
                'data' => [],
            ];
        }
    }

    public function delete(int $id)
    {
        try {
            $this->commentRepository->delete($id);
            return [
                'status' => 'success',
                'statusCode' => Response::HTTP_OK,
                'message' => 'Comment deleted successfully',
            ];
        } catch (\Throwable $th) {
            //throw $th;
            Log::error($th->getMessage());
            return [
                'status' => 'error',
                'statusCode' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Something went wrong',
            ];
        }
    }

    public function deleteByPost(int $id)
    {
        try {
            $this->commentRepository->deleteByPost($id);
            return [
                'status' => 'success',
                'statusCode' => Response::HTTP_OK,
                'message' => 'Comment deleted successfully',
            ];
        } catch (\Throwable $th) {
            //throw $th;
            Log::error($th->getMessage());
            return [
                'status' => 'error',
                'statusCode' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Something went wrong',
            ];
        }
    }

    public function update(int $id,array $data)
    {
        try {
            $this->commentRepository->update($id,$data);
            return [
                'status' => 'success',
                'statusCode' => Response::HTTP_OK,
                'message' => 'Comment updated successfully',
            ];
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return [
                'status' => 'error',
                'statusCode' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Something went wrong',
            ];
        }
    }
}
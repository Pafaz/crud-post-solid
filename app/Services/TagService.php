<?php

namespace App\Services;

use App\Interfaces\TagInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\HttpFoundation\Response;

class TagService {

    protected TagInterface $tagRepository;

    public function __construct(TagInterface $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    public function getTags()
    {
        try {
            $data = $this->tagRepository->getAll();
            return [
                'status' => 'success',
                'statusCode' => Response::HTTP_OK,
                'message' => 'Tags retrieved successfully',
                'data' => $data,
            ];
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return [
                'status' => 'error',
                'statusCode' => Response::HTTP_NOT_FOUND,
                'message' => 'Tags Not Found',
                'data' => [],
            ];
        }
    }

    public function createTag(array $data)
    {
        try {
            $data = $this->tagRepository->create($data);
            return [
                'status' => 'success',
                'statusCode' => Response::HTTP_CREATED,
                'message' => 'Tag created successfully',
                'data' => $data,
            ];
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return [
                'status' => 'error',
                'statusCode' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Something went wrong',
                'data' => [],
            ];
        }
    }

    public function deleteTag(int $id)
    {
        try {
            $this->tagRepository->delete($id);
            return [
                'status' => 'success',
                'statusCode' => Response::HTTP_OK,
                'message' => 'Tag deleted successfully',
            ];
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return [
                'status' => 'error',
                'statusCode' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Something went wrong',
            ];
        }
    }
}
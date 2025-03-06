<?php

namespace App\Services;

use App\Helpers\ApiResponse;
use App\Http\Resources\TagResource;
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
        return $this->tagRepository->getAll();
    }

    public function createTag(array $data)
    {
        return $this->tagRepository->create($data);
    }

    public function deleteTag(int $id)
    {
        return $this->tagRepository->delete($id);
    }

    //Api
    public function getTagsApi()
    {
        try {
            $data = $this->tagRepository->getAll();
            return ApiResponse::success(TagResource::collection($data), 'Tags retrieved successfully', Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error('Ups! Tags Not Found', Response::HTTP_NOT_FOUND);
        }
    }

    public function createTagApi(array $data)
    {
        try {
            $data = $this->tagRepository->create($data);
            return ApiResponse::success(TagResource::make($data), 'Tag created successfully', Response::HTTP_CREATED);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error('Ups! Something went wrong', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    
    public function deleteTagApi(int $id)
    {
        try {
            $data = $this->tagRepository->find($id);
            if (!$data) {
                return ApiResponse::error('Ups! Tag Not Found', Response::HTTP_NOT_FOUND);
            }
            $this->tagRepository->delete($id);
            return ApiResponse::success(null, 'Tag deleted successfully', Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error('Ups! Something went wrong', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
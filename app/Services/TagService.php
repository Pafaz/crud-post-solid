<?php

namespace App\Services;

use App\Helpers\Api;
use App\Interfaces\TagInterface;
use App\Http\Resources\TagResource;
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
        $data = $this->tagRepository->getAll();
        return Api::response(
            TagResource::collection($data), 
            'Tags retrieved successfully', 
        );
    }

    public function createTagApi(array $data)
    {
        $data = $this->tagRepository->create($data);
        return Api::response(
            TagResource::make($data), 
            'Tag created successfully', 
            Response::HTTP_CREATED);
    }
    
    public function deleteTagApi(int $id)
    {
        $this->tagRepository->delete($id);
        return Api::response(
            null, 
            'Tag deleted successfully', 
        );
    }
}
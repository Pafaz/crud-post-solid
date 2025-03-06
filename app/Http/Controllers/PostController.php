<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Services\CategoryService;
use App\Services\PostService;
use App\Services\TagService;

class PostController extends Controller
{
    private $postService;
    private $categoryService;
    private $tagService;

    public function __construct(
        PostService $postService, 
        CategoryService $categoryService, 
        TagService $tagService)
    {
        $this->postService = $postService;
        $this->categoryService = $categoryService;
        $this->tagService = $tagService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        return view('post.index', [
            'posts' => $this->postService->getPosts(request('category')),
            'categories' => $this->categoryService->getCategories()['data'],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('post.create', [
            'categories' => $this->categoryService->getCategories()['data'], 
            'tags'=> $this->tagService->getTags()['data']
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {   
        $this->postService->create($request->validated());
        return redirect()->route('posts.index')->with('success', 'Post created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('post.detail', [
            'post' => $this->postService->getPost($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('post.edit',$this->postService->getEditData($id))
        ->with('success', 'Post updated successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, string $id)
    {
        // dd($request->all());
        $this->postService->update($id, $request->validated());
        return redirect()->route('posts.show', $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        $this->postService->delete($id);
        return redirect()->route('posts.index')->with('success', 'Post deleted successfully');
    }
}

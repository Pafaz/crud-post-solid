<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Services\CategoryService;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request,  CategoryService $categoryService)
    {
        $categoryService->create($request->validated());
        return redirect()->back()->with('success', 'Category created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show( $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request,  $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $category)
    {
        //
    }
}

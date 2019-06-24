<?php

namespace App\Controller;

require_once __DIR__ . '/../model/Category.php';

use App\Model\Category;
use System\Request;

class CategoryController extends Controller
{

    public function store(Request $request)
    {
        // Only high level users can create categories
        $category = new Category();
        $category->fill($request->all());
        $category->save();
        // Redirecting to create a new category
        redirect('category/create');
    }

    public function create()
    {
        view('categories.edit');
    }

    public function edit(Request $request)
    {
        $category = Category::find($request->get_args()[0]);
        view('categories.edit', compact('category'));
    }

    public function update(Request $request)
    {
        if ($category = Category::find($request->get_args()[0])) {
            $category->fill($request->all());
            $category->save();
            redirect("category/$category->id/edit");
        } else redirect('category/list');
    }

    public function index()
    {
        $categories = Category::paginate(600, 0);
        view('categories.list', compact('categories'));
    }
}
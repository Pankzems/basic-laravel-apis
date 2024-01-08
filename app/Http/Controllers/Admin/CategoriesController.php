<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Requests\MassDestroyDressRequest;
use Freshbitsweb\Laratables\Laratables;
use App\Category;

class CategoriesController extends Controller
{
    public function index()
    {
        abort_unless(\Gate::allows('category_access'), 403);

       return view('admin.categories.index');
    }

    public function list()
    {
        return Laratables::recordsOf(Category::class);
    }

    public function create()
    {
        abort_unless(\Gate::allows('category_create'), 403);

        return view('admin.categories.create');
    }  

    public function store(StoreCategoryRequest $request)
    {
        abort_unless(\Gate::allows('category_create'), 403);

        $category = Category::create($request->all());

        return redirect()->route('admin.categories.index');
    }

    public function edit(Category $category)
    {
        abort_unless(\Gate::allows('category_edit'), 403);

        return view('admin.categories.edit', compact('category'));
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        abort_unless(\Gate::allows('category_edit'), 403);

        $category->update($request->all());

        return redirect()->route('admin.categories.index');
    }

    public function show(Category $category)
    {
        abort_unless(\Gate::allows('category_show'), 403);

        return view('admin.categories.show', compact('category'));
    }

    public function destroy(Category $category)
    {
        abort_unless(\Gate::allows('category_delete'), 403);

        $category->delete();

        return back();
    }

    public function massDestroy(MassDestroyDressRequest $request)
    {
        Category::whereIn('id', request('ids'))->delete();

        return response(null, 204);
    }

    public function getCustomColumnDatatablesData()
    {
        return Laratables::recordsOf(Category::class);
    }
}

<?php

namespace App\Http\Controllers;

use App\Enum\HelperAccent;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Insert Category
     *
     * @param Request $request
     */
    public function store(Request $request)
    {
        try {
            $request->validate(['name' => 'required|regex:/^([a-zA-Z0-9'.HelperAccent::ACCENT_LETTERS.']+)(\s[a-zA-Z0-9'.HelperAccent::ACCENT_LETTERS.']+)*$/|unique:products,name,NULL,id,deleted_at,NULL',]);

            $category = new Category();
            $category->name = $request->name;
            $category->save();

            return redirect()->route('home')->with('success', 'Catégorie créée avec succès');

        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }

    /**
     * Create category
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create() {

        return view('Category.createCategory');
    }

    /**
     * Remove the specified category from storage.
     *
     * @param string $categoryId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(string $categoryId)
    {
        $category = Category::findById($categoryId);
        if (empty($category)) {

            return redirect()->back()->with('error', 'Aucune catégorie n\'a été trouvée');
        }

        foreach ($category->products()->get() as $product) {
            $product->delete();
        }

        $category->delete();

        return redirect()->route('home');
    }

}

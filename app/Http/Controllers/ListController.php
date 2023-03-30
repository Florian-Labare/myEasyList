<?php

namespace App\Http\Controllers;

use App\Enum\HelperAccent;
use App\Models\Category;
use App\Models\Product;
use App\Models\ShoppingList;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ListController extends Controller
{
    /**
     * Store a newly created list in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|regex:/^([a-zA-Z0-9'.HelperAccent::ACCENT_LETTERS.']+)(\s[a-zA-Z0-9'.HelperAccent::ACCENT_LETTERS.']+)*$/',
        ]);

        $list = new ShoppingList();
        $list->title = $request->title;
        $list->save();

        return redirect()->route('home')->with('success', 'la liste '.$list->title.' a bien été créée');

    }

    /**
     * Create the list.
     */
    public function create()
    {
        return view('List.createList');
    }

    /**
     * Display the specified List.
     */
    public function show(int $listId)
    {
        $list = ShoppingList::findById($listId);
        if(empty($list)) {

            return redirect()->back()->with('error', 'Aucune liste n\'a été trouvée');
        }
        $triProductsByCategory = [];
        $categories = Category::all();
        $productsName = @$list->products_data;

        if(empty($productsName)) {

            return view('List.list', [
                'list' => $list,
            ]);
        }

        foreach ($categories as $category) {
            $productsNamesByCategory = $category->products()->pluck('name')->toArray();
            foreach ($productsName as $productName) {
                if(in_array($productName, $productsNamesByCategory)) {
                    $objProduct = Product::findByName($productName);
                    $triProductsByCategory[$category->id]['category_name'] = $category->name;
                    $triProductsByCategory[$category->id]['products'][] = $objProduct;
                }
            }
        }

        return view('List.list', [
            'list' => $list,
            'triProductsByCategory' => $triProductsByCategory
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $listId)
    {
        $list = ShoppingList::findById($listId);
        if(empty($list)) {

            return redirect()->back()->with('error', 'Aucune liste n\'a été trouvée');
        }

        $list->updateItem($request->title);

        return redirect()->route('home')->with('success', 'La liste '.$list->title.' a bien été modifiée');

    }

    /**
     * @param int $listId
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(int $listId) {
        $list = ShoppingList::findById($listId);

        return view('List.editList', ['list' => $list]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $listId)
    {
        $list = ShoppingList::findById($listId);
        if(empty($list)) {

            return redirect()->back()->with('error', 'Aucune liste n\'a été trouvée');
        }

        $list->delete();

        return redirect()->route('home')->with('success', 'La liste a bien été supprimée');
    }

    /**
     * @param Request $request
     * @param int $listId
     * @return \Illuminate\Http\JsonResponse
     */
    public function addProductsTolist(Request $request, int $listId) : JsonResponse
    {
        $list = ShoppingList::findById($listId);
        if(empty($list)) {

            return response()->json('aucune liste trouvée', 404);
        }

        $list->products_data = $request->products;
        $list->save();

        return response()->json(['list' => $list, 'success' => 'Produits bien ajoutés à la liste']);
    }

    /**
     * @param Request $request
     * @param int $listId
     * @return \Illuminate\Http\JsonResponse
     */
    public function mergeProductsToList(Request $request, int $listId) : JsonResponse
    {
        $list = ShoppingList::findById($listId);
        if(empty($list)) {

            return response()->json('aucune liste trouvée', 404);
        }
         $existingData = (array) $list->products_data;
         $mergeData = (array) $request->products;

        if(!is_array($existingData) && !is_array($mergeData)) {

            return response()->json('impossible d\'ajouter les produits', 500);
        }

        $data = array_merge($existingData, $mergeData);
        $list->products_data = array_unique($data, SORT_REGULAR);
        $list->save();

        return response()->json(['list' => $list, 'success' => 'Produits bien ajoutés à la liste']);
    }
}

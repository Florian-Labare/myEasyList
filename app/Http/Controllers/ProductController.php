<?php

namespace App\Http\Controllers;

use App\Enum\HelperAccent;
use App\Enum\ProductStatus;
use App\Models\Category;
use App\Models\Product;
use App\Models\ShoppingList;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use function response;

class ProductController extends Controller
{
    /**
     * List products by category
     *
     * @param int $categoryId
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function productsByCategory( int $categoryId, int $numPage = 1 )
    {
        $category = Category::findById($categoryId);

        if (empty($category)) {

            return redirect()->back()->with('error', 'Aucune catégorie n\'a été trouvée');
        }

        $products = $category->products()->paginate(5);

        return view('Product.product', [
            'category'   => $category,
            'products'   => $products,
        ]);
    }

    /**
     * Store a newly created product in storage.
     *
     * @param Request $request
     * @param integer|null $categoryId
     */
    public function store(Request $request, int $categoryId = null)
    {
        $product =  null;
        if (empty($categoryId)) {
            $request->validate([
                'products.*' => 'required|string|distinct|min:3|regex:/^([a-zA-Z0-9'.HelperAccent::ACCENT_LETTERS.']+)(\s[a-zA-Z0-9'.HelperAccent::ACCENT_LETTERS.']+)*$/|unique:products,name,NULL,id,deleted_at,NULL',
                'category' => 'required|exists:categories,id',
            ]);
        } else {
            $request->validate([
                'products.*' => 'required|string|distinct|regex:/^([a-zA-Z0-9'.HelperAccent::ACCENT_LETTERS.']+)(\s[a-zA-Z0-9'.HelperAccent::ACCENT_LETTERS.']+)*$/|unique:products,name,NULL,id,deleted_at,NULL',
            ]);
        }

        foreach ($request->products as $productName) {
            $product = new Product;
            $product->name = $productName;
            $product->category_id = !empty($categoryId) ? $categoryId : $request->category;
            $product->begin_date  = Carbon::today();
            $product->save();
        }

        return redirect()->route('products.category', [
            'categoryId' => $product->category_id
        ])->with('success', 'product created with success');

    }

    /**
     * create product out of category and associate it or create product in category
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create(int $categoryId = null)
    {
        $category = null;
        if (!empty($categoryId)) {

            //to determine the category's product
            $category =  Category::findById($categoryId);
        }

        // to associate category at the product
        $categories = Category::all();

        return view('Product.createProduct', ['categories' => $categories,
            'category' => $category
        ]);
    }

    /**
     * Edit product
     *
     * @param Request $request
     * @param int $categoryId
     * @param int $productId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, int $categoryId, int $productId)
    {
        $request->validate(['name' => 'required']);
        $product = Product::findById($productId);
        $product->updateItem($request->name);

        return redirect()->back()->with('success', 'le produit ' .$product->name. 'a bien été mis à jour' );
    }

    /**
     * Delete product
     *
     * @param int $categoryId
     * @param int $productId
     * @return JsonResponse
     */
    public function destroy(int $categoryId, int $productId): JsonResponse
    {
        $product = Product::findById($productId);
        if (empty($product)) {

            return response()->json(['status' => 'error', 'message' => 'Product not found']);
        }

        $product->delete();

        return response()->json(['status' => 'success', 'message' => 'Product has been deleted']);
    }

    /**
     * List products with not ok status by category
     *
     * @param int $categoryId
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function productsWithNotOkStatusByCategory(int $categoryId)
    {
        $lists = ShoppingList::all();

        return view('Product.notOkStatuses', [
            'products' => Category::getProductWithNotOkStatusByCategory($categoryId, ProductStatus::NOT_OK_STATUSES),
            'lists' => $lists,
            'categoryId' => $categoryId
        ]);
    }

    /**
     * Add validity days to the product
     *
     * @param Request $request
     * @param int $categoryId
     * @param int $productId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addValidityDaysCategoryProduct(Request $request, int $categoryId, int $productId)
    {
        $product = Product::findById($productId);
        if(empty($product)) {

            return redirect()->back()->with('error','Aucun produit ne correspond');
        }

        $product->addDays($request->addDays);

        return redirect()->route('products.category', [
            'categoryId' => $categoryId

        ])->with('success', $product->name.' '.' a bien été mis à jour');

    }

    /**
     * @param int $productId
     * @return JsonResponse
     */
    public function addReferenceValidityDays(int $productId) : JsonResponse
    {
        $product = Product::findById($productId);
        if(empty($product)){

            return response()->json('Aucun produit trouvé', 404);
        }

        $referenceCountDay = $product->count_day;
        $product->addDays($referenceCountDay);

        return response()->json([
            'product_status' => $product->getStatus(),
            'remaining_day' => $product->getRemainingDays()
        ]);

    }

    /**
     * @param int|null $categoryId
     * @param int $productId
     * @return JsonResponse
     */
    public function getProgressBarPercent(int $categoryId, int $productId) : JsonResponse
    {
        $product = null;
        $products = Category::findById($categoryId)->products()->get();

        foreach ($products as $item) {
            if($item->id == $productId) {
                $product = $item;
            }
        }

        return response()->json($product->getPercent());
    }

}

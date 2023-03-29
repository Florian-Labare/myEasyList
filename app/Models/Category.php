<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
    ];

   /**
    * get the products for
    *
    * @return HasMany
    */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * get category by id
     *
     * @param integer $id
     * @return Category
     */
    public static function findById(int $id): ?Category {

        return self::where('id', $id)->first();
    }

    public function updateItem(string $name) {
        $this->name = $name;
        $this->save();
    }

    /**
     * @param int $categoryId
     * @param array $statuses
     * @return array
     */
    public static function getProductWithNotOkStatusByCategory(int $categoryId, array $statuses) : array
    {
        $category =  self::findById($categoryId);
        $products = $category->products()->get();
        $displayProducts = [];
        foreach ($products as $product) {

            if (in_array($product->getStatus(),  $statuses)) {

                $displayProducts[] = $product;
            }
        }

        return $displayProducts;
    }

}

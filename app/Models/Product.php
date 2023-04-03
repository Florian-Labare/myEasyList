<?php

namespace App\Models;

use App\Enum\ProductStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name'];

    protected $date = [
        'begin_date',
    ];

    /**
     * Get category of products
     *
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {

        return $this->belongsTo(Category::class);
    }

    /**
     * get product by id
     *
     * @param integer $id
     * @return Product
     */
    public static function findById(int $id): ?Product
    {

        return self::where('id', $id)->first();
    }

    public static function findByName(string $name): ?Product
    {

        return self::where('name', $name)->first();
    }

    /**
     * Update item
     *
     * @param string $name
     * @return void
     */
    public function updateItem(string $name)
    {
        $this->name = $name;
        $this->save();
    }

    /**
     * count days since the purchase date
     *
     * @return int
     */
    public function getDaysSincePurchase (): int
    {

        return Carbon::today()->diffInDays(Carbon::create($this->begin_date));
    }

    /**
     * get percent
     *
     * @return int
     */
    public function getPercent(): int
    {
        return intval($this->getDaysSincePurchase() / $this->count_day * 100);
    }

    /**
     * Determine statuses
     *
     * @return string
     */
    public function getStatus(): string
    {

       $percent = $this->getPercent();

       if ($percent < ProductStatus::HALF) {
           $status = ProductStatus::STATUS_OK;
       } elseif ($percent ==ProductStatus::HALF) {
           $status = ProductStatus::STATUS_WARNING;
       } elseif ($percent < ProductStatus::THREE_QUARTER) {
           $status = ProductStatus::STATUS_WARNING;
       } else {
           $status = ProductStatus::STATUS_CRITICAL;
       }

       return $status;
    }

    /**
     * Get not ok statuses for all products
     *
     * @param array $statuses
     * @return array
     */
    public static function getNotOkStatus(array $statuses): array
    {
        $products = self::findAllByStatus($statuses);
        $displayProducts = [];
        foreach ($products as $product) {
            $category = $product->category()->first();

            $displayProducts[$product->category_id]['libelle'] = @$category->name;
            $displayProducts[$product->category_id]['products'][] = $product;
            $displayProducts[$product->category_id]['id'] = $category->id;
        }
        return $displayProducts;
    }

    /**
     * find item by status
     *
     * @param array $statuses
     * @return array
     */
    public static function findAllByStatus(array $statuses): array
    {
        $products = self::join('categories', 'products.category_id', '=', 'categories.id')
                        ->whereNull('categories.deleted_at')
                        ->select('products.*')
                        ->get();
        $list = [];
        foreach ($products as $product) {
            if (in_array($product->getStatus(), $statuses)) {
                $list[] = $product;
            }
        }

        return $list;
    }

    /**
     * add validity days
     *
     * @param $addDays
     * @return void
     */
    public function addDays($addDays)
    {
        $this->begin_date = Carbon::today();
        $this->count_day = $addDays;
        $this->save();
    }

    /**
     * get remining days
     *
     * @return int
     */
    public function getRemainingDays(): int
    {

        return $this->count_day - $this->getDaysSincePurchase();
    }

}

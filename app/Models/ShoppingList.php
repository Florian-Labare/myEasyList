<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShoppingList extends Model
{
    use HasFactory;

    protected $table = 'lists';
    protected $fillable = ['products'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'products_data' => 'array'
    ];

    public static function findById(int $listId) : ?ShoppingList
    {

        return self::where('id', $listId)->first();
    }

    /**
     * @param string $name
     * @return void
     */
    public function updateItem(string $title)
    {
        $this->title = $title;
        $this->save();
    }
}

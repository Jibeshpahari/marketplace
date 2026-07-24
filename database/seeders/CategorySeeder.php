<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Top-level categories mapped to their children.
     * Add/remove freely — structure drives everything below.
     */
    protected array $tree = [
        'Electronics' => [
            'Mobile Phones',
            'Laptops & Computers',
            'Cameras & Photography',
            'Audio & Headphones',
            'Wearable Technology',
        ],
        'Fashion' => [
            "Men's Clothing",
            "Women's Clothing",
            'Shoes',
            'Bags & Accessories',
            'Jewelry & Watches',
        ],
        'Home & Living' => [
            'Furniture',
            'Kitchen & Dining',
            'Home Decor',
            'Bedding & Bath',
            'Storage & Organization',
        ],
        'Beauty & Health' => [
            'Skincare',
            'Makeup',
            'Hair Care',
            'Fragrances',
            'Personal Care',
        ],
        'Sports & Outdoors' => [
            'Fitness Equipment',
            'Outdoor & Camping',
            'Cycling',
            'Team Sports',
        ],
        'Toys & Baby' => [
            'Toys & Games',
            'Baby Gear',
            'Kids Clothing',
        ],
        'Books & Stationery' => [
            'Books',
            'Office Supplies',
            'Art & Craft Supplies',
        ],
        'Groceries' => [
            'Fresh Produce',
            'Pantry Staples',
            'Beverages',
            'Snacks',
        ],
    ];

    public function run(): void
    {
        foreach ($this->tree as $parentName => $children) {
            /** @var Category $parent */
            $parent = Category::updateOrCreate(
                ['slug' => Str::slug($parentName)],
                [
                    'name' => $parentName,
                    'parent_id' => null,
                    'is_active' => true,
                ]
            );

            foreach ($children as $childName) {
                Category::updateOrCreate(
                    ['slug' => Str::slug($parentName . ' ' . $childName)],
                    [
                        'name' => $childName,
                        'parent_id' => $parent->id,
                        'is_active' => true,
                    ]
                );
            }
        }
    }
}

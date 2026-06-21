<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kopi = Category::where('name', 'Kopi')->first();
        $nonKopi = Category::where('name', 'Non-Kopi')->first();
        $makanan = Category::where('name', 'Makanan Utama')->first();
        $snack = Category::where('name', 'Snack')->first();

        // If categories aren't seeded properly yet, just skip to avoid errors
        if (!$kopi || !$nonKopi || !$makanan || !$snack) {
            return;
        }

        $menus = [
            ['category_id' => $kopi->id, 'name' => 'Kopi Susu Gula Aren', 'description' => 'Kopi susu dengan gula aren asli yang legit dan creamy.', 'price' => 20000, 'is_available' => true],
            ['category_id' => $kopi->id, 'name' => 'Americano', 'description' => 'Espresso shot ganda diseduh dengan air panas murni.', 'price' => 15000, 'is_available' => true],
            ['category_id' => $kopi->id, 'name' => 'Cafe Latte', 'description' => 'Espresso dengan susu full cream yang lembut dan gurih.', 'price' => 22000, 'is_available' => true],
            ['category_id' => $kopi->id, 'name' => 'Caramel Macchiato', 'description' => 'Paduan espresso, susu, vanilla, dan saus karamel lezat.', 'price' => 25000, 'is_available' => true],
            
            ['category_id' => $nonKopi->id, 'name' => 'Matcha Latte', 'description' => 'Matcha premium impor berpadu dengan susu segar.', 'price' => 25000, 'is_available' => true],
            ['category_id' => $nonKopi->id, 'name' => 'Red Velvet Latte', 'description' => 'Minuman red velvet manis dan creamy dengan cream cheese.', 'price' => 24000, 'is_available' => true],
            ['category_id' => $nonKopi->id, 'name' => 'Lychee Tea', 'description' => 'Teh leci segar dengan buah leci asli didalamnya.', 'price' => 18000, 'is_available' => true],
            
            ['category_id' => $makanan->id, 'name' => 'Nasi Goreng Spesial', 'description' => 'Nasi goreng khas rempah dengan telur, ayam, dan sosis.', 'price' => 28000, 'is_available' => true],
            ['category_id' => $makanan->id, 'name' => 'Mie Goreng Maaju', 'description' => 'Mie goreng kenyal dengan bumbu rahasia dapur Maaju.', 'price' => 25000, 'is_available' => true],
            ['category_id' => $makanan->id, 'name' => 'Chicken Cordon Bleu', 'description' => 'Dada ayam gulung keju dan smoked beef dengan saus BBQ.', 'price' => 35000, 'is_available' => true],
            
            ['category_id' => $snack->id, 'name' => 'Kentang Goreng', 'description' => 'Kentang goreng renyah dengan taburan bumbu rahasia.', 'price' => 18000, 'is_available' => true],
            ['category_id' => $snack->id, 'name' => 'Croissant Butter', 'description' => 'Croissant mentega perancis yang hangat dan berlapis.', 'price' => 20000, 'is_available' => true],
            ['category_id' => $snack->id, 'name' => 'Cireng Bumbu Rujak', 'description' => 'Cireng goreng renyah kenyal dengan bumbu rujak manis pedas.', 'price' => 15000, 'is_available' => true],
        ];

        foreach ($menus as $menu) {
            Menu::firstOrCreate(['name' => $menu['name']], $menu);
        }
    }
}

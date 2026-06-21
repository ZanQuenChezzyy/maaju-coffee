<?php

use App\Models\Category;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\AprioriService;

it('calculates apriori recommendations correctly', function () {
    // Setup test data
    $category = Category::create(['name' => 'Test Category']);

    $menu1 = Menu::create(['category_id' => $category->id, 'name' => 'Kopi A', 'price' => 10000]);
    $menu2 = Menu::create(['category_id' => $category->id, 'name' => 'Roti B', 'price' => 15000]);
    $menu3 = Menu::create(['category_id' => $category->id, 'name' => 'Susu C', 'price' => 12000]);

    // Transaction 1: Kopi A, Roti B
    $order1 = Order::create(['total_amount' => 25000, 'status' => 'completed', 'payment_status' => 'paid']);
    OrderItem::create(['order_id' => $order1->id, 'menu_id' => $menu1->id, 'quantity' => 1, 'price' => 10000, 'subtotal' => 10000]);
    OrderItem::create(['order_id' => $order1->id, 'menu_id' => $menu2->id, 'quantity' => 1, 'price' => 15000, 'subtotal' => 15000]);

    // Transaction 2: Kopi A, Roti B
    $order2 = Order::create(['total_amount' => 25000, 'status' => 'completed', 'payment_status' => 'paid']);
    OrderItem::create(['order_id' => $order2->id, 'menu_id' => $menu1->id, 'quantity' => 1, 'price' => 10000, 'subtotal' => 10000]);
    OrderItem::create(['order_id' => $order2->id, 'menu_id' => $menu2->id, 'quantity' => 1, 'price' => 15000, 'subtotal' => 15000]);

    // Transaction 3: Kopi A, Susu C
    $order3 = Order::create(['total_amount' => 22000, 'status' => 'completed', 'payment_status' => 'paid']);
    OrderItem::create(['order_id' => $order3->id, 'menu_id' => $menu1->id, 'quantity' => 1, 'price' => 10000, 'subtotal' => 10000]);
    OrderItem::create(['order_id' => $order3->id, 'menu_id' => $menu3->id, 'quantity' => 1, 'price' => 12000, 'subtotal' => 12000]);

    // Test service
    $apriori = new AprioriService(0.1, 0.5); // min_support=10%, min_conf=50%

    // Test: if cart has Kopi A, it should recommend Roti B (confidence 66.6%)
    // Support(A) = 3/3 = 1.0. Support(A,B) = 2/3 = 0.66. Confidence(A=>B) = 0.66 / 1.0 = 0.66
    $recommendations = $apriori->getRecommendations([$menu1->id]);

    expect($recommendations)->toContain($menu2->id);

});

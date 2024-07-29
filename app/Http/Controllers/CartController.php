<?php


namespace App\Http\Controllers;



    use App\Models\Cart;
    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;

   class CartController extends Controller
{
    protected static $taxRate = 0.2;

public function index()
{
$cartItems = Cart::all();
return response()->json(['cartItems' => $cartItems, 'X-CSRF-TOKEN' => csrf_token()]);
}

public function getOneItem($id)
{
$cartItem = Cart::find($id);

if (!$cartItem) {
return response()->json(['error' => 'Cart item not found'], 404);
}

return response()->json(['cartItem' => $cartItem]);
}

public function add(Request $request)
{
$data = $request->validate([
'product_name' => 'required|string',
'quantity' => 'required|integer|min:1',
'price' => 'required|numeric'
]);

$cartItem = Cart::where('product_name', $data['product_name'])->first();

if ($cartItem) {
$cartItem->quantity += $data['quantity'];
} else {
$cartItem = new Cart();
$cartItem->product_name = $data['product_name'];
$cartItem->quantity = $data['quantity'];
$cartItem->price = $data['price'];
}

$cartItem->save();

return response()->json(['cartItem' => $cartItem], 201);
}

public function multipleAdd(Request $request)
{
$data = $request->validate([
'items' => 'required|array',
'items.*.product_name' => 'required|string',
'items.*.quantity' => 'required|integer|min:1',
'items.*.price' => 'required|numeric'
]);

$addedItems = [];

foreach ($data['items'] as $item) {
$cartItem = Cart::where('product_name', $item['product_name'])->first();

if ($cartItem) {
$cartItem->quantity += $item['quantity'];
} else {
$cartItem = new Cart();
$cartItem->product_name = $item['product_name'];
$cartItem->quantity = $item['quantity'];
$cartItem->price = $item['price'];
}

$cartItem->save();
$addedItems[] = $cartItem;
}

return response()->json(['addedItems' => $addedItems], 201);
}

public function update(Request $request, $id)
{
$data = $request->validate([
'product_name' => 'required|string',
'quantity' => 'required|integer|min:1',
'price' => 'required|numeric'
]);

$cartItem = Cart::find($id);

if (!$cartItem) {
return response()->json(['error' => 'Cart item not found'], 404);
}

$cartItem->product_name = $data['product_name'];
$cartItem->quantity = $data['quantity'];
$cartItem->price = $data['price'];

$cartItem->save();

return response()->json(['cartItem' => $cartItem]);
}

public function remove($id)
{
$cartItem = Cart::find($id);

if (!$cartItem) {
return response()->json(['error' => 'Cart item not found'], 404);
}

$cartItem->delete();

return response()->json(['message' => 'Item removed'], 204);
}

public function deleteAllItems()
{
Cart::truncate();

return response()->json(['message' => 'All items removed'], 201);
}

public function subtotal()
{
    $cartItems = Cart::all();
    $subtotal = $cartItems->sum(function($cartItem) {
        return $cartItem->quantity * $cartItem->price;
    });

    return response()->json(['subtotal' => $subtotal]);
}

public function total()
{
    $cartItems = Cart::all();
    $subtotal = $cartItems->sum(function($cartItem) {
        return $cartItem->quantity * $cartItem->price;
    });

    $total = $subtotal + ($subtotal * self::$taxRate);

    return response()->json(['total' => $total]);
}

public function tax()
{
    $cartItems = Cart::all();
    $subtotal = $cartItems->sum(function($cartItem) {
        return $cartItem->quantity * $cartItem->price;
    });

    $tax = $subtotal * self::$taxRate;

    return response()->json(['tax' => $tax]);
}

public static function setTax(Request $request)
{
$data = $request->validate([
'taxRate' => 'required|numeric'
]);

self::$taxRate = $data['taxRate'];

return response()->json(['message' => 'Tax rate set'], 201);
}

public function count()
{
$count = Cart::sum('quantity');

return response()->json(['count' => $count]);
}

public function deleteAItem($productId)
{
$cartItem = Cart::where('id', $productId)->first();

if (!$cartItem) {
return response()->json(['error' => 'Cart item not found'], 404);
}

$cartItem->delete();

return response()->json(['message' => 'Item removed'], 201);
}
}

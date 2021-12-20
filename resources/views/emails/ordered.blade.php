<p class="mb-4">{{ $product['ownerName']}}様の商品が注文されました。</p>

<div class="mb-4">商品情報<div>
  <ul class="mb-4">
    <li>商品名: {{ $product['name'] }}</li>
    <li>商品金額: {{ number_format($product['price'])}}円</li>
    <li>商品数: {{ $product['quantity'] }}</li>
    <li>合計金額: {{ number_format($product['price'] * $product['quantity']) }}円</li>
  </ul>

<div class="mb-4">購入者情報<div>
<ul>
  <li>{{ $user->name }}様</li>
</ul>

<br>
<br>
<br>
<p class="mb-4">{{ $product['ownerName'] }}'s items have been purchased.</p>

<div class="mb-4">Items Information</div>
    <ul class="mb-4">
        <li>Item Name：{{ $product['name'] }}</li>
        <li>Item Price：{{ number_format($product['price']) }}円</li>
        <li>Quantity：{{ $product['quantity'] }}</li>
        <li>Total Price：{{ number_format($product['price'] * $product['quantity']) }}円</li>
    </ul>

<div class="mb-4">Buyer</div>
    <ul>
        <li>{{ $user->name }} has been ordered.</li>
    </ul>
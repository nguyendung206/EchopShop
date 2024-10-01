<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        body {
  --overlap: 10rem;
  --border-thickness: 1px;
  --theme-color: #1a237e;
}

body > header {
  padding: 2rem 2rem var(--overlap) 2rem;
  background-image: radial-gradient(#0336ff, #000);
  width: 100%;
  box-sizing: border-box;
}
main {
  margin-top: 200px;
}
h1 {
  color: #fff;
  margin-top: 0;
}

form {
  margin: calc(var(--overlap) * -1) auto 0 auto;
  width: 80%;
  max-width: 700px;
  background-color: #fff;
  border-radius: 2px;
  box-shadow: 0 5px 15px rgb(0, 0, 0, 0.5);
  position: relative;
  padding: 1rem;
}

form > header {
  flex-wrap: nowrap;
  margin-bottom: 2rem;
}

form > header > * {
  flex: 0 0 auto;
}

.company .name,
.customer .bill-to {
  font-size: 1.1rem;
  margin-bottom: 0.5rem;
  text-transform: capitalize;
}

form > header h2 {
  margin-top: 0;
  margin-bottom: 0;
  text-transform: uppercase;
  font-size: 2rem;
}

.customer {
  display: flex;
  flex-wrap: nowrap;
  margin-bottom: 3rem;
}

.customer > * {
  flex: 0 0 auto;
}

.customer .invoice {
}

.customer .invoice th {
  padding-right: 0.5rem;
  text-align: right;
}

form > table {
  width: 100%;
  /*   border-collapse: collapse; */
}

form > table th {
  background: var(--theme-color);
  color: #fff;
}

form > table th {
  padding: 0.35rem 0.75rem;
}

form > table td {
  padding: 0.35rem 0;
}

form > table th:first-child,
form > table td:first-child {
  text-align: left;
}

form > table th:last-child,
form > table td:last-child {
  text-align: right;
  max-width: 100px;
}

form > table td:last-child > input {
  text-align: right;
}

form > table th:nth-child(2),
form > table td:nth-child(2),
form > table th:nth-child(3),
form > table td:nth-child(3) {
  max-width: 100px;
}

form > table td:nth-child(2) input,
form > table td:nth-child(3) input {
  text-align: center;
}

form > table tr:last-child button {
  background: inherit;
  border: 1px solid var(--theme-color);
  padding: 0.35rem 0.75rem;
  color: var(--theme-color);
  border-radius: 2px;
  cursor: pointer;
  appearance: none;
  -webkit-appearance: none;
  -moz-appearance: none;
}

form > table tr:last-child button:hover {
  background: var(--theme-color);
  color: #fff;
}

form > table tr:last-child input {
  background: transparent;
  color: #fff;
  text-align: right;
  padding: 0;
}

input {
  width: 100%;
  margin: 0;
  border: 1px solid #ccc;
  border-radius: 2px;
  box-sizing: border-box;
  padding: 0.35rem 0.75rem;
  font-size: 1rem;
}

input.error {
  border-color: #d50000;
}

input[disabled] {
  border: none;
}

.footer {
  text-align: center;
  padding: 1rem;
}

/* template */

body,
html {
  margin: 0;
  padding: 0;
  background: #f8f9fa;
  font-family: sans-serif;
}

    </style>
</head>
<body>
    @php
      $sum = 0;
    @endphp
      <main>
        <form>
          <header>
            <h2>Đơn hàng đã được tạo thành công</h2>
            <div class="company">
              <div class="name"><strong>{{$order->customer->name}}</strong></div>
              <div class="address">
                Địa chỉ nhận hàng: {{ $order->customer->address }}, {{ $order->customer->ward->ward_name }}, {{ $order->customer->district->district_name }},
                {{ $order->customer->province->province_name }}
              </div>
            </div>
          </header>
          <div class="customer">
            
            <div class="invoice">
              <table>
                <tr>
                  <th>Ngày tạo</th>
                  <td>{{date('d/m/Y', strtotime($order->created_at))}}</td>
                </tr>
                
              </table>
            </div>
          </div>
          <table>
            <thead>
              <tr>
                <th style="background-color: #b10000">Tên hàng</th>
                <th style="background-color: #b10000">Giá</th>
                <th style="background-color: #b10000">Số lượng</th>
                <th style="background-color: #b10000">Thành tiền</th>
              </tr>
                  @foreach($order->orderDetails as $orderDetail)
                  @php
                        $product = $orderDetail->product;
                        $sum += $product->quantity * $product->price;
                    @endphp
                <tr class="item">
                  <td>
                    {{$product->name}}
                  </td>
                  <td>{{format_price($product->price)}}</td>
                  <td>{{$orderDetail->quantity}}</td>
                  <td>{{format_price($orderDetail->quantity * $product->price)}}</td>
                </tr>
              @endforeach
              <tr>
                <td colspan="4">
                  @if ($order->discount)
                        
                  <div class="text-right total-price-purchase col-6">Thành tiền: <span class="init-money">{{format_price($order->total_amount)}}</span> <span class="discount-money">{{format_price(calculateDiscountedPrice($order->discount->type->value, $order->total_amount, $order->discount->value, $order->discount->max_value))}}</span></div>
                  @else
                  <div class="text-right total-price-purchase col-6">Thành tiền: <span class="discount-money">{{format_price($order->total_amount)}}</span> </div>
                  @endif

                </td>
              </tr>
            </thead>
          </table>
        </form>
      </main>
</body>
</html>
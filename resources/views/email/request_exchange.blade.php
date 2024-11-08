<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .email-container {
            background-color: #fff;
            padding: 20px;
            max-width: 800px;
            margin: 20px auto;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .email-header {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .email-body {
            font-size: 16px;
            line-height: 1.6;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
            color: #888;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
            font-weight: bold;
        }

        .cta {
            background-color: #B10000;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
        }

        .product-image {
            width: 100%;
            max-width: 150px;
            object-fit: cover;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="email-header">
            {{ $title }}
        </div>
        <div class="email-body">
            <p>{{ $body }}</p>
            <table>
                <thead>
                    <tr>
                        <th></th>
                        <th>Thông tin sản phẩm của bạn</th>
                        <th>Thông tin sản phẩm trao đổi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Tên sản phẩm:</strong></td>
                        <td>{{ $exchangeProduct->name }}</td>
                        <td>{{ $product->name }}</td>
                    </tr>
                    <tr>
                        <td><strong>Giá:</strong></td>
                        <td>{{format_price($exchangeProduct->price)}}</td>
                        <td>{{format_price($product->price)}}</td>
                    </tr>
                    <tr>
                        <td><strong>Mô tả:</strong></td>
                        <td>{{ strip_tags($exchangeProduct->description) }}</td>
                        <td>{{ strip_tags($product->description) }}</td>
                    </tr>
                    <tr>
                        <td><strong>Chất lượng:</strong></td>
                        <td>{{ $exchangeProduct->quality }}</td>
                        <td>{{ $product->quality }}</td>
                    </tr>
                    <tr>
                        <td><strong>Danh mục:</strong></td>
                        <td>{{ $exchangeProduct->category->name }}</td>
                        <td>{{ $product->category->name }}</td>
                    </tr>
                    <tr>
                        <td><strong>Thương hiệu:</strong></td>
                        <td>{{ $exchangeProduct->brand->name }}</td>
                        <td>{{ $product->brand->name }}</td>
                    </tr>
                </tbody>
            </table>

            <p>Vui lòng kiểm tra lại thông tin và xác nhận yêu cầu trao đổi sản phẩm.</p>

        </div>
        <div class="footer">
            <p>Đây là email tự động. Vui lòng không trả lời.</p>
        </div>
    </div>
</body>

</html>
<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class OrderExport implements FromCollection, ShouldAutoSize, WithColumnFormatting, WithEvents, WithHeadings, WithMapping
{
    protected $orders;

    public function __construct($orders = null)
    {
        $this->orders = $orders;
    }

    public function collection()
    {
        return $this->orders;
    }

    public function map($order): array
    {
        $address = getAddress($order);
        $discountAmount = 'Không giảm giá';
        $discountedPrice = $order->total_amount;
        if (! empty($order->discount)) {
            $discountAmount = calculateDiscountAmount($order->discount->type->value, $order->total_amount, $order->discount->value, $order->discount->max_value);
            $discountedPrice = calculateDiscountedPrice($order->discount->type->value, $order->total_amount, $order->discount->value, $order->discount->max_value);
        }
        $data = [
            $order->created_at,
            $order->customer?->name ?? '',
            $address,
            $order->total_amount,
            $discountAmount,
            $discountedPrice,
            $order->status->label(),
        ];

        $rows = [];
        $isFirstRow = true;
        if ($order->orderDetails->isEmpty()) {
            $rows[] = array_merge($data, ['', '', '']);
        } else {
            foreach ($order->orderDetails as $orderDetail) {
                $product = $orderDetail->product;
                if ($isFirstRow) {
                    $row = array_merge($data, [
                        $product->name ?? '',
                        $orderDetail->quantity,
                        $product->price,
                        $orderDetail->productUnit?->color ?? null,
                        $orderDetail->productUnit?->size ?? null,
                    ]);
                    $isFirstRow = false;
                } else {
                    $row = array_merge(array_fill(0, count($data), ''), [
                        $product->name ?? '',
                        $orderDetail->quantity,
                        $product->price,
                        $orderDetail->productUnit?->color ?? null,
                        $orderDetail->productUnit?->size ?? null,
                    ]);
                }

                $rows[] = $row;
            }
        }

        return $rows;
    }

    public function headings(): array
    {
        return [
            'Ngày tạo',
            'Tên khách hàng',
            'Địa chỉ nhận hàng',
            'Tiền gốc',
            'Giảm giá',
            'Thành tiền',
            'Trạng thái',
            'Tên sản phẩm',
            'Số lượng',
            'Giá',
            'Màu',
            'Kích cỡ',
        ];
    }

    public function columnFormats(): array
    {
        $array = [
            'A' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'D' => '#,##0 VNĐ',
            'E' => '#,##0 VNĐ',
            'F' => '#,##0 VNĐ',
            'J' => '#,##0 VNĐ',
        ];

        return $array;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $rowStart = 2;
                foreach ($this->orders as $order) {
                    $orderDetailCount = $order->orderDetails->count();

                    $event->sheet->getDelegate()->mergeCells("A{$rowStart}:A".($rowStart + $orderDetailCount - 1));
                    $event->sheet->getDelegate()->mergeCells("B{$rowStart}:B".($rowStart + $orderDetailCount - 1));
                    $event->sheet->getDelegate()->mergeCells("C{$rowStart}:C".($rowStart + $orderDetailCount - 1));
                    $event->sheet->getDelegate()->mergeCells("D{$rowStart}:D".($rowStart + $orderDetailCount - 1));
                    $event->sheet->getDelegate()->mergeCells("E{$rowStart}:E".($rowStart + $orderDetailCount - 1));
                    $event->sheet->getDelegate()->mergeCells("F{$rowStart}:F".($rowStart + $orderDetailCount - 1));
                    $event->sheet->getDelegate()->mergeCells("G{$rowStart}:G".($rowStart + $orderDetailCount - 1));

                    $rowStart += $orderDetailCount;
                }
            },
        ];
    }
}

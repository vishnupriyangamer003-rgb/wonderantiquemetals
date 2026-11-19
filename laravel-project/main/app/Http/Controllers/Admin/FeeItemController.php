<?php

namespace App\Http\Controllers\Admin;

use App\Models\FeeItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class FeeItemController extends ResourceController
{
    protected function model(): string
    {
        return FeeItem::class;
    }

    protected function key(): string
    {
        return 'fees';
    }

    protected function label(): string
    {
        return 'Fee item';
    }

    protected function rules(?Model $item): array
    {
        return [
            'item' => ['required', 'string', 'max:200'],
            'qty' => ['nullable', 'string', 'max:20'],
            'amount' => ['required', 'string', 'max:40'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
        ];
    }

    protected function transform(array $data, Request $request, ?Model $item): array
    {
        $data['qty'] = trim((string) ($data['qty'] ?? '')) ?: '1';

        return $data;
    }
}

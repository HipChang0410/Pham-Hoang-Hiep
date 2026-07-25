<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $productId = $this->route('product');

        return [
            'productname' => ['required', 'string', 'min:5', 'max:150'],
            'slug' => [
                'required',
                'string',
                'min:5',
                'max:180',
                'regex:/^[a-z0-9_-]+$/',
                Rule::unique('products', 'slug')->ignore($productId),
            ],
            'price' => ['required', 'numeric', 'min:0', 'lt:10000000'],
            'pricediscount' => ['nullable', 'numeric', 'min:0', 'lt:price'],
            'status' => ['required', 'in:0,1'],
            'cateid' => ['required', 'exists:categories,id'],
            'brandid' => ['required', 'exists:brands,id'],
            'description' => ['nullable', 'regex:/^[^@!$^]+$/'],
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute không được để trống.',
            'min' => ':attribute phải từ :min ký tự trở lên.',
            'max' => ':attribute không vượt quá :max ký tự.',
            'numeric' => ':attribute phải là số.',
            'string' => ':attribute phải là chuỗi.',
            'exists' => ':attribute không tồn tại.',
            'in' => ':attribute không hợp lệ.',
            'regex' => ':attribute không hợp lệ.',
            'lt' => ':attribute phải nhỏ hơn giá gốc.',
            'unique' => ':attribute đã tồn tại.',
        ];
    }

    public function attributes(): array
    {
        return [
            'productname' => 'Tên sản phẩm',
            'slug' => 'Đường dẫn (Slug)',
            'price' => 'Giá',
            'pricediscount' => 'Giá khuyến mãi',
            'status' => 'Trạng thái',
            'cateid' => 'Loại sản phẩm',
            'brandid' => 'Thương hiệu',
            'description' => 'Mô tả',
        ];
    }
}

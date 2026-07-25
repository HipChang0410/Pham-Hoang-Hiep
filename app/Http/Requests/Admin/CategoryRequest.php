<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $categoryId = $this->route('category');

        return [
            'catename' => [
                'required',
                'min:3',
                'max:100',
                Rule::unique('categories', 'catename')->ignore($categoryId),
            ],
            'slug' => [
                'required',
                'min:3',
                'max:150',
                'regex:/^[a-z0-9-]+$/',
                Rule::unique('categories', 'slug')->ignore($categoryId),
            ],
            'img' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:200'],
            'status' => ['nullable', 'in:0,1'],
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute không được để trống.',
            'min' => ':attribute phải từ :min ký tự trở lên.',
            'max' => ':attribute không vượt quá :max ký tự.',
            'unique' => ':attribute đã tồn tại.',
            'slug.regex' => ':attribute chỉ được chứa chữ thường, số và dấu gạch ngang (-).',
            'status.in' => ':attribute không hợp lệ.',
            'img.image' => ':attribute phải là hình ảnh.',
            'img.mimes' => ':attribute chỉ chấp nhận JPG, JPEG, PNG, WEBP.',
            'img.max' => ':attribute không được vượt quá 200KB.',
        ];
    }

    public function attributes(): array
    {
        return [
            'catename' => 'Tên loại',
            'slug' => 'Đường dẫn (Slug)',
            'img' => 'Hình ảnh',
            'status' => 'Trạng thái',
        ];
    }
}

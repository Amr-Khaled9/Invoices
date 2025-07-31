<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoicesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
    'invoice_number'    => ['nullable', 'unique:invoices,invoice_number'],
    'section_id'        => ['nullable'],
    'product'           => ['nullable'],
    'amount_collection' => ['nullable', 'regex:/^\d{1,6}(\.\d{1,2})?$/'], 
    'amount_Commission' => ['nullable', 'regex:/^\d{1,6}(\.\d{1,2})?$/'],
    'discount'          => ['nullable', 'regex:/^\d{1,6}(\.\d{1,2})?$/'],
    'note'              => ['nullable', 'string'],
    'pie'               => ['nullable', 'file', 'mimes:pdf,jpeg,jpg,png']
          
        ];

    }

    public function messages(){
        return [
    'invoice_number.required' => 'رقم الفاتورة مطلوب.',
    'invoice_number.unique' => 'رقم الفاتورة موجود بالفعل.',

    'invoice_Date.required' => 'تاريخ الفاتورة مطلوب.',
    'invoice_Date.date' => 'تاريخ الفاتورة غير صالح.',

    'due_date.required' => 'تاريخ الاستحقاق مطلوب.',
    'due_date.date' => 'تاريخ الاستحقاق غير صالح.',

    'section_id.required' => 'القسم مطلوب.',
    'section_id.exists' => 'القسم المحدد غير موجود.',

    'product.required' => 'اسم المنتج مطلوب.',
    'product.string' => 'اسم المنتج يجب أن يكون نصاً.',
    'product.max' => 'اسم المنتج لا يجب أن يتجاوز 50 حرفاً.',

    'amount_collection.decimal' => 'قيمة التحصيل يجب أن تكون رقماً عشرياً (8 أرقام، منهم 2 بعد العلامة).',

    'amount_Commission.required' => 'قيمة العمولة مطلوبة.',
    'amount_Commission.decimal' => 'قيمة العمولة يجب أن تكون رقماً عشرياً (8 أرقام، منهم 2 بعد العلامة).',

    'discount.required' => 'قيمة الخصم مطلوبة.',
    'discount.decimal' => 'قيمة الخصم يجب أن تكون رقماً عشرياً (8 أرقام، منهم 2 بعد العلامة).',

    'value_VAT.required' => 'قيمة الضريبة مطلوبة.',
    'value_VAT.decimal' => 'قيمة الضريبة يجب أن تكون رقماً عشرياً (8 أرقام، منهم 2 بعد العلامة).',

    'rate_VAT.required' => 'نسبة الضريبة مطلوبة.',
    'rate_VAT.string' => 'نسبة الضريبة يجب أن تكون نصاً.',
    'rate_VAT.max' => 'نسبة الضريبة لا يجب أن تتجاوز 999 حرفاً.',

    'total.required' => 'الإجمالي مطلوب.',
    'total.decimal' => 'الإجمالي يجب أن يكون رقماً عشرياً (8 أرقام، منهم 2 بعد العلامة).',

    'note.string' => 'الملاحظات يجب أن تكون نصاً.',

    'pie.file' => 'يجب أن يكون الملف المرفق صالحًا.',
    'pie.mimes' => 'الملف يجب أن يكون من نوع: pdf, jpeg, jpg, png.',
];

    }
}

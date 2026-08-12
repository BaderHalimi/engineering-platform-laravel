<?php

namespace App\Http\Requests;

use App\Models\ServicesType;
use Illuminate\Foundation\Http\FormRequest;

class StoreServiceRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $rules = [
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_email' => ['nullable', 'email', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:20'],
            'customer_address' => ['nullable', 'string', 'max:500'],
            'service_id' => ['required', 'exists:services_types,id'],
            'title' => ['required', 'string', 'max:255'],
            'details' => ['nullable', 'string', 'max:5000'],
        ];

        if (ServicesType::whereKey($this->input('service_id'))->where('documented', true)->exists()) {
            $rules['documents'] = ['required', 'array', 'min:1', 'max:5'];
            $rules['documents.*'] = ['file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'customer_name.required' => 'الاسم الكامل مطلوب',
            'customer_phone.required' => 'رقم الجوال مطلوب',
            'service_id.required' => 'نوع الخدمة مطلوب',
            'service_id.exists' => 'الخدمة المختارة غير موجودة',
            'title.required' => 'عنوان الطلب مطلوب',
            'customer_email.email' => 'البريد الإلكتروني غير صحيح',
            'documents.required' => 'هذه الخدمة تتطلب رفع مستندات',
            'documents.*.mimes' => 'صيغة الملف غير مدعومة (PDF, JPG, PNG فقط)',
            'documents.*.max' => 'حجم الملف يجب ألا يتجاوز 5 ميغابايت',
        ];
    }
}

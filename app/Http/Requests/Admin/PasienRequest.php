<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PasienRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'namaPasien' => 'required|max:255',
            'alamat' => 'required|max:255',
            'noHP' => 'required|max:255',
        ];

        if ($this->isMethod('post')) {
            // Rules untuk Create
            $rules['nik'] = 'required|max:255|unique:pasien';
            $rules['nomorRM'] = 'required|max:255|unique:pasien';
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) {
            // Rules untuk Update
            $rules['nik'] = 'nullable|max:255|unique:pasien,nik,' . $this->route('pasien');
            $rules['nomorRM'] = 'nullable|max:255|unique:pasien,nomorRM,' . $this->route('pasien');
        }

        return $rules;
    }
}

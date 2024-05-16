<?php

namespace App\Http\Requests\Document;

use Illuminate\Foundation\Http\FormRequest;

class DocumentUpdateRequest extends FormRequest
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
        return [
            //
            'name'=>'nullable|string',

            'files'=>'nullable',
            'files.*'=>"nullable|mimes:pdf,xlxs,docx,txt|mimetypes:file/pdf,file/docx,file/xlsx"

        ];
    }
}

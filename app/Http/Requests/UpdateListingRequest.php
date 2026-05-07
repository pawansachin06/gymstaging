<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateListingRequest extends FormRequest
{
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
            'profile_image_file' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp', 'max:10240'],
            'cover_image_file' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp', 'max:10240'],
            'media_file' => ['nullable', 'array', 'max:25'],
            'media_file.*' => ['required', 'image', 'mimes:jpg,jpeg,png,webp,gif,svg', 'max:5120'],  // Each: image, types, <= 5MiB
            'media_file_deletes' => ['nullable', 'json'],
            'transformation_file' => ['nullable', 'array', 'max:25'],
            'transformation_file.*' => ['required', 'image', 'mimes:jpg,jpeg,png,webp,gif,svg', 'max:5120'],  // Each: image, types, <= 5MiB
            'transformation_file_deletes' => ['nullable', 'json'],
            'taggable' => ['nullable', 'boolean'],
            
        ];
    }
}
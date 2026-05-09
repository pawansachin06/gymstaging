<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class UpdateListingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $mentions = [];
        $ctas = $this->input('ctas', []);
        $perks = json_decode($this->input('perks', '[]'), true);
        $conversion = json_decode($this->input('conversion', '[]'), true);
        foreach ($ctas as $key => $cta) {
            $value = trim($cta['value'] ?? '');
            $ctas[$key]['enabled'] = $value !== '' ? 1 : 0;
        }
        foreach ($this->input('mention_id', []) as $id) {
            $mentions[] = ['id' => $id];
        }
        $conversion['enabled'] = !empty($conversion['value']);
        $this->merge([
            'ctas' => $ctas,
            'perks' => $perks,
            'mentions' => $mentions,
            'conversion' => $conversion,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'ctas' => ['nullable', 'array'],
            'ctas.site.value' => ['nullable', 'url'],
            'ctas.tiktok.value' => ['nullable', 'url'],
            'ctas.email.value' => ['nullable', 'email'],
            'ctas.twitter.value' => ['nullable', 'url'],
            'ctas.youtube.value' => ['nullable', 'url'],
            'ctas.call.value' => ['nullable', 'string'],
            'ctas.linkedin.value' => ['nullable', 'url'],
            'ctas.facebook.value' => ['nullable', 'url'],
            'ctas.instagram.value' => ['nullable', 'url'],
            'ctas.whatsapp.value' => ['nullable', 'string'],

            'place_id' => ['nullable', 'string', 'max:512'],
            'place_name' => ['nullable', 'string', 'max:255'],
            'mention_id' => ['nullable', 'array'],
            'mention_id.*' => [
                'string', Rule::exists('listings', 'id')->where('taggable', 1)->where('published', 1),
            ],
            'mentions' => ['nullable', 'array'],
            'conversion' => ['nullable', 'array'],
            'perks' => ['nullable', 'array'],

            'about' => ['nullable', 'string'],

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

    public function withValidator($validator)
    {
        $validator->after(function (Validator $validator) {
            
            $conversion = $this->input('conversion', []);
            $conversionType  = $conversion['type'] ?? '';
            $conversionValue = trim($conversion['value'] ?? '');
            if (!empty($conversionValue)) {
                if ($conversionType === 'email') {
                    if (!filter_var($conversionValue, FILTER_VALIDATE_EMAIL)) {
                        $validator->errors()->add(
                            'conversion',
                            'Conversion CTA must contain a valid email address.'
                        );
                    }
                } elseif (in_array($conversionType, [
                    'website',
                    'form',
                    'custom',
                ])) {
                    if (!filter_var($conversionValue, FILTER_VALIDATE_URL)) {
                        $validator->errors()->add(
                            'conversion',
                            'Conversion CTA must contain a valid URL.'
                        );
                    }
                }
            }

        });
    }

}
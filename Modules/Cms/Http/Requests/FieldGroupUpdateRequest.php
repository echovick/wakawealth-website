<?php

declare(strict_types=1);

namespace Modules\Cms\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @author WakaWealth Development Team
 */
final class FieldGroupUpdateRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $fieldGroupId = $this->route('field_group')->id;

        return [
            'title' => ['required', 'string', 'max:255'],
            'key' => ['required', 'string', 'max:255', Rule::unique('field_groups', 'key')->ignore($fieldGroupId)],
            'position' => ['nullable', 'string', 'in:normal,side'],
            'style' => ['nullable', 'string', 'in:default,seamless'],
            'active' => ['nullable', 'boolean'],
            'fields' => ['nullable', 'array'],
            'fields.*.key' => ['required', 'string'],
            'fields.*.label' => ['required', 'string'],
            'fields.*.name' => ['required', 'string'],
            'fields.*.type' => ['required', 'string'],
            'fields.*.instructions' => ['nullable', 'string'],
            'fields.*.required' => ['nullable', 'boolean'],
            'fields.*.conditional_logic' => ['nullable', 'array'],
            'fields.*.field_config' => ['nullable', 'array'],
            'locations' => ['nullable', 'array'],
            'locations.*.entity_type' => ['required', 'string'],
            'locations.*.entity_id' => ['nullable', 'integer'],
            'locations.*.rules' => ['nullable', 'array'],
        ];
    }
}

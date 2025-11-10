<?php

namespace Modules\Cms\Services;

final readonly class FieldRegistryService
{
    /**
     * Get all registered field types with their configurations
     *
     * @return array<string, array{label: string, icon: string, category: string, config: array<string, mixed>}>
     */
    public function getFieldTypes(): array
    {
        return [
            'text' => [
                'label' => 'Text',
                'icon' => 'text',
                'category' => 'basic',
                'config' => [
                    'placeholder' => '',
                    'maxlength' => null,
                    'prepend' => '',
                    'append' => '',
                ],
            ],
            'textarea' => [
                'label' => 'Text Area',
                'icon' => 'align-left',
                'category' => 'basic',
                'config' => [
                    'placeholder' => '',
                    'maxlength' => null,
                    'rows' => 4,
                ],
            ],
            'number' => [
                'label' => 'Number',
                'icon' => 'hash',
                'category' => 'basic',
                'config' => [
                    'min' => null,
                    'max' => null,
                    'step' => 1,
                ],
            ],
            'email' => [
                'label' => 'Email',
                'icon' => 'mail',
                'category' => 'basic',
                'config' => [
                    'placeholder' => '',
                ],
            ],
            'url' => [
                'label' => 'URL',
                'icon' => 'link',
                'category' => 'basic',
                'config' => [
                    'placeholder' => '',
                ],
            ],
            'wysiwyg' => [
                'label' => 'WYSIWYG Editor',
                'icon' => 'edit',
                'category' => 'content',
                'config' => [
                    'toolbar' => 'full',
                    'media_upload' => true,
                ],
            ],
            'image' => [
                'label' => 'Image',
                'icon' => 'image',
                'category' => 'media',
                'config' => [
                    'return_format' => 'array',
                    'preview_size' => 'medium',
                    'library' => 'all',
                ],
            ],
            'file' => [
                'label' => 'File',
                'icon' => 'file',
                'category' => 'media',
                'config' => [
                    'return_format' => 'array',
                    'library' => 'all',
                ],
            ],
            'select' => [
                'label' => 'Select',
                'icon' => 'list',
                'category' => 'choice',
                'config' => [
                    'choices' => [],
                    'allow_null' => false,
                    'multiple' => false,
                ],
            ],
            'checkbox' => [
                'label' => 'Checkbox',
                'icon' => 'check-square',
                'category' => 'choice',
                'config' => [
                    'choices' => [],
                    'layout' => 'vertical',
                ],
            ],
            'radio' => [
                'label' => 'Radio Button',
                'icon' => 'circle',
                'category' => 'choice',
                'config' => [
                    'choices' => [],
                    'layout' => 'vertical',
                ],
            ],
            'true_false' => [
                'label' => 'True / False',
                'icon' => 'toggle-right',
                'category' => 'choice',
                'config' => [
                    'message' => '',
                    'default_value' => false,
                ],
            ],
            'date_picker' => [
                'label' => 'Date Picker',
                'icon' => 'calendar',
                'category' => 'datetime',
                'config' => [
                    'display_format' => 'd/m/Y',
                    'return_format' => 'd/m/Y',
                ],
            ],
            'time_picker' => [
                'label' => 'Time Picker',
                'icon' => 'clock',
                'category' => 'datetime',
                'config' => [
                    'display_format' => 'g:i a',
                    'return_format' => 'g:i a',
                ],
            ],
            'repeater' => [
                'label' => 'Repeater',
                'icon' => 'layers',
                'category' => 'layout',
                'config' => [
                    'layout' => 'table',
                    'button_label' => 'Add Row',
                    'min' => 0,
                    'max' => 0,
                    'subfields' => [],
                ],
            ],
            'group' => [
                'label' => 'Group',
                'icon' => 'folder',
                'category' => 'layout',
                'config' => [
                    'layout' => 'block',
                    'subfields' => [],
                ],
            ],
            'flexible_content' => [
                'label' => 'Flexible Content',
                'icon' => 'grid',
                'category' => 'layout',
                'config' => [
                    'button_label' => 'Add Block',
                    'min' => 0,
                    'max' => 0,
                    'layouts' => [],
                ],
            ],
        ];
    }

    /**
     * Get field type configuration
     *
     * @param string $type
     * @return array<string, mixed>|null
     */
    public function getFieldType(string $type): ?array
    {
        $fieldTypes = $this->getFieldTypes();
        return $fieldTypes[$type] ?? null;
    }

    /**
     * Check if field type exists
     *
     * @param string $type
     * @return bool
     */
    public function hasFieldType(string $type): bool
    {
        return isset($this->getFieldTypes()[$type]);
    }

    /**
     * Get field types formatted for form usage
     *
     * @return array<int, array{type: string, label: string, icon: string, category: string}>
     */
    public function getFieldTypesForForm(): array
    {
        $types = [];
        foreach ($this->getFieldTypes() as $key => $config) {
            $types[] = [
                'type' => $key,
                'label' => $config['label'],
                'icon' => $config['icon'],
                'category' => $config['category'] ?? 'basic',
            ];
        }
        return $types;
    }

    /**
     * Get field types grouped by category
     *
     * @return array<string, array<string, array<string, mixed>>>
     */
    public function getFieldTypesByCategory(): array
    {
        $grouped = [];
        foreach ($this->getFieldTypes() as $key => $type) {
            $category = $type['category'];
            $grouped[$category][$key] = $type;
        }
        return $grouped;
    }
}

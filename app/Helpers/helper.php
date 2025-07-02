<?php

if (!function_exists('sanitizeTaskInput')) {
    function sanitizeTaskInput(array $data): array
    {
        $fields = ['title', 'description', 'long_description', 'name', 'email', 'password'];
        $sanitized = [];

        foreach ($fields as $field) {
            $value = $data[$field] ?? null;
            $sanitized[$field] = $value !== null && $value !== ''
                ? htmlspecialchars($value, ENT_QUOTES, 'UTF-8')
                : null;
        }

        return $sanitized;
    }
}

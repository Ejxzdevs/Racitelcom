<?php

class SanitizeInput {
    protected function sanitizeInput($data) {
        return array_map(function($value) {
            return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
        }, $data);
    }
}
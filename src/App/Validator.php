<?php
namespace App;

/**
 * Валидация данных формы
 */
class Validator
{
    public static function validate(array $data): array
    {
        $errors = [];

        if (!is_numeric($data['price']) || $data['price'] <= 0) {
            $errors[] = '<span id="error" style="color: red;">Некорректная цена</span>';
        }

        if (!is_numeric($data['prep_time']) || $data['prep_time'] <= 0) {
            $errors[] = '<span id="error" style="color: red;">Некорректное время приготовления</span>';
        }

        return $errors;
    }
}
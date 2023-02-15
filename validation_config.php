<?php
require_once(__DIR__ . "\\controllers\\validation.php");
$ValidationConfig = array(
        // Upload file validation config
    "upload_file_validation_list" => array(
        "filename" => [
            array(
                "error_message" => "Името на файла трябва да бъде най-много 30 символа",
                "validate" => bind_partial_last('is_str_len_in_range', 0, 30)
            ),
        ],
        "fileToUpload" => [
            array(
                "error_message" => "Файлът с това име вече съществува.",
                "validate" => bind_partial_last('file_not_exists')
            ),
            array(
                "error_message" => "Файлът трябва да бъде по-малък от 5 мегабайтa.",
                "validate" => bind_partial_last('file_size_constraint', 5000000)
            ),
        ]
    ),
        // User registration validation config
    "registration_validation_list" => array(
        "username" => [
            array(
                "error_message" => "Потребителското име трябва да съдържа между 6 и 30 символа.",
                "validate" => bind_partial_last('is_str_len_in_range', 6, 30)
            ),
            array(
                "error_message" => "Потребителското име трябва да съдържа само малки латински букви и цифри.",
                "validate" => bind_partial_last('test_regex', "/^[a-zA-Z0-9]+$/")
            ),
            array(
                "error_message" => "Потребителското име вече е заето.",
                "validate" => bind_partial_last('check_username_free'),
            )
        ],
        "email" => [
            array(
                "error_message" => "Въведете валиден имейл адрес.",
                "validate" => bind_partial_last('test_regex', "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/")
            ),
            array(
                "error_message" => "Имейлът вече е зает.",
                "validate" => bind_partial_last('check_email_free'),
            )
        ],
        "full_name" => [
            array(
                "error_message" => "Пълното име трябва да съдържа между 2 и 30 символа.",
                "validate" => bind_partial_last('is_str_len_in_range', 2, 30)
            ),
        ],
        "password" => [
            array(
                "error_message" => "Паролата трябва да съдържа между 6 и 20 символа.",
                "validate" => bind_partial_last('is_str_len_in_range', 6, 20)
            ),
            array(
                "error_message" => "Паролата трябва да съдържа поне една малка латинска буква, главна латинска буква и цифра.",
                "validate" => bind_partial_last('test_regex', "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/")
            )
        ],
    ),
    "mkdir_validation_list" => array(
        "dirname" => [
            array(
                "error_message" => "Името вече е заето.",
                "validate" => bind_partial_last('file_not_exists_dir')
            ),
            array(
                "error_message" => "Името на директорията трябва да съдържа между 6 и 30 символа.",
                "validate" => bind_partial_last('is_str_len_in_range', 6, 30)
            ),
            array(
                "error_message" => "Името на директорията трябва да съдържа само малки латински букви и цифри.",
                "validate" => bind_partial_last('test_regex', "/^[a-zA-Z0-9]+$/")
            ),
        ]
    ),
    "login_validation_list" => array(
    "username" => [
            array(
                "error_message" => "Потребителят не съществува или паролата е неправилна.",
                "validate" => bind_partial_last('user_exists')
            ),
        ]
    )
)
?>
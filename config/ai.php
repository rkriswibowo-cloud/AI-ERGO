<?php
// Configuration File: AI & LLM Settings

return [
    'default_provider' => 'gemini', // 'gemini' or 'groq'
    'gemini' => [
        'api_key' => '', // Configurable via DB settings
        'model' => 'gemini-1.5-flash',
        'endpoint' => 'https://generativelanguage.googleapis.com/v1beta/models/',
    ],
    'groq' => [
        'api_key' => '', // Configurable via DB settings
        'model' => 'llama-3.3-70b-versatile',
        'endpoint' => 'https://api.groq.com/openai/v1/chat/completions',
    ],
    'temperature' => 0.7,
    'max_tokens' => 2048,
];

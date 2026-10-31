<?php
// Configuration File: AI & LLM Settings

return [
    'default_provider' => env('AI_DEFAULT_PROVIDER', 'gemini'), // 'gemini' or 'groq'
    'gemini' => [
        'api_key' => env('GEMINI_API_KEY', ''), // Configurable via DB settings or env
        'model' => env('GEMINI_MODEL', 'gemini-1.5-flash'),
        'endpoint' => env('GEMINI_ENDPOINT', 'https://generativelanguage.googleapis.com/v1beta/models/'),
    ],
    'groq' => [
        'api_key' => env('GROQ_API_KEY', ''), // Configurable via DB settings or env
        'model' => env('GROQ_MODEL', 'llama-3.3-70b-versatile'),
        'endpoint' => env('GROQ_ENDPOINT', 'https://api.groq.com/openai/v1/chat/completions'),
    ],
    'temperature' => (float) env('AI_TEMPERATURE', 0.7),
    'max_tokens' => (int) env('AI_MAX_TOKENS', 2048),
];

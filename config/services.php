<?php
return [
    'postmark' => ['token' => env('POSTMARK_TOKEN')],
    'ses' => ['key' => env('AWS_ACCESS_KEY_ID'), 'secret' => env('AWS_SECRET_ACCESS_KEY'), 'region' => env('AWS_DEFAULT_REGION', 'us-east-1')],
    'resend' => ['key' => env('RESEND_KEY')],
    'slack' => ['notifications' => ['bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'), 'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL')]],

    'google' => [
        'service_account_json' => env('GOOGLE_SERVICE_ACCOUNT_JSON'),
        'sheet_id' => env('GOOGLE_SHEET_ID'),
        'drive_folder_id' => env('GOOGLE_DRIVE_FOLDER_ID'),
    ],
];

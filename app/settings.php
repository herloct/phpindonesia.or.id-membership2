<?php
return [
    'mode' => 'development',
    'salt_pwd' => 'dev-spirit',
    'app' => [
        'name'  => 'PHP Indonesia - Membership App',
        'email' => getenv('APP_EMAIL'),
    ],
    'db' => [
        'host'     => getenv('DB_HOST'),
        'driver'   => 'mysql',
        'username' => getenv('DB_USER'),
        'password' => getenv('DB_PASS'),
        'dbname'   => getenv('DB_NAME'),
    ],
    'mailer' => [
        'host'     => getenv('MAILER_HOST'),
        'port'     => getenv('MAILER_PORT'),
        'username' => getenv('MAILER_USER'),
        'password' => getenv('MAILER_PASS'),
    ],
    'view' => [
        'directory'     => APP_DIR.'views',
        'fileExtension' => 'php',
    ],
    'gcaptcha' => [
        'enable'  => true,
        'sitekey' => getenv('GCAPTCHA_KEY'),
        'secret'  => getenv('GCAPTCHA_SECRET')
    ],
    'cloudinary' => [
        'cloud_name' => getenv('CLOUDINARY_NAME'),
        'api_key'    => getenv('CLOUDINARY_KEY'),
        'api_secret' => getenv('CLOUDINARY_SECRET'),
    ],
    'socmedias' => [
        'facebook'  => ['Facebook',  'fa-facebook',    'https://www.facebook.com/'],
        'twitter'   => ['Twitter',   'fa-twitter',     'https://twitter.com/'],
        'linkedin'  => ['LinkedIn',  'fa-linkedin',    'https://www.linkedin.com/in/'],
        'instagram' => ['Instagram', 'fa-instagram',   'https://www.instagram.com/'],
        'path'      => ['Path',      'fa-pinterest-p', 'https://path.com/'],
        'github'    => ['GitHub',    'fa-github',      'https://github.com/'],
    ],
];

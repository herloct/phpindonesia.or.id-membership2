## Development Environment Menggunakan Docker

### Requirement

* Docker 17.03.1 ke atas
* Docker Compose 1.11.2 ke atas

### Setup

1.  Buat `docker-compose.override.yml`, lalu isikan seperti di bawah ini.

    ```yaml
    version: '3'

    services:
        composer:
            user: '<<USER_ID>>:<<GROUP_ID>>'
    ```

    Dimana `<<USER_ID>>:<<GROUP_ID>>` merupakan output dari perintah bash di bawah ini.

    ```bash
    $ echo $(id -u):$(id -g)
    ```

    Umumnya hasilnya `1000:1000`.

2.  Apabila port `80` untuk web server sudah digunakan oleh aplikasi lain, maka tambahkan isi
    `docker-compose.override.yml` menjadi seperti di bawah ini.

    ```yaml
    version: '3'

    services:
        web:
            ports:
                - '<<WEB_PORT>>:80'
    ```

    Dimana `<<WEB_PORT>>` merupakan port yang diinginkan untuk mengakses web server.

3.  Apabila port `8025` untuk MailHog Web UI sudah digunakan oleh aplikasi lain, maka tambahkan isi
    `docker-compose.override.yml` menjadi seperti di bawah ini.

    ```yaml
    version: '3'

    services:
        smtp:
            ports:
                - '<<MAILHOG_PORT>>:8025'
    ```

    Dimana `<<MAILHOG_PORT>>` merupakan port yang diinginkan untuk mengakses MailHog Web UI.

4.  Apabila port `8080` untuk Adminer sudah digunakan oleh aplikasi lain, maka tambahkan isi
    `docker-compose.override.yml` menjadi seperti di bawah ini.

    ```yaml
    version: '3'

    services:
        adminer:
            ports:
                - '<<ADMINER_PORT>>:8080'
    ```

    Dimana `<<ADMINER_PORT>>` merupakan port yang diinginkan untuk mengakses Adminer.

### App Settings

Berikut merupakan nilai untuk `app/settings.php` jika menggunakan `docker-compose.yml` bawaan.

```php
<?php
return [
    // -- omitted --

    'db' => [
        'host'     => 'database',
        'driver'   => 'mysql',
        'username' => 'mysql_user',
        'password' => 'mysql password',
        'dbname'   => 'membership',
    ],
    'mailer' => [
        'host'     => 'smtp',
        'port'     => 1025,
        'username' => '',
        'password' => '',
    ],

    // -- omitted --
];
```

### Install Dependencies

Untuk menginstall dependensi menggunakan `composer`, bisa menggunakan perintah berikut.

```bash
$ docker-compose run --rm composer install
```

### Starting Development Server

Untuk memulai development server (web server, database, Adminer, dan MailHog Web UI), gunakan perintah berikut.

```bash
$ docker-compose up -d web adminer
```

### Stoping Development Server

Untuk menghentikan development server, gunakan perintah berikut.

```bash
$ docker-compose down -v
```

### Adminer Login

Untuk login ke Adminer, silakan akses `http://localhost:<<ADMINER_PORT>>`, lalu isikan informasi berikut.

| Field    | Value          |
|----------|----------------|
| System   | MySQL          |
| Server   | database       |
| Username | mysql_user     |
| Password | mysql password |
| Database | membership     |

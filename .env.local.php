<?php

// This file was generated by running "composer dump-env prod"

return array (
  'APP_ENV' => 'prod',
  'APP_SECRET' => '432c3b85ae04adc746940dad90696356',
  'DATABASE_URL' => 'postgres://postgres:root@localhost:5432/sociedades_api',
  'JWT_SECRET_KEY' => '%kernel.project_dir%/config/jwt/private.pem',
  'JWT_PUBLIC_KEY' => '%kernel.project_dir%/config/jwt/public.pem',
  'JWT_PASSPHRASE' => 'sociedad_anonima',
);

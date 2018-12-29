<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| JWT Config
| -------------------------------------------------------------------------
| Values to be used in Jwt Client library
|
*/

$config['jwt_issuer'] = 'ASF - Admin';

// must be non-empty
$config['jwt_secret_key'] = 'eyJUb2tlblR5cGUiOiJBUEkiLCJhbGciOiJIUzUxMiJ9.eyJqdGkiOiIzYjg1MDY4Yy02NTA0LTQxNzYtOWNiOC1hODk0MGQ4OTc2YzYiLCJpYXQiOjE0ODI4MjUwNzV9.wjnsV0jKMcqukjhpM4hNbwVtms-GhSXf0HfnnjMF1f0blLOnWg2gqxE0EOEScnQLADokKZf2Vqanzswg6i2ZZA';

// expiry time since a JWT is issued (in seconds); set NULL to never expired
$config['jwt_expiry'] = NULL;
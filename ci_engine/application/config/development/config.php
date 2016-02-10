<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
function __autoload($classname) {
    if (strpos($classname, 'CI_') !== 0) {
        $file = APPPATH . 'libraries/' . $classname . '.php';
        if (file_exists($file) && is_file($file)) {
            @include_once($file);
	}
    }
}
$config['ctl_home'] = 'home/';
$config['ctl_upload'] = 'upload/';
$config['ctl_gallery'] = 'gallery/';
$config['ctl_myfoto'] = 'myfoto/';
$config['ctl_announcement'] = 'announcement/';

$config['ctl_auth'] = 'cms/auth/';
$config['ctl_dashboard'] = 'cms/dashboard/';
$config['ctl_cms_gallery'] = 'cms/gallery/';
$config['ctl_cms_comp'] = 'cms/comp/';


$config['base_images'] = 'http://stabilitas.co.id/appimages/galery/';
$config['library'] = 'assets/library/';
$config['bootstrap_theme'] = 'assets/library/bootstrap/default/';
$config['theme'] = 'assets/theme/';

$config['uploads'] = 'userfiles/uploads/';
$config['thumbs'] = 'userfiles/thumbs/';
$config['attachments'] = 'userfiles/attachments/';


$config['tmp'] = 'tmp/';


/******** socmed **********/
$config['GA_CODE'] = 'XXX';

$config['FB_APP_ID'] = '1453152094945684'; 
$config['FB_APP_SECRET'] = '';

$config['TW_TIMELINE_LIMIT'] = 5;
$config['TW_TIMELINE_HEIGHT'] = 100;
$config['TW_TWEET_NAME'] = 'stabilitas';

$config['base_url']	= 'http://localhost/projects/htdocs/brifc_fotocompetition/';
$config['index_page'] = '';
$config['uri_protocol']	= 'AUTO';
$config['url_suffix'] = '';
$config['language']	= 'english';
$config['charset'] = 'UTF-8';
$config['enable_hooks'] = FALSE;
$config['subclass_prefix'] = 'MY_';
$config['permitted_uri_chars'] = 'a-z 0-9~%.:_\-';


/*
|--------------------------------------------------------------------------
| Enable Query Strings
|--------------------------------------------------------------------------
*/
$config['allow_get_array']		= TRUE;
$config['enable_query_strings'] = FALSE;
$config['controller_trigger']	= 'c';
$config['function_trigger']		= 'm';
$config['directory_trigger']	= 'd'; // experimental not currently in use

$config['log_threshold'] = 0;
$config['log_path'] = '';
$config['log_date_format'] = 'Y-m-d H:i:s';

$config['cache_path'] = '';

$config['encryption_key'] = '$%#^*$#';


$config['sess_cookie_name']		= 'bfccompetition';
$config['sess_expiration']		= 7200;
$config['sess_expire_on_close']	= TRUE;
$config['sess_encrypt_cookie']	= FALSE;
$config['sess_use_database']	= TRUE;
$config['sess_table_name']		= 'ci_sessions';
$config['sess_match_ip']		= FALSE;
$config['sess_match_useragent']	= TRUE;
$config['sess_time_to_update']	= 300;

$config['cookie_prefix']	= "";
$config['cookie_domain']	= "";
$config['cookie_path']		= "/";
$config['cookie_secure']	= FALSE;

/*
|--------------------------------------------------------------------------
| Global XSS Filtering
|--------------------------------------------------------------------------
|
| Determines whether the XSS filter is always active when GET, POST or
| COOKIE data is encountered
|
*/
$config['global_xss_filtering'] = TRUE;

/*
|--------------------------------------------------------------------------
| Cross Site Request Forgery
|--------------------------------------------------------------------------
| Enables a CSRF cookie token to be set. When set to TRUE, token will be
| checked on a submitted form. If you are accepting user data, it is strongly
| recommended CSRF protection be enabled.
|
| 'csrf_token_name' = The token name
| 'csrf_cookie_name' = The cookie name
| 'csrf_expire' = The number in seconds the token should expire.
*/
$config['csrf_protection'] = FALSE;
$config['csrf_token_name'] = 'csrf_test_name';
$config['csrf_cookie_name'] = 'csrf_cookie_name';
$config['csrf_expire'] = 7200;

/*
|--------------------------------------------------------------------------
| Output Compression
|--------------------------------------------------------------------------
*/
$config['compress_output'] = FALSE;

/*
|--------------------------------------------------------------------------
| Master Time Reference
|--------------------------------------------------------------------------
*/
$config['time_reference'] = 'local';


/*
|--------------------------------------------------------------------------
| Rewrite PHP Short Tags
|--------------------------------------------------------------------------
*/
$config['rewrite_short_tags'] = FALSE;


/*
|--------------------------------------------------------------------------
| Reverse Proxy IPs
|--------------------------------------------------------------------------
*/
$config['proxy_ips'] = '';


/* End of file config.php */
/* Location: ./application/config/config.php */

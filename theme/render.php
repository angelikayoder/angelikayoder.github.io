<?php
/**
 * @file
 * Used to render PHP files & save rendered output into .htm files
 *
 * usage:
 * render.php?tpl=index
 */
//error_reporting(0);
define('THEME_VERSION', '3.0.9');
define('THEME_BASE_DIR', getcwd());
define('THEME_LOCAL_ASSETS_DIR', '/node_modules/');
define('THEME_TMP_DIR', THEME_BASE_DIR .'/_tmp/');
define('THEME_BUYNOW_URL', 'https://wrapbootstrap.com/theme/strapped-responsive-website-template-WB0C6D0H4?ref=tme');
define('THEME_UPSELL_URL', 'https://wrapbootstrap.com/theme/strapped-responsive-website-template-WB0C6D0H4?ref=tme');
define('JQUERY_VERSION', '3.2.1');
define('JQUERY_CDN', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/'. JQUERY_VERSION . '/jquery.min.js');
define('BOOTSTRAP_VERSION', 'v4.0.0-beta.2');
define('BOOTSTRAP_CSS_CDN', "https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css");
define('BOOTSTRAP_JS_CDN', "https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js");
define('FONTAWESOME_VERSION', '4.7.0');
define('FONTAWESOME_CSS_CDN', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
define('POPPER_VERSION', '1.12.3');
define('POPPER_CDN', "https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js");
define('TEMPLATE_PATH', 'templates');
define('TEMPLATE_INC_PATH', 'templates/includes');
define('TEMPLATE_ASSETS_PATH', TEMPLATE_PATH .'/_hidden_assets');
define('OUTPUT_FILE_TYPE', '.html');
define('OUTPUT_PATH', '');
define('OUTPUT_LITE_PREFIX', 'lite-');
define('HEAD_TITLE_DEFAULT', 'strapped Bootstrap Theme by Themelize.me');
define('SLIDER_REV_VERSION', '5.4.4');
define('DEMO_IMG_PATH', 'assets/img/demos/');

// Includes
include('templates/_pages.inc');
include('templates/dindent/src/Parser.php');
include('templates/includes/helper-functions.php');

global $plugins, $titles, $tags, $types, $users, $blog_media, $videos, $imgs, $audio, $team_members, $customers, $project_types;

// Blog stuff
$titles = array('Enim augue elit adipiscing placerat natoque', 'amet urna integer urna enim, sit arcu pid in nec?', 'Magna aliquet diam mauris tortor turpis vel porta', 'a nec in sed hac ultrices cursus', 'Urna natoque in phasellus rhoncus aliquet penatibus', 'Turpis odio dictumst tempor ac et!', 'Porta risus porttitor facilisis sit dapibus', 'Odio, nunc platea mattis, mid et', 'Nisi rhoncus nisi porttitor risus ridiculus tristique, quis.');
$tags = array('culture', 'general', 'coding', 'design', 'weather', 'jobs', 'health');
$types = array('news', 'feature', 'event', 'video', 'podcast');
$users = array('Tom', 'Alex', 'Erin', 'Dave', 'Joe', 'Jo');
$user_pics = array('adele.jpg', 'bono.jpg', 'robert.jpg', 'jimi.jpg', 'steve.jpg', 'obama.jpg');

$team_members = array(
  'jimi' => 'Founder & developer',
  'adele' => 'Founder & designer',
  'bono' => 'The Tech Guy',
  'robert' => 'Junior designer',
  'steve' => 'Sales Manager',
  'jolie' => 'Marketing Expert',
  'obama' => 'Project Manager',
  'kate' => 'Project Manager',
);

$customers =  array(
  'amazon' => 'Amazon',
  'bitbucket' => 'BitBucket',
  'css3' => 'CSS3',
  'ebay' => 'eBay',
  'github' => 'GitHub',
  'google' => 'Google',
  'html5' => 'HTML5',
  'jquery' => 'jQuery',
  'less' => 'LESS',
  'vodafone' => 'Vodafone',
  'yahoo' => 'Yahoo',
  'youtube' => 'YouTube'
);

$project_types = array(
  'Drupal',
  'Wordpress',
  'Ghost',
  'UX Design',
  'UI Design',
  'Art Direction'
);

$blog_media = array('video', 'audio', 'image', 'image', 'image');
$imgs = array('frog.jpg', 'ladybird.jpg', 'ape.jpg', 'fly.jpg', 'water-pump.jpg', 'butterfly.jpg', 'bee.jpg');
$videos[] = '<object width="560" height="315"><param name="movie" value="//www.youtube.com/v/YXVoqJEwqoQ?version=3&amp;hl=en_US&amp;rel=0"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="//www.youtube.com/v/YXVoqJEwqoQ?version=3&amp;hl=en_US&amp;rel=0" type="application/x-shockwave-flash" width="560" height="315" allowscriptaccess="always" allowfullscreen="true"></embed></object>';
$videos[] = '<object width="560" height="315"><param name="movie" value="//www.youtube.com/v/qpWlaOeGZ_4?hl=en_US&amp;version=3&amp;rel=0"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="//www.youtube.com/v/qpWlaOeGZ_4?hl=en_US&amp;version=3&amp;rel=0" type="application/x-shockwave-flash" width="560" height="315" allowscriptaccess="always" allowfullscreen="true"></embed></object>';
$audio[] = '<iframe width="100%" height="166" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/113479203&amp;color=ff5500&amp;auto_play=false&amp;hide_related=false&amp;show_artwork=true"></iframe>';
$audio[] = '<iframe width="100%" height="166" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/129984274&amp;color=ff5500&amp;auto_play=false&amp;hide_related=false&amp;show_artwork=true"></iframe>';



//alter this per theme
$all_pages = theme_get_pages();
function output_tpl($php_tpl, $output_file, $page_data, $echo = FALSE) {
  if (file_exists($php_tpl)) {
    $parser = new \Gajus\Dindent\Parser();
    $output = get_include_contents($php_tpl, $page_data);
    $output = $parser->indent($output);
    
    if ($echo) {   
      ob_start();
      echo $output;
      ob_end_flush();
      return;
    }
    
    if (file_put_contents($output_file, $output)) {
      return TRUE;
    }
    else {
      return FALSE;
    }
  }
  else {
    print_r($php_tpl . ' does not exist');
    return FALSE;
  }
}

function get_include_contents($filename, $page_data) {
  global $GLOBAL_ASSETS, $all_pages, $plugins, $titles, $tags, $types, $users, $blog_media, $videos, $imgs, $audio, $team_members, $customers, $project_types;
  
  // Assets
  $GLOBAL_ASSETS = array(
    // CSS
    'BOOTSTRAP_CSS' => BOOTSTRAP_CSS_CDN,
    'FONTAWESOME_CSS' => FONTAWESOME_CSS_CDN,
    
    // JS
    'RETINA_JS' => 'https://cdnjs.cloudflare.com/ajax/libs/retina.js/1.3.0/retina.min.js',
    'JQUERY_JS' => JQUERY_CDN,
    'POPPER_JS' => POPPER_CDN,
    'BOOTSTRAP_JS' => BOOTSTRAP_JS_CDN,
    
    // Icons
    'IONICONS_CSS' => 'http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css',
    'LINEARICONS_CSS' => 'https://cdn.linearicons.com/free/1.0.0/icon-font.min.css',
    'FLAGICONS_CSS' => 'assets/plugins/flag-icon-css/css/flag-icon.min.css',
    
    // Fonts
    'FONTS_CSS' => array(
      'http://fonts.googleapis.com/css?family=Open+Sans:400,700,300',
      'http://fonts.googleapis.com/css?family=Rambla:400,700',
      'http://fonts.googleapis.com/css?family=Calligraffitti',
      'http://fonts.googleapis.com/css?family=Roboto+Slab:400,700'
    ),
  );
  
  if (!empty($_GET['offline'])) {
    $base = THEME_LOCAL_ASSETS_DIR;
    $GLOBAL_ASSETS = array(
      'BOOTSTRAP_CSS' => $base .'bootstrap/dist/css/bootstrap.min.css',
      'FONTAWESOME_CSS' => $base .'bootstrap/dist/css/bootstrap.min.css',
      'RETINA_JS' => FALSE,
      'JQUERY_JS' => $base .'jquery/dist/jquery.min.js',
      'POPPER_JS' => $base .'popper.js/dist/umd/popper.min.js',
      'BOOTSTRAP_JS' => $base .'bootstrap/dist/js/bootstrap.min.js',
    );    
  }
  
  //settings
  $blazy_placeholder = 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==';
  $navbar_sticky = FALSE;
  $navbar_class = 'navbar-static-top'; //navbar-static-top
  $navbar_main_class = '';
  $navbar_toggle_class = 'd-lg-none'; // blank = persistent off canvas
  $navbar_toggleable_class = 'navbar-expand-md'; // hidden-xs-up = persistent off canvas
  $navbar_nav_class = 'float-lg-right'; // blank = persistent off canvas
  $navbar_layout = 'default'; // options: default, navbar-below
  $body_class_default = 'page'; //has-navbar-fixed-top';
  $head_title = $page_data['title'] .' | '. HEAD_TITLE_DEFAULT;
  $theme_name = 'strapped';
  $theme_title = '<span class="header-brand-text-alt">App</span>Strap<span class="header-brand-text-alt">.</span>';
  $theme_slogan = 'Bootstrap 4 Theme';
  $theme_slogan_class = 'd-none d-lg-block';
  $theme_brand_divider = TRUE;
  $theme_brand_divider_class = 'd-none d-lg-block';
  $js_debug = !empty($_GET['js_debug']) ? TRUE : FALSE;
  $mobile_menu_type = 'jpanel-menu';
  $mobile_menu_target = '.navbar-main';
  $page_loading = TRUE;
  $theme_css_main = 'assets/css/theme-style.min.css';
  $theme_css_extras = array(); //'full-path-to-file' => 'comment'
  $no_flexbox = FALSE;
  $header_sticky = TRUE;
  $style_switcher = TRUE;
  $default_modals = TRUE;
  
  // debug mode
  if ($_GET['debug']) {
    $js_debug = TRUE;
    $theme_css_main = str_replace('.min', '', $theme_css_main);
  }
  
  $navbar_full_width = FALSE;
  $no_mega_menus = FALSE;
  $page_title = $page_data['title'];
  $elements_sidebar = TRUE;
  $elements_menu_align_class = '';
  $elements_menu_item_icon = 'fa-angle-right';
  
  // Header settings
  $header_container = 'container';
  $header_hidden_region = TRUE;
  $header_upper_region = TRUE;
  $header_search_region = TRUE;
  $header_brand_class = '';
  $header_brand_h_class = 'h2';
  $header_block_class = 'order-12';
  $header_class = "";
  $header_navbar_nav = TRUE;
  $header_navbar_toggle = TRUE;
  $header_navbar_after_inc = '';
  $header_navbar_after_content = '';
  $search_btn_classes = 'btn btn-icon btn-link header-btn float-right';
  $mobile_menu_btn_classes = 'btn btn-link btn-icon header-btn float-right';
  $mobile_menu_btn_text = '';
  $navbar_secondary_links_inc = ''; //'_main_nav_secondary_links.inc';
  
  // Shop Settings
  $header_shopping_cart = FALSE;
  $header_shopping_cart_inc = '_shop_cart_dropdown.inc';
  $header_shopping_cart_btn = ''; // blank = default, large = big button
  $shop_cart_table = ''; //can be summary
  
  // Page header settings
  $page_header_class = '';
  $page_header_breadcrumb = TRUE;
  $page_header_after_content = '';
  $page_header_after_content_inc = '';
  
  // Includes
  $header_navbar_nav_inc = '_main_nav.inc';
  $header_nav_inc = 'includes/_header_nav.inc';
  $footer_inc = 'includes/_footer.inc';
  $closure_inc = 'includes/_closure.inc';
  $closure_extra_inc = '';
  $slider_rev_slides_inc = 'includes/_slider_revolution_slides_home.inc';
  $index_content = 'includes/_index_content.inc';
  $onepager_content = 'includes/_onepager_content.inc';
  $header_shop_dropdown_inc = '_shop_cart_dropdown.inc';
  $shop_sidebar_inc = 'includes/_shop_sidebar.inc';
  
  // Footer
  $footer_class = '';
  $footer_highlight = 'text-white';
  $footer_btns_class = 'btn-inverse btn-invert btn-rounded';
  $footer_hr_class = 'hr-white op-1';
  $footer_bg_alt = 'bg-inverse-dark';
  
  // Lite version
  $lite_version_pages = array('index', 'blog', 'blog-post', 'about', 'pricing', 'timeline', 'login', 'signup');
  
  // Per page overrides
  $page_settings = isset($page_data['settings']) && !empty($page_data['settings']) ? $page_data['settings'] : array();
  foreach ($page_settings as $setting => $value) {
    ${$setting} = $value;
  }
  
  // Footers
  if ($footer_type == 'light') {
    $footer_class = 'footer-light';
    $footer_highlight = 'text-grey-dark';
    $footer_btns_class = 'btn-inverse btn-rounded';
    $footer_hr_class = 'hr-inverse op-1';
    $footer_bg_alt = 'bg-grey';
  }  
  
  // Shop
  if ($header_shopping_cart) {
    $theme_css_extras['assets/css/theme-shop.min.css'] = 'Shop UI CSS - required if using shopping cart or any shop pages';
  }
  if (strpos($filename, 'shop') !== FALSE && empty($page_data['settings']['footer_inc'])) {
    $footer_inc = 'includes/_footer_menus.inc';
  }
  
  // One pagers
  if (strpos($filename, 'onepager') !== FALSE && !isset($page_data['settings']['header_sticky'])) {
    $header_sticky = TRUE;
  }
  
  // Helper functions includes
  $page_name = $page_data['name'];
  $incs = array();
  $incs[] = TEMPLATE_PATH .'/page_includes/'. $page_name .'.inc';
  
  if (!empty($incs)) {
    foreach ($incs as $inc) {
      if (file_exists($inc)) {
        include_once($inc);
      }
    }
  }
  
  // colors
  $theme_colors = array(
    'green',
    'red',
    'blue',
    'purple',
    'pink',
    'orange',
    'lime',
    'blue-dark',
    'red-dark',
    
    'brown', // #91633c
    'cyan-dark', // #2aa4a5
    'yellow', // #D4AC0D
    'slate', // #5D6D7E
    
    'olive', // #808000
    'teal', // #008080
    'green-bright', // #2ECC71
  );
  
  // General - @TODO - expand list with description & URL for readme
  $plugins = array();
  $plugins['bsswitch'] = 'bsswitch';
  $plugins['sliders'] = array('flexslider', 'revolution', 'backstretch'); //, 'layerslider');
  
  // iconsets
  $iconsets = array(
    'fontawesome',
    'flags',
    'ionicons',
    'linearicons',
  );
  
  // variables
  $body_classes = array();
  $body_classes[] = $body_class_default;
  $body_classes[] = 'page-'. $_GET['tpl'];
  $body_classes[] = 'navbar-layout-' . $navbar_layout;
  $body_classes = implode(' ', $body_classes); 
  
  $screenshot = FALSE;
  if ($_GET['screenshot'] == true || $_GET['make_screenshot'] == true) {
    $header_sticky = $navbar_sticky = FALSE;
    $style_switcher = FALSE;
    $page_loading = FALSE;
    $theme_css_extras[TEMPLATE_ASSETS_PATH . '/css/screenshot.css'] = 'Screenshot CSS';
    $screenshot = TRUE;
  }
  
  if (is_file($filename)) {
    ob_start();
    include $filename;
    $output = ob_get_clean();
    
    // screenshots
    if ($screenshot == true) {
      if (strpos($output, 'data-bg-video') !== FALSE) {
        $output = str_replace('data-bg-video', 'data-bg-img', $output);
        $output = str_replace('.mp4', '.jpg', $output);
      }
      $remove = array(
        ',"background-attachment": "fixed"',
        ', "sliderLayout":"fullscreen"',
      );
      $output = str_replace($remove, '', $output);
    }     
    
    return $output;
  }
  return false;
}

//render all in one go
if ($_GET['tpl'] == 'all') {
  print "--------------------------------------<br />"; 
  print "Rendering of all templates (". (count($all_pages)) .") initiated<br />";
  print "--------------------------------------<br />";
  $success = array();
  $total = array();
  foreach ($all_pages as $k => $data) {
    $page = $data;
    if (is_array($data)) {
      $page = $k;
    }
    
    $php_tpl = TEMPLATE_PATH .'/'. $page .'.php';
    $output_file = OUTPUT_PATH . $page . OUTPUT_FILE_TYPE;
    $page_data = array_merge(array('name' => $k), $data);
    
    $total[] = $php_tpl;

    print "<h4>". (count($total)) .") $php_tpl -> $output_file rendering initiated</h4>";    
    
    if (file_exists($php_tpl)) {
      $_GET['tpl'] = $page;
      
      if (!empty($data['active'])) {
        $_GET['active'] = $data['active'];
      }
      
      $parser = new \Gajus\Dindent\Parser();
      $output = get_include_contents($php_tpl, $page_data);
      $output = $parser->indent($output);
      if (file_put_contents($output_file, $output)) {
	print "<strong>SUCCESS: $output_file file rendering successful</strong><br />";
	$success[] = $output_file;
      }
      else {
	print "<strong>ERROR: $output_file file rendering failed</strong><br />";
      }
    }
    print "--------------------------------------<br /><br />"; 
  }
  
  print "<h2>". (count($success)) ." out of ". (count($all_pages)) ." files rendered</h2>";
}
elseif ($_GET['tpl'] == 'screenshots') {
  foreach ($all_pages as $k => $data) {
    $page = $data;
    $php_tpl = TEMPLATE_PATH .'/'. $k .'.php';
    if (file_exists($php_tpl) && !empty($data['make_screenshot'])) {
      $crop_options = $all_pages[$k]['screenshot_settings'];
      print "--------------------------------------<br />";
      print 'Making screenshot for: ' . $k .'<br />';
      generate_thumbnail_from_url('http://local.strappedtheme.com/render.php?tpl='. $k .'&screenshot=true', $k .'.png', $crop_options);
    }
  }
  print "--------------------------------------<br /><br />";
  print 'Screenshots for all pages rendered';  
}
//specific template
else {
  $php_tpl = TEMPLATE_PATH .'/'. $_GET['tpl'] .'.php';
  $output_file = OUTPUT_PATH . $_GET['tpl'] . OUTPUT_FILE_TYPE;
  $page_data = array_merge(array('name' => $_GET['tpl']), $all_pages[$_GET['tpl']]);

  // make screenshot
  if ($_GET['make_screenshot']) {
    $crop_options = $all_pages[$_GET['tpl']]['screenshot_settings'];
    generate_thumbnail_from_url('http://local.strappedtheme.com/render.php?tpl='. $_GET['tpl'] .'&screenshot=true', $_GET['tpl'] .'.png', $crop_options);
    print 'Made screenshot for: ' . $_GET['tpl'] .'<br />';
  }
  // Screenshot render
  elseif ($_GET['screenshot']) {
    echo output_tpl($php_tpl, $output_file, $page_data, TRUE);    
  }
  else {
    print "<h4>". (count($total)) .") $php_tpl -> $output_file rendering initiated</h4>";   
   
    if (output_tpl($php_tpl, $output_file, $page_data)) {
      print "<strong>SUCCESS: $output_file file rendering successful</strong><br />";
    }
    else {
      print "<strong>ERROR: $output_file file rendering failed</strong><br />";
    }
    
    // Subpages
    if ($page_data['subpages']) {
      print "<h4>--> Rendering subpages (". (count($page_data['subpages'])) .")</h4>";
      
      foreach ($page_data['subpages'] as $subpage_tpl => $subpage_output) {
        $subpage_tpl = TEMPLATE_PATH .'/'. $subpage_tpl .'.php';
        $subpage_output = OUTPUT_PATH . $subpage_output . OUTPUT_FILE_TYPE;
        
        if (output_tpl($subpage_tpl, $subpage_output, $page_data)) {
          print "<strong>---> SUCCESS: $subpage_output file rendering successful</strong><br />";
        }
        else {
          print "<strong>---> ERROR: $subpage_output file rendering failed</strong><br />";
        }      
      }
    }
  }
}

if ($_GET['tpl'] == 'pages') {
  foreach ($all_pages as $k => $data) {
    $page = $data;
    
    $php_tpl = TEMPLATE_PATH .'/'. $k .'.php';
    if (file_exists($php_tpl)) {
      if (is_array($data)) {
        $page = $k;
      }
  
      $readme[] = '* '. (!empty($data['title']) ? ucfirst($data['title']) : ucfirst($page)) .' ('. $page .'.html)';
    }
  }

print '
----------------------------<br />
PAGES PROVIDED ('. count($readme) .')<br />
----------------------------<br />';
print implode('<br />', $readme);  
}




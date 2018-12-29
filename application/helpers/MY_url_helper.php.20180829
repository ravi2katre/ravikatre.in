<?php

/**
 * Helper class with shortcut functions to lookup URL
 */

// location of public asset folder
function asset_url($path)
{
	return base_url('assets/'.$path);
}

// location of uploaded files
function upload_url($path)
{
	return base_url('assets/uploads/'.$path);
}

// location of post-processed assets (e.g. combined CSS / JS files)
function dist_url($path)
{
	return base_url('assets/dist/'.$path);
}

// location of post-processed images (i.e. optimized filesize)
function image_url($path)
{
	return base_url('assets/dist/images/'.$path);	
}

// location to pages in different language
// Sample Usage: 
// 	- lang_url('en'): to English version of current page
// 	- lang_url('en', 'about'): to English version of About page
function lang_url($lang, $url = NULL)
{
	$CI =& get_instance();
	$config = $CI->config->item('ci_bootstrap');
	
	if ( empty($config['languages']) )
	{
		$url = ($url===NULL) ? current_full_url() : $url;
		return base_url($url);
	}
	else
	{
		$lang_config = $config['languages'];
		$available_lang = $lang_config['available'];

		if ($url===NULL)
		{
			$segment_1 = $CI->uri->segment(1, $lang_config['default']);

			// current page in target language
			if (array_key_exists($segment_1, $available_lang))
			{
				// URL already contains language abbr
				if ($CI->uri->total_segments()==1)
					$target_url = str_replace("/$segment_1", "/$lang", current_full_url());
				else
					$target_url = str_replace("/$segment_1/", "/$lang/", current_full_url());
			}
			else
			{
				// URL does not contain language abbr
				$target_url = base_url($lang.'/'.$CI->uri->uri_string());
			}
		}
		else
		{
			// target page in target language
			$target_url = base_url($lang.'/'.$url);
		}

		return $target_url;
	}
}

// current URL includes query string
// Reference: http://stackoverflow.com/questions/4160377/codeigniter-current-url-doesnt-show-query-strings
function current_full_url()
{
	$CI =& get_instance();
	$url = $CI->config->site_url($CI->uri->uri_string());
	return $_SERVER['QUERY_STRING'] ? $url.'?'.$_SERVER['QUERY_STRING'] : $url;
}

// refresh current page (interrupt other actions)
function refresh()
{
	redirect(current_full_url(), 'refresh');
}

// referrer page
function referrer()
{
	$CI =& get_instance();
	$CI->load->library('user_agent');
	return $CI->agent->referrer();
}

// redirect back to referrer page
function redirect_referrer()
{
	redirect(referrer());
}

function admin_menus(){
    $ci =& get_instance();
    $ci->db->from('menus');
    //$ci->db->where('menu_id',$id);
    $ci->db->order_by('sort_by');
    $query = $ci->db->get();
    $rows = $query->result_array();
    $menus = buildTree($rows);
    $new_menus = array();
    foreach($menus as $key=>$val){
        $new_menus[$val['name']] = $val;
        $new_menus[$val['name']]['children'] = array();
        if(isset($val['children'][0])){
            foreach($val['children'] as $key_sub=>$val_sub){
                $new_menus[$val['name']]['children'][$val_sub['name']] = $val_sub['url'];
            }
        }

    }
    //cidb($new_menus);exit;
    return $new_menus;
}

function buildTree(array $elements, $parentId = 0) {
    $branch = array();

    foreach ($elements as $element) {
        if ($element['parent_id'] == $parentId) {
            $children = buildTree($elements, $element['menu_id']);
            if ($children) {
                $element['children'] = $children;
            }
            $branch[] = $element;
        }
    }

    return $branch;
}

function objToArray($obj, &$arr){

    if(!is_object($obj) && !is_array($obj)){
        $arr = $obj;
        return $arr;
    }

    foreach ($obj as $key => $value)
    {
        if (!empty($value))
        {
            $arr[$key] = array();
            objToArray($value, $arr[$key]);
        }
        else
        {
            $arr[$key] = $value;
        }
    }
    return $arr;
}
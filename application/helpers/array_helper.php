<?php


if ( ! function_exists('__unserialize'))
{
	function __unserialize($string) {
	    $unserialized = stripslashes($string);
	       $unserialized = preg_replace('!s:(\d+):"(.*?)";!e', "'s:'.strlen('$2').':\"$2\";'", $unserialized );
	       return unserialize($unserialized);
	}
}


function map_column_with_array_key($table_name=null,$data){
    //test code
    /*$data = new stdClass();
    $data->username ='ravi';
    $data->dd_name ='ravi';
    $data->uuuu_name ='ravi';
    cidb($data);
    $result = map_column_with_array_key('users',$data);
    cidb($result);exit;*/

    if($table_name == null)
        return $data;

    $data = (array) $data;

    if(!array_filter($data)) {
        return $data;
    }else{
        $data = array_filter($data);
    }

    $ci =& get_instance();
    $fields = $ci->db->list_fields($table_name);

    foreach ($data as $field=>$val)
    {
        if(!in_array($field,$fields)){
            unset($data[$field]);
        }elseif(empty($val)){
            unset($data[$field]);
        }
    }

    return array_filter($data);
}



function cidb ( $what ) {
    echo '<pre>';
    if ( is_array( $what ) )  {
        print_r ( $what );
    } else {
        var_dump ( $what );
    }
    echo '</pre>';
}

/**
 * @param $containts
 * @param string $fileName
 */
function logit($containts, $fileName = '') {
    error_reporting(0);
    if (empty($fileName))
        $fileName = "error_log_" . date('Y-m-d') . '.txt';
    else
        $fileName = $fileName . '.txt';
    if (!is_dir(FCPATH . "uploads/logs/" . date('Y/m/d'))) {
        mkdir(FCPATH . "uploads/logs/" . date('Y/m/d'), 0777, TRUE);
    }
    $filePath = FCPATH . "uploads/logs/" . date('Y/m/d/') . $fileName;
    file_put_contents($filePath, date('Y-m-d H:i:s') . ":=" . $containts, FILE_APPEND | LOCK_EX);
}
?>
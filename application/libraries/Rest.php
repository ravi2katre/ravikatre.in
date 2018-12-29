<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * CodeIgniter REST Class
 *
 * Make REST requests to RESTful services with simple syntax.
 *
 * @package         CodeIgniter
 * @subpackage      Libraries
 * @category        Libraries
 * @author          Philip Sturgeon
 * @author          Chris Kacerguis
 * @created         04/06/2009
 * @license         http://philsturgeon.co.uk/code/dbad-license
 * @link            http://getsparks.org/packages/restclient/show
 */

class REST
{
    // Method: POST, PUT, GET etc
    // Data: array("param" => "value") ==> index.php?param=value

    function CallAPI($method, $url, $data = false)
    {
        $api_domain = base_url();
        $url = $api_domain.$url;

        $curl = curl_init();

        switch ($method)
        {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);

                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_PUT, 1);
                break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
        }

        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'x-api-key: anonymous'
        ));

        // Optional Authentication:
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_USERPWD, "username:password");

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($curl);

        curl_close($curl);

        return json_decode($result, true);
    }

}

/* End of file REST.php */
/* Location: ./application/libraries/REST.php */
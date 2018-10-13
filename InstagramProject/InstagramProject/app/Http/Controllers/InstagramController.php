<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use MetzWeb\Instagram\Instagram;

/**
 * Instagram When logging in with Controller
 */
class InstagramController extends Controller
{
    # Because it is used in common, stored in construct
    private $instagram;

    function __construct() {
        # Get value of App from # config and instantiate
        $this->instagram = new Instagram(array(
            'apiKey' => config('instagram.client_id'),
            'apiSecret' => config('instagram.client_secret'),
            'apiCallback' => config('instagram.callback_url')
        ));
    }

    /**
     * Instagram Processing when registering with login, login being pressed
     */
    public function instagramLogin() {
        
    }

    /**
     * Instagram Process at the time of registering at login, redirecting after login was pressed
     * Instagram You can get information on
     */
    public function instagramCallback(Request $request) {
        # URL Since code is included in
        $code = $request->code;
        # Using the acquired code, OAhtu authentication
        $data = $this->instagram->getOAuthToken($code);
        $this->instagram->setAccessToken($data);

        # Since OAuth authentication is completed, you can hit your favorite API with $ instagram -> "method"
        # Since this time it is a login function in Instagram, use getUser ()
        $user_data = $this->instagram->getUser();

        echo '<pre>';
        var_dump($data);
        echo '</pre>';
    }
}
<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use CodeIgniter\HTTP\URI;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var list<string>
     */
    protected $helpers = ['form','url'];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    protected $session;
    protected $uri_segments;
    protected $is_logged_in = false;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        $this->session = \Config\Services::session();

        $current_url = current_url(true);
        $uri = new URI($current_url);
        $url_segments = $uri->getSegments();
        $this->uri_segments = $url_segments;

        // if(is_array($url_segments) && isset($url_segments[1]) && $url_segments[1] == 'admin'){
        //     echo 'admin';
        //     $session_data = $this->session->get();
        //     print_r($session_data);
        //     if(isset($session_data['user_id'])){
        //         echo 'okk';
        //         return redirect()->to('admin/dashboard');
        //     }
        // }
    }

    protected function randerPage($view, $data = [])
    {
        $segments = $this->uri_segments;
        if( is_array($segments) && isset($segments[1]) && $segments[1] == 'admin' ){
            $role = 1;
        }
        else{
            $role = 2;
        }

        $layout_header = 'layouts/user/header';
        $layout_footer = 'layouts/user/footer';

        if($role == 1){
            $layout_header = 'layouts/admin/admin_header';
            $layout_footer = 'layouts/admin/admin_footer';
        }

        return view($layout_header).view($view, $data).view($layout_footer);
    }
}

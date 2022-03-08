<?php

namespace App\Modules\System_user\Controllers\Admin;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 *
 * @package CodeIgniter
 */

use CodeIgniter\Controller;
use App\Libraries\Template;
use App\Models\Common_model;
use App\Libraries\UploadImage;
use App\Modules\System_user\Models\Admin\Admin_model;

class BaseController extends Controller
{

	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = ['form', 'url', 'lang_helper'];

	/**
	 * Constructor.
	 */
	/*protected $template;
	protected $auth_model;
	protected $dashboard_model;
	protected $home_model;
	protected $BASE_VIEW;*/

	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);

		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		// E.g.:

		//Calling Libraries
		$this->session 		 	= \Config\Services::session();
		$this->validation    	=  \Config\Services::validation();
		$this->request 		 	= \Config\Services::request();
		$this->pager            = \Config\Services::pager();
		$this->imageupload 		= new UploadImage();
		$this->uri 				= service('uri');
		$this->db 	   		 	= db_connect();

		$this->BASE_VIEW 	 	= "App\Modules\System_user\Views\Admin";

		//calling Model
		$this->template 	 	= new Template();
		$this->common_model 	= new Common_model();
		$this->admin_model 		= new Admin_model();
	}
}
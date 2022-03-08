<?php

namespace App\Modules\Token\Controllers\Admin;

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
/*use App\Modules\Finance\Models\Customer\Payment_model;*/
/*use App\Modules\Auth\Models\customer\Auth_model;
use App\Modules\Auth\Models\customer\Deshboard_model;*/

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

	/*protected  $auth_model;
	protected  $dashboard_model;
	protected $USER_ID;
	protected $BASE_VIEW;*/

	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);

		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		// E.g.:

		//Creating Libraries object
		$this->db            = db_connect();
		$this->validation    =  \Config\Services::validation();
		$this->session 		 = \Config\Services::session();
		$this->request 		 = \Config\Services::request();
		$this->pager         = \Config\Services::pager();
		$this->uri 			 = service('uri');
		$this->USER_ID 		 = $this->session->get('user_id');
		$this->BASE_VIEW 	 = "App\Modules\Token\Views\Admin";


		//Creating Model object
		$this->template 		= new Template();
		$this->common_model 	= new Common_model();
		
	}
}
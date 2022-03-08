<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AdminFilters
 *
 * @author bdtask
 */

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Customer_filter implements FilterInterface
{
	//put your code here
	public function before(RequestInterface $request, $arguments = null)
	{
		
		if (!session()->has('isLogIn') || !session()->has('user_id')) {
			return redirect()->to(base_url('login'));
		}
	}

	//--------------------------------------------------------------------

	/**
	 * We don't have anything to do here.
	 *
	 * @param RequestInterface|\CodeIgniter\HTTP\IncomingRequest $request
	 * @param ResponseInterface|\CodeIgniter\HTTP\Response       $response
	 * @param array|null                                         $arguments
	 *
	 * @return mixed
	 */
	public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
	{
	}
}
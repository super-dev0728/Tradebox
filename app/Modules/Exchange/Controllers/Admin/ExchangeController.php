<?php namespace App\Modules\Exchange\Controllers\Admin;

class ExchangeController extends BaseController
{
    public function index(){

        $page_number      = (!empty($this->request->getGet('page'))?$this->request->getGet('page'):1);
        $data['deposit']  = $this->common_model->get_all('dbt_deposit', array(), 'id','desc',20,($page_number-1)*20);
        $total            = $this->common_model->countRow('dbt_deposit');
        $data['pager']    = $this->pager->makeLinks($page_number, 20, $total);

        $data['title']  = 'Coin List';
       
        $data['content'] = $this->BASE_VIEW . '\cryptocoin\list';
        return $this->template->admin_layout($data);
    }

    public function ajax_list()
    {
        $post_data = $this->request->getVar();
        $list      = $this->exchange_model->get_datatables();

        $data = array();
        $no   = $this->request->getVar('start');

        foreach ($list as $cryptocoin) {

            $imagepath = $cryptocoin->image?IMAGEPATH.$cryptocoin->image:$cryptocoin->url;
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = '<img src="'.$imagepath.'" width="50px" />';
            $row[] = $cryptocoin->coin_name;
            $row[] = $cryptocoin->full_name;
            $row[] = $cryptocoin->symbol;
            $row[] = $cryptocoin->algorithm;
            $row[] = $cryptocoin->sponsored;
            $row[] = (($cryptocoin->show_home == 1)?'Yes':'No')."/ ".$cryptocoin->coin_position;
            $row[] = $cryptocoin->rank;
            $row[] = $cryptocoin->status;
            $row[] = '<a href="'.site_url("backend/exchange/cryptocoin-edit/$cryptocoin->id").'"'.' class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="Update"><i class="hvr-buzz-out fas fa-pencil-alt"></i></a>';
            $data[] = $row;
        }

        $output = array(
                "draw" => $this->request->getVar('draw'),
                "recordsTotal" => $this->common_model->countRow('dbt_cryptocoin', array()),
                "recordsFiltered" => $this->exchange_model->count_filtered(),
                "data" => $data,
            );
        //output to json format
        echo json_encode($output);
    }

    public function coin_check($coin_name, $id)
    { 
        $coinExists = $this->common_model->findById('dbt_cryptocoin', array('coin_name' => $coin_name, 'proof_type !=' => 'erc20', 'id !=' => $id));

        if (!empty($coinExists)){
            return 1;
        } else {
            return 0;
        }
    }

    public function coinsym_check($symbol, $id, $proof_type = null)
    { 
         if($this->request->getPost('proof_type') != 'erc20'){
            $coinExists = $this->common_model->findById('dbt_cryptocoin', array('symbol' => $symbol, 'proof_type !=' => 'erc20', 'id !=' => $id));
        } else {
            $coinExists = $this->common_model->findById('dbt_cryptocoin', array('symbol' => $symbol, 'proof_type' => 'erc20', 'id !=' => $id));
        }
        if (!empty($coinExists)){
            return 1;
        } else {
            return 0;
        }
    } 

    public function form($id = null)
    { 
    
        $data['last_row'] = $this->db->table('dbt_cryptocoin')->select('cid')->orderBy('cid',"desc")->limit(1)->get()->getRow();
        if ($this->request->getMethod() == 'post') {

            if($this->request->getPost('proof_type') != 'erc20'){

                $checkExist = $this->common_model->findById('dbt_cryptocoin', array('symbol' => $this->request->getPost('symbol'), 'proof_type !=' => 'erc20'));
            } else {
                $checkExist = $this->common_model->findById('dbt_cryptocoin', array('symbol' => $this->request->getPost('symbol'), 'proof_type' => 'erc20'));
            }

            if($checkExist && !$id){

                $this->session->setFlashdata('exception','This Symbol Already Exist!');
                return redirect()->to(base_url('backend/erc20/form'));
            }

            if (!empty($id)) {
                
                $existsymbol = $this->coinsym_check($this->request->getPost('symbol'), $id, $this->request->getPost('proof_type'));
                if($existsymbol == 1){

                    $this->session->setFlashdata('exception', "This Symbol Already Exists, Please Try Again!");
                    return redirect()->route('backend/exchange/cryptocoin');
                }
            } 

            $this->validation->setRule('coin_name', "Coin Name","max_length[100]|required|trim");
            $this->validation->setRule('symbol', 'symbol',"max_length[10]|trim");
            $this->validation->setRule('proof_type', "proof_type",'max_length[20]|required|trim');
            $this->validation->setRule('full_name', "full_name",'max_length[100]|required|trim');
            $this->validation->setRule('status', display('status'),'max_length[1]|required|trim');
            $this->validation->setRule('cid', 'Coin Id','required|trim|integer');
            $this->validation->setRule('image', "This Image", 'ext_in[image,png,jpg,gif,ico]|is_image[image]');


            if($this->validation->withRequest($this->request)->run()){

                $image_path = $this->imageupload->upload_image($this->request->getFile('image'), 'upload/coinlist/', $this->request->getPost('image_old'), 60, 60);
            } else {

                $image_path = "";
            }


            $data['cryptocoin'] = (object)$userdata = array(

                'id'            => $this->request->getPost('id'),
                'cid'           => $this->request->getPost('cid'),
                'image'         => $image_path,
                'symbol'        => $this->request->getPost('symbol'),
                'coin_name'     => $this->request->getPost('coin_name'),
                'full_name'     => $this->request->getPost('full_name'),
                'algorithm'     => $this->request->getPost('algorithm'),           
                'proof_type'    => $this->request->getPost('proof_type'),           
                'sponsored'     => $this->request->getPost('sponsored'),           
                'rank'          => $this->request->getPost('rank'),
                'show_home'     => $this->request->getPost('show_home'),
                'coin_position' => $this->request->getPost('coin_position'),
                'status'        => $this->request->getPost('status'),
            );
        

            if ($this->validation->withRequest($this->request)->run()) {

                if(empty($id)){

                    if($this->common_model->save('dbt_cryptocoin', $userdata)) {
                        $this->session->setFlashdata('message', display('save_successfully'));
                    } else {
                        $this->session->setFlashdata('exception', display('please_try_again'));
                    }
                    return redirect()->route('backend/exchange/cryptocoin');
                } else {

                    if ($this->common_model->update('dbt_cryptocoin', $userdata, array('cid' => $this->request->getVar('cid')))) {
                        $this->session->setFlashdata('message', display('update_successfully'));
                    } else {
                        $this->session->setFlashdata('exception', display('please_try_again'));
                    }
                   
                    return redirect()->route('backend/exchange/cryptocoin');
                }
            } else { 
                $this->session->setFlashdata("exception", $this->validation->listErrors());
                return redirect()->route('backend/exchange/cryptocoin');
            }

        } else {

            if(!empty($id)) {
                $data['title'] = display('edit_coin');
                $data['cryptocoin'] = $this->common_model->findById('dbt_cryptocoin', array('id' => $id));
            } else {

                $data['cryptocoin'] = (object)$test= array(
                    "id"            => "",
                    "cid"           => "",
                    "symbol"        => "",
                    "coin_name"     => "",
                    "full_name"     => "",
                    'algorithm'     => "",           
                    'proof_type'    => "",           
                    'sponsored'     => "", 
                    "rank"          => "",
                    "show_home"     => "",
                    "image"         => "",
                    "status"        => "",
                    "coin_position" => "",
                );

            }

            $data['title']   = 'Coin List';
            $data['content'] = $this->BASE_VIEW.'\cryptocoin\form';
            return $this->template->admin_layout($data);

        }
        
    }

    public function market(){

        $page_number      = (!empty($this->request->getGet('page'))?$this->request->getGet('page'):1);
        $data['market']   = $this->common_model->get_all('dbt_market', array(), 'id','desc',20,($page_number-1)*20);
        $total            = $this->common_model->countRow('dbt_market');
        $data['pager']    = $this->pager->makeLinks($page_number, 20, $total);

        $data['title']  = 'Market List';
       
        $data['content'] = $this->BASE_VIEW.'\market\list';
        return $this->template->admin_layout($data);
    }

    
    public function marketsym_check($symbol, $id)
    { 
        $coinExists = $this->common_model->findById('dbt_market', array('symbol' => $symbol, 'id !=' => $id));
        if (!empty($coinExists)){
            return 1;
        } else {
            return 0;
        }
    } 
    public function market_form($id = null)
    { 
        if (!empty($id)) {              

            $existsymbol = $this->marketsym_check($this->request->getPost('symbol'), $id);
            if($existsymbol == 1){

                $this->session->setFlashdata('exception', "This Symbol Already Exists, Please Try Again!");
                return redirect()->route('backend/exchange/market');
            }

            $rules = [
                'symbol'  => 'required|max_length[100]|trim',
                'name'    => 'max_length[100]|required|trim',
                'status'  => 'max_length[1]|required|trim',
            ];

        } else {

            $rules = [
                'symbol'   => 'required|is_unique[dbt_market.symbol]|max_length[100]|trim|is_unique[dbt_market.symbol]',
                'name'    => 'max_length[100]|required|trim',
                'status'  => 'max_length[1]|required|trim',
            ];
        }

        if($this->request->getMethod() == "post"){

            $data['market'] = (object)$userdata = array(

                'name'      => $this->request->getVar('name'),
                'full_name' => $this->request->getVar('full_name'),
                'symbol'    => $this->request->getVar('symbol'),
                'status'    => $this->request->getVar('status'),
            );

            if($this->validate($rules, $rules)) 
            {

                if (empty($id)) 
                {
                    if ($this->common_model->save('dbt_market',$userdata)) {
                        $this->session->setFlashdata('message', display('save_successfully'));

                    } else {
                        $this->session->setFlashdata('exception', display('please_try_again'));

                    }


                    return redirect()->route('backend/exchange/market');

                } else {
                    if ($this->common_model->update('dbt_market',$userdata, array('id' => $id))) {
                        $this->session->setFlashdata('message', display('update_successfully'));

                    } else {
                        $this->session->setFlashdata('exception', display('please_try_again'));

                    }
                    return redirect()->route('backend/exchange/market');
                }

            } else {

                $this->session->setFlashdata("exception", $this->validation->listErrors());
                return redirect()->route('backend/exchange/market');
            }
        } else {

            if(!empty($id)) {

                $data['market']   = $this->common_model->findById('dbt_market', array('id'=>$id));

            } else {

                $data['market'] = (object)$userdata = array(

                    'id'        => '',
                    'name'      => '',
                    'full_name' => '',
                    'symbol'    => '',
                    'status'    => '',
                );
            }

            $data['coins']   = $this->common_model->get_all('dbt_cryptocoin',array('status' => 1),'rank','asc',100, 0);
           
            $data['content'] = $this->BASE_VIEW.'\market\form';
            return $this->template->admin_layout($data);
        }

    }

    public function coin_pair(){

        $page_number      = (!empty($this->request->getGet('page'))?$this->request->getGet('page'):1);
        $data['coinpair'] = $this->common_model->get_all('dbt_coinpair', array(), 'id','desc',20,($page_number-1)*20);
        $total            = $this->common_model->countRow('dbt_coinpair');
        $data['pager']    = $this->pager->makeLinks($page_number, 20, $total);

        $data['market']   = $this->common_model->get_all('dbt_market',array(),'','',100, 0);
        $data['coins']    = $this->common_model->get_all('dbt_cryptocoin',array('status' => 1),'rank','asc',100, 0);


        $data['title']      = 'Coin Pair List';
        $data['content']    = $this->BASE_VIEW.'\coinpair\list';
        return $this->template->admin_layout($data);
    }

    public function add_coin_pair_form($id = null)
    { 
        
        if (!empty($id)) {

            $this->validation->setRule('symbol', "symbol","max_length[100]|required|trim");
           
            $exist =  $this->common_model->findById('dbt_coinpair', array('symbol' => $this->request->getPost('symbol', FILTER_SANITIZE_STRING), 'id !=' => $id));

            if(!empty($exist)){

                $this->session->setFlashdata('exception', "This pair already exist!");
                return  redirect()->to(base_url('/backend/exchange/edit-coin-pair/'.$id));
            }

        } else {

            $this->validation->setRule('symbol', 'symbol','required|is_unique[dbt_coinpair.symbol]|max_length[100]|trim');

        }

        $this->validation->setRule('name', "name",'max_length[100]|required|trim');
        $this->validation->setRule('market_id', "Market",'required|trim');
        $this->validation->setRule('coin_id', "Coin",'required|trim');
        $this->validation->setRule('status', display('status'),'max_length[1]|required|trim');

        if($this->request->getPost('initial_price') > 0){

            $initialprice = $this->request->getPost('initial_price', FILTER_SANITIZE_STRING);

        } else {

            $initialprice = NULL;
        }

      
        $data['coinpair'] = (object)$userdata = array(
            'id'                => $this->request->getPost('id', FILTER_SANITIZE_STRING),
            'market_symbol'     => $this->request->getPost('market_id', FILTER_SANITIZE_STRING),
            'currency_symbol'   => $this->request->getPost('coin_id', FILTER_SANITIZE_STRING),
            'name'              => $this->request->getPost('name', FILTER_SANITIZE_STRING),
            'full_name'         => $this->request->getPost('full_name', FILTER_SANITIZE_STRING),
            'symbol'            => $this->request->getPost('symbol', FILTER_SANITIZE_STRING),
            'initial_price'     => $initialprice,
            'status'            => $this->request->getPost('status', FILTER_SANITIZE_STRING),
        );
        if($this->request->getMethod() == 'post'){
            if($this->validation->withRequest($this->request)->run())
            {
                if (empty($id)) 
                {
                    if ($this->common_model->save('dbt_coinpair', $userdata)) {
                        $this->session->setFlashdata('message', display('save_successfully'));

                    } else {
                        $this->session->setFlashdata('exception', display('please_try_again'));
                    }
                    return  redirect()->to(base_url('/backend/exchange/coin-pair'));
                } else {
                    
                    if ($this->common_model->update('dbt_coinpair', $userdata, array('id' => $id))) {
                        $this->session->setFlashdata('message', display('update_successfully'));
                    } else {
                        $this->session->setFlashdata('exception', display('please_try_again'));
                    }
                    return  redirect()->to(base_url('/backend/exchange/add-coin-pair/'.$id));
                }
            } else {
                $this->session->setFlashdata("exception", $this->validation->listErrors());
            }
        } 

        if(!empty($id)) {
            $data['coinpair']   = $this->common_model->findById('dbt_coinpair', array('id' => $id));
        }

        $data['market']   = $this->common_model->findAll('dbt_market', array('status' => 1), 'id', 'desc');
        $data['coins']   = $this->common_model->findAll('dbt_cryptocoin', array('status' => 1), 'id', 'desc', 150, 0);

        $data['content']    = $this->BASE_VIEW.'\coinpair\form';
        return $this->template->admin_layout($data);
    }

    public function market_streamer()
    {
        $market_symbol = $this->request->getGet('market', FILTER_SANITIZE_STRING);
        $coin_symbol = explode('_', $market_symbol);

        $sql = "SELECT * FROM `dbt_coinhistory` INNER JOIN (SELECT `market_symbol`, MAX(`id`) AS maxid FROM `dbt_coinhistory` GROUP BY `id`,`market_symbol`) topid ON dbt_coinhistory.`market_symbol` = topid.`market_symbol` AND dbt_coinhistory.`id` = topid.`maxid`";
        $tradesummery = $this->db->query($sql, [])->getResult();
        echo json_encode(array('marketstreamer' => $tradesummery));
    }
}

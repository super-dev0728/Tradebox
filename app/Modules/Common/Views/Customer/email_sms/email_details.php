<?php 
    $this->db =    db_connect();
    $builder = $this->db->table('setting');
    $settings = $builder->select("*")
                        ->get()
                        ->getRow();
    $this->session = \Config\Services::session();
?>
<div class="row">
    <div class="col-sm-12">
        <div class="mailbox">
            <div class="mailbox-body">
                <div class="row m-2">
                    <div class="col-xs-12 col-sm-12 col-md-12  inbox-mail">
                        <div class="inbox-avatar p-20 border-btm">
                            <img src="<?php echo base_url(!empty($settings->logo)?esc($settings->logo):"/assets/images/icons/logo.png"); ?>" class="border-green hidden-xs hidden-sm" alt="">
                            <div class="inbox-avatar-text">
                                <div class="avatar-name"><strong>From: </strong>
                                    <em><?php echo esc($settings->email); ?></em>
                                </div>
                                <div><small><strong>Subject: </strong> <?php echo esc($notification->subject);?></small></div>
                            </div>
                            <div class="inbox-date text-right hidden-xs hidden-sm">
                                <div><span class="bg-green badge"><small><?php echo esc($notification->subject);?></small></span></div>
                                <div><small><?php echo esc($notification->date);?></small></div>
                            </div>
                        </div>

                        <div class="inbox-mail-details p-20">
                            <p><strong>Hi, <?php echo $this->session->userdata('fullname'); ?></strong></p>
                            <p><span><?php echo htmlspecialchars_decode($notification->details); ?></span></p>
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
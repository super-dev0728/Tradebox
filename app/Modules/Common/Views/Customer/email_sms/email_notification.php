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
            <div class="mailbox-header">
                <div class="row">
                    <div class="col-xs-4 ">
                    	<?php $image = $this->session->userdata('image'); ?>
						
                        <div class="inbox-avatar"><img src="<?php echo base_url(!empty($image)?$image:"/assets/images/icons/user.png") ?>" class="img-circle border-green" alt="">
                            <div class="inbox-avatar-text hidden-xs hidden-sm">
                                <div class="avatar-name"><?php echo $this->session->userdata('fullname'); ?></div>
                                <div><small class="small-mailbox">Mailbox</small></div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="mailbox-body">
                <div class="row m-0">
                    
                    <div class="col-xs-12 col-sm-12 col-md-12 inbox-mail">
                        <div class="mailbox-content">
                        	<?php foreach($notification as $val){?>
                            <a href="<?php echo base_url()?>/customer/notification/email_details/<?php echo esc($val->notification_id); ?>" class="inbox_item unread">
                                <div class="inbox-avatar"><img src="<?php echo base_url(!empty($settings->logo)?esc($settings->logo):"assets/images/icons/logo.png"); ?>" class="border-green hidden-xs hidden-sm" alt="">
                                    <div class="inbox-avatar-text">
                                        <div class="avatar-name"><?php echo esc($val->subject);?></div>
                                        <div><small><?php echo htmlspecialchars_decode($val->details);?></small></div>
                                    </div>
                                    <div class="inbox-date hidden-sm hidden-xs hidden-md">
                                        <div class="date"><?php echo esc($val->date);?></div>
                                    </div>
                                </div>
                            </a>
                            <?php }?>
                        </div>
                        
                    </div><div class="col-xs-12 col-sm-12 col-md-12 ">
                            <?php echo htmlspecialchars_decode($pager); ?>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
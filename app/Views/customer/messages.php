<div class="body-content">

    <?php 
        
            if ($session->getFlashdata('message')) { ?>
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <?php echo $session->getFlashdata('message') ?>
            </div>
            <?php } ?>
            <?php if ($session->getFlashdata('exception')) { ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <?php echo $session->getFlashdata('exception') ?>
            </div>
            <?php } ?>

             <?php if ($request->getMethod() == "post" && $validation->getErrors()) { ?>
                <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                aria-hidden="true">&times;</span></button>
                <?php echo $validation->listErrors(); ?>
            </div>
            <?php } ?>
        
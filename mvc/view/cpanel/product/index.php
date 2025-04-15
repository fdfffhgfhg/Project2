<?php
   require_once "./mvc/core/redirect.php";
   require_once "./mvc/core/constant.php";
   $redirect = new redirect();
?>
<link rel="stylesheet" href="public/build/css/product.css">
<div class="">
<div class="page-title">
    <div class="title_left">
        <h3><?php echo $data['title'];?></h3>
        <a href="<?= $data['template'].'/add' ?>" class="btn btn-primary"><i class="fa fa-plus" ></i></a>
        <a href="javascript:void(0)" onclick=delAll(this) data-control="<?= $data['template'] ?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>
        <a href="<?= base_url.$data['template'].'/index' ?>" data-control="<?= $data['template'] ?>" class="btn btn-success"><i class="fa fa-history" ></i></a>
    </div>
</div>
<div class="clearfix"></div>
<div class="row">
    <div class="col-12" id="MessageFlash">
         <?php if(isset($_SESSION['flash'])){ ?>
            <h3 class="text-success"><?= $redirect->setFlash('flash') ?></h3>
        <?php } ?>
        <?php if(isset($_SESSION['error'])){ ?>
            <h3 class="text-success"><?= $redirect->setFlash('error') ?></h3>
        <?php } ?>
    </div>
</div>
<div class="x_content">
<div class="row">
     <div class="col-md-55">
          <div>
               <div class="image view view-first">
                <img style="width: 100%; display: block;" src="public/build/images/media.jpg" alt="image" />
                 <div class="mask no-caption">
                  <div class="tools tools-bottom">
                  <a href="#"><i class="fa fa-link"></i></a>
                   <a href="#"><i class="fa fa-pencil"></i></a>
                    <a href="#"><i class="fa fa-times"></i></a>
                  </div>
            </div>
       </div>
       <div class="caption">
       <p><strong>Product Name</strong></p>
        <p>Gia san pham</p>
       </div>
      </div>
     </div>
</div>
</div>
</div>                   
<script>
    function toggle(){
        let isChecked = __this.checked;
        let checkbox = document.querySelectorAll('input[name="foo"]');
        if(isChecked){
            for(let index = 0 ; index < checkbox.length ; index++){
                checkbox[index].checked = isChecked;
            }
        }
        else{
            for(let index = 0 ; index < checkbox.length ; index++){
                checkbox[index].checked = false;
            }
        }
    }
</script>
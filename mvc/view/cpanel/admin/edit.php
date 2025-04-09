<div class="class">
<div class="page-title">
    <div class="title_left">
        <h3><?php echo $data['title'];?></h3>
        <a href="<?= $data['template'].'/index' ?>" class="btn btn-primary"><i class="fa fa-backward" ></i></a>
    </div>
    <div>
        
    </div>
    <div class="title_right">
        <div class="col-md-5 col-sm-5 form-group pull-right top_search">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search for...">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="button">Go!</button>
                </span>
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>
<div class="">
<form class="" action="" method="POST" novalidate>
        <div class="row">
            <div class = "col-6">
                <div class="form-group">
                     <label for="fullname">Ho ten</label>
                     <input id="fullname" type="text" value="<?= $data['datas']['fullname'] ?>" class="form-control" name="data_post[fullname]">
                </div>
                <div class="form-group">
                     <label for="publish">Hiển thị</label>
                     <input id="publish" type="checkbox" <?= $data['datas']['publish'] == 1?'checked':'' ?> value="1" name="data_post[publish]">
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" name="submit" type="submit"> 
                        Cap nhat
                    </button>
                </div>
            </div>
        </div>
  </form>
</div>
</div>  
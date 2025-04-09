<div class="class">
<div class="page-title">
    <div class="title_left">
        <h3><?php echo $data['title'];?></h3>
        <a href="<?= $data['template'].'/index' ?>" class="btn btn-primary"><i class="fa fa-backward"></i></a>
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
                <div class="class form-group">
                    <label for="">
                        Danh mục cha
                    </label>
                    <select name="data_post[parentID]" class="form-control" id="">
                        <?php if(isset($data['parent']) && $data['parent'] != NULL){ ?>
                            <option value="0">Chọn danh mục cha</option>
                           <?php foreach($data['parent'] as $key => $val){ ?>   
                               <option value="<?= $val['id'] ?>"><?= $val['name'] ?></option>
                           <?php } ?>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                     <label for="name">Tên module</label>
                     <input id="name" type="text" onkeyup="removeAccents(this)" class="form-control" name="data_post[name]">
                </div>
                <div class="form-group">
                     <label for="link">Lien ket</label>
                     <input id="link" type="text" onkeyup="removeAccents(this)" class="form-control" name="data_post[link]">
                </div>
                <div class="form-group">
                     <label for="controller">Controller</label>
                     <input id="controller" type="text" onkeyup="removeAccents(this)" class="form-control" name="data_post[controller]">
                </div>
                <div class="form-group">
                     <label for="icon">Icon</label>
                     <input id="icon" type="text" onkeyup="removeAccents(this)" class="form-control" name="data_post[icon]">
                </div>
                <div class="form-group">
                     <label for="publish">Hiển thị</label>
                     <input id="publish" type="checkbox" checked name="data_post[publish]">
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" name="submit" type="submit"> 
                        Thêm mới
                    </button>
                </div>
            </div>
        </div>
  </form>
</div>
</div>  

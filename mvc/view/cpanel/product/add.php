<script src="public/cpanel/ckeditor/ckeditor.js"></script>
<script src="public/cpanel/ckfinder/ckfinder.js"></script>
<link rel="stylesheet" href="public/build/css/product.css">
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
                        <option value="0">Chon san pham cha</option>
                        <?php if(isset($data['parent']) && $data['parent'] != NULL){ ?>
                           <?php foreach($data['parent'] as $key => $val){ ?>   
                               <option value="<?= $val['id'] ?>"><?= $val['name'] ?></option>
                               <?php if(isset($val['children']) && $val['children'] != null){?>
                                    <?php foreach($val['children'] as $child_key => $child_value){?>
                                        <option value="<?= $child_value['id'] ?>">---------<?= $child_value['name'] ?></option>
                                     <?php } ?>   
                                <?php } ?>
                           <?php } ?>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                     <label for="name">Tên san pham</label>
                     <input id="name" type="text" onkeyup="removeAccents(this)" class="form-control" name="data_post[name]">
                     <input type="hidden" name="data_post[slug]" id="slug">
                </div>
                <div class="form-group">
                     <label for="name">Gia</label>
                     <input id="name" type="text" onkeyup="formatManey(this)" class="form-control" name="data_post[price]">
                </div>
                <div class="form-group">
                     <label for="publish">Hiển thị</label>
                     <input id="publish" type="checkbox" checked name="data_post[publish]">
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="">Anh dai dien</label>
                        <div class="image-box">
                            <div class="image">
                                 <img id="preview" src="public/build/images/noimg.png" alt="">
                            </div>
                            <div class="btn-choose">
                                <label for="image">Chon hinh anh</label>
                                <input type="file" name="image" id="image" accept="image/png,image/jpg">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label for="">Noi dung</label>
                        <textarea name="data_post[contents]" class="form-control" id="" cols="30" rows="10"></textarea>
                        <script>
                                CKEDITOR.replace('data_post[contents]', {
                                    filebrowserBrowseUrl: 'public/cpanel/ckfinder/ckfinder.html',
                                    filebrowserUploadUrl: 'public/cpanel/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                                    filebrowserWindowWidth: '1000',
                                    filebrowserWindowHeight: '700'
                                } );
                        </script>
                    </div>
                </div>
                <div class="col-12 text-left">
                <div class="form-group">
                    <button class="btn btn-primary" name="submit" type="submit"> 
                        Thêm mới
                    </button>
                </div>
                </div>
            </div>
        </div>
  </form>
</div>
</div>  
<script>
   function removeAccents(str) {
        let substr = str.value;
        var AccentsMap = [
            "aàảãáạăằẳẵắặâầẩẫấậ",
            "AÀẢÃÁẠĂẰẲẴẮẶÂẦẨẪẤẬ",
            "dđ", "DĐ",
            "eèẻẽéẹêềểễếệ",
            "EÈẺẼÉẸÊỀỂỄẾỆ",
            "iìỉĩíị",
            "IÌỈĨÍỊ",
            "oòỏõóọôồổỗốộơờởỡớợ",
            "OÒỎÕÓỌÔỒỔỖỐỘƠỜỞỠỚỢ",
            "uùủũúụưừửữứự",
            "UÙỦŨÚỤƯỪỬỮỨỰ",
            "yỳỷỹýỵ",
            "YỲỶỸÝỴ",
            " .:/@#<>%^*()",
        ];
        for (var i=0; i<AccentsMap.length; i++) {
            var re = new RegExp('[' + AccentsMap[i].substr(1) + ']', 'g');
            var char = AccentsMap[i][0];
            substr = substr.replace(re, char);
            substr = substr.replace(/\s/g,'-');
        }
        document.querySelector('#slug').value = substr;
    }
    function formatMoney(__this){
        let val = __this.value;
        let num= val.replace(/[^\d.]/g,"");
        let arr = num.split(".");
        let val_num = arr[0];
        let len = val_num.length;
        let result = '';
        let j = 0;
        for (let index = len; index > 0; index--) {
            j++;
            if(j % 3 == 1 && j != 1){
                result = val_num.substr(index-1,1) + ',' + result;
            }
            else{
                result = val_num.substr(index-1,1) + result;
            }
            
        }
        __this.value = result;
    }
    let image = document.querySelector('#image');
    image.addEventListener('change',(e)=>{
        let input = e.target.files[0];
        if(input){
            let reader = new FileReader();
            reader.onload = function(e){
                document.querySelector('#preview').setAttribute('src',e.target.result);
            }
            reader.readAsDataURL(input);
        }
        else{
            document.querySelector('#preview').setAttribute('src','public/build/images/noimg.png');
        }
    })
</script>

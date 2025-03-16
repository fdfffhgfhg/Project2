<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Document</title>
</head>
<body>
    <table>
       <thead>
        <tr>
            <td>
                ID
            </td>
            <td>
                Name
            </td>
        </tr>
       </thead> 
       <tbody>
         <?php if(isset($data['array']) && $data['array'] != NULL){
               foreach($data['array'] as $key => $val){ ?>
               <tr>
                 <td><?= $val['id']?></td>
                 <td><?= $val['name_cate']?></td>
               </tr>
        <?php
         }
        }
        ?>
       </tbody>
    </table>
</body>
</html>
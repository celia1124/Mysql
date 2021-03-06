<?php
require __DIR__ . '/is_admin.php';
require __DIR__ . '/db_connect.php';

if (!isset($_GET['sid'])) {
    header('Location: db_list.php');
    exit;
}
$sid = intval($_GET['sid']);

$row = $pdo
    ->query("SELECT * FROM custo_order WHERE sid=$sid")
    ->fetch();

// if(empty($row)){
//     header('Location: db_list.php');
//     exit;
// }

?>
<?php include __DIR__ . '/parts/head.php'; ?>
<?php include __DIR__ . '/parts/navbar.php'; ?>


<style>
    #error-msg {

        color: red;
        border-color: red;
    }

    .card {
        margin-top: 20px;
    }

    body {
        background-color: #F7D7F7;
    }

    .card {
        background-color: #B441D9;
        color: white;
        border-radius: 40px;
    }

    .btn-primary {
        color: #fff;
        background-color: #F563C4;
        border-color: #F563C4;
        border-radius: 60px;
    }
</style>

<div class="container">
    <div class="row d-flex justify-content-center">
        <div class="col-lg-6">

            <div class="alert alert-danger" role="alert" id="info" style="display:none">
                錯誤
            </div>


            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">編輯客製化</h5>

                    <form name="form1" novalidate onsubmit="checkForm(); return false;">
                        <input type="hidden" name="sid" value="<?= $sid ?>">
                        <div class="form-group">
                            <label for="name">** 品名</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="客製化**蛋糕" value="<?= htmlentities($row['name']) ?>">
                            <small class="form-text" id="error-msg" style="display : none">0000</small>
                        </div>
                        <div class="form-group">
                            <label for="text">配料-香蕉</label>
                            <input type="text" class="form-control" id="banana" name="banana" placeholder="yes / no" value="<?= htmlentities($row['banana']) ?>">


                        </div>
                        <div class="form-group">
                            <label for="text">配料-草莓</label>
                            <input type="text" class="form-control" id="straw" name="straw" placeholder="yes / no">

                        </div>
                        <div class="form-group">
                            <label for="berry">配料-藍莓</label>
                            <input type="text" class="form-control" id="berry" name="berry" placeholder="yes / no" value="<?= htmlentities($row['blueberry']) ?>">

                        </div>
                        <div class="form-group">
                            <label for="text">產品編號</label>
                            <input type="text" class="form-control" id="proid" name="proid" placeholder="ex:A011" value="<?= htmlentities($row['productid']) ?>">
                            <small class="form-text" id="error-msg" style="display : none">0000</small>
                        </div>

                        <div class="form-group">
                            <label for="text">銷售編號</label>
                            <input type="text" class="form-control" id="orderid" name="orderid" pattern="^[A-Z]\d{3}?#\d{0,}$" placeholder="ex:A011#1" value="<?= htmlentities($row['saleid']) ?>">
                            <small class="form-text" id="error-msg" style="display : none">0000</small>
                        </div>

                        <button type="submit" class="btn btn-primary">修改</button>
                    </form>


                </div>
            </div>

        </div>
    </div>



</div>

<?php include __DIR__ . '/parts/scripts.php'; ?>



<script>
    const info = document.querySelector('#info');

    const name = document.querySelector('#name');
    const proid = document.querySelector('#proid');
    const orderid = document.querySelector('#orderid');
    const proid_re = /^[A-Z]\d{3}/;
    const orderid_re = /^[A-Z]\d{3}?#\d{0,}$/;





    function checkForm() {
        info.style.display = 'none';

        let isPass = true;




        name.style.borderColor = '#6CFF33';
        name.nextElementSibling.style.display = 'none';

        proid.style.borderColor = '#6CFF33';
        proid.nextElementSibling.style.display = 'none';

        orderid.style.borderColor = '#6CFF33';
        orderid.nextElementSibling.style.display = 'none';

        if (name.value.length < 5) {
            isPass = false;
            name.style.borderColor = 'red';
            let small = name.closest('.form-group').querySelector('small');
            small.innerText = "請輸入正確品名";
            small.style.display = 'block';
        }


        if (!proid_re.test(proid.value)) {
            isPass = false;
            proid.style.borderColor = 'red';
            let small = proid.closest('.form-group').querySelector('small');
            small.innerText = "請輸入正確格式";
            small.style.display = 'block';
        }

        if (!orderid_re.test(orderid.value)) {
            isPass = false;
            orderid.style.borderColor = 'red';
            let small = orderid.closest('.form-group').querySelector('small');
            small.innerText = "請輸入正確格式";
            small.style.display = 'block';
        }



        if (isPass) {
            const fd = new FormData(document.form1);

            fetch('ab-edit-api.php', {
                    method: 'POST',
                    body: fd
                })
                .then(r => r.json())
                .then(obj => {
                    console.log(obj);
                    if (obj.success) {
                        // 新增成功
                        info.classList.remove('alert-danger');
                        info.classList.add('alert-success');
                        info.innerHTML = '修改成功';
                    } else {
                        info.classList.remove('alert-success');
                        info.classList.add('alert-danger');
                        info.innerHTML = obj.error || '修改失敗';
                    }
                    info.style.display = 'block';
                });

        }





    }
</script>



<?php include __DIR__ . '/parts/foot.php'; ?>
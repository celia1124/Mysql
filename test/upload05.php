<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<form name="form1" onsubmit="doAjax(); return false;">
    <input type="file" name="avatar" accept="image/*">
    <input type="submit">
</form>

<img src="" alt="">

<script>
// action="a20201217-03-upload-test.php" enctype="multipart/form-data" method="post"
function doAjax(){

    const fd = new FormData(document.form1);

    fetch('upload.test.php', {
        method: 'POST',
        body: fd
    })
    .then(r=>r.json())
    .then(obj=>{
        console.log(obj);
        document.querySelector('img').src = '../uploads/' + obj.filename;
    })
}



</script>
</body>
</html>
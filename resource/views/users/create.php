<?php include_once '/xampp/htdocs/phpcrud/resource/inc/header.php' ?>
<?php require_once '/xampp/htdocs/phpcrud/database/connection.php' ?>
<?php
function UUID($n = 50)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $n; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $randomString .= $characters[$index];
    }
    return $randomString;
}
$erorrs = [];
$name = '';
$email = '';
$image = null;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_REQUEST['name'];
    $email = $_REQUEST['email'];
    $image = $_FILES['image'];

    if (!$name)
        $erorrs[] = "The name filed is requied";
    if (!$email)
        $erorrs[] = "The email filed is requied";
    if (!$image)
        $erorrs[] = "The image filed is requied";


    //saving if no erorrs
    if (empty($erorrs)) {
        $imageName = UUID() . '.png';
        move_uploaded_file($image['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/phpcrud/public/img/' . $imageName);
        $statment = $pdo->prepare('INSERT INTO USERS (name,email,image,created_at) VALUE(:name,:email,:image,:created_at)');
        $statment->bindValue(":name", $name);
        $statment->bindValue(":email", $email);
        $statment->bindValue(":image", $imageName);
        $statment->bindValue(":created_at", date('Y-m-d H:i:s'));
        $statment->execute();
        header('Location:index.php');
    }
}
?>

<div class="container my-3">
    <div class="row">
        <?php if (!empty($erorrs)) : ?>
            <div class="alert alert-danger" role="alert">
                <?php foreach ($erorrs as $erorr) : ?>
                    <?php echo $erorr . ' , '  ?>
                <?php endforeach ?>
            </div>

        <?php endif; ?>
        <form method="post" action="" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" name="name" id="name" value="<?php echo $name ?>" placeholder="Enter user name">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control" name="email" id="email" value="<?php echo $email ?>" placeholder="Enter user email">
            </div>
            <div class="form-group mb-3">
                <label for="image" class="form-label">Uplod avatar</label>
                <input id="image" class="form-control" type="file" value="<?php echo $image ?>" name="image">
            </div>
            <button type="submit" class="btn btn-success">Submit</button>
        </form>
    </div>
</div>

<?php include_once '/xampp/htdocs/phpcrud/resource/inc/footer.php' ?>
<?php include_once '/xampp/htdocs/phpcrud/resource/inc/header.php' ?>
<?php require_once '/xampp/htdocs/phpcrud/database/connection.php' ?>
<?php
$search = $_GET['search'] ?? "";

if ($search) {
    $statment = $pdo->prepare(" SELECT * FROM USERS WHERE name Like :name ");
    $statment->bindValue(':name', "%$search%");
} else {
    $statment = $pdo->prepare('SELECT * FROM USERS');
}
$statment->execute();
$users = $statment->fetchAll(PDO::FETCH_CLASS);

?>

<div class="container my-3">
    <div class="row">
        <div class="col-3">
            <a class="btn btn-success" href="./create.php" role="button">Add new User</a>
        </div>
        <form class="form-inline mt-5" method="get" action="">
            <div class="mb-3">
                <label for="" class="form-label">Search</label>
                <input type="text" name="search" value="<?php echo $search ?>" class="form-control" placeholder="What are you looking" aria-describedby="helpId">
            </div>
            <button type="sunmit" class="btn  btn-secondary">Search</button>
        </form>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Image</th>
                    <th scope="col">E-mail</th>
                    <th scope="col">Careated AT</th>
                    <th scope="col">Update AT</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user) : ?>
                    <tr>
                        <th scope="row"><?php echo $user->id ?></th>
                        <td><?php echo $user->name ?></td>
                        <td><img style="max-width: 100px;" class="img-thumbnail" src="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . '/phpcrud/public/img/' . $user->image ?> " /></td>
                        <td><?php echo $user->email ?></td>
                        <td><?php echo $user->created_at ?></td>
                        <td><?php echo $user->updated_at ?? 'never been changed' ?></td>
                        <td>
                            <a class="btn btn-primary" href="update.php?id=<?php echo $user->id  ?>" role="button">EDIT</a>
                            <form class="mt-2 d-flex" action="delete.php" method="post">
                                <input type="number" name="id" hidden value="<?php echo $user->id  ?>">
                                <input class="btn btn-danger" type="submit" value="DELETE">
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>

            </tbody>
        </table>
    </div>
</div>

<?php include_once '/xampp/htdocs/phpcrud/resource/inc/footer.php' ?>
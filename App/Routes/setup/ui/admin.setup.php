<?php
include __DIR__ . "/layouts/header.php";
?>
<div class="container">
    <h1>Admin Setup</h1>

    <form action="<?= base_url("setup/admin") ?>" method="post">

        <div class="form-group">
            <label>Name</label>
            <input class="form-control" type="text" name="name" placeholder="Name" required />
        </div>

        <div class="form-group">
            <label>Password</label>
            <input class="form-control" type="password" name="password" placeholder="Password" required />
        </div>

        <div style="text-align: right;" class="mt-5">
            <button class="btn btn-primary btn-lg" type="submit">Save</button>
        </div>
    </form>

</div>


<?php
include __DIR__ . "/layouts/footer.php";
?>

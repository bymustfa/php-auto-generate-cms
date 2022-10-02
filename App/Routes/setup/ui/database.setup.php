<?php
include __DIR__ . "/layouts/header.php";
?>
<div class="container">
    <h1>Database Setup</h1>


    <form action="<?= base_url("setup/db") ?>" method="post">


        <div class="form-group">
            <label>Host</label>
            <input class="form-control" required type="text" name="host" placeholder="Host"
                   value="<?= config("DB_HOST") ?>"/>
        </div>


        <div class="form-group">
            <label>User</label>
            <input class="form-control" required type="text" name="user" placeholder="Host"
                   value="<?= config("DB_USER") ?>"/>
        </div>


        <div class="form-group">
            <label>Password</label>
            <input class="form-control" type="password" name="password" placeholder="Password"/>
        </div>


        <div class="form-group">
            <label>Database Name</label>
            <input class="form-control" required type="text" name="database" placeholder="Database Name"
                   value="<?= config("DB_NAME") ?>"/>
        </div>

        <div class="form-group">
            <label>Database Prefix</label>
            <input class="form-control" required type="text" name="prefix" placeholder="Database Prefix"
                   value="<?= config("DB_PREFIX") ?>"/>
        </div>
        <div style="text-align: right;" class="mt-5">
            <button class="btn btn-primary btn-lg" type="submit">Save</button>
        </div>
    </form>

</div>

<?php
include __DIR__ . "/layouts/footer.php";
?>

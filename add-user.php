<?php require_once('layout/header.php') ?>
<?php require_once('layout/validate-user.php') ?>
<?php require_once('database-manager/database-object.php'); ?>

<div class="container my-5">
    <h3>Add new user (Customer Service Account)</h3>
    <div class="card">
        <div class="card-body">
            <form action="services/user-service/create-user.php" id="create-user-form" method="POST">
                <div class="form-group">
                    <label for="" class="control-label">Name</label>
                    <input type="text" name="name" required="" class="form-control">
                </div>
                <div class="form-group">
                    <label for="" class="control-label">Email</label>
                    <input id="email" type="email" name="email" required="" class="form-control">
                    <div id="emailValidation" class="text-danger">Email already exists</div>
                </div>
                <div class="form-group">
                    <label for="" class="control-label">Password</label>
                    <input id="password" type="password" name="password" required="" class="form-control">
                </div>
                <button class="button btn btn-primary btn-block">Create new user</button>
            </form>
        </div>
    </div>
    <a href="/egyway/">Go Home</a>
</div>

<script>
    let canSubmit = true;

    $('#emailValidation').hide();

    // Handle the submit
    $('#create-user-form').submit(function(e) {
        // Check if submission is prevented due to invalid data
        if (!canSubmit) {
            e.preventDefault();
        } else {
            alert("User has been created successfully!");
        }
        
    });

    $('#email').keyup(function(e) {
        const ajaxData = 'email=' + e.target.value;
        $.ajax({
            url: 'services/user-service/validate-email.php',
            method: "POST",
            data: ajaxData,
            success: function(response) {
                $('#emailValidation').hide();
                canSubmit = true;
            },
            error: function(err) {
                $('#emailValidation').show();
                canSubmit = false;
            }
        })
    });
</script>


<?php require_once('layout/footer.php') ?>
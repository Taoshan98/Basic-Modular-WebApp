<?php
include "../../includes/header.php"
?>

<main class="form-signin">
    <form>
        <img class="mb-4" src="../../img/php.svg" alt="">

        <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

        <label for="username" class="visually-hidden">Username</label>
        <input type="text" id="username" class="form-control" placeholder="Username" required="" autofocus="">

        <label for="password" class="visually-hidden">Password</label>
        <input type="password" id="password" class="form-control" placeholder="Password" required="">

        <button class="w-100 btn btn-lg btn-primary" id="submit" type="submit">Sign in</button>
    </form>
</main>

<?php
include "../../includes/footer.php"
?>

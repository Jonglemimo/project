
<form action="#" id="insert-user" method="POST">
    <input error type="text" name="mail" value="<?php if (isset($mail)) echo $mail ?>" placeholder="E-mail"><br>
    <?php if (isset($errors['mail'])) : ?>
        <div class="error"><?= $errors['mail'] ?></div>
    <?php endif; ?>
    <button type="submit" name="reset-password">Envoyer</button>
</form>
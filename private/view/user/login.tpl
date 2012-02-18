<article class="area right">
    <section class="title">
        enter your login details
    </section>
    
    <?php 
    if(!empty($this->formError))
    {
    ?>
        <section class="error">
        <?php
            echo $this->formError;
        ?>
        </section>
    <?php
    }
    ?>

    <form method="POST" action="/user/dologin">
        <section class="label">username:</section><input type="text" name="username" value="<?php echo \Util\Arr::get($_POST, 'username');?>" /><br /><br />
        <section class="label">password:</section><input type="password" name="password" value="" /><br /><br />

        <input type="hidden" name="return" value="<?php echo !empty($this->return) ? $this->return : '';?>" />
        
        <input type="submit" value="Submit" />
    </form>
    
</article>

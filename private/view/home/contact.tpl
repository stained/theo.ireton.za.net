<article class="area right">
    <section class="title">
        or leave a message
    </section>

    <?php 
    if(empty($this->formMessage))
    {
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

    <form method="POST" action="/feedback">
        <section class="label">name:</section><input type="text" name="name" value="<?php echo \Util\Arr::get($_POST, 'name');?>" /><br /><br />
        <section class="label">email:</section><input type="text" name="email" value="<?php echo \Util\Arr::get($_POST, 'email');?>" /><br /><br />

        <section class="label">message:</section><br /><br />
        <textarea name="message"><?php echo \Util\Arr::get($_POST, 'message');?></textarea><br /><br />
        <input type="submit" value="Submit" />
    </form>
    <?php
    }
    else
    {
    ?>
        <section class="message">
        <?php
            echo $this->formMessage;
        ?>
        </section>
    <?php
    }
    ?>
</article>

<article class="area right">
    <section class="title">
        get hold of me on
    </section>
    <p>
        <?php 
            if(!empty($this->contact))
            {
                foreach($this->contact as $type=>$detail)
                {
                    if(!empty($detail))
                    {
                        switch($type)
                        {
                            case 'email':
                                // encode the email
                                $detail = \Util\Email::javascriptEncode($detail);
                                break;

                            case 'twitter':
                                $detail = "<a href='http://twitter.com/{$detail}'>$detail</a>";
                                break;

                            case 'facebook':
                                $detail = "<a href='http://facebook.com/{$detail}'>$detail</a>";
                                break;

                            case 'skype':
                                $detail = "<a href='skype://{$detail}'>$detail</a>";
                                break;
                        }

                        echo '<p>' . $type . ': ' . $detail . '</p>';
                    }
                }
            }
        ?>
    </p>

</article>


<?php
    if(!empty($this->nav))
    {
        $this->nav->display();
    }

    if(!empty($this->post))
    {
        $this->post->display();
    }
?>

<?php
    if(empty($this->posts))
    {
    ?>
    <article class="area left">
        <section class="title">
            blog posts
        </section>
        
        No blog posts have been made yet
    </article>

    <?php
    }
    else
    {
        foreach($this->posts as $post)
        {
        ?>
        <article class="area left">
            <section class="title">
                <time class="time">
                    <?php echo date("l, d F Y \a\\t g:i A", strtotime($post->getTimestamp())); ?>
                </time>

                <?php 
                    echo "<a href='/blog/view/{$post->getId()}'>{$post->getTitle()}</a>"; 
                ?>
            </section>

            <?php 
                echo \Util\String::truncate($post->getPost(), 400, " <a href='/blog/view/{$post->getId()}'>read more</a>"); 
            ?>

            <section class="category">
                posted in <?php echo "<a href='/blog/category/{$post->getCategory()}'>{$post->getCategory()}</a>";?>
            </section>
        </article>
        <?php  
        }
    }
?>
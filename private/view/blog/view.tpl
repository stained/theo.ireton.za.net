<?php
    if(!empty($this->nav))
    {
        $this->nav->display();
    }
?>

<article class="area left">

    <section class="title">
        <time class="time">
            <?php echo date("l, d F Y \a\\t g:i A", strtotime($this->post->getTimestamp())); ?>
        </time>

        <?php 
            echo $this->post->getTitle(); 
        ?>
    </section>

    <?php 
        echo $this->post->getPost(); 
    ?>

    <section class="category">
        posted in <?php echo "<a href='/blog/category/{$this->post->getCategory()}'>{$this->post->getCategory()}</a>";?>
    </section>
    
</article>
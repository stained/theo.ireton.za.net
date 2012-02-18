<article class="area left">
    <section class="title">
        <time class="time">
            <?php
                echo date("l, d F Y \a\\t g:i A");
            ?>
        </time>
        
        create new post
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
    <form method="POST" action="/blog/post">
        <section class="label">title:</section><input type="text" name="title" value="<?php echo \Util\Arr::get($_POST, 'title');?>" /><br /><br />
        <section class="label">category:</section><select name="category">
            <option value='-1'>-- select a category --</option>
            <?php
                if(!empty($this->categories))
                {
                    $selected = \Util\Arr::get($_POST, 'category');
                    
                    foreach($this->categories as $category)
                    {
                        $selectedItem = '';
                        
                        if(!empty($selected) && $selected == $category->getId())
                        {
                            $selectedItem = "selected='selected'";
                        }
                        
                        echo "<option value='{$category->getId()}' {$selectedItem}>{$category->getName()}</option>";
                    }
                }
            ?>
        </select><br /><br />

        <section class="label">post:</section><br /><br />
        <textarea name="post" class="full"><?php echo \Util\Arr::get($_POST, 'post');?></textarea><br /><br />
        
        <input type="submit" value="Create Post" />
    </form>    
</article>

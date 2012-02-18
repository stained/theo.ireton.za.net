<article class="area right">
    <section class="title">
        menu
    </section>

    <p>
        <a href="/blog/manage">Blog Manager</a>
    </p>
    
    <p>
        <a href="/user">Return to User Console</a>
    </p>
</article>

<article class="area left">
    <section class="title">
        <time class="time">
            <?php
                echo date("l, d F Y g:i:s A", strtotime($this->post->getTimestamp()));
            ?>
        </time>
        
        edit post
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
    elseif(!empty($this->formMessage))
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
    
    <form method="POST" action="/blog/update/<?php echo $this->post->getId();?>">
        <section class="label">title:</section><input type="text" name="title" value="<?php echo $this->post->getTitle();?>" /><br /><br />
        <section class="label">category:</section><select name="category">
            <option value='-1'>-- select a category --</option>
            <?php
                if(!empty($this->categories))
                {
                    $selected = $this->post->getCategoryId();
                    
                    foreach($this->categories as $category) 
                    {
                        $selectedItem = '';
                        
                        if($selected == $category->getId())
                        {
                            $selectedItem = "selected='selected'";
                        }
                        
                        echo "<option value='{$category->getId()}' {$selectedItem}>{$category->getName()}</option>";
                    }
                }
            ?>
        </select><br /><br />

        <section class="label">post:</section><br /><br />
        <textarea name="post" class="full"><?php echo $this->post->getPost();?></textarea><br /><br />
        
        <input type="submit" value="Update" name="update" />
        <input type="submit" value="Delete" name="delete" />
    </form>    
</article>

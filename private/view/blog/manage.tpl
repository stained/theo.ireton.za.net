<article class="area right">
    <section class="title">
        select a post to edit
    </section>
    
    <?php
        if(empty($this->posts))
        {
        ?>
            no blog entries posted
        <?php
        }
        else
        {
            $year = '';
            $month = '';
            
            foreach($this->posts as $post)
            {
                $postYear = substr($post->getTimestamp(), 0, 4);
                $postMonth = date("F", strtotime($post->getTimestamp()));
                
                if($postYear != $year)
                {
                    $year = $postYear;
                    $month = $postMonth;
                    
                    echo "<p><h3>{$year}</h3></p>\n";
                    echo "<p class='indented'>{$month}</p>\n";
                }
                else
                {
                    if($month != $postMonth)
                    {
                        $month = $postMonth;
                        echo "<p class='indented'>{$month}</p>\n";
                    }
                }
                
                echo "<p class='doubleindented'><a href='/blog/edit/{$post->getId()}'>{$post->getTitle()}</a></p>\n";
            }
        }
    ?>
    
    <section class="title">
        menu
    </section>

    <p>
        <a href="/user">Return to User Console</a>
    </p>
</article>

<?php
    $this->post->display();
?>
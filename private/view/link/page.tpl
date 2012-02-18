<article class="area right">
    <section class="title">
        links of interest
    </section>
 
    just a bunch of links that I find interesting, and which I plan on revisiting at some point in the future.
</article>

<?php 
if(empty($this->links))
{
?>
<article class="area left">
    no links have been defined yet
</article>
<?php
}
else
{
    // group by day
    $day = '';

    $current = 0;
    foreach($this->links as $link)
    {
        $linkTimestamp = substr($link->getTimestamp(), 0, 10);

        if($day != $linkTimestamp)
        {
           $day = $linkTimestamp;
           
           if($current != 0)
           {
       ?>
       </article>
       <?php
       }
       ?>
       
       <article class="area left">
            <section class="title">
                <time class="time">
                    <?php echo date("l, d F Y ", strtotime($linkTimestamp)); ?>
                </time>
                &nbsp;
            </section>
        <?php
        }

        echo "<p><a href='{$link->getURL()}' target='_blank'>{$link->getURL()}</a> <img src='/images/external.png' class='external' alt='{$link->getDescription()}' />" .
             "<p>" . str_replace("\n", "<br />", $link->getDescription()) . "</p></p><hr />";
        
        $current++;
    }
}
?>

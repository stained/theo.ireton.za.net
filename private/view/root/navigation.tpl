<?php

    // set up nav items
    $items = array(
                    array('href'=>'/', 'title'=>'home'),
                    array('href'=>'/about', 'title'=>'about'),
                    array('href'=>'/blog', 'title'=>'blog'),
                    array('href'=>'/portfolio', 'title'=>'portfolio'),
                    array('href'=>'/education', 'title'=>'education'),
                    array('href'=>'/link', 'title'=>'links'),
                    array('href'=>'/contact', 'title'=>'contact'),
                  );
    
    $user = \Controller\User::_getLoggedInUser();
    
    if(!empty($user))
    {
        $items[] = array('href'=>'/user', 'title'=>'user console');
    }
    else
    {
        $items[] = array('href'=>'/user/login', 'title'=>'owner login');
    }
?>

<nav class="nav">

    <?php
        $count = 0;
        $total = count($items) - 1;

        foreach($items as $item)
        {
            $selected = '';

            if(!empty($this->selected) && $this->selected == $item['title'])
            {
                echo "<span class='selected'>{$item['title']}</span>";
            }
            else
            {
                echo "<a href='{$item['href']}' {$selected}>{$item['title']}</a>";
            }

            if($count != $total)
            {   
                echo '|';
            }

            $count++;
        }
    ?>

</nav>
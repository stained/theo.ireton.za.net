<?php
/**
 * Master view
 */
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo !empty($this->title) ? $this->title : \System\Config::get('site'); ?></title>
        
        <link rel="stylesheet" type="text/css" href="/css/master.css" />
        <link rel="shortcut icon" href="favicon.ico" />
    </head>
    
    <body>
        <header class="header">
            <section class="logo">
                <?php echo \System\Config::get('site'); ?>
            </section>
        </header>

        <header class="navigation">
            <?php
                $this->navigation->display();
            ?>
        </header>
            
        
        <section class="background">
        </section>

        <section class="content">
            <?php
                $this->content->display();
            ?>
            
        </section>
    </body>
</html>


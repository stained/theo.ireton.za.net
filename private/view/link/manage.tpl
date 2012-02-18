<article class="area right">
    <section class="title">
        new link
    </section>

    <p>
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

    <form method="POST" action="/link/add">
        <section class="label">url:</section><input type="text" name="url" /><br /><br />

        <section class="label">description:</section><br /><br />
        <textarea name="description"></textarea><br /><br />
        
        <input type="submit" value="Create" />
    </form>      
    </p>
    
    <section class="title">
        menu
    </section>

    <p>
        <a href="/user">Return to User Console</a>
    </p>
</article>

<article class="area left">
    <section class="title">
        existing links
    </section>

    <p>
    <?php
        if(empty($this->links))
        {
        ?>
            no links have been defined yet
        <?php
        }
        else
        {
        ?>
        <form method="POST" action="/link/update">
            <table>
                <tr><th>link</th><th>description</th><th>delete?</th></tr>
                <tr><td colspan='2'>&nbsp;</td></tr>

                <?php
                foreach($this->links as $link)
                {
                    echo "<tr>";
                    echo "<td valign='top'><input type='text' name='link[{$link->getId()}][url]' value='{$link->getURL()}' /></td>";
                    echo "<td valign='top'><textarea name='link[{$link->getId()}][desc]'>{$link->getDescription()}</textarea></td>";
                    echo "<td valign='top'><input type='checkbox' name='linkdel[{$link->getId()}]' /></td>";
                    echo "</tr>";
                }
                ?>
            </table>

            <br >
            <input type="submit" value="Update" />
        </form>
        <?php
        }
    ?>
    </p>
</article>
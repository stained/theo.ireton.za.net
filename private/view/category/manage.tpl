<article class="area right">
    <section class="title">
        new category
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

    <form method="POST" action="/category/add">
        <section class="label">name:</section><input type="text" name="name" /><br /><br />

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
        existing categories
    </section>

    <p>
    <?php
        if(empty($this->categories))
        {
        ?>
            no categories have been defined yet
        <?php
        }
        else
        {
        ?>
        <form method="POST" action="/category/update">
            <table>
                <tr><th>category</th><th>delete?</th></tr>
                <tr><td colspan='2'>&nbsp;</td></tr>

                <?php
                foreach($this->categories as $category)
                {
                    echo "<tr>";
                    echo "<td><input type='text' name='category[{$category->getId()}]' value='{$category->getName()}' /></td>";
                    echo "<td><input type='checkbox' name='categorydel[{$category->getId()}]' /></td>";
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
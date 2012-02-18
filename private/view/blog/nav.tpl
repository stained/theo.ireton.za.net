<article class="area right">
    <section class="title">
        archive
    </section>
   
    <?php
    if(empty($this->groupedDates))
    {
    ?>
    <p>
        no posts in archive
    </p>
    <?php
    }
    else
    {
        $year = '';

        foreach($this->groupedDates as $timestamp)
        {
            $groupYear = substr($timestamp['date'], 0, 4);

            if($groupYear != $year)
            {
                $year = $groupYear;

                echo "<p><h3>{$year}</h3></p>\n";
            }

            $groupMonth = substr($timestamp['date'], 4, 6);
            
            $month = date("F", strtotime($timestamp['date'] . "-01 00:00:00")); 

            if(!empty($this->selectedDate) && $this->selectedDate == $timestamp['date'])
            {
                echo "<p class='indented'>{$month} ({$timestamp['count']})</p>\n";
            }
            else
            {
                echo "<p class='indented'><a href='/blog/archive/" . 
                     str_replace("-", "/", $timestamp['date']) . "'>{$month}</a>" .
                     " ({$timestamp['count']})</p>\n";
            }
        }
    }
    ?>

    <section class="title">
        categories
    </section>
    
    <?php
    if(empty($this->groupedCategories))
    {   
    ?>
    <p>
        no categories have been defined
    </p>
    <?php
    }
    else
    {
        foreach($this->groupedCategories as $category)
        {
            if(!empty($this->selectedCategory) && $this->selectedCategory == $category['name'])
            {
                echo "<p>{$category['name']} ({$category['count']})</p>\n";
            }
            else
            {
                echo "<p><a href='/blog/category/{$category['name']}'>{$category['name']}</a>" .
                     " ({$category['count']})</p>\n";
            }
        }
    }
    ?>
</article>

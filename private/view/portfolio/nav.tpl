<?php
    $items = array('professional'=>array(array('title'=>'Boom!',
                                                    'href'=>'/portfolio/professional/boom',
                                                     ),
                                               array('title'=>'South African Space Resources Association',
                                                    'href'=>'/portfolio/professional/sasra',
                                                     ),                                                   
                                               array('title'=>'6th Line',
                                                    'href'=>'/portfolio/professional/6th',
                                                     ),                                                   
                                               array('title'=>'Coldshift Technologies',
                                                    'href'=>'/portfolio/professional/coldshift',
                                                     ),                                                   
                                               array('title'=>'Department of Statistics South Africa',
                                                    'href'=>'/portfolio/professional/statssa',
                                                     ),                                                   
                                             ),
        
                   'personal'=>array(array('title'=>'Hackershack',
                                              'href'=>'/portfolio/personal/hackershack',
                                              ),
                                        array('title'=>'theo.ireton.za.net',
                                              'href'=>'/portfolio/personal/site',
                                              ),                                             
                                        array('title'=>'Dots and Boxes',
                                              'href'=>'/portfolio/personal/dots',
                                              ),                                             
                                        array('title'=>'C.V. Shift',
                                              'href'=>'/portfolio/personal/cvshift',
                                              ),                                             
                                        array('title'=>'OAO Just Rocket Science',
                                              'href'=>'/portfolio/personal/oao',
                                              ),                                             
                                        array('title'=>'SnowWind',
                                              'href'=>'/portfolio/personal/snow',
                                              ),                                             
                                        array('title'=>'Voicelog',
                                              'href'=>'/portfolio/personal/voicelog',
                                              ),                                             
                                       ),
                  );
?>

<article class="area right">
    <?php
        foreach($items as $section1=>$level1Data)
        {
            echo "<section class='title'>\n" .
                 "{$section1}\n".
                 "</section>";

            foreach($level1Data as $level2Section=>$level2Data)
            {
                if(!is_numeric($level2Section))
                {
                    // section
                    echo "<p><h3>{$level2Section}</h3></p>\n";
                    
                    foreach($level2Data as $level3Data)
                    {
                        if(!empty($this->selected) && $level3Data['href'] == $this->selected)
                        {
                            echo "<p class='indented'>{$level3Data['title']}</p>\n";
                        }
                        else
                        {
                            echo "<p class='indented'><a href='{$level3Data['href']}'>{$level3Data['title']}</a></p>\n";
                        }
                    }
                }
                else
                {
                    if(!empty($this->selected) && $level2Data['href'] == $this->selected)
                    {
                        echo "<p>{$level2Data['title']}</p>\n";
                    }
                    else
                    {
                        echo "<p><a href='{$level2Data['href']}'>{$level2Data['title']}</a></p>\n";
                    }
                }
            }
        }
    ?>
</article>

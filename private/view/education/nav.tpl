<?php
    $items = array('education'=>array('Secondary'=>array(array('title'=>'P.W. Botha Technical College',
                                                               'href'=>'/education/secondary',
                                                              ),
                                                        ),
        
                                      'Tertiary'=>array(array('title'=>'Formal College-Level',
                                                               'href'=>'/education/tertiary/formal',
                                                              ),
                                                        array('title'=>'OpenCourseWare',
                                                               'href'=>'/education/tertiary/opencourseware',
                                                              ),                                          
                                                        array('title'=>'Professional Development',
                                                               'href'=>'/education/tertiary/professional',
                                                              ),                                          
                                                        ),
        
                                     ),
        
/*                   'partial career history'=>array(array('title'=>'Boom!',
                                                        'href'=>'/education/career/boom',
                                                         ),
                                                   array('title'=>'South African Space Resources Association',
                                                        'href'=>'/education/career/sasra',
                                                         ),                                                   
                                                   array('title'=>'Blue Label Mobile',
                                                        'href'=>'/education/career/blm',
                                                         ),                                                   
                                                   array('title'=>'6th Line',
                                                        'href'=>'/education/career/6th',
                                                         ),                                                   
                                                   array('title'=>'Barmazel International',
                                                        'href'=>'/education/career/barmazel',
                                                         ),                                                   
                                                   array('title'=>'Coldshift Technologies',
                                                        'href'=>'/education/career/coldshift',
                                                         ),                                                   
                                                   array('title'=>'Department of Statistics South Africa',
                                                        'href'=>'/education/career/statssa',
                                                         ),                                                   
                                                   array('title'=>'Odyssey Internet Cafe Franchise',
                                                        'href'=>'/education/career/odyssey',
                                                         ),                                                   
                                                   array('title'=>'Conradie Hospital',
                                                        'href'=>'/education/career/conradie',
                                                         ),                                                   
                                                  ),
        
                   'memberships'=>array(array('title'=>'South African Space Resources Association',
                                              'href'=>'/education/memberships/sasra',
                                              ),
                                        array('title'=>'Institute of Electrical and Electronics Engineers',
                                              'href'=>'/education/memberships/ieee',
                                              ),                                             
                                       ),
        */
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

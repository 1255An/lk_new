<?php


$num=0;
foreach($_POST as $sentence)
{
    if(substr_count($sentence,"plan_term_project_")>0)
    {
        $num++;
    }
}

echo $num;


?>
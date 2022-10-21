<?php

//set dark theme if theme is not set 
if(empty($_COOKIE['theme_notess']))
{
    setcookie("theme_notess","dark");
}

//check for theme

$theme = "";
if($_COOKIE['theme_notess'] == "dark")
{
    $theme = "dark";
}
elseif ($_COOKIE['theme_notess'] == "light"){
    $theme = "light";
}
else {
    $theme = "dark";
}


//load labels

$labels[3] = ["","",""];

$file = fopen(getcwd()."/subjects/app_labels.txt","r");


//check if the file exists
if(!$file)
{
    $content = file_get_contents("error500.html");
    echo $content;
}
else {
    // get labels data and set it to array
    fclose($file);
    foreach(file(getcwd()."/subjects/app_labels.txt") as $line)
    {
        $record = explode("=",$line);
        if($record[0] == "subject")
        {
            $labels[0] = $record[1];
        }
        elseif ($record[0] == "lesson") {
            $labels[1] = $record[1];
        }
        elseif ($record[0] == "title") {
            $labels[2] = $record[1];
        }
    }
}

//checks if all labels have they text

for($i = 0;$i < 3;$i++)
{
    if($labels[$i] == "")
    {
        $content = file_get_contents("error500.html");
        echo $content;
        break;
    }
}

//html heads and bodies

//this global body load static data like js script that is important for all pages to be functional
$global_body = "<body><script type='text/javascript' src='js/menu.js'></script></body>";

//this is head for menu,where user choose a subject 
$head = "<head><meta charset='utf-8'><title>".$labels[2]."</title><link rel='stylesheet' href='css/explorer.css'</head>";
//this is head for content of lesson
$page_head = "<head><meta charset='utf-8'><title>".$labels[2]."</title><link rel='stylesheet' href='css/page.css'</head>";
//this is head for list of lessons that can user choose
$lessons_head = "<head><meta charset='utf-8'><title>".$labels[2]."</title><link rel='stylesheet' href='css/lessons.css'</head>";

//html for body to create div with class name content
$div_start = "<div class='content'>";
$div_end = "</div>";


//choose right head for css style that depends on theme that is set by cookie
if($theme == "light")
{
    $page_head = "<head><meta charset='utf-8'><title>".$labels[2]."</title><link rel='stylesheet' href='css/page_light.css'</head>";
    $head = "<head><meta charset='utf-8'><title>".$labels[2]."</title><link rel='stylesheet' href='css/explorer_light.css'</head>";
    $lessons_head = "<head><meta charset='utf-8'><title>".$labels[2]."</title><link rel='stylesheet' href='css/lessons_light.css'</head>";
}


//check if is a subject empty,if yes then the user will be prompted to choose that subject,otherwise it will show list of lessons
if(empty($_GET['subject']))
{
    //own html for  page  next to global html 
    $first = "<div class='menu'><img onclick='ChangeTheme()' src='img/theme.svg' height=30 width=30 ></div>";
    //title
    $to_print = "<b><h1>".$labels[0]."</h1></b>";

    //scans dir for subjects,name.txt in folder of subject is used to display in list of subjectsmotherwise it is a name of folder of that subject,also the button redirect user to list of lessons under desired subject
    $dir = scandir(getcwd()."/subjects/");
    $final = array_values(array_diff($dir,array(".","..")));
    for($i = 0;$i < count($final);$i++)
    {
        if(is_dir(getcwd()."/subjects/".$final[$i]."/")){
            if(file_exists(getcwd()."/subjects/".$final[$i]."/name.txt"))
            {
                $content = file_get_contents(getcwd()."/subjects/".$final[$i]."/name.txt");
                $to_print = $to_print."<br><a href='?subject=".$final[$i]."'><button>".$content."</button></a>";
            }
            else {
            $to_print = $to_print."<br><a href='?subject=".$final[$i]."'><button>".$final[$i]."</button></a>";
            }
        }
    }
    //display of page
    echo $head.$global_body.$first.$div_start.$to_print.$div_end;
}
else {
    //check if lesson is empty,if yes then it display list of lessons,otherwise the page of lesson will be displayed
    if(empty($_GET['lesson']))
    {
        //secure thing to clear special characters that cause security holes
        $subject = preg_replace('/[^a-zA-Z0-9_ -]/s',' ',$_GET['subject']);
        $to_print = "<div class='menu'><a href='/'><img src='img/backward.svg' height=30 width=30 ></a><img onclick='ChangeTheme()' src='img/theme.svg' height=30 width=30 ></div><b><h1>".$labels[1]."</h1></b>";
        if(!is_dir(getcwd()."/subjects/".$subject."/"))
        {
            $content = file_get_contents("error404.html");
            echo $content;
            exit(0);
        }
        //scan for lessons in subject
        $dir = scandir(getcwd()."/subjects/".$subject."/");
        $final = array_values(array_diff($dir,array(".","..","name.txt")));
        for($i = 0;$i < count($final);$i++)
        {
            if(is_dir(getcwd()."/subjects/".$subject."/".$final[$i]."/"))
            {
                if(file_exists(getcwd()."/subjects/".$subject."/".$final[$i]."/name.txt"))
                {
                    $content = file_get_contents(getcwd()."/subjects/".$subject."/".$final[$i]."/name.txt");
                    $to_print = $to_print."<br><a href='?subject=".$subject."&lesson=".$final[$i]."'><button>".$content."</button></a>";
                }
                else {
                    $to_print = $to_print."<br><a href='?subject=".$subject."&lesson=".$final[$i]."'><button>".$final[$i]."</button></a>";
                }
            }
        }
        //display list of lessons
        echo $lessons_head.$global_body.$to_print;
    }
    else {
        //secure thing to clear special characters that cause security holes
        $subject = preg_replace('/[^a-zA-Z0-9_ -]/s','',$_GET['subject']);
        $lesson = preg_replace('/[^a-zA-Z0-9_ -]/s','',$_GET['lesson']);

        //check if the index of lesson exists,if yes then it will be displayed to user,otherwise it will cause error 404
        if(file_exists(getcwd()."/subjects/".$subject."/".$lesson."/index.html"))
        {
            $for_print = "<div class='menu'><a href='?subject=".$subject."'><img src='img/backward.svg' height=30 width=30 ></a><img onclick='ChangeTheme()' src='img/theme.svg' height=30 width=30 ></div>";
            $content = file_get_contents(getcwd()."/subjects/".$subject."/".$lesson."/index.html");
            echo $page_head.$global_body.$for_print.$content;
        }
        else {
            $content = file_get_contents("error404.html");
            echo $content;
        }
    }
}

?>
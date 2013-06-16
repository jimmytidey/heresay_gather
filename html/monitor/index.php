<?

include('../header.php'); 

date_default_timezone_set ('Europe/London');

echo "<h1>Totals</h1>";
echo "<P>Total Number Of Posts</p>";
$results = $db->fetch('SELECT count(*) FROM manual_updates');
echo $results[0]['count(*)'];

echo "<P>Total Number Of Categorised Posts</p>";
$results = $db->fetch("SELECT count(*) FROM manual_updates WHERE category_1!='' && category_1!='undefined'");
echo $results[0]['count(*)'];

echo "<P>Total Number Of Located Posts</p>";
$results = $db->fetch("SELECT count(*) FROM manual_updates WHERE lat!='' && lat!='--' && lat!='0'");
echo $results[0]['count(*)'];

echo "<hr/>";

echo "<h1>Historical stats</h1>";

$yesterday_midnight = strtotime("Yesterday");

$yesterday_midnight = $yesterday_midnight+ (60*60*12); 

$i = 0;

for($time=$yesterday_midnight; $time>1343797200; $time=$time-(60*60*24)) { 
    if ($i<20) { 
        $time_minus = $time-(60*60*24);
        echo "<p>Starts " . date('F j, Y, g:i a',$time) . "  -----   Ends " . date('F j, Y , g:i a',$time_minus) . "</p>";


        $results = $db->fetch("SELECT count(*) FROM manual_updates WHERE pubdate > $time_minus && pubdate< $time " );
        echo "<P>TOTAL POSTS:      " . $results[0]['count(*)'] . "</p>";



        $results = $db->fetch("SELECT count(*) FROM manual_updates WHERE  (lat!='' || (category_1 !='' && category_1!='undefined')) && pubdate > $time_minus && pubdate< $time");
        echo "<P>Posts with location OR category:    " . $results[0]['count(*)'] . "</p>";


        $results = $db->fetch("SELECT count(*) FROM manual_updates WHERE  lat!='' && lat!='0'  && pubdate > $time_minus && pubdate< $time");
        echo "<P>Posts with lat lng: " . $results[0]['count(*)'] . "</p>";

        $results = $db->fetch("SELECT *, COUNT(*) from manual_updates WHERE pubdate > '$time_minus' && pubdate< '$time' GROUP BY user"); 

        foreach($results as $result) { 
            echo "<p>". $result['user'] . " - " . $result['COUNT(*)'] . "</p>";
        }    
        echo "<hr/>";
        $i++;
    }
}














?>
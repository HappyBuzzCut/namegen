<?php include 'db.inc';
$TABLE_MALE = 'popular_male_first_names';
$TABLE_FEMALE = 'popular_female_first_names';

if($_GET['namegen'])
{
	$numnames = intval($_GET['namegen']);
	if($numnames > 25)
	{
		echo "Are you trying to get me in trouble?  25 or less names should be enough";
		exit;
	}
    if(!strtolower($_GET['sex'])):
    $sex = $TABLE_MALE;
	$color = '#0099FF';
    elseif(strtolower($_GET['sex']) == "male"):
    $sex = $TABLE_MALE;
	$color = '#0099FF';
    else:
    $sex = $TABLE_FEMALE;
	$color = '#FF00CC';
    endif;
    
    $sthfn = $dbh->prepare('SELECT * FROM ' . $sex . ' where id = :random');
    $sthln = $dbh->prepare('SELECT * FROM common_last_names where id = :random');
    
    $x=1;
    while($x<=$numnames) {
        $randln = rand(1,1918);  //Number of names hardcoded as I'm avoiding strain on mySQL
        $randfn = rand(1,200);
        
        $sthfn->bindValue('random', $randfn, PDO::PARAM_INT);
        $sthfn->execute();
        $sthln->bindValue('random', $randln, PDO::PARAM_INT);
        $sthln->execute();
        
        $resultfn = $sthfn->fetch(PDO::FETCH_LAZY);
        $resultln = $sthln->fetch(PDO::FETCH_LAZY);
        if(intval($_GET['plaintext']) == 1)
        {
            echo $resultfn['firstName'] . ' ' . $resultln['lastName'] . '\n';
        }
        else
        {
            echo '<div id="name" style="color:' . $color .'">' . $resultfn['firstName'] . ' ' . $resultln['lastName'] . "</div>";
        }
        $x++;
    }
    
    $dbh = null;
}

?>


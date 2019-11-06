<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);

function convertToBurmeseNumber($numberInput){
	$numbers = array(
            "၀" => 0,
            "၁" => 1,
            "၂" => 2,
            "၃" => 3,
            "၄" => 4,
            "၅" => 5,
            "၆" => 6,
            "၇" => 7,
            "၈" => 8,
            "၉" => 9
        );
	$r = array();
	
	$str_arr = str_split($numberInput);
	foreach($str_arr as $key => $value){
		foreach($numbers as $k => $v){
			if($v == $value){
				$r[] = $k;
			}
		}
	}
	return $r;
}

function convertToEnglishNumber($numberInput){
	$numbers_1 = array(
            "၀" => 0,
            "၁" => 1,
            "၂" => 2,
            "၃" => 3,
            "၄" => 4,
            "၅" => 5,
            "၆" => 6,
            "၇" => 7,
            "၈" => 8,
            "၉" => 9
        );
	$numbers_2 = array(
            0=>"၀",
            1=>"၁",
            2=>"၂",
            3=>"၃",
            4=>"၄",
            5=>"၅",
            6=>"၆",
            7=>"၇",
            8=>"၈",
            9=>"၉"
        );
	$change = str_replace($numbers_2, $numbers_1, $numberInput);
	return $change;
}

print_r(convertToBurmeseWords('11110', 'speech'));

function convertToBurmeseWords($num, $wordType="written"){
	
	$words = array('', 'တစ္', 'ႏွစ္', 'သံုး', 'ေလး', 'ငါး', 'ေျခာက္', 'ခုႏွစ္', '႐ွစ္', 'ကိုး', 'တစ္ဆယ္');
	$_words = array('တစ္', 'ႏွစ္', 'သံုး', 'ေလး', 'ငါး', 'ေျခာက္', 'ခုႏွစ္', '႐ွစ္', 'ကိုး', 'တစ္ဆယ္');
	$wordsConcat = implode("|", $_words);
	
	if(!$num) return $num;
	
	if(strlen($num)==1){
		return $_words[$num-1];
	}
	
	// convert to english number first
    $num = convertToEnglishNumber($num);
	if(strlen($num)>11){
		return 'overflow';
	}
	$n = substr('000000000'.$num, -10);
	//var n = match(/^(\d{1})(\d{1})(\d{1})(\d{2})(\d{1})(\d{1})(\d{1})(\d{2})$/);
	
	if(!$n){return false;}
	$nn = preg_match('/^(\d{1})(\d{1})(\d{1})(\d{2})(\d{1})(\d{1})(\d{1})(\d{2})$/', substr('000000000'.$num, -10), $rgr);
	$n = implode(",", $rgr);
	$upperLakh = '';
	$lowerLakh = '';
	
	if($rgr[1] != 0){$upperLakh .= 'သိန္း' . $words[$rgr[1][0]] . 'ေသာင္း';}else{$upperLakh .='';}
	
	if($rgr[2] != 0){
		if($upperLakh != ''){
			$upperLakh .= '';
		}else{
			$upperLakh .= 'သိန္း';
		}
		$upperLakh .= $words[$rgr[2][0]] . 'ေထာင္';
		
	}else{
		$upperLakh .= '';
	}
	
	if($rgr[3] != 0){
		if($upperLakh != ''){
			$upperLakh .= '';
		}else{
			$upperLakh .= 'သိန္း';
		}
		$upperLakh .= $words[$rgr[3][0]] . 'ရာ';
	}else{
		$upperLakh .='';
	}
	
	if($rgr[4] != 0){
		if($words[$rgr[4][0]] && !$words[$rgr[4][1]]){
			$upperLakh .= (($upperLakh != '') ? '' : 'သိန္း') . $words[$rgr[4][0]] . 'ဆယ္';
			
		}elseif($words[$rgr[4][0]] || $words[$rgr[4][1]]){
			if($words[$rgr[4]]){
				$upperLakh .= ($words[$rgr[4]] || $words[$rgr[4][0]] . 'ဆယ္' . $words[$rgr[4][1]]) . 'သိန္း';
			}else{
				#var_dump($words[$rgr[4][1]]);
				if(strlen($words[$rgr[4][0]]) <> 0){
					$upperLakh .= ($words[$rgr[4][0]] . 'ဆယ္' . $words[$rgr[4][1]]) . 'သိန္း';	
				}else{
					$upperLakh .= ($words[$rgr[4][1]]) . 'သိန္း';
				}
				
				
			}
		}
	}
	
	//lowerLakh += (n[5] != 0) ? (words[Number(n[5])]) + 'ေသာင္း' : '';
	if($rgr[5] != 0){
		$lowerLakh .= $words[$rgr[5]] . 'ေသာင္း';
	}else{
		$lowerLakh .='';
	}
	//lowerLakh += (n[6] != 0) ? (words[Number(n[6])]) + 'ေထာင္' : '';
	if($rgr[6] != 0){
		$lowerLakh .= $words[$rgr[6]] . 'ေထာင္';
	}else{
		$lowerLakh .='';
	}
	//lowerLakh += (n[7] != 0) ? (words[Number(n[7])]) + 'ရာ' : '';
	if($rgr[7] != 0){
		$lowerLakh .= $words[$rgr[7]] . 'ရာ';
	}else{
		$lowerLakh .='';
	}
	//lowerLakh += (n[8] != 0) ? (words[Number(n[8])] || words[n[8][0]] + 'ဆယ္' + words[n[8][1]]) : '';
	
	#return $words[$rgr[8][0]];
	if($rgr[8] != 0){
		if($words[$rgr[8]]){
			$lowerLakh .= $words[$rgr[8]];
		}else{
			$lowerLakh .= $words[$rgr[8][0]] . 'ဆယ္' . $words[$rgr[8][1]];
		}
	}else{
		$lowerLakh .='';
	}
	
	//var final = (upperLakh !== '' && lowerLakh !== '') ? upperLakh + ' ႏွင့္ ' + lowerLakh : upperLakh + lowerLakh;
	
	$final = '';
	if($upperLakh !== '' && $lowerLakh !== ''){
		$final = $upperLakh . ' ႏွင့္ ' . $lowerLakh;
	}else{
		$final = $upperLakh . $lowerLakh;
	}
	
	#return $final.' -> '.strlen($final).' -> '.strpos($final, "ေထာင္").' / ေထာင္';
	
	if(!strpos($final, "ရာ") === false){
		//do nothing here
		if($wordType == 'speech'){
			//Not all speech should emphasis, e.g. not required if last word
			if(strlen($final) - strpos($final, "ရာ") != 6){
				$final = str_replace("ရာ", "ရာ့ ", $final);
			}
		}
	}
	
	if(!strpos($final, "ေထာင္") === false){
		if($wordType == 'speech'){
			//Not all speech should emphasis, e.g. not required if last word
			if(strlen($final) - strpos($final, "ေထာင္") != 15){
				$final = str_replace("ေထာင္", "ေထာင့္ ", $final);
			}
		}
	}
	
	if(!strpos($final, "ဆယ္") === false){
		if($wordType == 'speech'){
			//Not all speech should emphasis, e.g. not required if last word
			if(strlen($final) - strpos($final, "ဆယ္") != 9){
				$final = str_replace("ဆယ္", "ဆယ့္", $final);
			}
		}
	}
	
	return $final;
}
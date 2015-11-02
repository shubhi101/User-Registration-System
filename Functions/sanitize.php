<?php
//might be needed for data going in as well as coming out
function escape($string){
	return htmlentities($string,ENT_QUOTES,'UTF-8');
}

/*Do more in sanitizing using mysqli
ENT_QUOTES : Escape single and double magic_quotes_runtime()*/
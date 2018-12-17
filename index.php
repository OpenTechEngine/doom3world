<?php
header ( "Content-Type: text/html;charset=utf-8" );
if (! isset ( $_GET ["thread_id"] )) {
	$threads = file ( "catalog.txt", FILE_IGNORE_NEW_LINES );
	foreach ( $threads as $thread ) {
		$info = explode ( "=", $thread, 2 );
		echo "<a href='{$_SERVER['PHP_SELF']}?thread_id={$info[0]}'>{$info[1]}</a><br/>";
	}
} else {
	$thread = (int) $_GET ["thread_id"];
	if (
		is_int ( $thread ) 
		&& $thread > 0 
		&& $thread < PHP_INT_MAX 
		&& file_exists ( getcwd() . DIRECTORY_SEPARATOR . "catalog" . DIRECTORY_SEPARATOR . "{$thread}.xml" )
	) {
		$xml = simplexml_load_file ( getcwd() . DIRECTORY_SEPARATOR . "catalog" . DIRECTORY_SEPARATOR . "{$thread}.xml" );
		foreach ( $xml->thread->posts->post as $post ) {
			/* tähän väliin per-post data */
			echo "{$post->author}@{$post->attributes()->date}: {$post->body}<br><hr><br/>";
		}
	} else {
		die("<img src='toobad.jpg'><br>too bad but do not bad");
	}
}
?>
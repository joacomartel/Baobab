<form method="get" id="searchform" action="<?php bloginfo('url'); ?>">
	<input type="text" name="s" id="search" placeholder="Buscar" value="<?php the_search_query(); ?>" />	
</form>
<?php
/**
* Pagination
*
* This set of functions supports pagination.
*/

	/**
	* Pagination Controls
	*
	* Returns a string containing HTML that describes pagination controls
	* for a multi-page listing of search results.
	*
	* Creates the appropriate URLs for each control
	* 
	* The arguments are as follows:
	* - $count: The total number of records found in the search.
	* - $limit: The number of records to display on a page
	* - $offset: The record number from which to begin displaying results
	* - $offset_name: The name of the query argument that controls the record 
	*   number from which to begin displaying results
	*
	* @return $controls: a string containing the HTML pagination controls
	*/

	function trj_golem_pagination_controls($count, $limit, $offset, $offset_name) {

		/*
		* Basic Error Checking
		*
		* Return early providing an empty string if nonsensical input is provided.
		*/
		$do_not_display = false;
		// Check if $limit is less than 1
		if($limit<1) {
			$do_not_display = true;
		}
		// Check if $count is less than or equal to $limit (all results will fit on one page)
		if($count <= $limit) {
			$do_not_display = true;
		}
		// If there was an input error return early.
		if($do_not_display) {
			return '';
		} // if

		/*
		* URL Parsing and Reconstruction
		*
		* Get the current URL and reconstruct it without the $offset_name 
		* parameter. This allows custom versions of the URL to be constructed
		* by adding a new $offset_name parameter with a different value to support
		* pagination.
		*/

		// Get the base URL without the query string
		$url_base = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]" . strtok($_SERVER["REQUEST_URI"],'?') . "?";
		// Get the query terms in an array
		parse_str($_SERVER['QUERY_STRING'], $query_terms);
		// If the $offset_name parameter is present remove it
		if (isset($query_terms[$offset_name])) {
			unset($query_terms[$offset_name]);
		} // if
		// Add the query terms back into the URL without $offset_name
		foreach($query_terms as $key=>$value) {
			$url_base .= "$key=$value&";
		} // foreach
		// Remove trailing "&" from end of URL string
		$url_base = substr($url_base, 0, -1);

		// Calculate total number of pages
		$total_pages = ceil($count/$limit);

		/*
		* Create individual page control elements
		*/
		// Create an array to hold pagination-related data
		$pages = array();
		// Create a control
		$pages['current']['offset'] = (ceil(($offset+1) / $limit) - 1) * $limit;
		$pages['current']['page'] = ceil(($offset+1) / $limit);
		$pages['current']['symbol'] = $pages['current']['page'];
		$pages['current']['class'] = 'trj_golem_pagination_current';
		$pages['current']['url'] = $url_base . "&$offset_name={$pages['current']['offset']}";
		$pages['current']['html'] = '<span class="' . $pages['current']['class'] . '">' . $pages['current']['symbol'] . '</span>';
		// Create a control
		$pages['first']['offset'] = 0;
		$pages['first']['page'] = 1;
		$pages['first']['symbol'] = $pages['first']['page'];
		$pages['first']['class'] = 'trj_golem_pagination_control_first';
		$pages['first']['url'] = $url_base . "&$offset_name={$pages['first']['offset']}";
		$pages['first']['html'] = $pages['current']['page'] <= 1 ? '' : '<span class="' . $pages['first']['class'] . '"><a href="' . $pages['first']['url'] . '">' . $pages['first']['symbol'] . '</a></span>';
		// Create a control
		$pages['last']['offset'] = (($total_pages-1) * $limit);
		$pages['last']['page'] = $total_pages;
		$pages['last']['symbol'] = $pages['last']['page'];
		$pages['last']['class'] = 'trj_golem_pagination_control_last';
		$pages['last']['url'] = $url_base . "&$offset_name={$pages['last']['offset']}";
		$pages['last']['html'] = $pages['current']['page'] >= $total_pages ? '' : '<span class="' . $pages['last']['class'] . '"><a href="' . $pages['last']['url'] . '">' . $pages['last']['symbol'] . '</a></span>';
		// Create a control
		$pages['next']['offset'] = min((($total_pages-1) * $limit), ($offset + $limit));
		$pages['next']['page'] = $pages['current']['page'] + 1;
		$pages['next']['symbol'] = $pages['next']['page'];
		$pages['next']['class'] = 'trj_golem_pagination_control_page';
		$pages['next']['url'] = $url_base . "&$offset_name={$pages['next']['offset']}";
		$pages['next']['html'] = $pages['next']['page'] >= $total_pages ? '' : '<span class="' . $pages['next']['class'] . '"><a href="' . $pages['next']['url'] . '">' . $pages['next']['symbol'] . '</a></span>';
		// Create a control
		$pages['next2']['offset'] = min((($total_pages-1) * $limit), ($offset + ($limit*2)));
		$pages['next2']['page'] = $pages['current']['page'] + 2;
		$pages['next2']['symbol'] = $pages['next2']['page'];
		$pages['next2']['class'] = 'trj_golem_pagination_control_page';
		$pages['next2']['url'] = $url_base . "&$offset_name={$pages['next2']['offset']}";
		$pages['next2']['html'] = $pages['next2']['page'] >= $total_pages ? '' : '<span class="' . $pages['next2']['class'] . '"><a href="' . $pages['next2']['url'] . '">' .$pages['next2']['symbol'] . '</a></span>';
		// Create a control
		$pages['next3']['offset'] = min((($total_pages-1) * $limit), ($offset + ($limit*3)));
		$pages['next3']['page'] = $pages['current']['page'] + 3;
		$pages['next3']['symbol'] = $pages['next3']['page'];
		$pages['next3']['class'] = 'trj_golem_pagination_control_page';
		$pages['next3']['url'] = $url_base . "&$offset_name={$pages['next3']['offset']}";
		$pages['next3']['html'] = $pages['next3']['page'] >= $total_pages ? '' : '<span class="' . $pages['next3']['class'] . '"><a href="' . $pages['next3']['url'] . '">' .$pages['next3']['symbol'] . '</a></span>';
		// Create a control
		$pages['previous']['offset'] = max(0, ($offset - $limit));
		$pages['previous']['page'] = $pages['current']['page'] - 1;
		$pages['previous']['symbol'] = $pages['previous']['page'];
		$pages['previous']['class'] = 'trj_golem_pagination_control_page';
		$pages['previous']['url'] = $url_base . "&$offset_name={$pages['previous']['offset']}";
		$pages['previous']['html'] = $pages['previous']['page'] <= 1 ? '' : '<span class="' . $pages['previous']['class'] . '"><a href="' . $pages['previous']['url'] . '">' . $pages['previous']['symbol'] . '</a></span>';
		// Create a control
		$pages['previous2']['offset'] = max(0, ($offset - ($limit * 2)));
		$pages['previous2']['page'] = $pages['current']['page'] - 2;
		$pages['previous2']['symbol'] = $pages['previous2']['page'];
		$pages['previous2']['class'] = 'trj_golem_pagination_control_page';
		$pages['previous2']['url'] = $url_base . "&$offset_name={$pages['previous2']['offset']}";
		$pages['previous2']['html'] = $pages['previous2']['page'] <= 1 ? '' : '<span class="' . $pages['previous2']['class'] . '"><a href="' . $pages['previous2']['url'] . '">' . $pages['previous2']['symbol'] . '</a></span>';
		// Create a control
		$pages['previous3']['offset'] = max(0, ($offset - ($limit * 3)));
		$pages['previous3']['page'] = $pages['current']['page'] - 3;
		$pages['previous3']['symbol'] = $pages['previous3']['page'];
		$pages['previous3']['class'] = 'trj_golem_pagination_control_page';
		$pages['previous3']['url'] = $url_base . "&$offset_name={$pages['previous3']['offset']}";
		$pages['previous3']['html'] = $pages['previous3']['page'] <= 1 ? '' : '<span class="' . $pages['previous3']['class'] . '"><a href="' . $pages['previous3']['url'] . '">' . $pages['previous3']['symbol'] . '</a></span>';

		/*
		* Create entire pagination widget from individual page control elements
		*/
		// Create a variable to hold pagination controls
		$paginator = '';
		// Concatenate individual control elements
		$paginator .= '<div class="trj_golem_pagination_container">';
			$paginator .= '<div class="trj_golem_pagination_widget">';
				$paginator .= $pages['first']['html'];
				$paginator .= ' ';
				$paginator .= $pages['previous3']['html'];
				$paginator .= ' ';
				$paginator .= $pages['previous2']['html'];
				$paginator .= ' ';
				$paginator .= $pages['previous']['html'];
				$paginator .= ' ';
				$paginator .= $pages['current']['html'];
				$paginator .= ' ';
				$paginator .= $pages['next']['html'];
				$paginator .= ' ';
				$paginator .= $pages['next2']['html'];
				$paginator .= ' ';
				$paginator .= $pages['next3']['html'];
				$paginator .= ' ';
				$paginator .= $pages['last']['html'];
			$paginator .= '</div>';
		$paginator .= '</div>';

		return $paginator;

	} // function trj_golem_pagination_controls

?>

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('breadcumb_add')){
    function breadcumb_add(&$breadcumb,$title,$link=NULL,$active=FALSE){
        if (is_array($breadcumb)){
            $item = array('title'=>$title, 'active'=>$active);
            if ($link){
                $item['link'] = $link;
            }
            $breadcumb [] = $item;
        }
    }
}

if (!function_exists('breadcumb')){
    function breadcrumb($pages){
        $str = '<ol class="breadcrumb">';
        
        if (is_array($pages)){
            foreach ($pages as $page){
                $active = (isset($page['active'])&&$page['active']==TRUE);
                $str.= '<li';
                if ($active)
                    $str.= ' class="active"';
                        
                $str.= '>';
                if (isset($page['link']))
                    $str.= '<a href="'.$page['link'].'">'. $page['title'].'</a>';
                else
                    $str.= $page['title'];
                
                
                $str.= '</li>';
            }
        }
        else
        {
            $str.= '<li>'.$page.'</li>';
        }
        $str.= '</ol>';
        return $str;
    }
}

if (!function_exists('create_alert_box')){
    /**
     * Get alert box in string format
     * @param string $alert_text
     * @param string $alert_type : default|info|success|warning|danger|error
     * @param string $alert_title
     * @return string alert box string
     */
    function create_alert_box($alert_text, $alert_type=NULL, $alert_title=NULL){
        $type_labels = array(
            'default' => 'Information', 'info'=>'Information', 'success'=>'Successfull', 
            'warning'=>'Warning', 'danger'=>'Danger', 'error'=>'Error'
        );
        $type_alerts = array(
            'default'=>'alert-info', 'info'=>'alert-info', 'success'=>'alert-success', 
            'warning'=>'alert-warning', 'danger'=>'alert-danger', 'error'=>'alert-danger'
        );
        $s = '<div class="alert '.(isset($type_alerts[$alert_type])?$type_alerts[$alert_type]:$type_alerts['default']).' alert-dismissible" role="alert">';
        //button dismiss
        $s.= '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
        //Label in bold
        $s.= '<strong>'. ($alert_title?$alert_title:(isset($type_labels[$alert_type])?$type_labels[$alert_type]:$type_labels['default']).'!').'</strong> ';
        //Alert text
        $s.= $alert_text;
        $s.= '</div>';
        
        return $s;
    }
}

if (!function_exists('indonesia_date_format')){
    /**
     * 
     * @param type $format
     * @param type $time
     */
    function indonesia_date_format($format='%d-%m-%Y', $time=NULL){
        
        //create date object
        if (!$time) { $time = time(); }
        $date_obj  =  getdate($time);
        
        //set Indonesian month name
        $bulan = array(
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'Nopember', 'Desember'
        );
        
        $bulan_short = array(
            'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nop', 'Des'
        );
        
        $hari = array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu');
        
        $format_search = array('%d','%D','%m','%M','%S','%y','%Y','%H','%i','%s');
        $format_replace = array( 
            $date_obj['mday'], $hari[$date_obj['wday']],  $date_obj['mon'], $bulan[$date_obj['mon']-1],  
            $bulan_short[$date_obj['mon']-1], $date_obj['year'], $date_obj['year'], $date_obj['hours'], 
            $date_obj['minutes'], $date_obj['seconds']  
        );
        $str = str_replace($format_search, $format_replace, $format);
        
        return $str;
    }
}

if (!function_exists('btn_new')){
    function btn_new($uri='#', $title=''){
        return anchor($uri, '<i class="icon-file"></i> Create New ', 'title="'.$title.'"' );
    }
}

if (!function_exists('btn_edit')){
    function btn_edit($uri='#', $attributes=''){
        return anchor($uri, '<i class="icon-edit"></i>', $attributes);
    }
}

if (!function_exists('btn_delete')){
    function btn_delete($uri){
        return anchor($uri, '<i class="icon-remove" title="Remove"></i>', array(
		'onclick' => "return confirm('You are about to delete a record. This cannot be undone. Are you sure?');",
                'title' =>  'Delete item'
	));
    }
}

if (!function_exists('btn_upload')){
    function btn_upload($uri){
        return anchor($uri, '<i class="icon-upload" title="Upload"></i>');
    }
}

if (!function_exists('btn_syncronize')){
    function btn_syncronize($uri, $title=''){
        return anchor($uri, '<i class="icon-refresh"></i>' . $title, array(
		'onclick' => "return confirm('Syncronize with API will replace old with new data and takes time. Are you sure?');",
                'title' => 'Syncronize'
	));
    }
}

if (!function_exists('create_pagination')){
    function create_pagination($total_pages, $current_page, $url_format='%i'){
        $str = '';
        if ($total_pages > 1){
            $str.= '<div class="pagination">';
            $str.= '<ul>';
            
            if ($total_pages > 2){
                $str.= '<li'.($current_page==0?' class="disabled"':'').'><a'.($current_page>0?' href="'.str_replace('%i',($current_page-1),$url_format).'"':''). '>Prev</a></li>';
            }
            
            for($i=0;$i<$total_pages;$i++){
                $str.= '<li'. ($current_page==$i?' class="active"':'') .'><a href="'.  str_replace('%i',$i,$url_format) .'">'.($i+1).'</a></li>';
            }
            
            if ($total_pages > 2){
                $str.= '<li'.($current_page==($total_pages-1)?' class="disabled"':'').'><a'.($current_page<($total_pages-1)?' href="'.str_replace('%i',($current_page+1),$url_format).'"':''). '>Next</a></li>';
            }
            
            $str.= '</ul>';
            $str.= '</div>';
        }
        
        return $str;
    }
}

if (!function_exists('smart_paging')){
    function smart_paging($totalPages, $page=1, $adjacents=2, $url_format='%i', $min_page_adjacents=5, $recordInfo=NULL){  
	$prev = $page - 1;
	$next = $page + 1;
        $first_page = 1;
	$lastpage = $totalPages-1;		//lastpage is = total pages / items per page, rounded up.
	$lpm1 = $lastpage - 1;			//last page minus 1

	/* 
         * Now we apply our rules and draw the pagination object. 
         * We're actually saving the code to a variable in case we want to draw it more than once.
	*/
        
        
	$pagination = '';
        $pagination .= '<div class="pagination"><ul class="pagination pagination-sm">';
        if ($recordInfo && is_array($recordInfo)){
            $pagination .= '<li class="disabled"><a>Showing result '. number_format($recordInfo['records'],0,'.',',').' from total '.  number_format($recordInfo['total'],0,'.',',').' records</a></li>';
        }
        
	if($lastpage >=1)
	{   
            //previous button
            if ($page > 1) 
                $pagination.= '<li><a href="'.str_replace('%i',$prev,$url_format).'">&laquo;</a></li>';
            else
                $pagination.= '<li class="disabled"><a>&laquo;</a></li>';

            //pages	
            if ($lastpage < $min_page_adjacents + $adjacents)	//not enough pages to bother breaking it up
            {	
                for ($counter = 1; $counter <= $totalPages; $counter++)
		{
                    if ($counter == $page)
                        $pagination.= '<li class="active"><a class="current">'.$counter.'</a></li>';
                    else
                        $pagination.= '<li><a href="'.str_replace('%i',$counter,$url_format).'">'.$counter.'</a></li>';				
		}
            }
            
            elseif($lastpage > $min_page_adjacents + $adjacents)	//enough pages to hide some
            {
                //close to beginning; only hide later pages
		if($page < 1 + ($adjacents * 2))		
		{
                    for ($counter = 1; $counter < $min_page_adjacents + $adjacents; $counter++)
                    {
                        if ($counter == $page)
                            $pagination.= '<li class="active"><a class="current">'.$counter.'</a></li>';
                        else
                            $pagination.= '<li><a href="'.str_replace('%i',$counter,$url_format).'">'.$counter.'</a></li>';			
                    }
                    $pagination.='<li class="disabled"><a>...</a></li>';
                    for($i=0;$i<$adjacents;$i++){
                        $pagination.= '<li><a href="'.str_replace('%i',($lastpage-$i),$url_format).'">'.($lastpage-$i).'</a></li>';
                    }
                    
                }
                //in middle; hide some front and some back
                elseif($lastpage - $adjacents > $page && $page > $adjacents)
		{
                    for($i=0;$i<$adjacents;$i++){
                        $pagination.= '<li><a href="'.str_replace('%i',($first_page+$i),$url_format).'">'.($first_page+$i).'</a></li>';
                    }
                    $pagination.='<li class="disabled"><a>...</a></li>';
                    for ($counter = $page - $adjacents; $counter <= $page+$adjacents; $counter++)
                    {
                        if ($counter == $page)
                            $pagination.= '<li class="active"><a>'.$counter.'</a></li>';
			else
                            $pagination.= '<li><a href="'.str_replace('%i',$counter,$url_format).'">'.$counter.'</a></li>';
                    }
                    $pagination.='<li class="disabled"><a>...</a></li>';
                    for($i=0;$i<$adjacents;$i++){
                        $pagination.= '<li><a href="'.str_replace('%i',($lastpage-$i),$url_format).'">'.($lastpage-$i).'</a></li>';
                    }
                }
                //close to end; only hide early pages
		else
		{
                    for($i=0;$i<$adjacents;$i++){
                        $pagination.= '<li><a href="'.str_replace('%i',($first_page+$i),$url_format).'">'.($first_page+$i).'</a></li>';
                    }
                    $pagination.='<li class="disabled"><a>...</a></li>';
                    for ($counter = $lastpage - (2 + $adjacents); $counter <= $totalPages; $counter++)
                    {
                        if ($counter == $page)
                            $pagination.= '<li class="active"><a>'.$counter.'</a></li>';
                        else
                            $pagination.= '<li><a href="'.str_replace('%i',$counter,$url_format).'">'.$counter.'</a></li>';				
                    }
		}
            }
            
            //next button
            if ($page < $totalPages) 
                $pagination.= '<li><a href="'.str_replace('%i',$next,$url_format).'">&raquo;</a></li>';
            else
                $pagination.= '<li class="disabled"><a>&raquo;</a></li>';
	}
        $pagination.= '</ul></div>';

        
        return $pagination;
    }
}

if (!function_exists('smart_paging_js')){
    function smart_paging_js($totalPages, $page=1, $jsClick='', $adjacents=2, $offsetTag='$'){  
	$prev = $page - 1;
	$next = $page + 1;
	$lastpage = $totalPages-1;		//lastpage is = total pages / items per page, rounded up.
	$lpm1 = $lastpage - 1;			//last page minus 1
	
	/* 
         * Now we apply our rules and draw the pagination object. 
         * We're actually saving the code to a variable in case we want to draw it more than once.
	*/
	$pagination = '';
	if($lastpage >=1)
	{	
            $pagination .= '<div class="pagination"><ul>';
            //previous button
            if ($page > 1) 
                $pagination.= '<li><a href='.  parseJs($jsClick, $prev, $offsetTag).'>Prev</a></li>';
            else
                $pagination.= '<li class="disabled"><a>Prev</a></li>';
		
            //pages	
            if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
            {	
                for ($counter = 1; $counter <= $totalPages; $counter++)
		{
                    if ($counter == $page)
                        $pagination.= '<li class="active"><a>'.$counter.'</a></li>';
                    else
                        $pagination.= '<li><a href='.  parseJs($jsClick, $counter).'>'.$counter.'</a></li>';				
		}
            }
            
            elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
            {
                //close to beginning; only hide later pages
		if($page < 1 + ($adjacents * 2))		
		{
                    for ($counter = 1; $counter < 5 + ($adjacents * 2); $counter++)
                    {
                        if ($counter == $page)
                            $pagination.= '<li class="active"><a>'.$counter.'</a></li>';
                        else
                            $pagination.= '<li><a href='.  parseJs($jsClick, $counter).'>'.$counter.'</a></li>';			
                    }
                    $pagination.='<li><a>...</a></li>';
                    $pagination.= '<li><a href='.  parseJs($jsClick, $lpm1).'>'.$lpm1.'</a></li>';
                    $pagination.= '<li><a href='.  parseJs($jsClick, $lastpage).'>'.$lastpage.'</a></li>';
                    
                }
                //in middle; hide some front and some back
                elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
		{
                    $pagination.= '<li><a href='.  parseJs($jsClick, 1).'>1</a></li>';
                    $pagination.= '<li><a href='.  parseJs($jsClick, 2).'>2</a></li>';
                    $pagination.='<li><a>...</a></li>';
                    for ($counter = $page - $adjacents; $counter <= $page+1 + $adjacents; $counter++)
                    {
                        if ($counter == $page)
                            $pagination.= '<li class="active"><a>'.$counter.'</a></li>';
			else
                            $pagination.= '<li><a href='.  parseJs($jsClick, $counter).'>'.$counter.'</a></li>';
                    }
                    $pagination.='<li><a>...</a></li>';
                    $pagination.= '<li><a href='.  parseJs($jsClick, $lpm1).'>'.$lpm1.'</a></li>';
                    $pagination.= '<li><a href='.  parseJs($jsClick, $lastpage).'>'.$lastpage.'</a></li>';
                }
                //close to end; only hide early pages
		else
		{
                    $pagination.= '<li><a href='.  parseJs($jsClick, 1).'>1</a></li>';
                    $pagination.= '<li><a href='.  parseJs($jsClick, 2).'>2</a></li>';
                    $pagination.='<li><a>...</a></li>';
                    for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $totalPages; $counter++)
                    {
                        if ($counter == $page)
                            $pagination.= '<li class="active"><a>'.$counter.'</a></li>';
                        else
                            $pagination.= '<li><a href='.parseJs($jsClick, $counter).'>'.$counter.'</a></li>';				
                    }
		}
            }
            
            //next button
            if ($page < $totalPages) 
                $pagination.= '<li><a href='. parseJs($jsClick, $next).'>Next</a></li>';
            else
                $pagination.= '<li class="disabled"><a>Next</a></li>';

            $pagination.= '</ul></div>';
	}
		
	
        
        return $pagination;
    }
    
    function parseJs($js, $var, $tag='$'){
        return str_replace($tag, $var, $js);
    }
}

if (!function_exists('cleanString')){
    function cleanString($subject, $replace='', $search=array('\'','"')){
        return str_replace($search, $replace, $subject);
    }
}

if (!function_exists('format_parent_category')){
    function format_parent_category($data, $parent=0){
        $items = array();
        foreach($data as $item){
            $items['parent'][$item->parent] [] = $item->id;
            $items['items'][$item->id] = $item;
        }
        
        $option_list = iterate_category($items, $parent);
        
        return $option_list;
    }
    
    function iterate_category($data_arr, $parent=0, $level=0){
        $options = array();
        if (isset($data_arr['parent'][$parent])){
            foreach($data_arr['parent'][$parent] as $parent_id){
                if ($parent==0) $level = 0;
                $item = $data_arr['items'][$parent_id];
                $options [] = array('id'=>$item->id, 'category' => str_repeat('-',$level*3).$item->category);
                
                if (isset($data_arr['parent'][$item->id]))
                    $options = array_merge ($options, iterate_category($data_arr, $item->id, $level+1));
            }
        }
        
        return $options;
    }
}
    
if (!function_exists('time_difference')){
    function time_difference($date,$unix_input=FALSE)
    {
        if(empty($date)) {
            return "Please provide date.";
        }

        $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
        $lengths = array("60","60","24","7","4.35","12","10");

        $now = time();
        if ($unix_input){
            $unix_date = $date;
        }else{
            $unix_date = strtotime($date);
        }

        // check validity of date
        if(empty($unix_date)) {
            return "Invalid date";
        }

        //Check to see if it is past date or future date
        if($now > $unix_date) {
            $difference = $now - $unix_date;
            $tense = "ago";

        } else {
            $difference = $unix_date - $now;
            $tense = "from now";
        }

        for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
            $difference /= $lengths[$j];
        }

        $difference = round($difference);

        if($difference != 1) {
            $periods[$j].= "s";
        }

        return "$difference $periods[$j] {$tense}";
    }
}

if (!function_exists('get_bankname_list')){
    function get_bankname_list(){
        return array(
            'bca'   => 'Bank Central Asia (BCA)', 'bni'=>'Bank Nasional Indonesia (BNI)', 'mandiri'=>'Bank Mandiri'
        );
    }
}

if (!function_exists('get_currency_list')){
    function get_currency_list(){
        return array(
            'AUD'   => 'Australian Dollar', 'CAD'=>'Canadian Dollar',
            'CHF'   => 'Switzerland, Francs', 'CNY' => 'China Yuan',
            'DKK'   => 'Denmark, Kroner', 'EUR' => 'European Euro',
            'GBP'   => 'Great Britain Poundsterling', 'HKD' => 'Hongkong Dollar',
            'JPY'   => 'Japan Yen', 'NZD' => 'New Zealand Dollar',
            'SAR'   => 'Saudi Arabia, Riyals', 'SEK' => 'Sweden, Kronor',
            'SGD'   => 'Singapore Dollar', 'USD' => 'US Dollar'
        );
    }
}

if (!function_exists('ip_is_local')){
    function ip_is_local($ip){
        $local = array('::1','127.0.0.1');
        
        return in_array($ip, $local);
    }
}

if (!function_exists('tail_custom')){
    /*
     * tail_custom
     * credit to lorenzos on github https://gist.github.com/lorenzos/1711e81a9162320fde20
     */
    function tail_custom($filepath, $lines = 1, $adaptive = true) {
 
        // Open file
        $f = @fopen($filepath, "rb");
        if ($f === false) return false;

        // Sets buffer size
        if (!$adaptive) $buffer = 4096;
        else $buffer = ($lines < 2 ? 64 : ($lines < 10 ? 512 : 4096));

        // Jump to last character
        fseek($f, -1, SEEK_END);

        // Read it and adjust line number if necessary
        // (Otherwise the result would be wrong if file doesn't end with a blank line)
        if (fread($f, 1) != "\n") $lines -= 1;

        // Start reading
        $output = '';
        $chunk = '';

        // While we would like more
        while (ftell($f) > 0 && $lines >= 0) {

            // Figure out how far back we should jump
            $seek = min(ftell($f), $buffer);

            // Do the jump (backwards, relative to where we are)
            fseek($f, -$seek, SEEK_CUR);

            // Read a chunk and prepend it to our output
            $output = ($chunk = fread($f, $seek)) . $output;

            // Jump back to where we started reading
            fseek($f, -mb_strlen($chunk, '8bit'), SEEK_CUR);

            // Decrease our line counter
            $lines -= substr_count($chunk, "\n");

        }

        // While we have too many lines
        // (Because of buffer size we might have read too many)
        while ($lines++ < 0) {

            // Find first newline and remove all text before that
            $output = substr($output, strpos($output, "\n") + 1);

        }

        // Close file and return
        fclose($f);
        return trim($output);

    }
 
}

if (!function_exists('file_extension')){
    function file_extension($file_url){
        $filename = basename($file_url);
        $arr_elements = explode('.', $filename);
        
        return strtolower(end($arr_elements));
    }
}
/*
 * file location: /application/helpers/cms_helper.php
 */

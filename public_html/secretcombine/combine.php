<?php
	require_once(realpath(dirname(__FILE__).'/../configs/setup.php'));

	$type = $_GET['type'];
	$domain = array_pop(array_filter(explode('/', LOCAL_DIR)));
	
	if ($type == 'css') $def_path = "secretcss";
	else if ($type == 'js') $def_path = "secretjs";
	else exit;
	
	$path='';
    $caching       = false; 
    $cachedir =  LOCAL_DIR.'/cache/combine';

    $cssdir   = '';

    $parts = preg_split('/\//',$_GET['files']);
    $files = $parts[count($parts)-1];
    $files = preg_replace('/\.'.$type.'/i','',$files);
    array_pop($parts);
    
    
    // Construct path
    if (count($parts)>0)
    {
    	if (is_numeric($parts[0])) array_shift($parts);
    	if (count($parts)>0) $path = join('/',$parts);
    }
    if (strlen($path)<1) $path = $def_path;
    
    $workload = array();
    foreach (preg_split('/,/',$files) as $file) $workload[] = '../'.$path.'/'.$file.'.'.$type;
    
    
    // Determine last modification date of the files 
    $lastmodified = 0; 
    foreach ($workload as $file)
    {
        if (!file_exists($file)) { 
            header ("HTTP/1.0 404 Not Found"); 
            exit; 
        } 
         
        $lastmodified = max($lastmodified, filemtime($file));
    } 
     
    // Send Etag hash 
    $hash = $lastmodified . '-' . md5($_GET['files']); 
    header ("Etag: \"" . $hash . "\""); 

    
    $offset = 15552000; //seconds
    header ("Expires: " . gmdate("D, d M Y H:i:s", time() + $offset) . " GMT");
    header ("Cache-Control:	max-age=$offset");

     
    if (isset($_SERVER['HTTP_IF_NONE_MATCH']) &&  
    stripslashes($_SERVER['HTTP_IF_NONE_MATCH']) == '"' . $hash . '"')  
    { 
        // Return visit and no modifications, so do not send anything 
        header ("HTTP/1.0 304 Not Modified"); 
        header ('Content-Length: 0');
    }  
    else  
    { 
        // First time visit or files were modified 
            // Determine supported compression method
            $gzip = strstr($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip');
            $deflate = strstr($_SERVER['HTTP_ACCEPT_ENCODING'], 'deflate');
    
            // Determine used compression method
            $encoding = $gzip ? 'gzip' : ($deflate ? 'deflate' : 'none');
    
            // Check for buggy versions of Internet Explorer
            if (!strstr($_SERVER['HTTP_USER_AGENT'], 'Opera') && 
                preg_match('/^Mozilla\/4\.0 \(compatible; MSIE ([0-9]\.[0-9])/i', $_SERVER['HTTP_USER_AGENT'], $matches))
                {
                	$version = floatval($matches[1]);
                	
                	if ($version < 6) $encoding = 'none';
                	if ($version == 6 && !strstr($_SERVER['HTTP_USER_AGENT'], 'EV1')) $encoding = 'none';
            	}
        
           if ($caching)    
           {
	            // Try the cache first to see if the combined files were already generated 
	            $cachefile = 'cache-' . $hash . '.' . $type . ($encoding != 'none' ? '.' . $encoding : '');
	            
	            if (file_exists($cachedir . '/' . $cachefile))
	            {
	                if ($fp = fopen($cachedir . '/' . $cachefile, 'rb')) { 
	                    if ($encoding != 'none') {
	                        header ("Content-Encoding: " . $encoding);
	                    }
	                 
	                    header ("Content-Type: text/" . $type);
	                    header ("Content-Length: " . filesize($cachedir . '/' . $cachefile));
	         
	                    fpassthru($fp); 
	                    fclose($fp); 
	                    exit; 
	                }
	            }
        	}
     
        // No previous cache found
        // Get contents of the files
        $contents = ''; 
        
        foreach ($workload as $file)
        {
            $conts=file_get_contents($file); 
            $conts = str_ireplace('$domain',$domain,$conts);
            $contents .= "\n\n" . $conts;
        }

        
        if ($type=='js')
        {
        	//require 'jsmin.php';
			//$contents = JSMin::minify($contents);
        }
        else $contents = compress_css($contents);
       
        		
        // Send Content-Type 
        header ("Content-Type: text/" . $type); 

        if (isset($encoding) && $encoding != 'none') 
        { 
            // Send compressed contents 
            $contents = gzencode($contents, 9, $gzip ? FORCE_GZIP : FORCE_DEFLATE); 
            header ("Content-Encoding: " . $encoding); 
            header ('Content-Length: ' . strlen($contents)); 
            echo $contents; 
        }  
        else  
        { 
            // Send regular contents 
           header ('Content-Length: ' . strlen($contents)); 
           echo $contents; 
        }

        // Store cache 
        if ($caching)
        { 
            if ($fp = fopen($cachedir . '/' . $cachefile, 'wb'))
            { 
                fwrite($fp, $contents); 
                fclose($fp); 
            } 
        } 
    }


function compress_css($buffer)
{
	return $buffer;
	// remove comments
	$buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
	// remove tabs, spaces, newlines, etc.
	$buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer);
	return $buffer;
}
?>
<?php

/*

	# Copyright (C) 2017 Eduardo Nacimiento García <enacimie@ull.edu.es>
	This file is part of TinyULL.

    TinyULL is free software: you can redistribute it and/or modify
    it under the terms of the GNU Affero General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    TinyULL is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Foobar.  If not, see <http://www.gnu.org/licenses/>.
	
*/


    $request = $_SERVER['REQUEST_URI'];
    $params = split("/", $request);


    require_once('./lib/connect.php');
    require_once('./lib/functions.php');
    
    require_once('./html/before.html');
  
 
    
    if ($params[1] != "")  {
        if ($params[1] == "list" && $params[2] == "all") {
            getAllItems($mysqli);    
        }
        else {
            $result = getOneItem($mysqli, $params[1]);
            if ($result['longurl'] != '') {
                header("Location: ".$result['longurl'], true, 301);
                exit();
            }
            else {
                header("Location: ./", true, 301);
                exit();
            }
        }
    }
    elseif (isset($_POST['submit'])) {
        $allowed_urls = "/^(http:\/\/|https:\/\/|\w*[^:]\w)[^&\?\/]+\.ull\.es(\/\S*$|\?\S*$|$)/";
        if (preg_match($allowed_urls, $_POST['longurl'])) {
            addNewItem($mysqli);
        } else {
            header("Location: ./", true, 301);
            exit();
        }
    }
    else {
       addNewItemForm($mysqli);
    }

    require_once('./html/after.html');

?>
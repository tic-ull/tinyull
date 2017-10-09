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


    $database = [
        "host" => "127.0.0.1",
        "db" => "tinyull",
        "user" => "mencey",
        "pass" => "",
        ];
        

    $mysqli = new mysqli($database['host'], $database['user'], $database['pass'], $database['db']);
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }






?>
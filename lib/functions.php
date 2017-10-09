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


require_once('./lib/connect.php');


function getAllItems($mysqli) {
    $sql = "SELECT * FROM tinyulls LIMIT 10";
    $result = $mysqli->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "id: " . $row["id"]. " - Short: " . $row["shorturl"]. " " . $row["longurl"]. "<br>";
        }
    }
    $result->free();
    $mysqli->close();
}


function getOneItem($mysqli, $shorturl) {

    $sql = "SELECT * FROM tinyulls WHERE shorturl LIKE '$shorturl'";
    $result = $mysqli->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo "id: " . $row["id"]. " - Short: " . $row["shorturl"]. " " . $row["longurl"]. "<br>";
        $result->free();
    }
    $mysqli->close();
    return $row;
}


function addNewItem ($mysqli) {
    $created_at = date("Y-m-d H:i:s");
    $updated_at = $created_at;
    $longurl = $_POST['longurl'];
    $query = "SELECT * FROM tinyulls WHERE longurl LIKE '$longurl'";
    $result = $mysqli->query($query);
    if ($result->num_rows > 0) {
        echo 'Ya existe';
    }
    else {
        $query = "SELECT shorturl FROM tinyulls ORDER BY id DESC LIMIT 1";
        $result = $mysqli->query($query);
         if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $shorturl = $row['shorturl'];
            ++$shorturl;
            $query = "INSERT INTO tinyulls (shorturl, longurl, created_at, updated_at) VALUES ('$shorturl', '$longurl', '$created_at', '$updated_at')";
            echo $query;
            $mysqli->query($query);
         }
    }
    $mysqli->close();

}

function addNewItemForm ($mysqli) {
    echo '
    <div id="formulario">
        <form method="post">
            <p>  
                <input id="tinyull_longurl" name="longurl" size="30" type="text" pattern="^(http:\/\/|https:\/\/|\w*[^:]\w)[^&\?\/]+\.ull\.es(\/\S*$|\?\S*$|$)">
            </p>
            <p>
                <input id="tinyull_submit" name="submit" value="Crear enlace corto" type="submit">
            </p>
        </form>
        <h2>S&oacute;lo URLs de la Universidad de La Laguna</h2>
    </div>
    ';
    
}




?>
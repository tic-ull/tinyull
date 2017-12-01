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


// Select all items from the database
function getAllItems($mysqli) {
    $sql = "SELECT * FROM tinyulls";
    $result = $mysqli->query($sql);
    if ($result->num_rows > 0) {
        echo '<div id="listado" >';
        while($row = $result->fetch_assoc()) {
        //    echo "id: " . $row["id"]. " - Short: " . $row["shorturl"]. " " . $row["longurl"]. "<br>";
            echo $row["shorturl"].' -- <a href="'.$row["longurl"].'">' . $row["longurl"] . '</a><br>';
        }
        echo '</div>';
    }
    $result->free();
    $mysqli->close();
}

// Select an item from the database with a specific shorturl
function getOneItem($mysqli, $shorturl) {

    $sql = "SELECT * FROM tinyulls WHERE shorturl LIKE '$shorturl'";
    $result = $mysqli->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $result->free();
    }
    $mysqli->close();
    return $row;
}

// Add new item to the database
function addNewItem ($mysqli, $longurl = NULL, $multiple = false) {
    
    $reservedwords = [
        "list",
        "all",
        "add",
        "phpmyadmin",
        ];
    
    
    $created_at = date("Y-m-d H:i:s");
    $updated_at = $created_at;
    if ($longurl == NULL) {
        $longurl = $_POST['longurl'];
    }
    $query = "SELECT * FROM tinyulls WHERE longurl LIKE '$longurl'";
    $result = $mysqli->query($query);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (!$multiple) {
            showOneItem($row['shorturl'], $row['longurl']);
        }
        $shorturl = $row['shorturl'];
    }
    else {
        $query = "SELECT shorturl FROM tinyulls ORDER BY id DESC LIMIT 1";
        $result = $mysqli->query($query);
         if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $shorturl = $row['shorturl'];
            ++$shorturl;
            if (in_array($shorturl, $reservedwords)) {
                ++$shorturl;
            }
            $query = "INSERT INTO tinyulls (shorturl, longurl, created_at, updated_at) VALUES ('$shorturl', '$longurl', '$created_at', '$updated_at')";
            if (!$multiple) {
                showOneItem($shorturl, $longurl);
            }
            $mysqli->query($query);
         }
    }
    //$mysqli->close();
    if ($multiple) {
        return $shorturl;
    }
}


// Form to add new item to the database
function addNewItemForm ($mysqli) {
    echo '
    <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#normal">Modo normal</a></li>
    <li><a data-toggle="tab" href="#masive">Modo masivo</a></li>
    </ul>
    <div class="tab-content">
    <div id="normal" class="tab-pane fade in active">
        <div id="class="form-horizontal"">
            <form method="post">
                 <div class="input-group">
                    <input class="form-control" placeholder="Crear nueva URL" id="tinyull_longurl" name="longurl" size="30" type="text" pattern="^(http:\/\/|https:\/\/|\w*[^:]\w)[^&\?\/]+\.ull\.es(\/\S*$|\?\S*$|$)">
                    <div class="input-group-btn">
                       <button id="tinyull_submit" name="submit"   class="btn btn-primary" type="submit"><i class="glyphicon glyphicon-save"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div id="masive" class="tab-pane fade">
         <div id="class="form-horizontal"">
            <form method="post">
                 <div class="">
                    <textarea class="form-control" rows="5" id="tinyull_masiveurl" name="masiveurl" placeholder="Introducir texto con varias URLs incrustadas" ></textarea>
                </div>
                 <button id="tinyull_masivesubmit" name="masivesubmit" type="submit" class="btn btn-primary btn-block"><i class="glyphicon glyphicon-cloud-download"></i> Generar enlaces masivos</button> 
            </form>
        </div>
    </div>
    <br> 
    <p class="alert alert-danger"><strong>¡Atención!</strong> Sólo URLs de la Universidad de La Laguna</p>
    </div> 
    ';
    

}


function showOneItem($shorturl, $longurl) {
    $base = "http://t.ull.es/"; 
    echo ' <div id="formulario">
        <p>
        <b>URL original:</b>
        <a href="'.$longurl.'">'.$longurl.'</a>
        </p>
        <p>
        <b>URL corta:</b>
        <input type="text"  value="'.$base.$shorturl.'"/>
        </p>
        <p><a href="'.$base.'">Crear otra URL</a></p>
        </div>';
}


function addMultipleItems ($mysqli, $text)  {

    
    $allowed_urls = "/(http:\/\/|https:\/\/|\w*[^:]\w)[^&\?\/]+\.ull\.es(\/\S*|\?\S*|)/";
    
    preg_match_all($allowed_urls, $text, $matches);

    foreach ($matches[0] as $m) {
         if (preg_match($allowed_urls, $m)) {
             $array_matches['#'.$m.'#'] = 'http://' . addNewItem($mysqli, $m, true);
         }
    }
    $longs = array_keys($array_matches);
    $shorts = array_values($array_matches);
    $text = preg_replace($longs, $shorts, $text);
    
    echo '<textarea class="form-control" rows="5" id="tinyull_masiveurl" name="masiveurl" placeholder="Introducir texto con varias URLs incrustadas" >';
    echo $text;
    echo '</textarea>';
}

?>
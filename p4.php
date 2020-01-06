<?php
printHeader();
ini_set("allow_url_fopen", 1);

$sourcedata = $fielddata = "";

if ($_GET["sourcedata"] != "") {
    $url = 'https://www.cs.uky.edu/~paul/public/P4_Sources.json';
    $string = file_get_contents($url);
    $result = json_decode($string, true);

    # switch case retrieved from online resource given by Prof. Linton
    switch (json_last_error()) {
            case JSON_ERROR_NONE:
                //printForm($result);
            break;
            case JSON_ERROR_DEPTH:
                echo ' - Maximum stack depth exceeded';
            break;
            case JSON_ERROR_STATE_MISMATCH:
                echo ' - Underflow or the modes mismatch';
            break;
            case JSON_ERROR_CTRL_CHAR:
                echo ' - Unexpected control character found';
            break;
            case JSON_ERROR_SYNTAX:
                echo ' - Syntax error, malformed JSON';
            break;
            case JSON_ERROR_UTF8:
                echo ' - Malformed UTF-8 characters, possibly incorrectly encoded';
            break;
            default:
                echo ' - Unknown error';
            break;
    }

    $sourcedata = test_input($_GET["sourcedata"]);
    $fielddata = test_input($_GET["fielddata"]);

    $url2 = "";
    $field1 = "";
    $field2 = "";

    foreach ($result["sources"] as $key => $value) {
        if ($value["name"] == $sourcedata) {
            $url2 = $value["url"];
            $field1 = $value["groupfields"][0];
            $field2 = $value["groupfields"][1];
        }
    }

    $string2 = file_get_contents($url2);
    $result2 = json_decode($string2, true);

    # switch case retrieved from online resource given by Prof. Linton
    switch (json_last_error()) {
            case JSON_ERROR_NONE:
                //printForm($result);
            break;
            case JSON_ERROR_DEPTH:
                echo ' - Maximum stack depth exceeded';
            break;
            case JSON_ERROR_STATE_MISMATCH:
                echo ' - Underflow or the modes mismatch';
            break;
            case JSON_ERROR_CTRL_CHAR:
                echo ' - Unexpected control character found';
            break;
            case JSON_ERROR_SYNTAX:
                echo ' - Syntax error, malformed JSON';
            break;
            case JSON_ERROR_UTF8:
                echo ' - Malformed UTF-8 characters, possibly incorrectly encoded';
            break;
            default:
                echo ' - Unknown error';
            break;
    }

    foreach ($result2[$field1] as $comment) {
        echo "<p><h3>$comment</h3></p>";
    }

    foreach ($result2[$field2] as $key => $value) {
        echo "<p>";
        foreach ($value as $key2 => $value2) {
            echo "$key2: $value2 <br>";
        }
        echo "</p>";
    }



}
else {
    $url = 'https://www.cs.uky.edu/~paul/public/P4_Sources.json';
    $string = file_get_contents($url);
    $result = json_decode($string, true);

    # switch case retrieved from online resource given by Prof. Linton
    switch (json_last_error()) {
            case JSON_ERROR_NONE:
                printForm($result);
            break;
            case JSON_ERROR_DEPTH:
                echo ' - Maximum stack depth exceeded';
            break;
            case JSON_ERROR_STATE_MISMATCH:
                echo ' - Underflow or the modes mismatch';
            break;
            case JSON_ERROR_CTRL_CHAR:
                echo ' - Unexpected control character found';
            break;
            case JSON_ERROR_SYNTAX:
                echo ' - Syntax error, malformed JSON';
            break;
            case JSON_ERROR_UTF8:
                echo ' - Malformed UTF-8 characters, possibly incorrectly encoded';
            break;
            default:
                echo ' - Unknown error';
            break;
    }
}

printFooter();

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function printHeader() {
    echo "
    <html>
    <head>
    <title>Project 4 - Menchen</title>
    </head>
    <body>
    <h1>Project 4 - Jordan Menchen</h1>
    ";
}

function printFooter() {
    echo "
    </body>
    </html>
    ";
}

function printForm($result) {
    ?>
    <form method='get' action='p4.php'>
    	<select name='sourcedata'>
            <option value="none" selected disabled hidden>Select a Name</option>
            <?php
            if (isset($result)) {
                foreach ($result["sources"] as $key => $value) {
                    echo '"<option value="'.$value["name"].'">'.$value["name"].'</option>';
                }
            }
            else {
                echo "\$result is not set";
            }
            ?>
        </select><br><br>
    	<select name='fielddata'>
            <option value="none" selected disabled hidden>Select a Field</option>
            <?php
            if (isset($result)) {
                foreach ($result["sources"] as $key => $value) {
                    foreach ($value["searchfields"] as $field) {
                        echo '"<option value="'.$field.'">'.$field.'</option>';
                    }
                }
            }
            else {
                echo "\$result is not set";
            }
            ?>
        </select><br><br>
    	<select name='findorsort'>
            <option value="none" selected disabled hidden>Find or Sort</option>
            <option value="find">Find</option>
            <option value="sort">Sort</option>
        </select><br><br>
        <input type='TEXT' name='whattofind'><br><br>
        <input type="submit" name="submit" value="submit">
    </form>
    <?php
}

?>

<?php
function is_str_len_in_range(string $str,int $a,int $b)
{
    $n = strlen($str);
    return ($n >= $a) && ($n <= $b);
}
function test_regex($str, $regex) {
    return preg_match($regex, $str) == 1;
}
function contains_all($str, $sym_list) {
    $contains_all = true;
    foreach($sym_list as $c) {
        $contains_all = $contains_all && str_contains($str, $c);
    }
    return $contains_all;
}
// Partially called function.
// N - number of arguments of function $f
// Returns function $f with last parameters binded to values of $last_args array
// Used for creating validation functions
function bind_partial_last($f, ...$last_args) {
    return function (...$remaining) use ($f, $last_args) {
        return call_user_func_array($f, array_merge($remaining, $last_args));
    };
}

// Function that goes through list of validations
// Carries them out
// And creates error array if any exist
function validate_list($validation_list, $post_values) {
    $has_err = False;
    $errors = array();
    foreach ($validation_list as $key => $val_arr) {
        $errors[$key] = [];
        foreach ($val_arr as $validation) {
            if (!$validation["validate"]($post_values[$key])) {
                $has_err = True;
                array_push($errors[$key], $validation["error_message"]);
            }
        }
    }
    return array("errors" => $errors, "has_error" => $has_err);
}

// File validation functions
function file_size_constraint($file, $max_size_bytes) {
    return $file["size"] < $max_size_bytes;
}

function file_not_exists($file) {
    // return !file_exists(Config::ROOT_FOLDER."\\tmp\\.".$_SESSION["user_data"]["username"]."\\".$file["name"]);
    return !file_exists(CONFIG::ROOT_FOLDER . "\\tmp\\" . $_SESSION["user_data"]["username"] . "\\" .
        str_replace("/", "\\", (isset($_REQUEST["path"]) ? $_REQUEST["path"] : "")) . "\\" .
        (strlen($_POST["filename"]) > 0 ? $_POST["filename"] : $_FILES["fileToUpload"]["tmp_name"]));
}

function file_not_exists_dir($filename) {
    // return !file_exists(Config::ROOT_FOLDER."\\tmp\\.".$_SESSION["user_data"]["username"]."\\".$file["name"]);
    return !file_exists(CONFIG::ROOT_FOLDER . "\\tmp\\" . $_SESSION["user_data"]["username"] . "\\" .
        str_replace("/", "\\", (isset($_REQUEST["path"]) ? $_REQUEST["path"] : "")) . "\\" .
        $filename);
}

    // User validation functions
function check_username_free($username) {
    return count(UserModel::select(array("username" => $username))) == 0;
}
function check_email_free($email) {
    return count(UserModel::select(array("email" => $email))) == 0;
}
function passwords_match($password, $password_repeat) {
    return $password == $password_repeat;
}

?>
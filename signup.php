<?php

#checking if the username, pass and name are submitted

if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['name'])) {

    #DATABASE connection file
    include '../db.conn.php';


    #getting data from POST req and storing them in a var

    $name = $_POST['name'];
    $password = $_POST['password'];
    $username = $_POST['username'];

    # makiiing URL data format

    $data = 'name=' . $name . '&username=' . $username;

    #form validation

    if (empty($name)) {
        #error message
        $em = "Name is required";

        #redirecting to signup.php and passing the error message
        header("Location: ../../signup.php?error=$em");
        exit;
    } else if (empty($username)) {
        $em = "Username is required";

        header("Location: ../../signup.php?error=$em&$data");
        exit;
    } else if (empty($password)) {

        $em = "Password is required";

        header("Location: ../../signup.php?error=$em&$data");
        exit;
    } else {
        #checking the database if the username is taken 
        $sql = "SELECT username FROM users WHERE username=?";
        $stmt =  $conn->prepare($sql);
        $stmt->execute([$username]);

        if ($stmt->rowCount() > 0) {
            $em = "The username ($username) is already taken";
            header("Location: ../../signup.php?error=$em&$data");
            exit;
        } else {
            #profile pic uploading
            if (isset($_FILES['pp'])) {
                $img_name = $_FILES['pp']['name'];
                $tmp_name = $_FILES['pp']['tmp_name'];
                $error = $_FILES['pp']['error'];

                #if theres no error while uploading
                if ($error === 0) {
                    #get image extension, store it in a variable
                    $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);

                    #convert the image extension in lowercase and store it in a var
                    $img_ex_lc = strtolower($img_ex);

                    #create array that stores allowed to upload image extensions
                    $allowed_exs = array("jpg", "jpeg", "png");

                    #check if the image extension is in the array
                    if (in_array($img_ex_lc, $allowed_exs)) {
                        #renaming the image with  user's username
                        $new_img_name = $username . '.' . $img_ex_lc;

                        #crating upload path on root directory
                        $img_upload_path = '../../uploads/' . $new_img_name;
                        #move uploaded image to ./upload folder
                        move_uploaded_file($tmp_name, $img_upload_path);
                    } else {
                        $em = "You can not upload files of this type!";
                        header("Location: ../../signup.php?error=$em&$data");
                        exit;
                    }
                }
            }

            //pass hashing 
            $password = password_hash($password, PASSWORD_DEFAULT);

            #if the user upload profile picture
            if (isset($new_img_name)) {
                #insering data into database
                $sql = "INSERT INTO users (name, username, password, p_p)
                 VALUES (?,?,?,?)";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$name, $username, $password, $new_img_name]);
            } else {
                #insering data into database
                $sql = "INSERT INTO users (name, username, password)
                        VALUES (?,?,?)";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$name, $username, $password]);
            }

            #success message
            $sm = "Account created successfully";
            
            #redirect to index.php and pass the success message
            header("Location: ../../index.php?success=$sm");
            exit;
        }
    }
} else {
    header("Location: ../../signup.php");
    exit;
}
 
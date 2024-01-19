<?php
session_start();

#check if pass and username are submitted

if (isset($_POST['username']) && isset($_POST['password'])) {

    #DATABASE connection file
    include '../db.conn.php';


    #getting data from POST req and storing them in a var
    $password = $_POST['password'];
    $username = $_POST['username'];

    #form validation
    if (empty($username)) {
        $em = "Username is required";

        header("Location: ../../index.php?error=$em");
    } else if (empty($password)) {
        $em = "Password is required";

        header("Location: ../../index.php?error=$em");
    } else {
        $sql = "SELECT * FROM users WHERE username=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$username]);

        #if the username exist
        if ($stmt->rowCount() === 1) {
            #fetching user data
            $user = $stmt->fetch();

            #if both usernames are strictly equal
            if ($user['username'] === $username) {
                #verifying hte encripted password
                if (password_verify($password, $user['password'])) {
                    #successfully logged in
                    #creating the SESSION
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['name'] = $user['name'];
                    $_SESSION['user_id'] = $user['user_id'];

                    #redirect to hoome.php
                    header("Location: ../../home.php");

                } else {
                    $em = "Incorrect username or password";

                    header("Location: ../../index.php?error=$em");
                }
            } else {
                $em = "Incorrect username or password";

                header("Location: ../../index.php?error=$em");
            }
        }
    }
} else {
    header("Location: ../../index.php");
    exit;
}

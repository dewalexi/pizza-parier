<?php

require "./helpers/db.php";

$email = $title = $ingredients = htmlspecialchars("");

$errors = array("email" => "", "title" => "", "ingredients" => "");

if (isset($_POST["submit"]) && !empty($_POST["submit"])) {
    $email = htmlspecialchars($_POST["email"]);
    $title =  htmlspecialchars($_POST["title"]);
    $ingredients = htmlspecialchars($_POST["ingredients"]);

    if (empty($email)) {
        $errors["email"] = "[i] Email input cannot be empty";
    } else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors["email"] = "[i] Email input is invalid";
        }
    }

    if (empty($title)) {
        $errors["title"] = "[i] Title input cannot be empty";
    } else {
        if (!preg_match("/^[a-zA-Z\s]+$/", $title)) {
            $errors["title"] = "[i] Title can only contain letters & spaces";
        }
    }

    if (empty($ingredients)) {
        $errors["ingredients"] = "[i] Ingredients cannot be empty";
    } else {
        if (!preg_match("/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/", $ingredients)) {
            $errors["ingredients"] = "[i] Ingredients must be a comma separated list";
        }
    }

    if (array_filter($errors)) {
        #echo 'Form is invalid';
    } else {

        $mres_email = mysqli_real_escape_string($conn, $email);
        $mres_title = mysqli_real_escape_string($conn, $title);
        $mres_ingredients = mysqli_real_escape_string($conn, $ingredients);

        $sql_command = "INSERT INTO pizzas(title, email, ingredients) VALUES('$mres_title', '$mres_email', '$mres_ingredients')";

        if (mysqli_query($conn, $sql_command)) {
            header("Location: index.php");
        } else {
            echo "Query error: " . mysqli_error($conn);
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<?php require "templates/header.php"; ?>
<section class="add-pizza">
    <form autocomplete="off" method="POST" action="add.php">
        <div class="labels">
            <label for="email">Email</label>
            <input type="text" name="email" id="email" value="<?php echo $email ?>">
            <p><?php echo $errors["email"] ?></p>
        </div>

        <div class="labels">
            <label for="title">Pizza title</label>
            <input type="text" name="title" id="title" value="<?php echo $title ?>">
            <p><?php echo $errors["title"] ?></p>
        </div>

        <div class="labels">
            <label for="ingredients">Ingredients (comma separated)</label>
            <input type="text" name="ingredients" id="ingredients" value="<?php echo $ingredients ?>">
            <p><?php echo $errors["ingredients"] ?></p>
        </div>

        <div class="submit"><input type="submit" name="submit" value="Submit"></div>
    </form>
</section>
<?php require "templates/footer.php"; ?>

</html>
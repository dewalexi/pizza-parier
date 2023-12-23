<?php

require "./helpers/db.php";

if (isset($_POST["delete"])) {
    $delete_id = mysqli_real_escape_string($conn, $_POST["delete_id"]);

    // Curating a SQL command
    $delete_command = "DELETE FROM pizzas WHERE id = $delete_id";

    // Fetching the result
    $delete_result = mysqli_query($conn, $delete_command);

    if (mysqli_query($conn, $delete_command)) {
        header("Location: index.php");
    } else {
        echo "Query error: " . mysqli_error($conn);
    }
}

if (isset($_GET["id"])) {
    $id = mysqli_real_escape_string($conn, $_GET["id"]);

    // Curating a SQL command
    $sql_command = "SELECT * FROM pizzas WHERE id = $id";

    // Fetching the result
    $result = mysqli_query($conn, $sql_command);

    // Returning result as an associative array
    $pizzas = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // Freeing result from memory
    mysqli_free_result($result);

    // Closing connection
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">

<?php require "templates/header.php"; ?>

<section class="details">
    <?php if (!empty($pizzas[0])) :  ?>
        <div class="pizza-details">
            <h2><?php echo $pizzas[0]["title"] ?></h2>
            <p><?php echo "Created at : " . $pizzas[0]["created_at"] ?></p>
            <p><?php echo "Created by : " . $pizzas[0]["email"] ?></p>

            <h3>Ingredients:</h3>
            <p><?php echo $pizzas[0]["ingredients"] ?></p>

        </div>

        <form method="POST" action="details.php">
            <input type="hidden" name="delete_id" value="<?php echo $id ?>">
            <input id="delete" type="submit" name="delete" value="Delete">
        </form>
    <?php else : ?>
        <?php echo "<h2>No such pizzas exists!</h2>"; ?>
    <?php endif ?>
</section>

<?php require "templates/footer.php"; ?>

</html>
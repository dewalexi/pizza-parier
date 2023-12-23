<?php

require "./helpers/db.php";

// Curating a SQL command
$sql_command = "SELECT title, email, ingredients, id FROM pizzas";

// Fetching the result
$result = mysqli_query($conn, $sql_command);

// Returning result as an associative array
$pizzas = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Freeing result from memory
mysqli_free_result($result);

// Closing connection
mysqli_close($conn);

# echo $pizzas[0]["email"]
?>

<!DOCTYPE html>
<html lang="en">

<?php require "templates/header.php"; ?>

<section class="home">

    <?php foreach ($pizzas as $pizza) : ?>
        <div class="home-pizza-wrapper">
            <img src="./images/pizza.svg" alt="">
            <h2> <?php echo $pizza["title"] ?> </h2>

            <ul>
                <?php
                $ingredients = explode(",", $pizza["ingredients"]);
                foreach ($ingredients as $ingredient) {
                    echo "<li class='ingredients'> $ingredient </li>";
                }
                ?>
            </ul>

            <div>
                <button>
                    <a href="details.php?id=<?php echo $pizza["id"] ?>">More Info</a>
                </button>
            </div>
        </div>
    <?php endforeach ?>

</section>

<?php require "templates/footer.php"; ?>

</html>
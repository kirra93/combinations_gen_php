<html>
    <head>
        <link rel="stylesheet" href="styles/main.css">
    </head>
    <body>
    <header>
        <h1>Test task Cells-Coins solver</h1>
    </header>
    <div class="message"><?php if ($msg) echo $msg ?></div>
    <div class="container">
        <form action="/solve" method="post" class="cells-form">
            Count of cells:<br>
            <input type="number" name="cells"><br>
            Count of coins:<br>
            <input type="number" name="coins">
            <br>
            <input type="submit" name="submit">
        </form>
    </div>
    <footer>

    </footer>
    </body>
</html>

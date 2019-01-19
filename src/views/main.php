<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= getenv('service') ?></title>
</head>
<body>
    <section>
        <h2>Add Query</h2>
        <form action="/addQuery" method="post">
            <input type="text" name="query" placeholder="enter your job query" required>
            <input type="submit" value="run query">
        </form>
    </section>

    <section>
        <h2>Manage Stored Queries</h2>
    </section>
</body>
</html>
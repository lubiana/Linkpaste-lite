<!DOCTYPE html>
<html lang="en">
<head>
  <title> <?= $title ?> </title>
  <meta http-equiv="content-type" content="text/html;charset=utf-8" />
  <meta name="generator" content="Linkpaste" />
  <link href="style.css" rel="stylesheet" type="text/css">
</head>

<body>
  <form action="post.php" method="GET">
    <ul id="form">
      <li>
        <label>
          <span>Url: </span>
          <input type="text" name="link">
        </label>
      </li>
      <li>
        <label>
          <span>Beschreibung: </span>
          <input type="text" name="beschreibung">
        </label>
      </li>
      <li>
        <input type="submit" name="sub" value="OK">
      </li>
    </ul>
  </form>
  <ul id="wrapper">
    <?= $links ?>
  </ul>
</body>

</html> 


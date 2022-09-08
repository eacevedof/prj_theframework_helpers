<?php
/**
 * @var App\Shared\Infrastructure\Views\AppView $this
 * @var string $pagetitle
 */
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="/wp-content/uploads/2020/01/el-chalan-logo.png"/>
  <link rel="stylesheet" id="rs-plugin-settings-css" href="/errors/error.css" type="text/css" media="all" />
  <title><?=$pagetitle ?? ""?></title>
</head>
<body>
<!-- error.tpl -->
<main>
<?php
$this->_template();
?>
</main>
</body>
</html>
```php
include_once "../helpers/autoload_nc.php";

use TheFramework\Helpers\Form\Input\Checkbox;

//https://www.w3schools.com/tags/att_input_checked.asp
$o = new Checkbox();
$o->set_name("chkSome");
$o->set_unlabeled(0); //incluye el texto visible dentro de una etiqueta
$o->set_options(["valbike"=>"Bike","valcar"=>"Car"]);
$o->show();
```

```php
use TheFramework\Helpers\Form\Input\Date;

$o = new Date("someId");
$o->set_value("06-12-2018");//ok
$o->set_value("2018-12-06");//ok
$o->set_value("20181206");//bad!
$o->set_value("06122018");//bad!
$o->set_value("06/12/2018");//ok
$o->show();
```

```php
use TheFramework\Helpers\Form\Input\File;

$oL = new TheFramework\Helpers\Form\Label;
$oL->set_for("someId");
$oL->set_innerhtml("This is an Input File:");
$o = new File("someId","someName",NULL,$oL);
$o->set_accept("image/png, image/jpeg");
$o->add_extras("multiple","multiple");
$o->show();
```

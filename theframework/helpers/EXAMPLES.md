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

```php
use TheFramework\Helpers\Form\Input\Hidden;

$oL = new TheFramework\Helpers\Form\Label;
$oL->set_for("someId");
$oL->set_innerhtml("Field hidden is here:");
$oL->show();
$o = new Hidden("someId","someName","her-comes-a-token-to-be-hidden-afdoopjy8679834ñoñ$$34878=?dsjk");
$o->show();
$o = new Hidden();
$o->set_id("someId2");
$o->set_name("someName2");
$o->set_value("this-is-a-date: 2018-12-08 09:02:00");
$o->show();
```


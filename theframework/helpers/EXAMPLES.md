```php
use TheFramework\Helpers\Form\Input\Checkbox;
//https://www.w3schools.com/tags/att_input_checked.asp
$o = new Checkbox();
$o->set_name("chkSome");
$o->set_options(["valbike"=>"Bike","valcar"=>"Car"]);
$o->show();
```
<!-- elem-band-env -->
<?php
if (ENV::is_prod()) return;
?>
<div style="background-color:<?=ENV::color()?>; color:white; position: sticky; height: 7px; width: 100%; border: 1px solid black;"></div>
<!-- /elem-band-env -->
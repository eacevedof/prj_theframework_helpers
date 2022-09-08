<?php
/**
 * @var App\Shared\Infrastructure\Views\AppView $this
 */
use App\Shared\Infrastructure\Helpers\RoutesHelper as Routes;
use App\Shared\Domain\Enums\RequestActionType;

$urlpost = Routes::url("home.contactsend");
?>
<div class="wpb_text_column wpb_content_element">
  <div class="wpb_wrapper">
    <div role="form" class="wpcf7" lang="en-US" dir="ltr">
      <div class="screen-reader-response">
        <p role="status" aria-live="polite" aria-atomic="true"></p>
      </div>
      <form action="<?php $this->_echo($urlpost); ?>" method="post" class="wpcf7-form init">
        <input type="hidden" id="csrf" name="_csrf" value="<?php $this->_echo($csrf)?>" />
        <input type="hidden" id="action" name="_action" value="" />
        <div class="rica-contact-form">
          <?php
          if ($error):
          ?>
          <p style="color: red; font-size: 1.5rem;">
            <?=$error?>
            <ul style="list-style-type: none">
              <?php
              foreach ($fields as $field) {
              echo "<li style=\"color: red\">{$field["message"]}</li>";
              }
              ?>
            </ul>
          </p>
          <?php
          endif;
          if ($success):
          ?>
          <p style="color: green; font-size: 1.5rem;">
            <?=$success?>
          </p>
          <?php
          endif;
          ?>
          <span class="wpcf7-form-control-wrap name">
            <input type="text" id="name" name="name" size="40" class="wpcf7-form-control wpcf7-text rc-cf-name"
              autofocus aria-invalid="false" placeholder="Nombre" required value="<?=$error ? $post["name"] ?? "" : "" ?>"
            />
          </span><br/>
          <span class="wpcf7-form-control-wrap email">
            <input type="email" id="email" name="email" size="40"
              class="wpcf7-form-control wpcf7-text wpcf7-email wpcf7-validates-as-required wpcf7-validates-as-email rc-cf-mail"
              aria-required="true" aria-invalid="false" placeholder="Email" required value="<?=$error ? $post["email"] ?? "" : "" ?>"
            />
          </span><br/>
          <span class="wpcf7-form-control-wrap message">
            <textarea id="message" name="message" cols="40" rows="10"
              class="wpcf7-form-control wpcf7-textarea wpcf7-validates-as-required rc-cf-message" aria-required="true"
              aria-invalid="false" placeholder="Tu mensaje" required><?=$error ? $post["message"] ?? "" : ""?></textarea>
          </span>
          <button id="btn-send" class="mg-top-20 wpcf7-form-control has-spinner wpcf7-submit bt bt-md bt-background bt-primary mg-bottom-35">
            Enviar un mensaje
          </button>
          <br/><br/>
        </div>
      </form>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script type="module">
let resolver = null
const $form = document.querySelector("form")
const $btnsend = document.getElementById("btn-send")

const show_error = (id, label) => {
  Swal.fire({
    icon: "warning",
    html: `No se ha podido procesar tu mensaje. Revisa el campo ${label}`,
  })
  document.getElementById(id).focus()
}

const disablebtn = () => {
  $btnsend.setAttribute("disabled", "disabled")
  $btnsend.innerText = "...enviando mensaje"
}

const enablebtn = () => {
  $btnsend.removeAttribute("disabled")
  $btnsend.innerText = "Enviar un mensaje"
}

$form.addEventListener("submit", ev => {
  disablebtn()
  const data = Object.fromEntries(new FormData(ev.target))

  if (!data.name.trim()) {
    show_error("name", "Nombre")
    enablebtn()
    ev.preventDefault()
  }

  if (!data.email.trim()) {
    show_error("email", "Email")
    enablebtn()
    ev.preventDefault()
  }

  if (!data.message.trim()) {
    show_error("message", "Mensaje")
    enablebtn()
    ev.preventDefault()
  }

  resolver()
})

document.addEventListener("DOMContentLoaded", ev => {
  resolver = function () {
    const $action = document.getElementById("action")
    $action.value = <?= json_encode(RequestActionType:: HOME_CONTACT_SEND) ?>
  }
})
</script>
<?php
$message = cookie('message');
if (!empty($message)){ ?>
<div class="alert {{$message->type}}" id="alert-element">
    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
    {!! $message->message !!}
</div>
<?php } ?>

<script>
    setTimeout(function () {
        const alertElement = document.getElementById('alert-element');
        if (alertElement) {
            alertElement.style.display = 'none';
        }
    }, 5000);
</script>




<?php
session_start();
if(!isset($_SESSION['reset'])) header("location: /"); 
?>
<i class="fa fa-lock fa-4x"></i>
<h1 class="text-center">Ξέχασες τον κωδικό σου?</h1>
<p>Συμπλήρωσε τον νέο σου κωδικό</p>
<div class="panel-body">
    <div class="form-group">
        <div class="form-group">
            <input id="newpass" placeholder="Νέος κωδικός" class="form-control" type="password">
            <div class="text-danger text-left"></div>
        </div>
    </div>
    <div class="form-group">
        <div class="form-group">
            <input id="confirmNewPass" placeholder="Επιβεβαίωση Νέου κωδικού" class="form-control" type="password">
            <div class="text-danger text-left"></div>
        </div>
    </div>
    <div class="form-group">
        <button id="submitNewPass" class="btn btn-lg btn-primary btn-block" type="button">Συνέχεια</button>
        <div id="res" class="d-flex justify-content-center pt-2"></div>
    </div>
</div>
<script defer src="newpass.js"></script>
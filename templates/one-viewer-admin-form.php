<!-- <div id="message" class="updated">
<p><strong><?php _e('Settings saved.') ?></strong></p>
</div> -->
<?php 


?>
<div class="oneviewer-container">
    <h2>OneViewer Settings</h2>
    <p>Please choose categories to show on viewer</p>
    <form action="<?= $_SERVER['REQUEST_URI']; ?>" method="post">
    <p class="submit">
        <input name="Submit" type="submit" class="button-primary" value="<?php esc_attr_e('Save Changes'); ?>" />
    </p>
    </form>
</div>

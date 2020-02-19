<div class="wrap">
    <h1> Quibi stock sync settings</h1>

    <?php settings_errors(); ?>

    <form method="post" action="options.php">
        <?php
            settings_fields('api_credentials_group');
            do_settings_sections( 'quibi_stock_sync' );
            submit_button();
        ?>
    </form>
</div>
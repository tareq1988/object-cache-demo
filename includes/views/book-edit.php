<div class="wrap">
    <h1><?php _e( 'Add', 'th' ); ?></h1>

    <?php $item = th_get_book( $id ); ?>

    <form action="" method="post">

        <table class="form-table">
            <tbody>
                <tr class="row-name">
                    <th scope="row">
                        <label for="name"><?php _e( 'Name', 'th' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="name" id="name" class="regular-text" placeholder="<?php echo esc_attr( '', 'th' ); ?>" value="<?php echo esc_attr( $item->name ); ?>" required="required" />
                    </td>
                </tr>
                <tr class="row-author">
                    <th scope="row">
                        <label for="author"><?php _e( 'Author', 'th' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="author" id="author" class="regular-text" placeholder="<?php echo esc_attr( '', 'th' ); ?>" value="<?php echo esc_attr( $item->author ); ?>" required="required" />
                    </td>
                </tr>
                <tr class="row-isbn">
                    <th scope="row">
                        <label for="isbn"><?php _e( 'ISBN Number', 'th' ); ?></label>
                    </th>
                    <td>
                        <input type="number" name="isbn" id="isbn" class="regular-text" placeholder="<?php echo esc_attr( '', 'th' ); ?>" value="<?php echo esc_attr( $item->isbn ); ?>" required="required" />
                    </td>
                </tr>
                <tr class="row-edition">
                    <th scope="row">
                        <label for="edition"><?php _e( 'Edition', 'th' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="edition" id="edition" class="regular-text" placeholder="<?php echo esc_attr( '', 'th' ); ?>" value="<?php echo esc_attr( $item->edition ); ?>" required="required" />
                    </td>
                </tr>
                <tr class="row-pages">
                    <th scope="row">
                        <label for="pages"><?php _e( 'Pages', 'th' ); ?></label>
                    </th>
                    <td>
                        <input type="number" name="pages" id="pages" class="regular-text" placeholder="<?php echo esc_attr( '', 'th' ); ?>" value="<?php echo esc_attr( $item->pages ); ?>" />
                    </td>
                </tr>
                <tr class="row-language">
                    <th scope="row">
                        <label for="language"><?php _e( 'Language', 'th' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="language" id="language" class="regular-text" placeholder="<?php echo esc_attr( '', 'th' ); ?>" value="<?php echo esc_attr( $item->language ); ?>" />
                    </td>
                </tr>
                <tr class="row-publish-date">
                    <th scope="row">
                        <label for="publish_date"><?php _e( 'Publish Date', 'th' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="publish_date" id="publish_date" class="regular-text" placeholder="<?php echo esc_attr( '', 'th' ); ?>" value="<?php echo esc_attr( $item->publish_date ); ?>" />
                    </td>
                </tr>
             </tbody>
        </table>

        <input type="hidden" name="field_id" value="<?php echo $item->id; ?>">

        <?php wp_nonce_field( 'nonce' ); ?>
        <?php submit_button( __( 'Update', 'th' ), 'primary', 'submit' ); ?>

    </form>
</div>
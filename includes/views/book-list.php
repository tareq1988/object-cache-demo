<div class="wrap">
    <h2><?php _e( 'Books', 'th' ); ?> <a href="<?php echo admin_url( 'admin.php?page=th-books&action=new' ); ?>" class="add-new-h2"><?php _e( 'Add New', 'th' ); ?></a></h2>

    <form method="post">
        <input type="hidden" name="page" value="ttest_list_table">

        <?php
        $list_table = new TH_Books_List_Table();
        $list_table->prepare_items();
        $list_table->search_box( 'search', 'search_id' );
        $list_table->display();
        ?>
    </form>

    <style type="text/css">
        td.column-name,
        th.column-name {
            width: 300px;
        }

        td.column-publish_date,
        th.column-publish_date {
            width: 170px;
        }
    </style>
</div>
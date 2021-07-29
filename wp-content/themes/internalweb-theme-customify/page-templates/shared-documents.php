<?php

/*
Template Name: Shared Documents
*/

get_header();

?>

<!-- Shared Documents Container -->
<div class="shared-documents-container">

    <?php

    if (have_rows('shared_documents')) :
        while (have_rows('shared_documents')) :
            the_row();
            $file = get_sub_field('file');
            $filepath_info = pathinfo($file);
            $alt_file_name = get_sub_field('file_name');
    ?>
            <!-- <?php echo $filepath_info['filename']; ?> -->
            <div>

                <?php
                switch ($filepath_info['extension']):
                    case 'pdf': ?>
                        <i class="fas fa-file-pdf"></i>
                    <?php break;
                    case 'xlsx': ?>
                        <i class="fas fa-file-excel"></i>
                    <?php break;
                    case 'docx': ?>
                        <i class="fas fa-file-word"></i>
                    <?php break;
                    case 'pptx': ?>
                        <i class="fas fa-file-powerpoint"></i>
                    <?php break;
                    default: ?>
                        <i class="fas fa-file"></i>
                <?php endswitch; ?>

                <a href="<?php echo $file; ?>" target="_blank">
                    <?php if ($alt_file_name) {
                        echo $alt_file_name;
                    } else {
                        echo $filepath_info['filename'];
                    } ?>
                </a>

            </div>
            <!-- /<?php echo $filepath_info['filename']; ?> -->
        <?php
        endwhile;
    else : ?>
        <h3>Sorry, no files seem to be shared...</h3>
    <?php
    endif;

    ?>

</div>
<!-- /Shared Documents Container -->

<?php

get_footer()

?>
<?php
global $post, $licenza;
?>
<div class="article-footer" style="padding-bottom:5px; padding-top:5px; background-color:black; margin-left:0em;text-transform:uppercase;color:#dddac5;letter-spacing:0em;font-family:YAD0xLc7TF0-2;line-height:1.1em;direction:ltr;text-align:center;">
    <p><strong><?php _e("Pubblicato", "avanguardie"); ?>:</strong> <?php
		$date_publish = new DateTime($post->post_date);
		echo $date_publish->format('d.m.Y');
		?> <span>-</span> <strong><?php _e("Revisione", "avanguardie"); ?>:</strong> <?php
		$date_update = new DateTime($post->post_modified);
		echo $date_update->format('d.m.Y');
		?></p>
    <p><?php
        if(trim($licenza)!= "")
            echo $licenza;
        else
            _e("Eccetto dove diversamente specificato, questo articolo è stato rilasciato sotto Licenza Creative Commons Attribuzione 3.0 Italia.", "avanguardie"); ?></p>
</div><!-- /article-footer -->


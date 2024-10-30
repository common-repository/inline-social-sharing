<div class="fiss-share-buttons-wrapper" style="border: <?= $fiss_border; ?>">

    <p>
        <?= $message; ?>
    </p>

    <div class="fiss-share-buttons">
        <?php if (! $hide_counter) : ?>
          <div>
              <span class="fiss_total_share_wrapper" style="display: none"><b class="fiss_total_share"></b><br />Shares</span>
          </div>
          <script>
          jQuery(function($) {
            'use strict';

            jQuery.post(ajaxurl, {'action': 'share_count','url': window.location.href}, function(response) {
              var obj = JSON.parse(response);
              $('.fiss_total_share').html(obj.shares.total);
              $('.fiss_total_share_wrapper').show();
            });
          });
          </script>
        <?php endif; ?>

        <!-- Facebook -->
        <?php if (array_key_exists('facebook', $fiss_social_list) and $fiss_social_list['facebook']) : ?>
            <a  href="http://www.facebook.com/sharer.php?u=<?= $actual_link; ?><?= strpos($actual_link, '?') !== true ? '&amp;' : '?'?>utm_source=facebook&amp;utm_medium=Social+Sharing&amp;utm_ campaign=FruitFul+Inline+Sharing+PRO">
                <div class="fiss-facebook">
                    <i class="fa fa-facebook"></i>
                    <span class="fiss-text" >Facebook</span>
                </div>
            </a>
        <?php endif; ?>

        <!-- Google+ -->
        <?php if (array_key_exists('google', $fiss_social_list) and $fiss_social_list['google']) : ?>
            <a href="https://plus.google.com/share?url=<?= $actual_link; ?><?= strpos($actual_link, '?') !== true ? '&amp;' : '?'?>utm_source=google&amp;utm_medium=Social+Sharing&amp;utm_campaign=FruitFul+Inline+Sharing+PRO">
                <div class="fiss-google">
                    <i class="fa fa-google"></i>
                    <span class="fiss-text" >Google+</span>
                </div>
            </a>
        <?php endif; ?>

        <!-- LinkedIn -->
        <?php if (array_key_exists('linkedin', $fiss_social_list) and $fiss_social_list['linkedin']) : ?>
            <a  href="http://www.linkedin.com/shareArticle?mini=true&url=<?= $actual_link; ?><?= strpos($actual_link, '?') !== true ? '&amp;' : '?'?>utm_source=linkedin&amp;utm_medium=Social+Sharing&amp;utm_campaign=FruitFul+Inline+Sharing+PRO">
                <div class="fiss-linkedin">
                    <i class="fa fa-linkedin"></i>
                    <span class="fiss-text" >Linkedin</span>
                </div>
            </a>
        <?php endif; ?>

        <!-- Twitter -->
        <?php if (array_key_exists('twitter', $fiss_social_list) and $fiss_social_list['twitter']) : ?>
            <a  href="https://twitter.com/share?url=<?= $actual_link; ?><?= strpos($actual_link, '?') !== true ? '&amp;' : '?'?>utm_source=twitter&amp;utm_medium=Social+Sharing&amp;utm_ campaign=FruitFul+Inline+Sharing+PRO&amp;text=<?= $fiss_twiter_handle; ?>&amp;hashtags=">
                <div class="fiss-twitter">
                    <i class="fa fa-twitter"></i>
                    <span class="fiss-text" >Twitter</span>
                </div>
            </a>
        <?php endif; ?>

        <!-- Whatsapp -->
        <?php if (array_key_exists('whatsapp', $fiss_social_list) and $fiss_social_list['whatsapp']) : ?>
            <a  href="whatsapp://send?text=<?= $actual_link; ?><?= strpos($actual_link, '?') !== true ? '&amp;' : '?'?>utm_source=twitter&amp;utm_medium=Social+Sharing&amp;utm_ campaign=FruitFul+Inline+Sharing+PRO" >
                <div class="fiss-whatsapp">
                    <i class="fa fa-whatsapp"></i>
                    <span class="fiss-text" >Whatsapp</span>
                </div>
            </a>
        <?php endif; ?>
    </div>

</div>

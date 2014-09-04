<span class="bubble green <?php if ($updated_amount === 0) : ?>hide<?php endif; ?> <?php if ($both_bubble) : ?>from-left<?php endif; ?>" id="my_surveys_updated_amount" title="There have been updates on your saved awards. Please check in your My List for the updates.">
    <?php echo $updated_amount; ?>
</span>
<span class="bubble red <?php if ($past_dues_amount === 0) : ?>hide<?php endif; ?>" id="my_surveys_past_dues_amount" title="Submission deadlines have passed on saved awards. Please check in your My List for the updates.">
    <?php echo $past_dues_amount; ?>
</span>
<?php
	global $_zp_current_zenpage_news;

	if ( !isset($_zp_current_zenpage_news) ) next_news();

	if (!isset($_zp_current_zenpage_news)) return;
?>

<div id="news-comments-entries">
	
	<?php $first = false; while (next_comment()) : ?>
		<div class="news-comment <?php echo(!$first ? 'first' : ''); $first = true; ?>">
			<div class='news-comment-info'>
				<div class="left opa40">
					<img src='<?= $_zp_themeroot ?>/resources/images/avatar.png' style="vertical-align: bottom;"/> 
					<span class="news-comment-author">
						<?= gettext("posted by") ?> <?php printCommentAuthorLink(); ?>
					</span>
				</div>
				<?php NewsUtil::printNewsDateBlock(); ?>
				<div class="clear"></div>
			</div>
			<div class="comment">
				<div class="comment-text">
					<?php echo getCommentBody();?>
				</div>
			</div>
		</div>
	<?php endwhile; ?>

	<?php if ( !$first ) : ?>
		<div class="news-comment <?php echo(!$first ? 'first' : ''); $first = true; ?>">
			<div class='news-comment-info'>
				<div class="left opa40">
					<img src='<?= $_zp_themeroot ?>/resources/images/avatar.png' style="vertical-align: bottom;"/> 
					<span class="news-comment-author">
						<?= gettext("No comment yet?") ?> 
					</span>
				</div>
				<div class="clear"></div>
			</div>
			<div class="comment">
				<div class="comment-text">
				</div>
			</div>
		</div>
	<?php endif; ?>
	<div class="clear" />
</div>	


<?php 
	if ( $_zp_current_zenpage_news->getCommentsAllowed() && 
		 (!getOption('comment_form_members_only') || zp_loggedin(ADMIN_RIGHTS | POST_COMMENT_RIGHTS)) ) : 
?>
	<div id="add-comment-header" class="opa60 shadow">
		+ <?= gettext("Add comment") ?>
	</div>
	<?php printCommentForm(); ?>
	<script>
		$("#commentform").addClass('opa60');
		$("#commentform .pushbutton").addClass('generic-button');
		$("#add-comment-header").click(function() {
			if ( $("#commentform").css('display') === 'none' ) {
				$("#commentform").css('visibility', 'hidden');
				$("#commentform").css('display', 'block');
				$("#loaded-comments a").css('visibility', 'hidden');
				$("#loaded-comments a").css('display', 'block');
			
				if ( $("#commentform").initialized !== true ) {
					$("#commentform .pushbutton").attr('value', 'Submit');
					$('#commentform input[type=checkbox]').checkbox({
					  cls:'jquery-safari-checkbox',
					  empty: BLANK_IMAGE
					});		
					$("#commentform").initialized = true;
				}

				$.currentPage.updateSizes();

				$("#commentform").css('visibility', 'visible');
				$("#loaded-comments a").css('visibility', 'visible');
				$("#add-comment-header").text('- Add comment');
				$("#add-comment-header").collapsed = false;
			}
			else {
				$("#commentform").css('display', 'none');
				$("#loaded-comments a").css('display', 'none');
				$.currentPage.updateSizes();
				$("#add-comment-header").text('+ Add comment');
			}
		});
	</script>
<?php else: ?>
	<div id="add-comment-header" class="opa60 shadow">
		<?= gettext('Comments are closed') ?>
	</div>
<?php endif; ?>

<style type="text/css" media="all">@import "zen.css";</style>
			<form id="commentform" action="#" method="post">
			<div><input type="hidden" name="comment" value="1" />
          	<input type="hidden" name="remember" value="1" />
 <?php if (isset($error)) { ?><tr><td><div class="error">There was an error submitting your comment. Name, a valid e-mail address, and a comment are required.</div></td></tr><?php } ?>
			<table border="0">
				<tr>
					<td><label for="name">Name:</label></td>
					<td><input type="text" id="name" name="name" size="20" value="<?php echo$stored[0];?>" class="inputbox" />
					</td>
				</tr>
				<tr>
					<td><label for="email">E-Mail:</label></td>
					<td><input type="text" id="email" name="email" size="20" value="<?php echo$stored[1];?>" class="inputbox" />
					</td>
				</tr>
				<tr>
					<td><label for="website">Site:</label></td>
					<td><input type="text" id="website" name="website" size="30" value="<?php echo$stored[2];?>" class="inputbox" /></td>
				</tr>
			</table>
			<textarea name="comment" rows="6" cols="25"></textarea>
			<br />
			<input type="submit" value="Add Comment" class="pushbutton" /></div>
		</form>
		</div>
	</div>
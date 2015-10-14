<?php
require_once('/../../lib/wrappers/functions.php');
require_once('/../../lib/wrappers/session.php');
require_once('/../../lib/wrappers/db.php');
require_once('/../../lib/wrappers/comment.php');

if (!$session->is_logged_in()) { redirect_to("login.php"); } 
	if(empty($_GET['id'])) {
	  $session->message("No card ID was provided.");
	  redirect_to('/../../lib/wrappers/index.html');
	}
	
  $card = Card::find_by_id($_GET['id']);
  if(!$card) {
    $session->message("The card could not be located.");
    redirect_to('/../../lib/wrappers/index.html');
  }

	$comments = $card->comments();
?>

<html>
  <head>
    <title>5status</title>
  </head>
  <body>
    <div id="main">
<br />

<h2>Comments on <?php echo $card->card_title; ?></h2>

<?php echo output_message($message); ?>
<div id="comments">
  <?php foreach($comments as $comment): ?>
    <div class="comment" style="margin-bottom: 2em;">
	       <div class="commentbody">
				<?php echo strip_tags($comment->comment, '<strong><em><p>'); ?>
			</div>
	    <div class="meta-info" style="font-size: 0.8em;">
	      <?php echo datetime_to_text($comment->creation_date); ?>
	    </div>
			<div class="actions" style="font-size: 0.8em;">
				<a href="delete_comment.php?id=<?php echo $comment->id; ?>">Delete Comment</a>
			</div>
    </div>
  <?php endforeach; ?>
  <?php if(empty($comments)) { echo "No Comments."; } ?>
</div>
    </div>
    <div id="footer">Copyright <?php echo date("Y", time()); ?></div>
  </body>
</html>
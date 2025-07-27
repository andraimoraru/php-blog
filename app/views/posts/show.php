<?php require APPROOT . '/views/inc/header.php'; ?>
<a href="<?php echo URLROOT; ?>/posts" class="btn btn-light"><i class="fa fa-backward"></i>  Back</a>
<br>
<h1><?php echo $data['post']->title; ?></h1>
<div class="bg-secondary text-white p-2 mt-3">
    Written by <?php echo $data['post']->name; ?> on <?php echo date    ('d M Y', strtotime($data['post']->postCreatedAt)); ?>
</div>
<div class="mt-3">
    <?php echo $data['post']->body; ?>
</div>

<?php if ($data['post']->userId == $_SESSION['user_id']) : ?>
    <hr>
    <a href="<?php echo URLROOT; ?>/posts/edit/<?php echo $data['post']->postId; ?>" class="btn btn-dark">Edit</a>

    <form class="float-end" action="<?php echo URLROOT; ?>/posts/delete/<?php echo $data['post']->postId; ?>" method="post" >
        <input type="submit" value="Delete" class="btn btn-danger">
    </form>
<?php endif; ?>

<?php require APPROOT . '/views/inc/footer.php'; ?>

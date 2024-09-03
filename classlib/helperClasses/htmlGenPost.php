<?php
namespace htmlGen\post;
/**
 * @param \Post $post
 * @param \User $requesting_user
 * @return string
 */
function header($post, $requesting_user)
{
    $o = '<div class="post-header">';
    $o.= '<p>';
    $o.= '<a href="'.$_SERVER['PHP_SELF'].'?pageID=b/'.$post->board_name().'">b/'.$post->board_name().'</a>';
    $o.= '</p>';
    $o .= '<h3>' . $post->title() . '</h3>';
    $o .= '<p>' . $post->content() . '</p>';
    if ($requesting_user->is_logged_in()) {
        $o .= '<ul class="nav">';
        $o .= '<li><button id="p' . $post->id() . '-reply-button" onclick="toggleDisplay(\'p' . $post->id() . '-reply\')" type="button">reply</button></li>';
        $o .= '<li><button id="p' . $post->id() . '-report-button" onclick="toggleDisplay(\'p' . $post->id() . '-report\')" type="button">report</button></li>';
        if ($requesting_user->id() === $post->author_id()) {
            $o.='<li>'.delete_form($post).'</li>';
        }
        else if ($requesting_user->is_admin()) {
            $o .= '<li>'.remove_form($post).'</li>';
        }
        $o .= '</ul>';
        $o .= reply_form($post);
        $o.= report_form($post);
    }
    $o .= '</div>';
    $o .= '';
    return $o;
}

function reply_form($post) {
    $output = '
    <form method="post" action="index.php?pageID=' . $_GET['pageID'] . '" class="hidden" id="p' . $post->id() . '-reply">
        <textarea name="content" cols="40" rows="5"></textarea>
        <br>
        <button type="submit" name="btn-submit-post-comment">Save</button>
        <button type="button" id="' . $post->id() . '-cancel-post-reply-button" onclick="toggleDisplay(\'p' . $post->id() . '-reply\')">Cancel</button>
    </form>
    ';
    return $output;
}

function report_form($post) {
    $output = '
    <form method="post" action="index.php?pageID=' . $_GET['pageID'] . '" class="hidden" id="p' . $post->id() . '-report">
        <p>Are you sure you wish to report this post?</p>
        <button type="submit" name="btn-submit-post-report">Yes, send report</button>
        <button type="button" id="' . $post->id() . '-cancel-post-report-button" onclick="toggleDisplay(\'p' . $post->id() . '-report\')">Cancel</button>
    </form>
    ';
    return $output;
}

function delete_form($post) {
    $output = '
    <form method="post" action="index.php?pageID=' . $_GET['pageID'] . '" id="p' . $post->id() . '-delete">
        <input name="delete-post-id" type="hidden" value="' . $post->id() . '">
        <button type="submit" name="btn-delete-post">delete</button>
    </form>
    ';
    return $output;
}

function remove_form($post) {
    // same as delete for now
    $output = '
    <form method="post" action="index.php?pageID=' . $_GET['pageID'] . '" id="p' . $post->id() . '-delete">
        <input name="delete-post-id" type="hidden" value="' . $post->id() . '">
        <button type="submit" name="btn-delete-post">remove</button>
    </form>
    ';
    return $output;
}


/**
 * @param \Post $post
 * @return string
 */
function card($post) {
    $o = '<div class="post-card">';

    $o.= '<p><a href='.$_SERVER['PHP_SELF'].'?pageID='.$_GET['pageID'].'/'.$post->id().'>';
    $o.= $post->title();
    $o.= '</a></p>';

    $o.= '<p>';
    $o.= 'Submitted at '.$post->time_created().' by ';
    $o.= '<a href="index.php?pageID=user/'.$post->author_name().'">';
    $o .= $post->author_name();
    $o .= '</a>';
    $o.= '</p>';

    $o.= '<p>';
    $o.= ' '.$post->comment_count().' comments';
    $o.= '</p>';

    $o.= '</div>';
    $o .= '';
    return $o;
}
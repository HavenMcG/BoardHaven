<?php
namespace htmlGen;

use CommentTable;
use User;

function comment($comment, $requesting_user) {
    $o = '';
    $is_owner = $requesting_user->id() == $comment->author_id();
    $is_deleted = $comment->author_id() == 0;

    $o .= '<div class="comment">';
    $o .= '<p class="tagline">';
    if ($is_deleted) $o .= '&lt;deleted&gt';
    else $o .= '<a href="' . $_SERVER['PHP_SELF'] . '?pageID=user/' . $comment->author_name() . '">' . $comment->author_name() . '</a>';
    $o .= ' @' . $comment->time_created();
    $o .= '</p>';
    $o .= '<p class="text">';
    $o .= htmlentities($comment->text());
    $o .= '</p>';
    if ($requesting_user->is_logged_in()) {
        $o .= '<ul class="nav">';
        if (!$is_deleted) {
            $o .= '<li><button id="c' . $comment->id() . '-reply-button" onclick="toggleDisplay(\'c' . $comment->id() . '-reply\')" type="button">reply</button></li>';
            if (!$is_owner) {
                $o .= '<li><button id="c' . $comment->id() . '-report-button" onclick="toggleDisplay(\'c' . $comment->id() . '-report\')" type="button">report</button></li>';
            }
            if ($requesting_user->is_admin() && !$is_owner) {
                $o .= '<li>' . remove_form($comment) . '</li>';
            }
            if ($is_owner) {
                $o .= '<li>' . delete_form($comment) . '</li>';
                $o .= '<li><button id="c' . $comment->id() . '-edit-button" onclick="toggleDisplay(\'c' . $comment->id() . '-edit\')" type="button">edit</button></li>';
            }
        } else $o .= '&lt;deleted&gt';
        $o .= '</ul>';
        $o .= reply_form($comment) . edit_form($comment) . report_form($comment);
    }
    $o .= '</div>';

    return $o;
}

function delete_form($comment) {
    $output = '
    <form method="post" action="index.php?pageID=' . $_GET['pageID'] . '" id="c' . $comment->id() . '-delete">
        <input name="id" type="hidden" value="' . $comment->id() . '">
        <button type="submit" name="btn-delete-comment">delete</button>
    </form>
    ';
    return $output;
}

function remove_form($comment) {
    // same as delete for now
    $output = '
    <form method="post" action="index.php?pageID=' . $_GET['pageID'] . '" id="c' . $comment->id() . '-remove">
        <input name="id" type="hidden" value="' . $comment->id() . '">
        <button type="submit" name="btn-delete-comment">remove</button>
    </form>
    ';
    return $output;
}

function reply_form($comment) {
    $output = '
    <form method="post" action="index.php?pageID=' . $_GET['pageID'] . '" class="hidden" id="c' . $comment->id() . '-reply">
        <input name="parent-comment" type="hidden" value="' . $comment->id() . '">
        <textarea name="text" cols="40" rows="5"></textarea>
        <br>
        <button type="submit" name="btn-submit-comment-comment">Save</button>
        <button type="button" id="' . $comment->id() . '-cancel-comment-reply-button" onclick="toggleDisplay(' . '\'c' . $comment->id() . '-reply' . '\'' . ')">Cancel</button>
    </form>
    ';
    return $output;
}

function edit_form($comment) {
    $output = '
    <form method="post" action="index.php?pageID=' . $_GET['pageID'] . '" class="hidden" id="c' . $comment->id() . '-edit">
        <input name="id" type="hidden" value="' . $comment->id() . '">
        <textarea name="content" cols="40" rows="5"></textarea>
        <br>
        <button type="submit" name="btn-edit-comment">Save</button>
        <button type="button" id="' . $comment->id() . '-cancel-edit-button" onclick="toggleDisplay(' . '\'c' . $comment->id() . '-edit' . '\'' . ')">Cancel</button>
    </form>
    ';
    return $output;
}

function report_form($comment) {
    $output = '
    <form method="post" action="index.php?pageID=' . $_GET['pageID'] . '" class="hidden" id="c' . $comment->id() . '-report">
        <p>Are you sure you wish to report this comment?</p>
        <input name="report-comment-id" type="hidden" value="'.$comment->id().'">
        <button type="submit" name="btn-submit-comment-report">Yes, send report</button>
        <button type="button" id="' . $comment->id() . '-cancel-comment-report-button" onclick="toggleDisplay(\'c' . $comment->id() . '-report\')">Cancel</button>
    </form>
    ';
    return $output;
}


/**
 * @param CommentTable $ct
 * @param int $comment_id
 * @param User $requesting_user
 * @return string
 */
function comment_comments($ct, $comment_id, $requesting_user)
{
    $rs = $ct->get_comment_comments($comment_id);
    $output = '<ul class="comment-list nested">';
    while ($row = $rs->fetch_assoc()) {
        $c = new \Comment($row);
        unset($row);
        $output .= '<li class="comment-container">' . comment($c, $requesting_user);
        $output .= comment_comments($ct, $c->id(), $requesting_user);
        $output .= '</li>';
    }
    $output .= '</ul>';
    return $output;
}

/**
 * @param CommentTable $ct
 * @param int $post_id
 * @param User $requesting_user
 * @return string
 */
function post_comments($ct, $post_id, $requesting_user)
{
    $rs = $ct->get_post_comments($post_id);
    $output = '<ul class="comment-list top-level">';
    while ($row = $rs->fetch_assoc()) {
        $c = new \Comment($row);
        unset($row);
        $output .= '<li class="comment-container">' . comment($c, $requesting_user);
        $output .= comment_comments($ct, $c->id(), $requesting_user);
        $output .= '</li>';
    }
    $output .= '</ul>';
    return $output;
}

function submission($submission)
{
    $output = '';
    if ($submission->title()=='<deleted>') return $output;
    if ($submission->type() == 1) {
        $output = '
        <div class="submission">
            <div class="header">
                <p class="tagline">' . $submission->time_created() . '</p>
                <p class="tagline">
                    ' . $submission->author_name() . '
                    commented on
                    \'<a href="' . $_SERVER['PHP_SELF'] . '?pageID=b/' . $submission->board_name() . '/' . $submission->post_id() . '">' . $submission->title() . '</a>\'
                    in
                    <a href="' . $_SERVER['PHP_SELF'] . '?pageID=b/' . $submission->board_name() . '">b/' . $submission->board_name() . '</a>
                </p>
            </div>
            <p class="text">
                ' . $submission->content() . '
            </p>
        </div>
    ';
    } else if ($submission->type() == 2) {
        $output = '
        <div class="submission">
            <div class="header">
                <p class="tagline">' . $submission->time_created() . '</p>
                <p class="tagline">
                    ' . $submission->author_name() . '
                    posted in
                    <a href="' . $_SERVER['PHP_SELF'] . '?pageID=b/' . $submission->board_name() . '">b/' . $submission->board_name() . '</a>
                </p>
            </div>
            <p><a href="' . $_SERVER['PHP_SELF'] . '?pageID=b/' . $submission->board_id() . '/' . $submission->post_id() . '">' . $submission->title() . '</a></p>
            <p class="text">
                ' . $submission->content() . '
            </p>
        </div>
    ';
    }
    return $output;
}
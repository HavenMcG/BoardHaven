<?php
namespace htmlGen\board;


use function htmlGen\home\create_board_form;

/**
 * @param \Board $board
 * @param \User $requesting_user
 * @return string
 */
function header($board, $requesting_user) {
    $o = '<div class="board-header">';
    $o.= '<h3>'.$board->name().'</h3>';
    if ($requesting_user->is_logged_in()) {
        $o .= '<button onclick="toggleDisplay(\'create-post\')" type="button">Make a post</button>';
        $o .= '<br><br>';
        $o .= create_post_form($board);
    }
    $o.= '';
    $o.= '</div>';
    return $o;
}

function create_post_form($board) {
    $output = '
    <form method="post" action="index.php?pageID=' . $_GET['pageID'] . '" class="hidden" id="create-post">
        <div class="form-group">
        <label for="post-title-input">Title:</label>
        <input type="text" name="title" id="post-title-input" class="form-control">
        <label for="post-content-input">Content:</label>
        <textarea name="content" cols="40" rows="5" id="post-content-input" class="form-control"></textarea>
        <input type="hidden" name="board-id" value="'.$board->id().'">
        </div>
        <button type="submit" name="btn-submit-post">Post</button>
        <button type="button" id="btn-cancel-post" onclick="toggleDisplay(\'create-post\')">Cancel</button>
    </form>';
    return $output;
}

/**
 * @param \Post[] $posts
 * @param \User $requesting_user
 * @return string
 */
function post_list($posts, $requesting_user) {
    $o = '<ul class="post-list">';
    foreach ($posts as $p) {
        $o.= '<li class="post-card-container">';
        $o.= \htmlGen\post\card($p);
        $o.= '</li>';
    }
    $o.= '</ul>';
    $o.= '';
    return $o;
}

/**
 * @param \Board $board
 * @param \User $requesting_user
 * @return string
 */
function card($board, $requesting_user) {
    $o = '<div class="board-card">';
    $o.= '<a href="'.$_SERVER['PHP_SELF'].'?pageID=b/'.$board->name().'">';
    $o.= $board->name();
    $o.= '</a>';
    $o.= '</div>';
    $o.= '';
    return $o;
}
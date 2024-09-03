<?php
namespace htmlGen\home;

/**
 * @param \User $requesting_user
 * @return string
 */
function header($requesting_user) {
    $o = '<h3>BoardHaven</h3>';
    if ($requesting_user->is_logged_in()) {
        $o .= '<button onclick="toggleDisplay(\'create-board\')" type="button">Start a board</button>';
        $o .= '<br><br>';
        $o .= create_board_form();
    }
    return $o;
}

function create_board_form() {
    $output = '
    <form method="post" action="index.php?pageID=' . $_GET['pageID'] . '" class="hidden" id="create-board">
        <label for="board-name-input">Name:</label>
        <input type="text" name="name" id="board-name-input">
        <br>
        <button type="submit" name="btn-submit-create-board">Create</button>
        <button type="button" id="btn-cancel-create-board" onclick="toggleDisplay(\'create-board\')">Cancel</button>
    </form>';
    return $output;
}

/**
 * @param \Board[] $boards
 * @param \User $requesting_user
 * @return string
 */
function board_list($boards, $requesting_user) {
    $o = '<ul>';
    foreach ($boards as $b) {
        $o.= '<li>';
        $o.= \htmlGen\board\card($b, $requesting_user);
        $o.= '</li>';
    }
    $o.= '</ul>';
    $o.= '';
    return $o;
}
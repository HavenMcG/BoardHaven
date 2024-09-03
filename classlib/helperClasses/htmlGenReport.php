<?php
namespace htmlGen\report;

/**
 * @param \Report[] $reports
 * @param \User $requesting_user
 * @return string
 */
function report_list($reports, $requesting_user) {
    $o = '<table class="table table-striped">';
    $o.= '<tr>';
    $o.= '<th>Id</th>';
    $o.= '<th>Post Id</th>';
    $o.= '<th>Comment Id</th>';
    $o.= '<th>Reporter Id</th>';
    $o.= '<th>Time Created</th>';
    $o.= '</tr>';
    foreach ($reports as $r) {
        $o.= '<tr>';
        $o.= '<td>';
        $o.= $r->id();
        $o.= '</td>';
        $o.= '<td>';
        $o.= $r->post_id();
        $o.= '</td>';
        $o.= '<td>';
        $o.= $r->comment_id();
        $o.= '</td>';
        $o.= '<td>';
        $o.= $r->reporter_id();
        $o.= '</td>';
        $o.= '<td>';
        $o.= $r->time_created();
        $o.= '</td>';
        $o.= '</tr>';
    }
    $o.= '</table>';
    return $o;
}
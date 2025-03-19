<?php
function formatTime($totalMinutes)
{
    if ($totalMinutes == 0) {
        return "0";
    }

    $hours = floor($totalMinutes / 60);
    $minutes = $totalMinutes % 60;

    $formattedTime = "";

    if ($hours > 0) {
        $formattedTime .= $hours . " hr" . ($hours > 1 ? "s" : "");
    }

    if ($minutes > 0) {
        $formattedTime .= ($hours > 0 ? " " : "") . $minutes . " min" . ($minutes > 1 ? "s" : "");
    }

    return $formattedTime;
}

<?php
$list_status=2;

$list_status_class=$list_status==1 ? 'event done':'event doing';
$done_time=$list_status==1 ? time():0;
$event_state=$list_status==1 ? '已经完成了':'正在进行中......';
echo $list_status_class . '<br/>';
echo $done_time. '<br/>';
echo $event_state. '<br/>';
?>
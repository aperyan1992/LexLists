<?php 
exec('mysqldump -u root -h localhost -proot lexlists | gzip -9 > '.dirname(__DIR__).'/backup/lexlists_backup_'.date('Y').'_'.date('m').'_'.date('d').'.sql.gz');
?>

<?
//-----Создаем титл страницы-----//
$title = 'Оплата';
include ('../inc/head.php');
//-----Создаем титл страницы-----//
$title = 'Пополнить счёт';
//-----Подключаем функции-----//
include ('../inc/config.php');
include_once '../worldkassa/config_worldkassa.php';

if (isset($_POST['id_shop']) && is_numeric($_POST['id_shop']) && isset($_POST['id_bill']) && is_numeric($_POST['id_bill']) && isset($_POST['summa']) && is_numeric($_POST['summa']) && isset($_POST['hash']))
	{
	$sql=mysql_query("SELECT * FROM `worldkassa` WHERE `id_bill` = '".$_POST['id_bill']."'");
	if (mysql_num_rows($sql)>0)
		{
		$data=mysql_fetch_assoc($sql);
		if ($_POST['summa']<$data['summa'])
			{
			//Можно поставить уведомление на подмену суммы пополнения
			}
			elseif($_POST['hash']!=md5($hash.$id_shop.$_POST['id_bill'].$_POST['summa']))
			{
			//Можно поставить уведомление, что не совпал хеш
			}
			else
			{
			mysql_query("UPDATE `worldkassa` SET `time_oplata` = '".time()."' WHERE `id` = '".$data['id']."'");
			mysql_query("UPDATE `users` SET `money` = `money`+".$data['summa']." WHERE `id` = '".$data['id_user']."'");
			//mysql_query("UPDATE `users` SET `money` = `money`+".$data['summa']."  *.10  WHERE `id` = '".$data['id_user']."'");
                       // mysql_query("UPDATE `users` SET `wmid_pod` = `1` WHERE `id` = '".$data['id_user']."'");
			}
		}
	}
?>
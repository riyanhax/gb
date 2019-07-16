<?
include ('../inc/head.php');
//-----Создаем титл страницы-----//
$title = 'Пополнить счёт';
//-----Подключаем функции-----//
include ('../inc/config.php');
include_once '../worldkassa/config_worldkassa.php';

//-----Если гость,то...----//

if (isset($_POST['summa']))
	{
	if (preg_match('#^([0-9]+)$|^([0-9]+\.)+([0-9]{1,2})$#', $_POST['summa']))
		{
		$data=file_get_contents('http://worldkassa.ru/user/oplata.php?id_shop='.$id_shop.'&summa='.$_POST['summa'].'&hash='.$hash);
		if (is_numeric($data))
			{
			mysql_query("INSERT INTO `worldkassa` (`id_user`, `id_bill`, `time`, `summa`) values('".$user['id']."', '".$data."', '".time()."', '".$_POST['summa']."')");
			header("Location: http://worldkassa.ru/user/oplata.php?uniq=".$data);
			exit();
			}
			else
			{
			$err=$data;
			}
		}
		else
		{
		$err='Введите корректно сумму';
		}
	}
	
	
//echo '<div class="podmenu"><center><b>'.$err.'</b></center>';
echo 'Ваш баланс '.$user['money'].' Rub<br/>
Пополнить на:<br/>
<form action="?" method="post">
<input name="summa" type="text" value="1.00"/> RUB<br/>
<input type="submit" value="Пополнить"/>
</form></div>';
include ('../inc/foot.php');
?>
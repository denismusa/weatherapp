<?
	session_start();
	
	include_once "includes/functions.php";
	
	if($_GET['session'] == "reset")
	{
		unset($_SESSION['new_cities']);
		header("location: /weather");
	}
	
	if($_POST['submit'])
	{
		$name = htmlspecialchars($_POST['name']);
		$name = str_replace(" ", "", $name);
		
		$search_url = "http://api.openweathermap.org/data/2.5/weather?q=$name&appid=44db6a862fba0b067b1930da0d769e98";
		$search_json = file_get_contents($search_url);
		$search_data = json_decode($search_json, true);
		
		if($search_data['cod'] == 200)
		{
			$_SESSION['new_cities'][$name] = $name;
			header("location: /weather");
		}
		else
		{
			echo "<h2>City don't exist</h2>";
		}
	}
	
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Weather app</title>
	<link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
</head>
<body>
	

	<div class="section_blue_1">
		<div class="section_width">
			
			<form action="" method="post">
				<input type="name" name="name" class="input_big" />
				<input type="submit" name="submit" value="Add" class="submit" />
			</form>
			<a href="?session=reset">Reset cities</a>
		</div>
	</div>
	
	
	<div class="">
		<div class="section_width">
			
			
			<?
				$cities = array('copenhagen', 'newyork', 'berlin', 'budapest');
				
				foreach($_SESSION['new_cities'] as $new_city)
				{
					array_push($cities, $new_city);
				}
				
				
				foreach($cities as $city)
				{
					
					$insert_city = $city;
				
					$url = "http://api.openweathermap.org/data/2.5/weather?q=$insert_city&appid=44db6a862fba0b067b1930da0d769e98";
					$json = file_get_contents($url);
					$data = json_decode($json, true);
					
					echo "<div class='box'>";
					
					echo "<h2>".k_to_c($data['main']['temp'])." °C</h2>";
					
					echo "<h3>".$data['name'].", ".$data['sys']['country']."</h3>";
					
					echo "
						<table>
							<tr>
								<td>Condition</td>
								<td>".$data['weather'][0]['main']."</td>
							</tr>
							<tr>
								<td>Cloud</td>
								<td>".$data['clouds']['all']."</td>
							</tr>
							<tr>
								<td>Wind speed</td>
								<td>".$data['wind']['speed']."</td>
							</tr>
						</table>
					";
					
					echo "</div>";
					
				}
				
			?>
			
		</div>
	</div>


</body>
</html>